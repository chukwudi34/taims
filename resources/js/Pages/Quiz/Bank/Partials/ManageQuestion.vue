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
                        <inertia-link href="/">Quiz Question</inertia-link>
                        <i class="fas fa-caret-right"></i>
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
                <div class="white_box_tittle">
                  <div class="main-title2">
                    <h6 class="nowrap float-left mt-1 mb-0">
                      <i class="mdi mdi-pencil mr-2"></i> Manage Quiz Question
                    </h6>
                    <div class="float-right">
                      <button
                        style="font-size: 14px"
                        @click="
                          generateQustionBoard(), addSearchResult(searchInputs)
                        "
                        class="btn shadow-md btn-dark px-3 py-2"
                        type="button"
                      >
                        <i class="mdi mdi-comment-question mr-1"></i>
                        New Question
                      </button>
                      <inertia-link
                        href="/assessment/quiz_bank"
                        style="font-size: 14px"
                        class="btn shadow-md btn-dark px-3 py-2"
                      >
                        <i class="mdi mdi-calendar-outline mr-1"></i>
                        Done
                      </inertia-link>
                    </div>
                  </div>
                </div>
                <div class="box_body">
                  <div v-if="showQuest == true" class="mt-4">
                    <VueElementLoading
                      :active="quizLoading"
                      spinner="line-wave"
                      color="var(--primary)"
                    />
                    <form @submit.prevent="submitData">
                      <div
                        class="row justify-content-center"
                        v-for="(inp, i) in searchInputs"
                        :key="'inp' + i"
                      >
                        <div class="col-md-10">
                          <div class="row my-2">
                            <div class="col-sm-5"></div>
                            <div class="col-sm-2">
                              <input
                                v-model="form[0].mark_obtainable"
                                :id="`mark_obtainable-${i}`"
                                type="number"
                                placeholder="Enter Quiz Mark"
                                class="form-control form-control-sm"
                              />
                              <i>question obtainable mark</i>
                            </div>
                            <div class="col-sm-5"></div>
                          </div>
                          <div class="mt-2">
                            <vue-editor
                              v-model="form[0].question_title"
                            ></vue-editor>
                          </div>
                          <div
                            class="alert alert-info mt-3"
                            style="
                              padding-top: 0.5rem !important;
                              padding-bottom: 0.5rem !important;
                            "
                          >
                            Click on an Option from below to set as Correct
                            Answer
                          </div>
                          <div class="mt-3">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <input
                                        type="checkbox"
                                        :id="`answer_id-0`"
                                        @change="disableChecked()"
                                        :disabled="isDisabled1"
                                      />
                                    </div>
                                  </div>
                                  <input
                                    type="text"
                                    class="form-control"
                                    v-model="form[1].option"
                                  />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <input
                                        type="checkbox"
                                        :id="`answer_id-1`"
                                        @change="disableChecked2()"
                                        :disabled="isDisabled2"
                                      />
                                    </div>
                                  </div>
                                  <input
                                    type="text"
                                    class="form-control"
                                    v-model="form[2].option"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <input
                                        type="checkbox"
                                        :id="`answer_id-2`"
                                        @change="disableChecked3()"
                                        :disabled="isDisabled3"
                                      />
                                    </div>
                                  </div>
                                  <input
                                    type="text"
                                    class="form-control"
                                    v-model="form[3].option"
                                  />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <input
                                        type="checkbox"
                                        :id="`answer_id-3`"
                                        @change="disableChecked4()"
                                        :disabled="isDisabled4"
                                      />
                                    </div>
                                  </div>
                                  <input
                                    type="text"
                                    class="form-control"
                                    v-model="form[4].option"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7"></div>
                        <div class="col-md-5">
                          <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-6">
                              <button type="button" class="btn btn-focus">
                                Cancel
                              </button>
                              <button
                                type="submit"
                                class="btn btn-primary mr-1"
                              >
                                Submit
                              </button>
                            </div>
                            <div class="col-md-2"></div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div v-if="questions != ''">
                    <div
                      class="col-md-12 alert alert-warning px-2 mt-1"
                      style="font-size: 500"
                    >
                      Please Do Not Edit the boxes for now!!!
                    </div>
                    <div class="row mt-1">
                      <div class="col-md-12 col-sm-12 col-*">
                        <div
                          class="pt-4 mt-4"
                          style="background: white !important"
                          v-for="(q, i) in questions"
                          :key="i"
                        >
                          <div
                            class="card-header"
                            style="background: white !important"
                          >
                            <div class="d-flex justify-content-between">
                              <div>
                                <h6 class="d-inline mb-0 mt-2">
                                  <b>Question {{ i + 1 }}</b>
                                </h6>
                                &nbsp;&nbsp;
                                <span class="badge badge-info badge-pill"
                                  >{{ q.mark_obtainable + " " }} MARK(s)</span
                                >
                              </div>
                              <div>
                                <div class="dropdown">
                                  <button
                                    type="button"
                                    class="btn dropdown-toggle p-0"
                                    data-toggle="dropdown"
                                  >
                                    <i class="fas fa-ellipsis-v"></i>
                                  </button>
                                  <div
                                    class="dropdown-menu dropdown-menu-right"
                                  >
                                    <div
                                      class="dropdown-item"
                                      style="cursor: pointer"
                                      @click="removeQuestion(q.id)"
                                    >
                                      Delete
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-12">
                                <p
                                  class="text-capitalize"
                                  v-html="q.question_title"
                                  :class="'para'"
                                ></p>
                                <div data-v-6e7c21d6="" class="separator mt-4">
                                  answer choices
                                </div>
                                <div class="mt-4">
                                  <div class="row">
                                    <div
                                      class="col-md-3"
                                      v-for="(opt, index) in q.options"
                                      :key="index"
                                    >
                                      <div class="form-check">
                                        <label class="form-check-label">
                                          <input
                                            type="checkbox"
                                            class="form-check-input"
                                            :value="opt.is_correct"
                                            :checked="
                                              opt.is_correct == 'true'
                                                ? true
                                                : false
                                            "
                                          />{{ opt.option }}
                                        </label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="col-12" v-if="$page.props.auth.user.user_type_id == 1">
                            <div>Not ready Yet</div>
                        </div> -->
          </div>
        </div>
      </div>
    </layout>
  </div>
