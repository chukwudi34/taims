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
                      <h3>Class Manager</h3>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="dashboard_breadcam text-right">
                      <p>
                        <inertia-link href="/">Dashboard</inertia-link>
                        <i class="fas fa-caret-right"></i> class manager
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="white_box_tittle">
                    <div class="main-title2">
                      <h6 class="nowrap float-left mt-1 mb-0">
                        <i class="fas fa-edit mr-1"></i> classes
                      </h6>
                      <div class="float-right">
                        <button
                          style="
                            background-color: #002147 !important;
                            color: white !important;
                          "
                          @click="$bvModal.show('create-class')"
                          class="btn shadow-md btn-sm px-3 py-1"
                          v-if="$page.props.auth.user.user_type_id == 3"
                        >
                          <i class="mdi mdi-plus-circle-outline mr-1"></i>
                          New Class
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="box_body mt-5">
                    <div class="table-responsive-sm">
                      <table
                        class="table table-striped mt-4 table-bordered"
                        v-if="classes.length"
                      >
                        <thead>
                          <tr>
                            <th width="10%">#</th>
                            <th width="50%">class</th>
                            <th width="30%">Code</th>
                            <th>Status</th>
                            <th width="3%">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(cl, index) in classes" :key="index">
                            <td style="text-transform: capitalize">
                              {{ index + 1 }}
                            </td>
                            <td style="text-transform: capitalize">
                              {{ cl.class_name }}
                            </td>
                            <td>{{ cl.class_code.toUpperCase() }}</td>
                            <td>
                              <span
                                class="badge badge-pill text-uppercase"
                                :class="{
                                  'badge-success': cl.status == 'approved',
                                  'badge-secondary': cl.status == 'pending',
                                  'badge-danger': cl.status == 'declined',
                                }"
                                >{{ cl.status }}</span
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
                                    class="dropdown-item btn btn-success btn-round-md"
                                    style="cursor: pointer"
                                  ></div>
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
            </div>
          </div>
        </div>
        <b-modal id="create-class" hide-footer title="Add New Subject">
          <create-class
            :my_modal="this.$bvModal"
            @class-created="getAllClass"
          />
        </b-modal>
      </div>
    </layout>
  </div>
</template>
    <script>
import layout from "../../BaseLayouts/Layout.vue";
import CreateClass from "./Partials/Create-class";
import VueElementLoading from "vue-element-loading";
import swal from "sweetalert";
import axios from "axios";
export default {
  components: {
    layout,
    "create-class": CreateClass,
    VueElementLoading,
  },
  data() {
    return {
      classLoading: false,
      classes: {},
      currentclass: {},
    };
  },
  methods: {
    getAllClass() {
      this.classLoading = true;
      this.subjectLoading = true;
      axios
        .get(this.$route("admin.class.classes"))
        .then((res) => {
          this.classes = res.data;
        })
        .catch((err) => {
          //   swal("Error", "Unable to fetch Subjects", "error");
        })
        .finally(() => {
          this.subjectLoading = false;
        });
    },
    setCurrentClass(data) {
      this.currentclass = data;
    },
  },
  mounted() {
    this.getAllClass();
  },
};
</script>
