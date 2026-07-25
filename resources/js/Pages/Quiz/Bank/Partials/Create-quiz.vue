<template>
  <div class="card">
    <VueElementLoading
      :active="classCreateLoading"
      spinner="line-wave"
      color="var(--primary)"
    />
    <form @submit.prevent="saveQuiz">
      <div class="card-body">
        <div class="row">
          <div class="col-12 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Title</span>
              </div>
              <input
                type="text"
                v-model="form.title"
                class="form-control"
                placeholder=""
              />
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Duration</span>
              </div>
              <input
                type="text"
                v-model="form.duration"
                class="form-control"
                placeholder=""
              />
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">class</span>
              </div>
              <select
                class="custom-select"
                v-model="form.class"
                @change="getAllSubjects"
                required
              >
                <option value="">--Select Class--</option>
                <option v-for="cl in classes" :key="cl.id" :value="cl.id">
                  {{ cl.class_name }}
                </option>
              </select>
              <span class="text-danger" v-if="errorMsg.subject">
                {{ errorMsg.class[0] }}
              </span>
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Subject</span>
              </div>
              <select
                class="custom-select"
                v-model="form.subject"
                @change="getCategory"
                required
              >
                <option value="">--Select Subject--</option>
                <option
                  v-for="subject in subjects"
                  :key="subject.id"
                  :value="subject.id"
                >
                  {{ subject.subject_name }}
                </option>
              </select>
              <span class="text-danger" v-if="errorMsg.subject">
                {{ errorMsg.subject[0] }}
              </span>
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" v-if="topicLoading == true"
                  ><i class="fa fa-spinner fa-pulse fa-1x"></i
                ></span>
                <span class="input-group-text" v-else>Category</span>
              </div>
              <select class="custom-select" v-model="form.category_id" required>
                <option value="">--Select Category--</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                  {{ cat?.topic?.topic_name }}
                </option>
              </select>
            </div>
            <span class="text-danger" v-if="errorMsg.category_id">
              {{ errorMsg.category_id[0] }}
            </span>
          </div>
        </div>
      </div>
      <div class="d-block text-right card-footer">
        <button type="button" class="mr-2 btn btn-link btn-sm" @click="closeMe">
          Cancel
        </button>
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
      </div>
    </form>
  </div>
</template>

  <script>
import VueElementLoading from "vue-element-loading";
import axios from "axios";

export default {
  components: {
    VueElementLoading,
  },
  props: {
    my_modal: Object,
  },
  data() {
    return {
      classCreateLoading: false,
      topicLoading: false,
      subjects: {},
      classes: {},
      topics: {},
      errorMsg: {},
      form: {},
      live_class: {},
      categories: {},
    };
  },
  mounted() {
    this.getClass();
  },
  methods: {
    getClass() {
      this.classCreateLoading = true;
      axios
        .get(this.$route("get-class"))
        .then((res) => {
          this.classes = res.data.filter((e) => {
            return e.status == "approved";
          });
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.classCreateLoading = false;
        });
    },
    getAllSubjects() {
      this.classCreateLoading = true;
      axios
        .post(this.$route("client.curriculum.subjects"), {
          class_id: this.form.class,
        })
        .then((res) => {
          this.subjects = res.data.filter((e) => {
            return e.status == "approved";
          });
        })
        .catch((err) => {})
        .finally(() => {
          this.classCreateLoading = false;
        });
    },

    getCategory() {
      axios
        .post(this.$route("assessment.get_quiz_category"), {
          subject: this.form.subject,
          class_id: this.form.class_id,
        })
        .then((res) => {
          this.categories = res.data.data;
        })
        .catch((err) => {
          this.$swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.topicLoading = false;
        });
    },
    //   //  method to send form data to server for database entry
    saveQuiz() {
      //  console.log(this.form);
      this.classCreateLoading = true;
      axios
        .post(this.$route("assessment.set_quiz"), this.form)
        .then((response) => {
          this.$toast.success("Quiz created successfully");
          this.$emit("quiz-created");
          this.closeMe();
        })
        .catch((err) => {
          this.$toast.error("Unable to save category");
          this.errorMsg = err.response.data.errors;
        })
        .finally(() => {
          this.classCreateLoading = false;
        });
    },
    //  method to fetch all class to be displayed
    //    getClass() {
    //     this.classCreateLoading = true;
    //     axios
    //       .get(this.$route("get-class"))
    //       .then((res) => {
    //         this.classes = res.data.filter(e => {
    //             return e.status == 'approved'
    //         });
    //       })
    //       .catch((err) => {
    //         //   swal("Error", "Unable to fetch Subjects", "error");
    //       })
    //       .finally(() => {
    //         this.classCreateLoading = false;
    //       });
    //   },
    closeMe() {
      this.my_modal.hide("create-quiz");
    },
  },
};
</script>
