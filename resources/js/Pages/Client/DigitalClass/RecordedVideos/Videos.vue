<template>
  <div>
    <div class="card_box position-relative mb_30 white_bg">
      <VueElementLoading
        :active="recordedVideosLoading"
        spinner="line-wave"
        color="var(--primary)"
      />
      <div class="white_box_tittle">
        <div class="main-title2">
          <h6 class="nowrap float-left mt-1 mb-0">
            <i class="fas fa-film mr-2"></i> Recorded Videos
          </h6>
          <div class="float-right">
            <button
              style="
                background-color: #002147 !important;
                color: white !important;
              "
              @click="$bvModal.show('create-video')"
              class="btn shadow-md px-3 py-2"
              v-if="$page.props.auth.user.user_type_id == 1"
            >
              <i class="mdi mdi-cloud-upload-outline mr-1"></i>
              Upload New Video
            </button>
          </div>
        </div>
      </div>
      <div class="box_body">
        <div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text">Subject</span>
                </div>
                <select
                  class="custom-select"
                  v-model="filter.subjectId"
                  @change="fetchRecordedVideos"
                  required
                >
                  <option value="">--Filter by Subject--</option>
                  <option
                    v-for="subject in subjects"
                    :key="subject.id"
                    :value="subject.id"
                  >
                    {{ subject.subject_name }}
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <table
          class="table table-bordered table-responsive table-hover"
          v-if="recordedVideos.data != ''"
        >
          <thead>
            <tr>
              <th width="3%">#</th>
              <th width="20%">Subject</th>
              <th width="25%">Topic</th>
              <th width="8%">Video Link</th>
              <th width="18%">Uploaded by</th>
              <th width="20%">Date Uploaded</th>
              <th>Status</th>
              <th width="3%">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(video, index) in recordedVideos.data" :key="video.id">
              <td>{{ index + 1 }}.</td>
              <td style="text-transform: capitalize">
                {{ video.subject.subject_name }}
              </td>
              <td>{{ video.topic.topic_name }}</td>
              <td>
                <a
                  style="text-decoration: underline"
                  target="tabs"
                  :href="`https://www.youtube.com/watch?v=${video.video_link}`"
                  >https://www.youtube.com/watch?v={{ video.video_link }}</a
                >
              </td>
              <td>{{ video.creator.lname }} {{ video.creator.fname }}</td>
              <td>
                {{ video.created_at | moment("ddd Do MMM, YYYY, hh:mm a") }}
              </td>
              <td>
                <div
                  class="badge badge-pill badge-success text-uppercase"
                  :class="{
                    'badge-success': video.status == 'approved',
                    'badge-danger': video.status == 'disapproved',
                    'badge-info': video.status == 'pending',
                  }"
                >
                  {{ video.status }}
                </div>
              </td>
              <td>
                <div class="dropdown">
                  <button
                    type="button"
                    class="btn dropdown-toggle p-0 action"
                    data-toggle="dropdown"
                  >
                    <i class="fas fa-cog"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <div
                      @click="
                        $bvModal.show('edit-video');
                        setCurrentVideo(video);
                      "
                      class="dropdown-item"
                      style="cursor: pointer"
                    >
                      Edit
                    </div>
                    <div
                      v-if="video.status != 'approved'"
                      @click="changeVideoStatus(video, 'approved')"
                      class="dropdown-item"
                      style="cursor: pointer"
                    >
                      Approve
                    </div>
                    <div
                      v-if="video.status == 'approved'"
                      @click="changeVideoStatus(video, 'disapproved')"
                      class="dropdown-item"
                      style="cursor: pointer"
                    >
                      Disapprove
                    </div>
                    <div
                      @click="deleteVideo(video)"
                      class="dropdown-item"
                      style="cursor: pointer"
                    >
                      Delete
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="alert alert-info text-center" v-else>
          <h5>No Record Found</h5>
        </div>
      </div>
      <div class="card_footer">
        <pagination
          :data="recordedVideos"
          @pagination-change-page="fetchRecordedVideos"
        >
          <span slot="prev-nav">&lt; Previous</span>
          <span slot="next-nav">Next &gt;</span>
        </pagination>
      </div>
    </div>

    <!-- Create Subject Modal  -->
    <b-modal id="create-video" hide-footer title="Upload Pre-recorded videos">
      <UploadVideo
        :my_modal="this.$bvModal"
        @video-created="fetchRecordedVideos"
      />
    </b-modal>

    <!-- Edit Subject Modal  -->
    <b-modal id="edit-video" hide-footer title="Edit Recorded Video details">
      <EditVideo
        :my_modal="this.$bvModal"
        :currentVideo="currentVideo"
        @video-updated="fetchRecordedVideos"
      />
    </b-modal>
  </div>
