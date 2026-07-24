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
                    <h3>Mark Attendance</h3>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="dashboard_breadcam text-right">
                    <p><inertia-link href="/attendance/index">Attendance</inertia-link> <i class="fas fa-caret-right"></i> Mark Attendance</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card_box position-relative mb_30 white_bg">
              <div class="box_header">
                <div class="main-title">
                  <h4>{{ liveClass.subject }} — {{ liveClass.topic }}</h4>
                  <p>{{ liveClass.date }} | {{ liveClass.start_time }} — {{ liveClass.end_time }}</p>
                </div>
              </div>
              <div class="box_body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(student, index) in students" :key="student.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ student.name }}</td>
                        <td>
                          <select v-model="student.status" class="form-control form-control-sm" style="width: auto;">
                            <option value="">Select</option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="excused">Excused</option>
                          </select>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="text-center mt-3">
                  <button class="btn btn-primary" @click="submitAttendance" :disabled="!canSubmit">
                    <i class="fas fa-save"></i> Save Attendance
                  </button>
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
  props: { liveClassId: Number },
  data() {
    return { liveClass: {}, students: [] };
  },
  computed: {
    canSubmit() {
      return this.students.some((s) => s.status);
    },
  },
  methods: {
    fetchStudents() {
      axios.get(`/attendance/live-class/${this.liveClassId}`).then((res) => {
        this.liveClass = res.data.liveClass;
        this.students = res.data.students;
      });
    },
    submitAttendance() {
      axios
        .post("/attendance/store", {
          live_class_id: this.liveClass.id,
          attendance: this.students
            .filter((s) => s.status)
            .map((s) => ({ student_id: s.id, status: s.status })),
        })
        .then(() => {
          this.$toast.success("Attendance saved");
          this.fetchStudents();
        })
        .catch((err) => {
          this.$toast.error("Error saving attendance");
        });
    },
  },
  mounted() {
    this.fetchStudents();
  },
};
</script>
