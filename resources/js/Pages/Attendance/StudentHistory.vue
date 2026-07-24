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
                    <h3>My Attendance</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card_box position-relative mb_30 white_bg">
              <div class="box_header">
                <div class="main-title">
                  <h4>Attendance Record</h4>
                  <p>Overall Attendance: <strong>{{ percentage }}%</strong></p>
                </div>
              </div>
              <div class="box_body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Subject</th>
                        <th>Topic</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(record, index) in records" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ record.date }}</td>
                        <td>{{ record.subject }}</td>
                        <td>{{ record.topic }}</td>
                        <td>
                          <span :class="'badge badge-' + (record.status === 'present' ? 'success' : record.status === 'absent' ? 'danger' : 'warning')">
                            {{ record.status }}
                          </span>
                        </td>
                      </tr>
                      <tr v-if="!records.length">
                        <td colspan="5" class="text-center">No attendance records found</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>
<script>
import layout from "../../BaseLayouts/Layout.vue";
import axios from "axios";
export default {
  components: { layout },
  data() {
    return { records: [], percentage: 0 };
  },
  mounted() {
    axios.get("/attendance/history").then((res) => {
      this.records = res.data.records;
      this.percentage = res.data.percentage;
    });
  },
};
</script>
