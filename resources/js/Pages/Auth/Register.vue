<template>
  <div
    class="container d-flex justify-content-center align-items-center min-vh-100"
  >
    <VueElementLoading
      :active="loading"
      spinner="bar-fade-scale"
      color="var(--primary)"
      text="Loading.."
      duration="0.6"
    />
    <div class="card shadow-lg" style="max-width: 500px; width: 100%">
      <div class="card-body">
        <div
          class="text-center"
          style="margin: 0px !important; padding: 0px !important"
        >
          <h1
            style="
              text-decoration: overline;
              margin: 0px !important;
              padding: 0px !important;
            "
            class="text-center mb-0"
          >
            <span style="color: rgb(69, 45, 139)">TA</span
            ><span style="color: #fdc800 !important">IM</span
            ><span style="display: inline-block">S</span>
          </h1>
          <small
            ><em
              >Technology Assisted Instructional Management Solution</em
            ></small
          >
          <p>
            <small>Registering as </small
            ><span class="badge badge-info badge-pill">
              {{ form.user_type }}
            </span>
          </p>
        </div>
        <form @submit.prevent="register" class="mt-2 mb-2">
          <div class="row">
            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label for="email" class="form-label">First Name</label>
                <input
                  type="text"
                  id="fname"
                  name="fname"
                  class="form-control"
                  placeholder="Enter your First Name"
                  autofocus
                  v-model="form.firstname"
                />
                <small v-if="errorMsg?.firstname" class="text-danger">
                  {{ errorMsg.firstname[0] }}
                </small>
              </div>
            </div>
            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label for="lname" class="form-label">Last Name</label>
                <input
                  type="text"
                  id="lname"
                  name="lname"
                  class="form-control"
                  placeholder="Enter your Last Name"
                  autofocus
                  v-model="form.lastname"
                />
                <small v-if="errorMsg?.lastname" class="text-danger">
                  {{ errorMsg.lastname[0] }}
                </small>
              </div>
            </div>
            <div class="col-md-12 mb-2" v-if="form.user_type == 'learner'">
              <div class="form-group">
                <label for="clsg">Class Group</label>
                <select class="form-control" id="clsg" v-model="form.class_id">
                  <option value="">--Select Class Gropu--</option>
                  <option :value="cls.id" v-for="(cls, i) in classes" :key="i">
                    {{ cls.class_name }}
                  </option>
                </select>
                <small v-if="errorMsg?.class_id" class="text-danger">
                  {{ errorMsg.class_id[0] }}
                </small>
              </div>
            </div>
            <div
              :class="{
                'col-md-6': form.user_type == 'learner',
                'col-md-12': form.user_type == 'instructor',
              }"
              class="mb-2"
            >
              <div class="form-group">
                <label for="emaila" class="form-label">Email Address</label>
                <input
                  type="email"
                  id="emaila"
                  name="emaila"
                  class="form-control"
                  placeholder="Enter your Eamil Address"
                  autofocus
                  v-model="form.email"
                />
                <small v-if="errorMsg?.email" class="text-danger">
                  {{ errorMsg.email[0] }}
                </small>
              </div>
            </div>
            <div class="col-md-6 mb-2" v-if="form.user_type == 'learner'">
              <div class="form-group">
                <label for="emaila" class="form-label"
                  >Parent Email Address</label
                >
                <input
                  type="email"
                  id="emaila"
                  name="emaila"
                  class="form-control"
                  placeholder="Enter your Eamil Address"
                  autofocus
                  v-model="form.parent_email"
                />
                <small v-if="errorMsg?.parent_email" class="text-danger">
                  {{ errorMsg.parent_email[0] }}
                </small>
              </div>
            </div>
            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label
                  for="phone"
                  class="form-label"
                  v-if="form.user_type == 'instructor'"
                  >Phone Number</label
                >
                <label
                  for="phone"
                  class="form-label"
                  v-if="form.user_type == 'learner'"
                  >Parent Phone Number</label
                >
                <input
                  type="text"
                  id="phone"
                  name="phone"
                  class="form-control"
                  placeholder="Enter Phone Number"
                  autofocus
                  v-mask="'###########'"
                  v-model="form.phone"
                />
                <small v-if="errorMsg?.phone" class="text-danger">
                  {{ errorMsg.phone[0] }}
                </small>
              </div>
            </div>
            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" v-model="form.gender">
                  <option value="">Select gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
                <small v-if="errorMsg?.gender" class="text-danger">
                  {{ errorMsg.gender[0] }}
                </small>
              </div>
            </div>
            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label for="state">State</label>
                <select
                  class="form-control"
                  id="state"
                  @change="getStateLga(form.state_id)"
                  v-model="form.state_id"
                >
                  <option value="">Select State</option>

                  <option :value="st.id" v-for="(st, i) in states" :key="i">
                    {{ st.stname }}
                  </option>
                </select>
                <small v-if="errorMsg?.state_id" class="text-danger">
                  {{ errorMsg.state_id[0] }}
                </small>
              </div>
            </div>
            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label for="lga">Lga</label>
                <select class="form-control" id="lga" v-model="form.lga">
                  <option value="">Select Lga</option>
                  <option
                    :value="lga.id"
                    v-for="(lga, i) in states_lga"
                    :key="i"
                  >
                    {{ lga.lganame }}
                  </option>
                </select>
                <small v-if="errorMsg?.lga" class="text-danger">
                  {{ errorMsg.lga[0] }}
                </small>
              </div>
            </div>

            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <input
                    :type="showPassword ? 'text' : 'password'"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="••••••••••••"
                    aria-describedby="password"
                    v-model="form.password"
                  />
                  <button
                    type="button"
                    class="input-group-text btn btn-light"
                    @click="togglePassword"
                  >
                    <i
                      :class="
                        showPassword
                          ? 'mdi mdi-eye-outline'
                          : 'mdi mdi-eye-off-outline'
                      "
                    ></i>
                  </button>
                  <small v-if="errorMsg?.password" class="text-danger">
                    {{ errorMsg.password[0] }}
                  </small>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label for="password" class="form-label"
                  >Confirm Password</label
                >
                <div class="input-group">
                  <input
                    :type="showConfirmPassword ? 'text' : 'password'"
                    id="confirmPassword"
                    name="confirmPassword"
                    class="form-control"
                    placeholder="••••••••••••"
                    aria-describedby="confirmPassword"
                    v-model="form.password_confirmation"
                  />
                  <button
                    type="button"
                    class="input-group-text btn btn-light"
                    @click="toggleConfirmPassword"
                  >
                    <i
                      :class="
                        showConfirmPassword
                          ? 'mdi mdi-eye-outline'
                          : 'mdi mdi-eye-off-outline'
                      "
                    ></i>
                  </button>
                  <small
                    v-if="errorMsg?.password_confirmation"
                    class="text-danger"
                  >
                    {{ errorMsg.password_confirmation[0] }}
                  </small>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="d-block">
                <button
                  type="submit"
                  class="btn btn-block"
                  style="
                    background-color: #002147 !important;
                    color: white !important;
                  "
                >
                  Register
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import VueElementLoading from "vue-element-loading";
import axios from "axios";