</template>
<script>
import layout from "../../../BaseLayouts/Layout.vue";
import axios from "axios";
import VueElementLoading from "vue-element-loading";
import { VueEditor } from "vue2-quill-editor";

export default {
  components: {
    layout,
    VueElementLoading,
    VueEditor,
  },
  props: ["quiz_id"],
  data() {
    return {
      opt_is_correct: [],
      quizLoading: false,
      live_class: {},
      quizzes: {},
      showQuest: false,
      searchInputs: [],
      form: [
        {
          mark_obtainable: "",
          question_title: "",
        },
        {
          is_correct: document.getElementById("answer_id-0"),
          option: "",
        },
        {
          is_correct: document.getElementById("answer_id-1"),
          option: "",
        },
        {
          is_correct: document.getElementById("answer_id-2"),
          option: "",
        },
        {
          is_correct: document.getElementById("answer_id-3"),
          option: "",
        },
      ],
      submitEachRecord: false,
      isDisabled1: false,
      isDisabled2: false,
      isDisabled3: false,
      isDisabled4: false,
      questions: {},
    };
  },
  methods: {
    generateQustionBoard() {
      this.showQuest = true;
      this.quizLoading = true;
    },
    addSearchResult(searchInputs) {
      if (this.searchInputs.length == 0) {
        this.searchInputs.push({});
        this.quizLoading = false;
      }
    },
    submitData() {
      let data = [
        {
          question_title: this.form[0].question_title,
          mark_obtainable: this.form[0].mark_obtainable,
          quiz_id: this.quiz_id,
        },
        [
          {
            is_correct: document.getElementById("answer_id-0").checked,
            option: this.form[1].option,
          },
          {
            is_correct: document.getElementById("answer_id-1").checked,
            option: this.form[2].option,
          },
          {
            is_correct: document.getElementById("answer_id-2").checked,
            option: this.form[3].option,
          },
          {
            is_correct: document.getElementById("answer_id-3").checked,
            option: this.form[4].option,
          },
        ],
      ];
      this.classCreateLoading = true;
      axios
        .post(this.$route("assessment.set_quiz_question"), data)
        .then((response) => {
          if (response.data == 1) {
            this.showQuest = false;
            this.searchInputs = [];
            this.form[1].option = "";
            this.form[2].option = "";
            this.form[3].option = "";
            this.form[4].option = "";
            this.form[0].question_title = "";
            this.form[0].mark_obtainable = "";
            // this.quiz_id = '';

            this.fetchQuiz();
          }
        })
        .catch((err) => {
          this.$toast.error("Unable to save category");
          this.errorMsg = err.response.data.errors;
        })
        .finally(() => {
          this.classCreateLoading = false;
        });
    },
    fetchQuiz(page = 1) {
      this.quizLoading = true;
      axios
        .post("/assessment/fetch_quiz_questions?page=" + page, {
          filter: this.filter,
          id: this.quiz_id,
        })
        .then((res) => {
          this.questions = res.data;
          this.quizLoading = false;
        })
        .catch((err) => {
          this.quizLoading = false;
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.quizLoading = false;
        });
    },
    disableChecked() {
      let a = document.getElementById("answer_id-0");
      if (a.checked == true) {
        (this.isDisabled2 = true),
          (this.isDisabled3 = true),
          (this.isDisabled4 = true);
      } else {
        (this.isDisabled2 = false),
          (this.isDisabled3 = false),
          (this.isDisabled4 = false);
      }
    },
    disableChecked2() {
      let b = document.getElementById("answer_id-1");
      if (b.checked == true) {
        (this.isDisabled1 = true),
          (this.isDisabled3 = true),
          (this.isDisabled4 = true);
      } else {
        (this.isDisabled1 = false),
          (this.isDisabled3 = false),
          (this.isDisabled4 = false);
      }
    },
    disableChecked3() {
      let c = document.getElementById("answer_id-2");
      if (c.checked == true) {
        (this.isDisabled1 = true),
          (this.isDisabled2 = true),
          (this.isDisabled4 = true);
      } else {
        (this.isDisabled1 = false),
          (this.isDisabled2 = false),
          (this.isDisabled4 = false);
      }
    },
    disableChecked4() {
      let d = document.getElementById("answer_id-3");
      if (d.checked == true) {
        (this.isDisabled1 = true),
          (this.isDisabled2 = true),
          (this.isDisabled3 = true);
      } else {
        (this.isDisabled1 = false),
          (this.isDisabled2 = false),
          (this.isDisabled3 = false);
      }
    },
    removeQuestion(id) {
      this.$swal({
        title: "Are you sure?",
        text: "You won't be able to revert this",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .post("/assessment/delete_question", { id: id })
            .then((res) => {
              if (res.data == 1) {
                this.$swal("Deleted!", "Question has been deleted.", "success");
                this.fetchQuiz();
              }
            })
            .catch((err) => {});
        }
      });
    },
  },
  mounted() {
    this.fetchQuiz();
  },
};
</script>
<style scoped>
.dropdown-item:hover {
  background-color: #d2d2d2 !important;
}
.separator[data-v-6e7c21d6] {
  display: flex;
  align-items: center;
  text-align: center;
  background-color: #666;
  color: #fff;
  border-radius: 10px;
}
.separator[data-v-6e7c21d6]:after {
  margin-left: 0.25em;
}
.separator[data-v-6e7c21d6]:after,
.separator[data-v-6e7c21d6]:before {
  content: "";
  flex: 1;
  border-bottom: 1px solid #d2d2d2;
}

.para {
  line-height: 24px !important;
  font-size: 15px !important;
  margin-bottom: 0 !important;
  color: #212529 !important;
  font-family: nunito, sans-serif !important;
  font-weight: 500 !important;
}

vue-editor {
  height: 250px !important;
}

.form-control-sm {
  height: calc(1.8125rem + 2px);
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
  line-height: 1.5;
  border-radius: 0.2rem;
}

.btn-primary {
  color: #fff;
  background-color: #7db117;
  border-color: #7db117;
}

.btn-focus {
  color: #fff;
  background-color: #444054;
  border-color: #444054;
}
</style>
