<template>
  <div>
    <layout>
      <div class="main_content_iner overly_inner">
        <div class="container-fluid p-0">
          <div class="row">
            <div class="col-12">
              <div
                class="page_title_box d-flex align-items-center justify-content-between"
              >
                <div class="page_title_left">
                  <h3 class="f_s_30 f_w_700 text_white">Dashboard</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3">
              <div class="white_card card_height_100 mb_20">
                <div class="white_card_header">
                  <div class="box_header m-0">
                    <div class="main-title">
                      <h3 class="m-0">Total Platform Instructor</h3>
                    </div>
                  </div>
                </div>
                <div class="white_card_body">
                  <h4 class="f_w_100 f_s_60">{{ analytic.total_teacher }}</h4>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="white_card card_height_100 mb_20">
                <div class="white_card_header">
                  <div class="box_header m-0">
                    <div class="main-title">
                      <h3 class="m-0">Total Registered Student</h3>
                    </div>
                  </div>
                </div>
                <div
                  class="white_card_body d-flex align-items-center"
                  style="height: 140px"
                >
                  <h4 class="f_w_100 f_s_60">{{ analytic.total_student }}</h4>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="white_card card_height_100 mb_20">
                <div class="white_card_header">
                  <div class="box_header m-0">
                    <div class="main-title">
                      <h3 class="m-0">Total Student Under Class</h3>
                    </div>
                  </div>
                </div>
                <div
                  class="white_card_body d-flex align-items-center"
                  style="height: 140px"
                >
                  <h4 class="f_w_100 f_s_60">
                    {{ analytic.total_student_class }}
                  </h4>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="white_card card_height_100 mb_20">
                <div class="white_card_header">
                  <div class="box_header m-0">
                    <div class="main-title">
                      <h3 class="m-0">Total User(s)</h3>
                    </div>
                  </div>
                </div>
                <div
                  class="white_card_body d-flex align-items-center"
                  style="height: 140px"
                >
                  <h4 class="f_w_100 f_s_60">{{ analytic.total_users }}</h4>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="white_card card_height_100 mb_20">
                <div class="white_card_header">
                  <div class="box_header m-0">
                    <div class="main-title">
                      <h3 class="m-0">Total Student Under Class</h3>
                    </div>
                  </div>
                </div>
                <div
                  class="white_card_body d-flex align-items-center"
                  style="height: 140px"
                >
                  <h4 class="f_w_100 f_s_60">
                    {{ analytic.total_student_each_teacher }}
                  </h4>
                </div>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="white_card card_height_100 mb_20">
                <div class="white_card_header">
                  <div class="box_header m-0">
                    <div class="main-title">
                      <h3 class="m-0">Total Live Class created</h3>
                    </div>
                  </div>
                </div>
                <div
                  class="white_card_body d-flex align-items-center"
                  style="height: 140px"
                >
                  <h4 class="f_w_100 f_s_60">
                    {{ analytic.live_class_for_teacher }}
                  </h4>
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
import axios from "axios";
export default {
  components: {
    layout,
  },
  data() {
    return {
      analytic: {},
    };
  },
  methods: {
    getData() {
      this.loading = true;
      axios
        .get("analytic/analytic")
        .then((res) => {
          this.analytic = res.data;
        })
        .catch((err) => {
          this.$toast.error(err.response.data, {
            position: "top-center",
            timeout: 5000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });
        })
        .finally((response) => {
          this.loading = false;
        });
    },
  },
  mounted() {
    this.getData();
  },
};
</script>
