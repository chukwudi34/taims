<template>
  <div class="card">
    <VueElementLoading
      :active="classEditLoading"
      spinner="line-wave"
      color="var(--primary)"
    />
    <form @submit.prevent="updateLiveClassSchedule">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="mb-4">
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
                      {{subject.subject_name}}
                    </option>
                  </select>
                </div>
                <p class="text-danger" v-if="errorMsg.subject">{{errorMsg.subject[0]}}</p>
            </div>
            <div class="mb-4">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" v-if="topicLoading == true"><i class="fa fa-spinner fa-pulse fa-1x"></i></span>
                    <span class="input-group-text" v-else>Topic</span>
                  </div>
                  <select
                    class="custom-select"
                    v-model="form.topic"
                    required
                  >
                    <option value="">--Select Topic--</option>
                    <option
                      v-for="topic in topics"
                      :key="topic.id"
                      :value="topic.id"
                    >
                      {{topic.topic_name}}
                    </option>
                  </select>
                </div>
                <p class="text-danger" v-if="errorMsg.topic">{{errorMsg.topic[0]}}</p>
            </div>
            <div class="mb-4">
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
                <p class="text-danger" v-if="errorMsg.class_date">{{errorMsg.class_date[0]}}</p>
            </div>
            <div class="mb-4">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Class Time</span>
                  </div>
                  <input
                    type="time"
                    v-model="form.class_time"
                    class="form-control"
                    placeholder=""
                  />
                </div>
                <p class="text-danger" v-if="errorMsg.class_time">{{errorMsg.class_time[0]}}</p>
            </div>
            <div class="mb-4">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Price (NGN)</span>
                  </div>
                  <input
                    type="number"
                    step="0.01"
                    min="0"
                    v-model="form.price"
                    class="form-control"
                    placeholder="0 = Free"
                  />
                </div>
                <p class="text-muted small mt-1">Set 0 for free access</p>
            </div>
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
    currentClass: Object,
    my_modal: Object,
  },
  data() {
    return {
      classEditLoading: false,
      topicLoading: false,
      subjects: {},
      topics: {},
      errorMsg: {},
      form: {
        subject: '',
        topic: this.currentClass.topic_id,
        class_date: this.currentClass.date,
        class_time: this.currentClass.time,
        price: this.currentClass.price || '',
        liveClassId: this.currentClass.id
      },
    };
  },
  mounted() {
      this.getAllSubjects()
      this.form.subject = this.currentClass.subject_id
  },
  methods: {
    //  method to fetch all subjects to be displayed
    getAllSubjects() {
      this.classEditLoading = true;
      axios
        .get(this.$route("client.curriculum.subjects"))
        .then((res) => {
          this.subjects = res.data.filter(e => {
              return e.status == 'approved'
          });
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.classEditLoading = false;
        });
    },
    //  method to fetch specific subject topics to be displayed
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
    //  method to send form data to server for database entry
    updateLiveClassSchedule() {
      this.classEditLoading = true;
      axios
        .post(this.$route("client.digital_class.live_class.edit"), this.form)
        .then((response) => {
          this.$toast.success("Class schedule updated successfully");
          this.$emit("class-updated");
          this.closeMe();
        })
        .catch((err) => {
          this.$toast.error("Unable to save class schedule");
          this.errorMsg = err.response.data.errors;
        })
        .finally(() => {
          this.classEditLoading = false;
        });
    },
    closeMe() {
      this.my_modal.hide("edit-class");
    },
  },
  watch: {
      'form.subject': function() {
        this.getSubjectTopics()
      }
  }
};
</script>
