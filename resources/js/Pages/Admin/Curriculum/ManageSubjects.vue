<template>
  <div>
    <div class="card_box position-relative mb_30 white_bg">
      <VueElementLoading
        :active="subjectLoading"
        spinner="line-wave"
        color="var(--primary)"
      />
      <div class="white_box_tittle">
        <div class="main-title2">
          <h6 class="nowrap float-left mt-1 mb-0">
            <i class="fas fa-edit mr-1"></i> Subjects
          </h6>
        </div>
      </div>
      <div class="box_body">
        <div class="row">
          <div class="col-md-8 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Class</span>
              </div>
              <select
                class="custom-select"
                v-model="class_id"
                @change="getAllSubjects"
              >
                <option value="">--Subject by class--</option>
                <option :value="cls.id" v-for="(cls, i) in classes" :key="i">
                  {{ cls.class_name }}
                </option>
              </select>
            </div>
          </div>
          <div
            class="col-md-4 mb-3"
            v-if="$page.props.auth.user.user_type_id == 3"
          >
            <div class="float-right">
              <button
                @click="$bvModal.show('create-subject')"
                style="
                  background-color: #002147 !important;
                  color: white !important;
                "
                class="btn shadow-md btn-sm px-3 py-1"
              >
                <i class="mdi mdi-plus-circle-outline mr-1"></i>
                New Subject
              </button>
            </div>
          </div>
          <div class="col-md-12">
            <table
              class="table table-bordered table-striped"
              v-if="subjects.length"
            >
              <thead>
                <tr>
                  <th width="10%">#</th>
                  <th width="50%">Subject</th>
                  <th width="30%">Code</th>
                  <th>Status</th>
                  <th width="3%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(subj, index) in subjects"
                  :key="subj.id"
                  :id="'row' + index"
                >
                  <td>
                    <span :id="'check' + index" style="display: none">👉 </span
                    >{{ index + 1 }}.
                  </td>
                  <td style="text-transform: capitalize">
                    {{ subj.subject_name }}
                  </td>
                  <td>{{ subj.subject_code.toUpperCase() }}</td>
                  <td>
                    <span
                      class="badge badge-pill text-uppercase"
                      :class="{
                        'badge-success': subj.status == 'approved',
                        'badge-secondary': subj.status == 'pending',
                        'badge-danger': subj.status == 'declined',
                      }"
                      >{{ subj.status }}</span
                    >
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
                          class="dropdown-item"
                          style="cursor: pointer"
                          @click="
                            manageTopics(subj);
                            setSelected(index);
                          "
                        >
                          Manage Topics
                        </div>
                        <div
                          @click="
                            $bvModal.show('edit-subject');
                            setCurrentSubject(subj);
                          "
                          class="dropdown-item"
                          style="cursor: pointer"
                        >
                          Edit
                        </div>
                        <div
                          @click="deleteSubject(subj.id)"
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
            <div class="alert alert-info text-center" v-else>
              <h5>No Record Found</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Create Subject Modal  -->
    <b-modal id="create-subject" hide-footer title="Add New Subject">
      <create-subject
        :my_modal="this.$bvModal"
        @subject-created="getAllSubjects"
      />
    </b-modal>

    <!-- Edit Subject Modal  -->
    <b-modal id="edit-subject" hide-footer title="Edit Subject">
      <edit-subject
        :my_modal="this.$bvModal"
        :currentSubject="currentSubject"
        @subject-updated="getAllSubjects"
      />
    </b-modal>
  </div>
</template>


<script>
import CreateSubject from "./Partials/Create-subject";
import EditSubject from "./Partials/Edit-subject";
import VueElementLoading from "vue-element-loading";
import swal from "sweetalert";
import axios from "axios";

export default {
  components: {
    VueElementLoading,
    "create-subject": CreateSubject,
    "edit-subject": EditSubject,
  },
  data() {
    return {
      subjectLoading: false,
      subjects: {},
      currentSubject: {},
      classes: {},
      class_id: "",
    };
  },
  methods: {
    getAllClass() {
      axios
        .get(this.$route("admin.class.classes"))
        .then((res) => {
          this.classes = res.data;
        })
        .catch((err) => {})
        .finally(() => {});
    },
    //  method to fetch all subjects to be displayed
    getAllSubjects() {
      this.subjectLoading = true;
      axios
        .post(this.$route("admin.curriculum.subjects"), {
          class_id: this.class_id,
        })
        .then((res) => {
          this.subjects = res.data;
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.subjectLoading = false;
        });
    },

    //  method to store the current selected subject for edit
    setCurrentSubject(subject) {
      this.currentSubject = subject;
    },

    //  method to manage topics for selected subject
    manageTopics(subject) {
      window.localStorage.setItem("subjects", JSON.stringify(subject));
      eventBus.$emit("showSubjects", subject);
    },

    //  function to style selected subject row
    setSelected(id) {
      for (let i = 0; i < this.subjects.length; i++) {
        let row = "row" + i;
        let check = "check" + i;
        let sel_row = document.getElementById(row);
        let sel_check = document.getElementById(check);
        sel_row.classList.remove("selected-row");
        sel_check.style.display = "none";
      }

      let row = "row" + id;
      let check = "check" + id;
      let sel_row = document.getElementById(row);
      let sel_check = document.getElementById(check);
      sel_row.classList.add("selected-row");
      sel_check.style.display = "inline";
    },
    reloadData() {
      this.getAllClass();
      this.getAllSubjects();
    },

    deleteSubject(id) {
      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: ["No, Exit", "Yes, Continue"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          this.subjectLoading = true;
          axios
            .post(this.$route("admin.curriculum.subject.delete"), { id: id })
            .then((res) => {
              this.$toast.success("Subject deleted successfully");
              this.getAllSubjects();
              this.subjectLoading = false;
            })
            .catch((err) => {
              this.$toast.error("Unable to delete Subject");
              this.subjectLoading = false;
            });
        } else {
          swal("Operation Cancelled", { icon: "info" });
        }
      });
    },
  },
  created() {
    window.localStorage.removeItem("subjects");
  },
  mounted() {
    this.reloadData();
    window.localStorage.removeItem("subjects");
  },
};
</script>

<style scoped>
.selected-row {
  background-color: rgb(181, 253, 223) !important;
}
</style>
