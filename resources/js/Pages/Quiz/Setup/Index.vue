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
              <div class="card_box position-relative white_bg">
                <VueElementLoading
                  :active="liveClassLoading"
                  spinner="line-wave"
                  color="var(--primary)"
                />
                <div class="white_box_tittle">
                  <div class="main-title2">
                    <h6 class="nowrap float-left mt-1 mb-0">
                      <i class="fas fa-video mr-2"></i> Assessment setup
                    </h6>
                    <div
                      class="float-right"
                      v-if="$page.props.auth.user.user_type_id == 3"
                    >
                      <button
                        @click="$bvModal.show('create-category')"
                        class="btn shadow-md btn-dark px-3 py-2"
                        style="
                          background-color: #002147 !important;
                          color: white !important;
                        "
                      >
                        <i class="mdi mdi-calendar-outline mr-1"></i>
                        Add Quiz Category
                      </button>
                    </div>
                  </div>
                </div>
                <div class="box_body">
                  <div class="table-responsive-sm">
                    <table
                      class="table table-bordered table-striped"
                      v-if="quiz_category.data != ''"
                    >
                      <thead>
                        <tr>
                          <th width="3%">#</th>
                          <th width="20%">Topic as Category Name</th>
                          <th width="20%">Subject With Code</th>
                          <th width="20%">Class</th>
                          <th width="15%">Status</th>
                          <th width="3%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(qc, i) in quiz_category.data" :key="i">
                          <td>{{ i + 1 }}</td>
                          <td>
                            {{ qc?.topic?.topic_name }}
                          </td>
                          <td>
                            {{
                              qc?.subject?.subject_name +
                              "- (" +
                              qc?.subject?.subject_code +
                              ")"
                            }}
                          </td>
                          <td>{{ qc.class && qc.class.class_name }}</td>
                          <td>
                            <span
                              class="badge text-capitalize py-2 px-2"
                              :class="{
                                'badge-success': qc.status == 'approved',
                                'badge-danger': qc.status == 'disapproved',
                                'badge-info': qc.status == 'pending',
                              }"
                            >
                              {{ qc.status }}
                            </span>
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
                              <div class="dropdown-menu dropdown-menu-left">
                                <div
                                  class="dropdown-item"
                                  @click="setLive(qc.id)"
                                  style="cursor: pointer"
                                >
                                  Change Status
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
                </div>
                <div class="card_footer">
                  <pagination
                    :data="quiz_category"
                    @pagination-change-page="fetchQuizCategory"
                  >
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                  </pagination>
                </div>
              </div>
            </div>
          </div>
        </div>
        <b-modal id="create-category" hide-footer title="Set Quiz Category">
          <CreateCategory
            :my_modal="this.$bvModal"
            @quiz-created="fetchQuizCategory"
          />
        </b-modal>
      </div>
    </layout>
  </div>
</template>
<script>
import layout from "../../BaseLayouts/Layout.vue";
import CreateCategory from "./Partials/Create.vue";
import VueElementLoading from "vue-element-loading";
import axios from "axios";

export default {
  components: {
    layout,
    CreateCategory,
    VueElementLoading,
  },
  data() {
    return {
      liveClassLoading: false,
      quiz_category: {},
      errorMsg: {},
    };
  },
  methods: {
    fetchQuizCategory(page = 1) {
      this.quizLoading = true;
      axios
        .post("/assessment/fetch_quiz_category?page=" + page, this.filter)
        .then((res) => {
          this.quiz_category = res.data;
        })
        .catch((err) => {
          this.$swal("Error", "Unable to fetch Quiz Category", "error");
        })
        .finally(() => {
          this.quizLoading = false;
        });
    },
    setLive(data) {
      this.liveClassLoading = true;
      axios
        .post("/assessment/set_quiz_category_live", { id: data })
        .then((response) => {
          // console.log(response.data);
          this.$toast.success("Set To Live successfully");
          this.fetchQuizCategory();
          // this.closeMe();
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
    this.fetchQuizCategory();
  },
};
</script>
