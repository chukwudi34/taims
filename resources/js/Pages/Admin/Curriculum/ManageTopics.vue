<template>
  <div>
    <div class="card_box position-relative mb_30 white_bg">
      <VueElementLoading
        :active="topicLoading"
        spinner="line-wave"
        color="var(--primary)"
      />
      <div class="white_box_tittle">
        <div class="main-title2">
          <h6
            v-if="Object.entries(subjectData).length > 0"
            class="nowrap float-left mt-1 mb-0"
          >
            <i class="fas fa-edit"></i>
            Manage Topics for
            <span class="badge badge-pill" :class="getRandomBadgeClass()">
              {{ subjectData?.subject_name }}
            </span>
            for
            <span class="badge badge-pill" :class="getRandomBadgeClass()">{{
              subjectData?.classes?.class_name
            }}</span>
          </h6>
          <h6 v-else class="mt-1 mb-0 nowrap float-left">
            <i class="fas fa-edit"></i>
            Manage Topics
          </h6>

          <div
            v-if="
              Object.entries(subjectData).length > 0 &&
              $page.props.auth.user.user_type_id == 3
            "
            class="float-right m-0"
          >
            <button
              style="
                background-color: #002147 !important;
                color: white !important;
              "
              @click="$bvModal.show('create-topic')"
              class="btn shadow-md btn-sm px-3 py-1"
            >
              <i class="mdi mdi-plus-circle-outline mr-1"></i>
              New Topic
            </button>
          </div>
        </div>
      </div>
      <div class="box_body">
        <table
          class="table table-bordered table-sm table-striped"
          v-if="Object.entries(subjectData).length > 0 && topics.length"
        >
          <thead>
            <tr>
              <th width="5%">#</th>
              <th width="30%">Topic</th>
              <th>Description</th>
              <th v-if="$page.props.auth.user.user_type == 'admin'">
                Created By
              </th>
              <!--<th width='10%'>Status</th>-->
              <th width="5%">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(topic, index) in topics" :key="topic.id">
              <td>{{ index + 1 }}.</td>
              <td style="text-transform: capitalize">{{ topic.topic_name }}</td>
              <td>{{ topic.description }}</td>
              <td v-if="$page.props.auth.user.user_type == 'admin'">
                {{ topic.created_name }}
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
                    <div
                      @click="
                        $bvModal.show('edit-topic');
                        setCurrentTopic(topic);
                      "
                      class="dropdown-item"
                      style="cursor: pointer"
                    >
                      Edit
                    </div>
                    <div
                      @click="deleteTopic(topic.id)"
                      class="dropdown-item"
                      style="cursor: pointer"
                    >
                      Delete
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="alert alert-info text-center" v-if="subjectData == ''">
          <h5>Select a subject to manage the topics attached to it</h5>
        </div>
        <div
          class="alert alert-info text-center"
          v-if="subjectData != '' && !topics.length"
        >
          <h5>No Record Found!!!</h5>
        </div>
      </div>
    </div>

    <!-- Create Topic Modal  -->
    <b-modal id="create-topic" hide-footer title="Add New Topic">
      <create-topic
        :my_modal="this.$bvModal"
        @topic-created="showAdded"
        :subject="subjectData"
      />
    </b-modal>

    <!-- Edit Topic Modal  -->
    <b-modal id="edit-topic" hide-footer title="Edit Topic">
      <edit-topic
        :my_modal="this.$bvModal"
        @topic-updated="showAdded"
        :subject="subjectData"
        :currentTopic="currentTopic"
      />
    </b-modal>
  </div>
</template>


<script>
import CreateTopic from "./Partials/Create-topic";
import EditTopic from "./Partials/Edit-topic";
import VueElementLoading from "vue-element-loading";
import swal from "sweetalert";
import axios from "axios";

export default {
  components: {
    "create-topic": CreateTopic,
    "edit-topic": EditTopic,
    VueElementLoading,
  },
  data() {
    return {
      topicLoading: false,
      topics: {},
      currentTopic: {},
      subjectData: {},
    };
  },
  methods: {
    getRandomBadgeClass() {
      // Define your color classes
      const colors = [
        "badge-primary",
        "badge-secondary",
        "badge-success",
        "badge-danger",
        "badge-warning",
        "badge-info",
        "badge-dark",
      ];

      const randomIndex = Math.floor(Math.random() * colors.length);
      return colors[randomIndex];
    },

    //  function to fecth topics related to selected subject
    fetchTopics(data) {
      this.topicLoading = true;
      this.subjectData = data;

      axios
        .post(this.$route("admin.curriculum.topics"), { subjectId: data.id })
        .then((res) => {
          this.topics = res.data;
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Topics", "error");
        })
        .finally(() => {
          this.topicLoading = false;
        });
    },

    //  function to set current topic to be edited
    setCurrentTopic(topic) {
      this.currentTopic = topic;
    },

    //  function to reload after create or edit
    showAdded(data) {
      this.reloadData();
    },
    deleteTopic(id) {
      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: ["No, Exit", "Yes, Continue"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          this.topicLoading = true;
          axios
            .post(this.$route("admin.curriculum.topics.delete"), { id: id })
            .then((res) => {
              this.$toast.success("Topic deleted successfully");
              this.reloadData();
              this.topicLoading = false;
            })
            .catch((err) => {
              this.$toast.error("An error occured. Please, Try again");
            });
        } else {
          swal("Operation Cancelled", { icon: "info" });
        }
      });
    },
    reloadData() {
      let subjects = JSON.parse(window.localStorage.getItem("subjects"));
      if (subjects != null) {
        this.fetchTopics(subjects);
      }
    },
  },
  created() {
    this.reloadData();
    eventBus.$on("showSubjects", (data) => {
      this.fetchTopics(data);
    });
  },
};
</script>

<style scoped>
</style>
