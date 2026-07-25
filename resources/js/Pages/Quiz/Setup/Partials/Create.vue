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
                @change="getSubjectTopics"
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
                <span class="input-group-text" v-else>Topic</span>
              </div>
              <select class="custom-select" v-model="form.topic" required>
                <option value="">--Select Topic--</option>
                <option
                  v-for="topic in topics"
                  :key="topic.id"
                  :value="topic.id"
                >
                  {{ topic.topic_name }}
                </option>
              </select>
            </div>
            <span class="text-danger" v-if="errorMsg.topic">
              {{ errorMsg.topic[0] }}
            </span>
          </div>
        </div>
      </div>
      <div class="d-block text-right card-footer">
        <button type="button" class="mr-2 btn btn-link btn-sm" @click="closeMe">
          Cancel
        </button>
        <button
          type="submit"
          class="btn btn-sm"
          style="background-color: #002147 !important; color: white !important"
        >
          Save
        </button>
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
      form: {
        live_class: "",
      },
      live_class: {},
    };
  },
  methods: {
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
    getSubjectTopics() {
      this.topicLoading = true;
      axios
        .get(this.$route("client.curriculum.subjects.topics", this.form.subject))
        .then((res) => {
          this.topics = res.data;
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.topicLoading = false;
        });
    },
    saveQuiz() {
      // return console.log(this.form);
      this.classCreateLoading = true;
      axios
        .post(this.$route("assessment.set_quiz_category"), this.form)
        .then((response) => {
          this.$toast.success("Quiz category created successfully");
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
    closeMe() {
      this.my_modal.hide("create-category");
    },
  },
  mounted() {
    this.getClass();
  },
};
</script>
