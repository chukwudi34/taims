<template>
  <div>
    <div class="card_box position-relative mb_30 white_bg">
      <VueElementLoading
        :active="liveClassLoading"
        spinner="line-wave"
        color="var(--primary)"
      />
      <div class="white_box_tittle">
        <div class="main-title2">
          <h6 class="nowrap float-left mt-1 mb-0">
            <i class="fas fa-video mr-2"></i> Live Class
          </h6>
          <div class="float-right">
            <button
              @click="$bvModal.show('create-class')"
              class="btn shadow-md btn-sm px-3 py-2"
              v-if="$page.props.auth.user.user_type_id == 1"
              style="
                background-color: #002147 !important;
                color: white !important;
              "
            >
              <i class="mdi mdi-calendar-outline mr-1"></i>
              Schedule Class
            </button>
          </div>
        </div>
      </div>
      <div class="box_body">
        <div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Subject</span>
                </div>
                <select
                  class="custom-select"
                  v-model="filter.subjectId"
                  @change="fetchLiveClassData"
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
        <div class="table-responsive-sm">
          <table
            class="table table-striped table-bordered"
            v-if="liveclasses.data != ''"
          >
            <thead>
              <tr>
                <th width="3%">#</th>
                <th width="15%">Subject</th>
                <th width="10%">Topic</th>
                <th width="10%">Class Date</th>
                <th width="10%">Start time</th>
                <th width="10%">End time</th>
                <th width="5%">Duration(Minutes)</th>
                <th width="18%">Created by</th>
                <th width="5%">Price</th>
                <th width="5%">Status</th>
                <th width="3%">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(lcs, index) in liveclasses.data" :key="lcs.id">
                <td>{{ index + 1 }}.</td>
                <td style="text-transform: capitalize">
                  {{ lcs.subject.subject_name }}
                </td>
                <td>{{ lcs.topic.topic_name }}</td>
                <td>{{ lcs.date }}</td>
                <td>{{ lcs.start_time }}</td>
                <td>{{ lcs.end_time }}</td>
                <td>{{ lcs.time_duration }}</td>
                <td>{{ lcs.creator.lname }} {{ lcs.creator.fname }}</td>
                <td>
                  <span v-if="lcs.price > 0">NGN {{ lcs.price }}</span>
                  <span v-else class="text-success">Free</span>
                </td>
                <td>
                  <span
                    :class="[
                      'badge',
                      'badge-pill',
                      lcs.status === 'expired'
                        ? 'badge-danger'
                        : lcs.status === 'ongoing'
                        ? 'badge-warning'
                        : lcs.status === 'not_started'
                        ? 'badge-success'
                        : 'badge-secondary',
                    ]"
                  >
                    {{
                      lcs.status === "not_started"
                        ? "Not Started"
                        : lcs.status === "ongoing"
                        ? "Ongoing"
                        : lcs.status === "expired"
                        ? "Expired"
                        : "Unknown"
                    }}
                  </span>
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
                        @click="OpenUrl(lcs.meeting_url)"
                        class="dropdown-item"
                        style="cursor: pointer"
                        v-if="
                          $page.props.auth.user.user_type_id == 1 &&
                          lcs.status == 'not_started'
                        "
                      >
                        <span> Start Class </span>
                      </div>
                      <a
                        :href="`/client/digital_class/live_class/join/${lcs.id}`"
                        class="dropdown-item"
                        style="cursor: pointer"
                        v-if="
                          $page.props.auth.user.user_type_id == 2 &&
                          lcs.status == 'ongoing'
                        "
                      >
                        <span> Join Class </span>
                      </a>
                      <!-- <div
                        @click="
                          $bvModal.show('edit-class');
                          setCurrentClass(lcs);
                        "
                        class="dropdown-item"
                        style="cursor: pointer"
                        v-if="
                          lcs.status == '1' &&
                          $page.props.auth.user.google_meet_link ==
                            lcs.meeting_url
                        "
                      >
                        Edit Class
                      </div> -->
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
      </div>
      <div class="card_footer">
        <pagination
          :data="liveclasses"
          @pagination-change-page="fetchLiveClassData"
        >
          <span slot="prev-nav">&lt; Previous</span>
          <span slot="next-nav">Next &gt;</span>
        </pagination>
      </div>
    </div>
    <!-- Create Subject Modal  -->
    <b-modal id="create-class" hide-footer title="Schedule Live Class">
      <CreateLiveClassVue
        :my_modal="this.$bvModal"
        @class-created="fetchLiveClassData"
      />
    </b-modal>
    <!-- Edit Subject Modal  -->
    <b-modal id="edit-class" hide-footer title="Edit Live Class">
      <EditLiveClassVue
        :my_modal="this.$bvModal"
        :currentClass="currentClass"
        @class-updated="fetchLiveClassData"
      />
    </b-modal>
  </div>