</template>


<script>
import VueElementLoading from "vue-element-loading";
import swal from "sweetalert";
import axios from "axios";
import UploadVideo from "./UploadVideo.vue";
import EditVideo from "./EditVideo";

export default {
  components: {
    VueElementLoading,
    UploadVideo,
    EditVideo,
  },
  data() {
    return {
      recordedVideosLoading: false,
      subjects: {},
      currentVideo: {},
      recordedVideos: {},
      filter: {
        subjectId: "",
      },
    };
  },
  methods: {
    // get all uploaded pre recorded videos
    fetchRecordedVideos(page = 1) {
      this.recordedVideosLoading = true;
      axios
        .post(
          "/client/digital_class/recorded_videos/fetch?page=" + page,
          this.filter
        )
        .then((res) => {
          this.recordedVideos = res.data;
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.recordedVideosLoading = false;
        });
    },

    //  method to fetch all subjects to be displayed
    getAllSubjects() {
      this.recordedVideosLoading = true;
      axios
        .post(this.$route("admin.curriculum.subjects"), {
          class_id: this.$page.props.auth.user.class_id ?? "",
        })
        .then((res) => {
          this.subjects = res.data;
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.recordedVideosLoading = false;
        });
    },

    OpenUrl() {
      window.open(
        this.$page.props.auth.user.google_meet_link,
        "popup",
        "width=600,height=600"
      );
      return false;
    },

    //  method to store the current selected subject for edit
    setCurrentVideo(data) {
      this.currentVideo = data;
    },

    //  Approve / Disapprove video
    changeVideoStatus(data, status) {
      this.$swal({
        icon: "warning",
        title: "Change video status to " + status + " ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes Continue!",
        cancelButtonText: "No, Exit!",
        cancelButtonColor: "#d92550",
        showCloseButton: true,
        showLoaderOnConfirm: true,
      }).then((result) => {
        if (result.value) {
          this.recordedVideosLoading = true;
          axios
            .post(
              this.$route("client.digital_class.recorded_videos.change_status"),
              {
                videoId: data.id,
                status: status,
              }
            )
            .then((res) => {
              this.$toast.success("Video status changed successfully");
              this.fetchRecordedVideos();
            })
            .catch((err) => {
              this.$toast.error("An error occured. Please, try again");
            })
            .finally(() => {
              this.recordedVideosLoading = false;
            });
        } else {
          this.$swal("Cancelled", "Operation Cancelled", "info");
          this.loading = false;
        }
      });
    },

    //  Delete videos
    deleteVideo(data) {
      this.$swal({
        icon: "warning",
        title: "Delete Video",
        text: "This action is irreversible. Are you sure you want to continue?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes Continue!",
        cancelButtonText: "No, Exit!",
        cancelButtonColor: "#d92550",
        showCloseButton: true,
        showLoaderOnConfirm: true,
      }).then((result) => {
        if (result.value) {
          this.recordedVideosLoading = true;
          axios
            .post(this.$route("client.digital_class.recorded_videos.delete"), {
              videoId: data.id,
            })
            .then((res) => {
              this.$toast.success("Video deleted successfully");
              this.fetchRecordedVideos();
            })
            .catch((err) => {
              this.$toast.error("An error occured. Please, try again");
            })
            .finally(() => {
              this.recordedVideosLoading = false;
            });
        } else {
          this.$swal("Cancelled", "Operation Cancelled", "info");
          this.loading = false;
        }
      });
    },

    reloadData() {
      this.fetchRecordedVideos();
      this.getAllSubjects();
    },
  },
  mounted() {
    this.reloadData();
  },
};
</script>

<style scoped>
.selected-row {
  background-color: rgb(181, 253, 223) !important;
}
</style>
