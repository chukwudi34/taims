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
          <table
            class="table table-bordered table-responsive table-hover"
            v-if="liveclasses.data != ''"
          >
            <thead>
              <tr>
                <th width="3%">#</th>
                <th width="20%">Subject</th>
                <th width="25%">Topic</th>
                <th width="15%">Start Date</th>
                <th width="10%">Start Time</th>
                <!-- <th>Joined</th> -->
                <th width="18%">Created by</th>
                <th>Status</th>
                <th width="3%">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(lcs, index) in liveclasses.data" :key="lcs.id">
                <td>{{ index + 1 }}.</td>
                <td style="text-transform: capitalize">
                  {{ lcs.subject.subject_name }}
                </td>
                <td>{{ lcs.topic && lcs.topic.topic_name }}</td>
                <td>{{ lcs.date }}</td>
                <td>{{ lcs.time }}</td>
                <!-- <td>0</td> -->
                <td>{{ lcs.creator.lname }} {{ lcs.creator.fname }}</td>
                <td>
                  <div
                    class="badge badge-pill badge-success badge-success"
                    :class="{
                      'badge-success': lcs.status == '1',
                      'badge-danger': lcs.status == '3',
                      'badge-info': lcs.status == '2',
                    }"
                  >
                    <span v-if="lcs.status == ('1' && lcs.meeting_url != lcs.meeting_url =='')"> ONGOING</span>
                    <span v-if="lcs.status == '2'"> SCHEDULED</span>
                    <span v-if="lcs.status == '3'"> ELASPED</span>
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
                          $bvModal.show('edit-class');
                          setCurrentClass(lcs);
                        "
                        class="dropdown-item"
                        style="cursor: pointer"
                      >
                        Edit Class
                      </div>
                      <div
                        @click="OpenUrl(lcs.meeting_url)"
                          v-if="lcs.status == '1'"
                        class="dropdown-item"
                        style="cursor: pointer"
                      >
                        Join Class
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
              :data="liveclasses"
              @pagination-change-page="fetchLiveClassData"
            >
              <span slot="prev-nav">&lt; Previous</span>
              <span slot="next-nav">Next &gt;</span>
            </pagination>
        </div>
      </div>

      <!-- Create Subject Modal  -->
      <!-- <b-modal id="create-class" hide-footer title="Schedule Live Class">
        <CreateLiveClassVue
          :my_modal="this.$bvModal"
          @class-created="fetchLiveClassData"
        />
      </b-modal> -->

      <!-- Edit Subject Modal  -->
      <!-- <b-modal id="edit-class" hide-footer title="Edit Live Class">
        <EditLiveClassVue
          :my_modal="this.$bvModal"
          :currentClass="currentClass"
          @class-updated="fetchLiveClassData"
        /> -->
      <!-- </b-modal> -->
    </div>
  </template>


  <script>
  import VueElementLoading from "vue-element-loading";
  import swal from "sweetalert";
  import axios from "axios";
//   import CreateLiveClassVue from "./CreateLiveClass.vue";
//   import EditLiveClassVue from "./EditLiveClass.vue";

  export default {
    components: {
      VueElementLoading,
    //   CreateLiveClassVue,
    //   EditLiveClassVue
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
      };
    },
    methods: {
      // get all Liveclass record
      fetchLiveClassData(page = 1) {
        this.liveClassLoading = true;
        axios
          .post("/client/digital_class/live_class/fetch?page="+page, this.filter)
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

      //  method to fetch all subjects to be displayed
      getAllSubjects() {
        this.liveClassLoading = true;
        axios
          .get(this.$route("client.curriculum.subjects"))
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

      OpenUrl(meeting_url) {
            window.open(meeting_url, 'popup', 'width=600,height=600');
            // this.meeting_url_close = meeting_url,
            localStorage.setItem("link", JSON.stringify({
                url: meeting_url
            }))
            setTimeout(this.trackClick.bind(this), 60 * 1000); // Call the trackClick function after 60 seconds
            // window.open(this.$page.props.auth.user.google_meet_link,'popup','width=600,height=600'); return false;
        },
        trackClick() {
            // let currentTime = Date.now();
            let a = JSON.parse(localStorage.getItem('link'));
            if(a.url === this.$page.props.auth.user.google_meet_link){
                window.close(a.url);
            }
                // console.log(a.url);
                // popup.close();
                // popup.location.href === 'https://www.example.com';


            // if (currentTime - this.lastClickTime > (60 * 1000)) { // Check if it has been an hour since the last click
            //      let a = JSON.parse(localStorage.getItem('link'));
            //     console.log(a);
            //     // eventBus.$emit('disable-description');
            //     // window.close(this.OpenUrl(this.meeting_url_close),'popup','width=600,height=600');
            //     // alert(123);
            //     // localStorage.setItem("link",{
            //     //     url:
            //     // })
            //     this.lastClickTime = currentTime; // Update last click time
            // } else {
            //     console.log("Function clicked within an hour of previous click");
            // }
        },
        UpdateStatusForElapsed() {
            axios
                .post("/client/digital_class/live_class/update_elapsed")
                .then((res) => {
                    //   this.liveclasses = res.data;
                })
                .catch((err) => {
                    // swal("Error", "Unable to fetch u", "error");
                })
                .finally(() => {
                    //   this.liveClassLoading = false;
                });
        },
      //  method to store the current selected subject for edit
      setCurrentClass(data) {
        this.currentClass = data;
      },

      reloadData() {
        this.fetchLiveClassData();
        this.getAllSubjects()
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