</template>


<script>
import VueElementLoading from "vue-element-loading";
import swal from "sweetalert";
import axios from "axios";
import CreateLiveClassVue from "./CreateLiveClass.vue";
import EditLiveClassVue from "./EditLiveClass.vue";

export default {
  props: ["condition"],
  components: {
    VueElementLoading,
    CreateLiveClassVue,
    EditLiveClassVue,
  },
  data() {
    return {
      liveClassLoading: false,
      subjects: {},
      currentClass: {},
      liveclasses: {},
      filter: {
        subjectId: "",
      },
      notify: false,
      popUp: null,
      openTabs: {},
    };
  },
  methods: {
    isCurrentTime(startTime) {
      const now = new Date();
      const currentTime = `${now.getHours()}:${String(
        now.getMinutes()
      ).padStart(2, "0")}`;
      return startTime === currentTime;
    },
    // get all Liveclass record
    fetchLiveClassData(page = 1) {
      this.liveClassLoading = true;
      axios
        .post(
          "/client/digital_class/live_class/fetch?page=" + page,
          this.filter
        )
        .then((res) => {
          this.liveclasses = res.data;
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.liveClassLoading = false;
        });
    },

    getAllSubjects() {
      this.liveClassLoading = true;
      axios
        .post(this.$route("client.curriculum.subjects"))
        .then((res) => {
          this.subjects = res.data;
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.liveClassLoading = false;
        });
    },

    generateUuid() {
      const array = new Uint32Array(4);
      window.crypto.getRandomValues(array);
      return Array.from(array, (dec) => dec.toString(16).padStart(8, "0")).join(
        "-"
      );
    },

    OpenUrl(meeting_url) {
      const tabId = this.generateUuid();
      localStorage.setItem("tabId", tabId);
      const urlWithId = `${meeting_url}?dtwesdffrr2a/=${tabId}`;
      const popUp = window.open(urlWithId, "_blank");
      if (!this.openTabs) {
        this.openTabs = {};
      }
      this.openTabs[tabId] = popUp;
    },

    closeMeeting() {
      const tabId = localStorage.getItem("tabId");
      if (this.openTabs && this.openTabs[tabId]) {
        this.openTabs[tabId].close();
        delete this.openTabs[tabId];
      }
    },
    checkMeetingExpiration() {
      const now = new Date().getTime();
      this.liveclasses.data.forEach((lcs) => {
        const dateTimeString = `${lcs.date} ${lcs.end_time}`;
        const endTime = new Date(dateTimeString).getTime();
        if (new Date(endTime).toISOString() <= new Date(now).toISOString()) {
          this.closeMeeting();
          this.fetchLiveClassData();
        }
      });
    },
    setCurrentClass(data) {
      this.currentClass = data;
    },

    reloadData() {
      this.fetchLiveClassData();
      this.getAllSubjects();
    },
  },
  mounted() {
    this.reloadData();
    setInterval(() => {
      this.checkMeetingExpiration();
    }, 60000);
  },

  created() {
    eventBus.$on("class-created", () => {
      this.notify = true;
    });
  },
};
</script>

<style scoped>
.selected-row {
  background-color: rgb(181, 253, 223) !important;
}
</style>
