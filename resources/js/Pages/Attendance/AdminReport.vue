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
                    <h3>Attendance Report</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card_box position-relative mb_30 white_bg">
              <div class="box_header">
                <div class="main-title">
                  <h4>All Students Attendance</h4>
                </div>
                <div class="box_header_right">
                  <button class="btn btn-secondary btn-sm" @click="exportCsv">
                    <i class="fas fa-download"></i> Export CSV
                  </button>
                </div>
              </div>
              <div class="box_body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Total Sessions</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Percentage</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(row, index) in report" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ row.student_name }}</td>
                        <td>{{ row.total_sessions }}</td>
                        <td>{{ row.present }}</td>
                        <td>{{ row.absent }}</td>
                        <td>
                          <div class="progress" style="height: 20px;">
                            <div class="progress-bar" :class="row.percentage >= 75 ? 'bg-success' : row.percentage >= 50 ? 'bg-warning' : 'bg-danger'" :style="{ width: row.percentage + '%' }">
                              {{ row.percentage }}%
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr v-if="!report.length">
                        <td colspan="6" class="text-center">No attendance data available</td>
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
    return { report: [] };
  },
  methods: {
    exportCsv() {
      let csv = "Student Name,Total Sessions,Present,Absent,Percentage\n";
      this.report.forEach((r) => {
        csv += `"${r.student_name}",${r.total_sessions},${r.present},${r.absent},${r.percentage}%\n`;
      });
      const blob = new Blob([csv], { type: "text/csv" });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "attendance_report.csv";
      a.click();
    },
  },
  mounted() {
    axios.get("/attendance/report").then((res) => {
      this.report = res.data.report;
    });
  },
};
</script>
