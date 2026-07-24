<template>
  <div>
    <layout>
      <div class="main_content_iner">
        <div class="container-fluid p-0 sm_padding_15px">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="dashboard_header mb_50">
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
              <div
                class="card p-4"
                style="background: white !important"
                v-if="start == false"
              >
                <div class="mx-auto">
                  <button
                    style="font-size: 14px"
                    @click="StartQuiz()"
                    class="btn shadow-md btn-dark px-3 py-2"
                  >
                    <i class="mdi mdi-calendar-outline mr-1"></i>
                    Start Quiz
                  </button>
                </div>
              </div>
              <div
                class="card_box position-relative mb_30 white_bg p-4"
                v-if="start == true"
              >
                <div class="text-center" v-if="quiz.data == ''">
                  <div class="mx-auto">
                    <div style="color: black; font-size: 25px !important">
                      No Quiz Set
                    </div>
                    <a
                      href="/assessment/take_quiz_index"
                      style="font-size: 14px"
                      class="btn shadow-md btn-dark px-3 py-2 pt-3"
                    >
                      <i class="mdi mdi-calendar-outline mr-1"></i>
                      Return To Initailization Page
                    </a>
                  </div>
                </div>
                <div class="box_body" v-if="quiz.data != ''">
                  <div class="row">
                    <div class="col-md-12">
                      <form @submit.prevent="SubmitData">
                        <div
                          class="pt-4 mt-4"
                          style="background: white !important"
                          v-for="(q, index) in quiz.data"
                          :key="index"
                        >
                          <div
                            class="card-header"
                            style="background: white !important"
                          >
                            <div class="d-flex justify-content-between">
                              <div>
                                <h6 class="d-inline mb-0 mt-2">
                                  <b>Question {{ index + 1 }}</b>
                                </h6>
                                &nbsp;&nbsp;
                                <span class="badge badge-info badge-pill"
                                  >{{ q.mark_obtainable + " " }} MARK(s)</span
                                >
                              </div>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-12">
                                <p
                                  class="text-capitalize"
                                  v-html="q.question_title"
                                  ref="myParagraph"
                                  :class="'para'"
                                ></p>
                                <div data-v-6e7c21d6="" class="separator mt-4">
                                  answer choices
                                </div>
                                <div class="mt-4">
                                  <div class="row">
                                    <div
                                      class="col-md-3"
                                      v-for="(opt, i) in q.options"
                                      :key="i"
                                    >
                                      <div class="form-check">
                                        <label class="form-check-label">
                                          <input
                                            type="radio"
                                            class="form-check-input"
                                            :name="'option-' + index"
                                            :id="'option-' + index + '-' + i"
                                            :value="opt"
                                            @change="
                                              updateSelectedOption(
                                                index,
                                                opt,
                                                q
                                              )
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
                        <div
                          class="row mt-5"
                          v-if="isPaginatedDataFinished == true"
                        >
                          <div class="col-md-7"></div>
                          <div class="col-md-5">
                            <div class="row">
                              <div class="col-md-12">
                                <button
                                  type="submit"
                                  class="btn btn-primary w-100"
                                >
                                  Submit
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="mt-3">
                    <pagination
                      :data="quiz"
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
      </div>
    </layout>
  </div>
</template>
<script>
import layout from "../../../BaseLayouts/Layout.vue";
import VueElementLoading from "vue-element-loading";
import axios from "axios";

export default {
  props: ["quiz_id"],
  components: {
    layout,
    VueElementLoading,
  },
  data() {
    return {
      quizLoading: false,
      quiz: {},
      errorMsg: {},
      start: false,
      form: {
        myChoice: [],
      },
      myParagraph: "",
      isPaginatedDataFinished: false,
      selectedOptions: [],
      selectedOptiona: null,
    };
  },
  methods: {
    updateSelectedOption(index, option, question) {
      const questionData = {
        question_index: index,
        option: option,
        question: question,
      };
      const questionIndex = this.selectedOptions.findIndex(
        (q) => q.question_index === index
      );
      if (questionIndex === -1) {
        this.selectedOptions.push(questionData);
      } else {
        this.selectedOptions.splice(questionIndex, 1, questionData);
      }
      // console.log(this.selectedOptions);
    },
    fetchLiveQuiz(page = 1) {
      this.quizLoading = true;
      axios
        .post("/assessment/fetch_to_start?page=" + page, { id: this.quiz_id })
        .then((res) => {
          this.quiz = res.data;
          if (this.quiz.total == this.quiz.data.length) {
            this.isPaginatedDataFinished = true;
          }
        })
        .catch((err) => {
          this.$swal("Error", "Unable to fetch", "error");
        })
        .finally(() => {
          this.quizLoading = false;
        });
    },
    StartQuiz() {
      this.start = true;
      this.fetchLiveQuiz();
    },
    SubmitData() {
      axios
        .post("/assessment/submit_quiz_student", { data: this.selectedOptions })
        .then((response) => {
          this.$toast.success("Submitted successfully");
          this.$inertia.visit("/assessment/take_quiz_index", {
            method: "get",
            data: { user_type: this.dt },
            replace: false,
            preserveState: false,
            preserveScroll: false,
            only: [],
            headers: {},
            errorBag: null,
            forceFormData: false,
            onCancelToken: (cancelToken) => {},
            onCancel: () => {},
            onBefore: (visit) => {},
            onStart: (visit) => {},
            onProgress: (progress) => {},
            onSuccess: (page) => {},
            onError: (errors) => {},
            onFinish: (visit) => {},
          });
        })
        .catch((err) => {
          this.$toast.error("Unable to save Question");
        })
        .finally(() => {
          this.classCreateLoading = false;
        });
    },
    // Checked(opt, question) {
    //     this.form.myChoice = [{ option: opt, question: question }];
    //     // console.log(this.myChoice);
    //     //    const existingIndex = this.myChoice.findIndex((item) => {
    //     //         return item.option === opt && item.question === question;
    //     //     });

    //     //     if (existingIndex >= 0) {
    //     //         // Remove the duplicate record
    //     //         this.myChoice = this.myChoice.filter((item, index) => {
    //     //         return index !== existingIndex;
    //     //         });
    //     //     } else {
    //     //         // Add the new record
    //     //         this.myChoice.push({
    //     //         option: opt,
    //     //         question: question
    //     //         });
    //     //     }
    //     //     console.log(this.myChoice);
    //     // this.myChoice.push({
    //     //     option:opt,
    //     //     question:question
    //     // });

    //     // let data = this.myChoice.filter((value, index) => {
    //     //     console.log(value.option.id,opt.id);
    //     //     return this.myChoice.indexOf(value) === index;
    //     // });
    //     // console.log(data);
    //     // this.myChoice.forEach(element => {
    //     // });

    // }
  },
  mounted() {},
};
</script>
