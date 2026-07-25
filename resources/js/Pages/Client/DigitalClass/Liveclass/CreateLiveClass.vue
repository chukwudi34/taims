<template>
  <div class="card">
    <VueElementLoading
      :active="classCreateLoading"
      spinner="line-wave"
      color="var(--primary)"
    />
    <form @submit.prevent="saveLiveClassSchedule">
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
          <div class="col-md-12 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Class Date</span>
              </div>
              <input
                type="date"
                v-model="form.class_date"
                class="form-control"
              />
            </div>
            <p class="text-danger" v-if="errorMsg.class_date">
              {{ errorMsg.class_date[0] }}
            </p>
          </div>
          <div class="col-md-6 mb-3">
            <div class="mb-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Start Time</span>
                </div>
                <input
                  type="time"
                  v-model="form.start_time"
                  class="form-control"
                  placeholder=""
                />
              </div>
              <span class="text-danger" v-if="errorMsg.start_time">
                {{ errorMsg.start_time[0] }}
              </span>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="mb-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">End Time</span>
                </div>
                <input
                  type="time"
                  v-model="form.end_time"
                  class="form-control"
                  placeholder=""
                />
              </div>
              <span class="text-danger" v-if="errorMsg.end_time">
                {{ errorMsg.end_time[0] }}
              </span>
            </div>
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
        subject: "",
        topic: "",
        class_date: "",
        end_time: "",
        start_time: "",
        class: "",
      },
      lastClickTime: 0,
    };
  },
  mounted() {
    // this.getAllSubjects();
    this.getClass();
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
    saveLiveClassSchedule() {
      this.classCreateLoading = true;
      axios
        .post(this.$route("client.digital_class.live_class.create"), this.form)
        .then((response) => {
          this.$toast.success("Class schedule saved successfully");

          this.closeMe();
          this.$emit("class-created");
        })
        .catch((err) => {
          this.$toast.error("Unable to save class schedule");
          this.errorMsg = err.response.data.errors;
        })
        .finally(() => {
          this.classCreateLoading = false;
        });
    },
    getClass() {
      this.classCreateLoading = true;
      axios
        .get(this.$route("client.classes"))
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
      this.my_modal.hide("create-class");
    },
  },
};
</script>