export default {
  name: "RegisterPage",
  components: { VueElementLoading },
  data() {
    return {
      valid: false,
      errorMessage: null,
      countryLoading: false,
      form: {
        firstname: "",
        lastname: "",
        gender: "",
        email: "",
        password: "",
        password_confirmation: "",
        phone: "",
        user_type: "",
        class_id: "",
        lga: "",
        state_id: "",
      },
      loading: false,
      showPassword: false,
      showConfirmPassword: false,
      errorMsg: {},
      countries: {},
      selectedFlag: "",
      classes: {},
      state_id: "",
      states: {},
      states_lga: {},
    };
  },
  methods: {
    register() {
      this.loading = true;
      axios
        .post("/register", this.form)
        .then((res) => {
          if (res.status == 201) {
            this.$toast.success("Registration successful");
            // toastr.success("success", "Registration successful");
            this.$inertia.visit("/dashboard");
          }
        })
        .catch((err) => {
          if (err.response && err.response.data.errors) {
            this.errorMsg = err.response.data.errors;
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
    togglePassword() {
      this.showPassword = !this.showPassword;
    },
    toggleConfirmPassword() {
      this.showConfirmPassword = !this.showConfirmPassword;
    },
    getState() {
      axios
        .get("/get-state")
        .then((res) => {
          this.states = res.data;
        })
        .catch((err) => {})
        .finally(() => {
          this.loading = false;
        });
    },
    getStateLga(id) {
      axios
        .get("/get-state-lga/" + id)
        .then((res) => {
          this.states_lga = res.data;
        })
        .catch((err) => {})
        .finally(() => {
          this.loading = false;
        });
    },

    fetchClass() {
      axios
        .get(this.$route("get-class"))
        .then((response) => {
          this.classes = response.data;
        })
        .catch((err) => {})
        .finally(() => {
          this.loading = false;
        });
    },
  },
  mounted() {
    this.fetchClass();
    this.getState();
    this.form.user_type = localStorage.getItem("userType");
  },
};
</script>
