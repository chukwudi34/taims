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
                        <i class="fas fa-caret-right"></i> setup
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card_box position-relative mb_30 white_bg">
                <VueElementLoading
                  :active="quizLoading"
                  spinner="line-wave"
                  color="var(--primary)"
                />
                <div class="box_body">
                  <div class="table-responsive-sm">
                    <table
                      class="table table-bordered table-striped"
                      v-if="quiz_category.data != ''"
                    >
                      <thead>
                        <tr>
                          <th width="3%">#</th>
                          <th width="20%">Quiz Title</th>
                          <th width="20%">No. Of Questions</th>
                          <th width="20%">Enable Report</th>
                          <th width="15%">Attempt Status</th>
                          <th width="15%">Attempted Question</th>
                          <th width="3%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(qc, i) in quiz_category.data" :key="i">
                          <td>{{ i + 1 }}</td>
                          <td>{{ qc.title }}</td>
                          <td>{{ qc.question_count }}</td>
                          <td>{{ qc.report }}</td>
                          <td>
                            <span
                              class="badge_btn_4"
                              v-if="qc?.question?.length >= 0"
                              >Participated</span
                            >
                            <span class="badge_btn_2" v-else
                              >Not Participated</span
                            >
                          </td>
                          <td>
                            <button
                              class="btn btn-outline-info btn-sm"
                              type="button"
                            >
                              View
                              <span class="badge badge-pill badge-success">
                                {{ qc?.question?.length }}
                              </span>
                            </button>
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
                                <a
                                  :href="$route('assessment.start_quiz', qc.id)"
                                  v-if="qc.status == 'approved'"
                                  class="dropdown-item"
                                  style="cursor: pointer"
                                >
                                  Start Quiz
                                </a>
                                <a
                                  :href="
                                    $route(
                                      'assessment.get_quiz_result_student',
                                      qc.id
                                    )
                                  "
                                  v-if="qc.status == 'disapproved'"
                                  class="dropdown-item"
                                  style="cursor: pointer"
                                >
                                  Check Your Result
                                </a>
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
                    :data="quiz_category"
                    @pagination-change-page="fetchLiveQuiz"
                  >
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                  </pagination>
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
import layout from "../../BaseLayouts/Layout.vue";
import VueElementLoading from "vue-element-loading";
import axios from "axios";

export default {
  components: {
    layout,
    VueElementLoading,
  },
  data() {
    return {
      quizLoading: false,
      quiz_category: {},
      errorMsg: {},
    };
  },
  methods: {
    fetchLiveQuiz(page = 1) {
      this.quizLoading = true;
      axios
        .post("/assessment/fetch_live_quiz?page=" + page, this.filter)
        .then((res) => {
          // console.log(res.data);
          this.quiz_category = res.data;
        })
        .catch((err) => {
          this.$swal("Error", "Unable to fetch Quiz Category", "error");
        })
        .finally(() => {
          this.quizLoading = false;
        });
    },
    StartQuiz(quiz_id) {
      console.log(quiz_id);
    },
    // setLive(data){
    //     this.liveClassLoading = true;
    //     axios
    //     .post("assessment.set_live", data)
    //     .then((response) => {
    //         this.$toast.success("Set To Live successfully");
    //         // this.closeMe();
    //     })
    //     .catch((err) => {
    //         // this.$toast.error("Unable to save category");
    //         this.errorMsg = err.response.data.errors;
    //     })
    //     .finally(() => {
    //         this.liveClassLoading = false;
    //     });
    // }
  },
  mounted() {
    this.fetchLiveQuiz();
  },
};
</script>
