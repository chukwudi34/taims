<template>
  <div
    class="container mt-2 d-flex justify-content-center align-items-center min-vh-100"
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
        </div>
        <form @submit.prevent="login">
          <div v-if="errorMessage" class="alert alert-danger mb-4">
            {{ errorMessage }}
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  id="email"
                  name="email-username"
                  class="form-control"
                  placeholder="Enter your email"
                  autofocus
                  v-model="form.email"
                />
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-4 form-password-toggle">
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
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div
                class="d-flex justify-content-between align-items-center mb-4"
              >
                <div class="form-check">
                  <input
                    type="checkbox"
                    id="remember-me"
                    class="form-check-input"
                  />
                  <label for="remember-me" class="form-check-label">
                    Remember Me
                  </label>
                </div>
                <a
                  href="auth-forgot-password-basic.html"
                  class="text-decoration-none"
                >
                  Forgot Password?
                </a>
              </div>
              <div class="d-block">
                <button
                  type="submit"
                  class="btn btn-block"
                  style="
                    background-color: #002147 !important;
                    color: white !important;
                  "
                >
                  Login
                </button>
              </div>
            </div>
          </div>
        </form>

        <!-- Register Link -->
        <p class="text-center mt-4">
          New to our platform?
          <a href="/" class="text-primary text-decoration-none">
            Create an account
          </a>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import VueElementLoading from "vue-element-loading";
import axios from "axios";

export default {
  name: "LoginPage",
  components: { VueElementLoading },
  data() {
    return {
      valid: false,
      errorMessage: null, // To display the error message
      form: {
        email: "",
        password: "",
      },
      loading: false,
      showPassword: false,
    };
  },
  methods: {
    async login() {
      this.loading = true;
      this.errorMessage = null;

      try {
        await axios.post("/login", this.form);
        this.$toast.success("logged In successful");

        this.$inertia.visit("/dashboard");
      } catch (error) {
        this.errorMessage =
          error.response?.data?.message || "An unexpected error occurred.";
      } finally {
        this.loading = false;
      }
    },
    togglePassword() {
      this.showPassword = !this.showPassword;
    },
  },
};
</script>

