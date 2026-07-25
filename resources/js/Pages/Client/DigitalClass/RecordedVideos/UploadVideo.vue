<template>
  <div class="card">
    <VueElementLoading
      :active="classVideoLoading"
      spinner="line-wave"
      color="var(--primary)"
    />
    <form @submit.prevent="uploadVideo">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="alert alert-info text-justify mb-4">
              <b>Note:</b> All videos are uploaded to the RainbowRise youtube
              channel. This might affect upload time depending on the size of
              the video.
            </div>
            <div class="mb-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Subject</span>
                </div>
                <select
                  class="custom-select"
                  v-model="form.subject"
                  @change="getSubjectTopics"
                  required
                >
                  <option value="">--Select Subject--</option>
                  <option
                    v-for="subject in subjects"
                    :key="subject.id"
                    :value="subject.id"
                  >
                    {{ subject.subject_name }}
                  </option>
                </select>
              </div>
              <p class="text-danger" v-if="errorMsg.subject">
                {{ errorMsg.subject[0] }}
              </p>
            </div>
            <div class="mb-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" v-if="topicLoading == true"
                    ><i class="fa fa-spinner fa-pulse fa-1x"></i
                  ></span>
                  <span class="input-group-text" v-else>Topic</span>
                </div>
                <select class="custom-select" v-model="form.topic" required>
                  <option value="">--Select Topic--</option>
                  <option
                    v-for="topic in topics"
                    :key="topic.id"
                    :value="topic.id"
                  >
                    {{ topic.topic_name }}
                  </option>
                </select>
              </div>
              <p class="text-danger" v-if="errorMsg.topic">
                {{ errorMsg.topic[0] }}
              </p>
            </div>
            <div class="mb-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Title</span>
                </div>
                <input type="text" v-model="form.title" class="form-control" />
              </div>
              <p class="text-danger" v-if="errorMsg.title">
                {{ errorMsg.title[0] }}
              </p>
            </div>
            <div class="mb-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Description</span>
                </div>
                <textarea
                  v-model="form.description"
                  class="form-control"
                  rows="2"
                ></textarea>
              </div>
              <p class="text-danger" v-if="errorMsg.description">
                {{ errorMsg.description[0] }}
              </p>
            </div>
            <!-- HTML block to preview the video -->
            <div
              :key="refreshKey"
              style="
                display: flex;
                justify-content: center;
                align-items: center;
              "
              class="col-12 mb-3"
              v-if="fileType == 'video' && url"
            >
              <video controls style="max-width: 100%; max-height: 200px">
                <source :src="url" />
              </video>
            </div>
            <div class="mb-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Price (NGN)</span>
                </div>
                <input
                  type="number"
                  step="0.01"
                  min="0"
                  v-model="form.price"
                  class="form-control"
                  placeholder="0 = Free"
                />
              </div>
              <p class="text-muted small mt-1">Set 0 for free access</p>
            </div>
            <div class="mb-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Select Video</span>
                </div>
                <input
                  type="file"
                  class="form-control"
                  placeholder=""
                  @change="onFileChange"
                />
              </div>
              <p class="text-danger" v-if="fileType && fileType != 'video'">
                *Only video files are allowed
              </p>
              <p class="text-danger" v-if="errorMsg.videoFile">
                {{ errorMsg.videoFile[0] }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="d-block text-right card-footer">
        <button type="button" class="mr-2 btn btn-link btn-sm" @click="closeMe">
          Cancel
        </button>
        <button
          type="submit"
          :disabled="fileType != 'video'"
          class="btn btn-sm"
          style="background-color: #002147 !important; color: white !important"
        >
          Upload
        </button>
      </div>
    </form>
  </div>
</template>

  <script>
import VueElementLoading from "vue-element-loading";
import axios from "axios";

export default {
  components: {
    VueElementLoading,
  },
  props: {
    my_modal: Object,
  },
  data() {
    return {
      classVideoLoading: false,
      topicLoading: false,
      subjects: {},
      topics: {},
      errorMsg: {},
      url: "",
      fileExt: "",
      fileType: "",
      form: {
        subject: "",
        topic: "",
        title: "",
        description: "",
        videoFile: "",
        price: "",
      },
      refreshKey: 0,
    };
  },
  mounted() {
    this.getAllSubjects();
  },
  methods: {
    //  method to fetch all subjects to be displayed
    getAllSubjects() {
      this.classVideoLoading = true;
      axios
        .post(this.$route("client.curriculum.subjects"))
        .then((res) => {
          this.subjects = res.data.filter((e) => {
            return e.status == "approved";
          });
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.classVideoLoading = false;
        });
    },
    //  method to fetch specific subject topics to be displayed
    getSubjectTopics() {
      this.topicLoading = true;
      axios
        .get(this.$route("client.curriculum.subjects.topics", this.form.subject))
        .then((res) => {
          this.topics = res.data;
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.topicLoading = false;
        });
    },
    onFileChange(e) {
      this.fileType = "";
      this.url = "";
      this.refreshKey += 1;
      const file = e.target.files[0];
      const splittedFileType = file.type.split("/")[0];
      const splittedFileExt = file.type.split("/")[1];
      this.fileType = splittedFileType;
      this.fileExt = splittedFileExt;
      //////variable to preview image (image local url)
      this.url = URL.createObjectURL(file);
      this.form.videoFile = file;
    },
    //  method to send form data to server for database entry
    uploadVideo() {
      this.classVideoLoading = true;
      let form = new FormData();
      form.append("subject", this.form.subject);
      form.append("topic", this.form.topic);
      form.append("title", this.form.title);
      form.append("description", this.form.description);
      form.append("video", this.form.videoFile);
      axios
        .post(this.$route("client.digital_class.recorded_videos.create"), form)
        .then((response) => {
          this.$toast.success("Video uploaded successfully");
          this.$emit("video-created");
          this.closeMe();
        })
        .catch((err) => {
          this.$toast.error("An error occured. Please, try again");
          this.errorMsg = err.response.data.errors;
        })
        .finally(() => {
          this.classVideoLoading = false;
        });
    },
    closeMe() {
      this.my_modal.hide("create-video");
    },
  },
};
</script>
