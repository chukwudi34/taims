<template>
  <layout>
    <div class="main_content_iner overly_inner">
      <div class="container-fluid p-0">
        <div class="row">
          <div class="col-12">
            <div class="page_title_box d-flex align-items-center justify-content-between">
              <div class="page_title_left">
                <h3 class="f_s_30 f_w_700 text_white">Dashboard</h3>
              </div>
            </div>
          </div>
        </div>

        <!-- Admin Analytics -->
        <template v-if="analytics.role === 'admin'">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12" v-for="stat in adminStats" :key="stat.label">
              <div class="white_card card_height_100 mb_20">
                <div class="white_card_header">
                  <div class="box_header m-0">
                    <div class="main-title">
                      <h3 class="m-0">{{ stat.label }}</h3>
                    </div>
                  </div>
                </div>
                <div class="white_card_body d-flex align-items-center" style="height: 140px">
                  <h4 class="f_w_100 f_s_60">{{ stat.value }}</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="white_card mb_20">
                <div class="white_card_header"><h4>Users by Role</h4></div>
                <div class="white_card_body">
                  <canvas id="usersByRoleChart" height="200"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="white_card mb_20">
                <div class="white_card_header"><h4>Monthly Registrations</h4></div>
                <div class="white_card_body">
                  <canvas id="monthlyRegistrationsChart" height="200"></canvas>
                </div>
              </div>
            </div>
          </div>
        </template>

        <!-- Teacher Analytics -->
        <template v-if="analytics.role === 'teacher'">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12" v-for="stat in teacherStats" :key="stat.label">
              <div class="white_card card_height_100 mb_20">
                <div class="white_card_header">
                  <div class="box_header m-0">
                    <div class="main-title">
                      <h3 class="m-0">{{ stat.label }}</h3>
                    </div>
                  </div>
                </div>
                <div class="white_card_body d-flex align-items-center" style="height: 140px">
                  <h4 class="f_w_100 f_s_60">{{ stat.value }}</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="white_card mb_20">
                <div class="white_card_header"><h4>Live Class Status</h4></div>
                <div class="white_card_body">
                  <canvas id="liveClassStatusChart" height="200"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="white_card mb_20">
                <div class="white_card_header"><h4>Live Classes per Month</h4></div>
                <div class="white_card_body">
                  <canvas id="monthlyLiveClassesChart" height="200"></canvas>
                </div>
              </div>
            </div>
          </div>
        </template>

        <!-- Student Analytics -->
        <template v-if="analytics.role === 'student'">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12" v-for="stat in studentStats" :key="stat.label">
              <div class="white_card card_height_100 mb_20">
                <div class="white_card_header">
                  <div class="box_header m-0">
                    <div class="main-title">
                      <h3 class="m-0">{{ stat.label }}</h3>
                    </div>
                  </div>
                </div>
                <div class="white_card_body d-flex align-items-center" style="height: 140px">
                  <h4 class="f_w_100 f_s_60">{{ stat.value }}</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="white_card mb_20">
                <div class="white_card_header"><h4>Attendance Overview</h4></div>
                <div class="white_card_body">
                  <canvas id="attendanceChart" height="200"></canvas>
                </div>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>
  </layout>
</template>
<script>
import layout from "../BaseLayouts/Layout.vue";
import axios from "axios";
export default {
  components: { layout },
  data() {
    return { analytics: {} };
  },
  computed: {
    adminStats() {
      if (this.analytics.role !== 'admin') return [];
      const s = this.analytics.stats || {};
      return [
        { label: 'Instructors', value: s.total_teacher },
        { label: 'Students', value: s.total_student },
        { label: 'Total Users', value: s.total_users },
        { label: 'Live Classes', value: s.total_live_classes },
        { label: 'Recorded Videos', value: s.total_recorded_videos },
        { label: 'Quizzes', value: s.total_quizzes },
        { label: 'Transactions', value: s.total_transactions },
        { label: 'Revenue (NGN)', value: s.total_revenue },
      ];
    },
    teacherStats() {
      if (this.analytics.role !== 'teacher') return [];
      const s = this.analytics.stats || {};
      return [
        { label: 'My Live Classes', value: s.my_live_classes },
        { label: 'My Students', value: s.my_students },
        { label: 'My Recorded Videos', value: s.my_recorded_videos },
        { label: 'My Quizzes', value: s.my_quizzes },
      ];
    },
    studentStats() {
      if (this.analytics.role !== 'student') return [];
      const s = this.analytics.stats || {};
      return [
        { label: 'My Purchases', value: s.my_purchases },
        { label: 'Attendance Rate', value: s.attendance_rate },
        { label: 'Total Attendance', value: s.total_attendance },
        { label: 'Upcoming Classes', value: s.upcoming_live_classes },
      ];
    },
  },
  methods: {
    getData() {
      axios.get("analytic/analytic").then((res) => {
        this.analytics = res.data;
        this.$nextTick(() => this.renderCharts());
      }).catch(() => {
        this.$toast.error("Failed to load analytics");
      });
    },
    renderCharts() {
      if (this.analytics.role === 'admin') {
        const c = this.analytics.charts;
        if (c?.users_by_role) {
          new Chart(document.getElementById('usersByRoleChart'), {
            type: 'doughnut',
            data: { labels: c.users_by_role.labels, datasets: [{ data: c.users_by_role.data, backgroundColor: ['#002147', '#fdc800', '#28a745'] }] },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } },
          });
        }
        if (c?.monthly_registrations) {
          new Chart(document.getElementById('monthlyRegistrationsChart'), {
            type: 'line',
            data: { labels: c.monthly_registrations.labels, datasets: [{ label: 'Registrations', data: c.monthly_registrations.data, borderColor: '#002147', fill: false, tension: 0.3 }] },
            options: { responsive: true, plugins: { legend: { display: false } } },
          });
        }
      }
      if (this.analytics.role === 'teacher') {
        const c = this.analytics.charts;
        if (c?.live_class_status) {
          new Chart(document.getElementById('liveClassStatusChart'), {
            type: 'doughnut',
            data: { labels: c.live_class_status.labels, datasets: [{ data: c.live_class_status.data, backgroundColor: ['#28a745', '#dc3545', '#ffc107'] }] },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } },
          });
        }
        if (c?.monthly_live_classes) {
          new Chart(document.getElementById('monthlyLiveClassesChart'), {
            type: 'bar',
            data: { labels: c.monthly_live_classes.labels, datasets: [{ label: 'Live Classes', data: c.monthly_live_classes.data, backgroundColor: '#002147' }] },
            options: { responsive: true, plugins: { legend: { display: false } } },
          });
        }
      }
      if (this.analytics.role === 'student') {
        const c = this.analytics.charts;
        if (c?.attendance) {
          new Chart(document.getElementById('attendanceChart'), {
            type: 'doughnut',
            data: { labels: c.attendance.labels, datasets: [{ data: c.attendance.data, backgroundColor: ['#28a745', '#dc3545', '#ffc107'] }] },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } },
          });
        }
      }
    },
  },
  mounted() {
    this.getData();
  },
};
</script>
