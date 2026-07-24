<template>
  <layout>
    <div class="main_content_iner">
      <div class="container-fluid p-0 sm_padding_15px">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="dashboard_header mb_50">
              <div class="row">
                <div class="col-lg-6">
                  <div class="dashboard_header_title">
                    <h3>Attendance</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12" v-if="userType == 1">
            <div class="card_box position-relative mb_30 white_bg">
              <div class="box_header">
                <div class="main-title">
                  <h4>Your Live Classes</h4>
                  <p>Select a live class to mark attendance</p>
                </div>
              </div>
              <div class="box_body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Topic</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(cls, index) in liveClasses" :key="cls.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ cls.subject }}</td>
                        <td>{{ cls.topic }}</td>
                        <td>{{ cls.date }}</td>
                        <td>
                          <inertia-link :href="'/attendance/live-class/' + cls.id" class="btn btn-sm btn-primary">
                            <i class="fas fa-check"></i> Mark Attendance
                          </inertia-link>
                        </td>
                      </tr>
                      <tr v-if="!liveClasses.length">
                        <td colspan="5" class="text-center">No live classes found</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12" v-else-if="userType == 2">
            <StudentHistory />
          </div>
          <div class="col-12" v-else-if="userType == 3">
            <AdminReport />
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>
<script>
import layout from "../BaseLayouts/Layout.vue";
import StudentHistory from "./StudentHistory.vue";
import AdminReport from "./AdminReport.vue";
import axios from "axios";
export default {
  components: { layout, StudentHistory, AdminReport },
  data() {
    return {
      userType: this.$page.props.auth.user.user_type_id,
      liveClasses: [],
    };
  },
  mounted() {
    if (this.userType == 1) {
      axios.post("/client/digital_class/live_class/fetch").then((res) => {
        this.liveClasses = (res.data.liveClasses || []).map((c) => ({
          id: c.id,
          subject: c.subject?.subject_name || "N/A",
          topic: c.topic?.topic_name || "N/A",
          date: c.date,
        }));
      });
    }
  },
};
</script>
