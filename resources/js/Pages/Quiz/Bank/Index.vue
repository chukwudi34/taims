<template>
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
                        <i class="fas fa-caret-right"></i> Bank
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
                      <i class="fas fa-video mr-2"></i> Assessment Bank
                    </h6>
                    <div class="float-right">
                      <button
                        @click="$bvModal.show('create-quiz')"
                        style="
                          background-color: #002147 !important;
                          color: white !important;
                        "
                        class="btn shadow-md btn-sm px-3 py-2"
                      >
                        <i class="mdi mdi-calendar-outline mr-1"></i>
                        Add Quiz
                      </button>
                    </div>
                  </div>
                </div>
                <div class="box_body">
                  <div class="table-responsive">
                  <table
                    class="table table-bordered table-striped"
                    v-if="quizzes.data != ''"
                  >
                    <thead>
                      <tr>
                        <th width="3%">#</th>
                        <th width="20%">Name</th>
                        <th width="20%">Duration</th>
                        <th width="20%">Total Participant(s)</th>
                        <th width="25%">Status</th>
                        <th width="3%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(quz, index) in quizzes.data" :key="quz.id">
                        <td>{{ index + 1 }}.</td>
                        <td style="text-transform: capitalize">
                          {{ quz.title }}
                        </td>
                        <td>{{ quz.duration }}</td>
                        <td>{{ participant.total_participant || 0 }}</td>
                        <td>
                          <div
                            class="badge badge-pill badge-success badge-success"
                            :class="{
                              'badge-success': quz.status == 'approved',
                              'badge-danger': quz.status == 'disapproved',
                              'badge-info': quz.status == 'pending',
                            }"
                          >
                            <span v-if="quz.status == 'approved'">Live</span>
                            <span v-if="quz.status == 'pending'">Not Live</span>
                            <span v-if="quz.status == 'disapproved'">
                              Disapproved</span
                            >
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
                              <a
                                :href="
                                  $route(
                                    'assessment.manage_assessment_questions',
                                    quz.id
                                  )
                                "
                                v-if="quz.status == 'approved'"
                                @click="setId(quz.id)"
                                class="dropdown-item"
                                style="cursor: pointer"
                              >
                                Manage Quiz Question
                              </a>
                              <div
                                class="dropdown-item"
                                v-if="quz.status == 'pending'"
                                style="cursor: pointer"
                                @click="setLive(quz.id)"
                              >
                                Set To Live
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
                <div class="card_footer"></div>
              </div>
            </div>
          </div>
        </div>
        <b-modal id="create-quiz" hide-footer title="Set Quiz">
          <CreateQuiz :my_modal="this.$bvModal" @quiz-created="fetchQuiz" />
        </b-modal>
      </div>
    </div>
  </layout>
</template>
<script>
import layout from "../../BaseLayouts/Layout.vue";
import CreateQuiz from "./Partials/Create-quiz.vue";
import axios from "axios";
import VueElementLoading from "vue-element-loading";

export default {
  components: {
    layout,
    CreateQuiz,
    VueElementLoading,
  },
  data() {
    return {
      liveClassLoading: false,
      live_class: {},
      quizzes: {},
      quiz_id: "",
      participant: "",
    };
  },
  methods: {
    fetchQuiz(page = 1) {
      this.quizLoading = true;
      axios
        .post("/assessment/fetch_quiz?page=" + page, this.filter)
        .then((res) => {
          this.quizzes = res.data;
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.quizLoading = false;
        });
    },
    fetchParticipant() {
      this.quizLoading = true;
      axios
        .get("/assessment/get_quiz_result_teacher")
        .then((res) => {
          this.participant = res.data;
        })
        .catch((err) => {})
        .finally(() => {
          this.quizLoading = false;
        });
    },
    setId(id) {
      this.quiz_id = id;
    },
    setLive(data) {
      this.liveClassLoading = true;
      axios
        .post("/assessment/set_quiz_live", { id: data })
        .then((response) => {
          this.$toast.success("Set To Live successfully");
          this.fetchQuiz();
        })
        .catch((err) => {
          // this.$toast.error("Unable to save category");
          this.errorMsg = err.response.data.errors;
        })
        .finally(() => {
          this.liveClassLoading = false;
        });
    },
  },
  mounted() {
    this.fetchQuiz();
    this.fetchParticipant();
  },
};
</script>
