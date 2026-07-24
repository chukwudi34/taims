<template>
  <div>
    <layout>
      <div class="main_content_iner">
        <div class="container-fluid p-0 sm_padding_15px">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="dashboard_header mb_20">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="dashboard_header_title">
                      <h3>Assessment</h3>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="dashboard_breadcam text-right">
                      <p>
                        <inertia-link href="/">Assessment</inertia-link>
                        <i class="fas fa-caret-right"></i> assessment
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card_box position-relative mb_30 white_bg">
                <VueElementLoading
                  :active="liveClassLoading"
                  spinner="line-wave"
                  color="var(--primary)"
                />
                <div class="white_box_tittle">
                  <div class="main-title2">
                    <h6 class="nowrap float-left mt-1 mb-0">
                      <i class="fas fa-video mr-2"></i> Assessment
                    </h6>
                    <div class="float-right">
                      <button
                        style="font-size: 14px"
                        @click="$bvModal.show('create-quiz')"
                        class="btn shadow-md btn-dark px-3 py-2"
                      >
                        <i class="mdi mdi-calendar-outline mr-1"></i>
                        Assessment
                      </button>
                    </div>
                  </div>
                </div>
                <div class="box_body">
                  <div>
                    <!-- <div class="row">
                      <div class="col-md-4 mb-3">
                        <div class="input-group mb-4">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Assessment</span>
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
                    </div> -->
                  </div>
                  <table
                    class="table table-bordered table-responsive table-hover"
                  >
                    <thead>
                      <tr>
                        <th width="3%">#</th>
                        <th width="20%">Subject</th>
                        <th width="25%">Topic</th>
                        <th width="15%">Start Date</th>
                        <th width="10%">Start Time</th>
                        <th>Joined</th>
                        <th width="18%">Created by</th>
                        <th>Status</th>
                        <th width="3%">Action</th>
                      </tr>
                    </thead>
                  </table>
                  <div class="alert alert-info text-center">
                    <h5>No Record Found</h5>
                  </div>
                </div>
                <div class="card_footer">
                  <!-- <pagination
                          :data="liveclasses"
                          @pagination-change-page="fetchLiveClassData"
                        >
                          <span slot="prev-nav">&lt; Previous</span>
                          <span slot="next-nav">Next &gt;</span>
                        </pagination> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </layout>
  </div>
</template>
  <script>
import layout from "../BaseLayouts/Layout.vue";
//   import LiveClassVue from "./LiveClass.vue";
//   import meetingLink from "./CreateMeetingLink.vue";
//   import StudentLive from "../StudentLiveClass/Index.vue";

export default {
  components: {
    layout,
    //   LiveClassVue,
    //   meetingLink,
    //   StudentLive
  },
};
</script>
