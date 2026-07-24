<template>
  <div>
    <VueElementLoading
      :active="loading"
      spinner="bar-fade-scale"
      color="var(--primary)"
      text="Loading.."
      duration="0.6"
    />
    <div class="container-fluid p-0">
      <div class="main" id="main">
        <nav
          class="navbar navbar-expand-md bg-dark navbar-dark fixed-top"
          id="mainNav"
        >
          <a class="navbar-brand" href="/">
            <h5 class="text-underline">
              <span style="color: #452d8b">TA</span
              ><span style="color: #e76021">IM</span><span>S</span>
              <sub class=""><small> </small></sub>
            </h5>
          </a>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#collapsibleNavbar"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item pl-md-4 mb-3">
                <inertia-link type="button" href="/" class="btn btn-info"
                  ><i class="fa fa-arrow-left" aria-hidden="true"></i
                  >&nbsp;&nbsp; Back To Home</inertia-link
                >
                <!-- <a type="button" class="btn btn-info" href="#"><i class="fa fa-arrow-left"
                                    aria-hidden="true"></i>&nbsp;&nbsp; Back To Home</a> -->
              </li>
              <li class="nav-item pl-md-4 mb-3">
                <inertia-link type="button" class="btn btn-info" href="login"
                  >Login <i class="fa fa-sign-in" aria-hidden="true"></i
                ></inertia-link>
              </li>
            </ul>
          </div>
        </nav>
        <div class="content mt-sm-5">
          <div class="row">
            <div class="col-md-6">
              <label
                for="student"
                class="shadow-md shadow-lg border hover-shadow box p-md-2 p-2 d-block"
              >
                <div class="form-check">
                  <label class="form-check-label"
                    ><input
                      type="radio"
                      name="optradio"
                      id="student"
                      class="form-check-input"
                      v-model="form.student"
                      @click="getUserType(form.student)"
                  /></label>
                </div>
                <div class="ml-md-5 ml-5">
                  <h3 class="font-weight-bold">Student</h3>
                  <div>
                    Welcome to our Technology Assisted Instructional Management
                    Solution! This platform helps you stay organized and
                    connected with your course materials, assignments, and
                    grades. With our easy-to-use interface, you can easily
                    access all of your course information and stay on top of
                    your studies. Let's get started!
                  </div>
                </div>
              </label>
            </div>
            <div class="col-md-6">
              <label
                for="teacher"
                class="shadow-md shadow-lg border hover-shadow box p-md-2 d-block p-2"
              >
                <div class="form-check">
                  <label class="form-check-label"
                    ><input
                      type="radio"
                      name="optradio"
                      id="teacher"
                      class="form-check-input"
                      v-model="form.teacher"
                      @click="getUserType(form.teacher)"
                  /></label>
                </div>
                <div class="ml-md-5 ml-5">
                  <h3 class="font-weight-bold">Teacher</h3>
                  <div>
                    Welcome to our page on Technology Assisted Instructional
                    Management Solutions! Here, you will find information on the
                    latest tools and techniques for integrating technology into
                    your teaching practice to enhance student learning and
                    increase efficiency in managing your classroom.
                  </div>
                </div>
              </label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label
                for="schoolowner"
                class="shadow-md shadow-lg border hover-shadow box p-md-2 p-2 d-block"
              >
                <div class="form-check">
                  <label class="form-check-label"
                    ><input
                      type="radio"
                      name="optradio"
                      id="schoolowner"
                      class="form-check-input"
                      v-model="form.schoolowner"
                      @click="getUserType(form.schoolowner)"
                  /></label>
                </div>
                <div class="ml-md-5 ml-5">
                  <h3 class="font-weight-bold">School Owner</h3>
                  <div>
                    Welcome to our page on Technology Assisted Instructional
                    Management Solutions! Here, you will find information on the
                    latest tools and techniques for integrating technology in
                    classrooms to enhance student learning, increase teacher
                    efficiency and manage schools more effectively. Our
                    research-based solutions can help improve student
                    engagement, collaboration and retention in schools.
                  </div>
                </div>
              </label>
            </div>
            <div class="col-md-6">
              <label
                for="training"
                class="shadow-md shadow-lg border hover-shadow box p-md-2 d-block p-2"
              >
                <div class="form-check">
                  <label class="form-check-label"
                    ><input
                      type="radio"
                      name="optradio"
                      id="training"
                      class="form-check-input"
                      v-model="form.training"
                      @click="getUserType(form.training)"
                  /></label>
                </div>
                <div class="ml-md-5 ml-5">
                  <h3 class="font-weight-bold">Training</h3>
                  <div>
                    Welcome to our page on Technology Assisted Instructional
                    Management Solutions! Here, you will find information on the
                    latest tools and techniques for integrating technology into
                    your teaching practice to enhance student learning and
                    increase efficiency in managing your classroom.
                  </div>
                </div>
              </label>
            </div>
          </div>
          <div class="row">
            <!-- <div class="col-md-3 col-0"></div> -->
            <div class="col-md-6">
              <label
                for="others"
                class="shadow-md shadow-lg border hover-shadow box p-md-2 p-2 d-block"
              >
                <div class="form-check">
                  <label class="form-check-label"
                    ><input
                      type="radio"
                      name="optradio"
                      id="others"
                      class="form-check-input"
                      v-model="form.others"
                      @click="getUserType(form.others)"
                  /></label>
                </div>
                <div class="ml-md-5 ml-5">
                  <h3 class="font-weight-bold">Others</h3>
                  <div>
                    Welcome to our page on Technology Assisted Instructional
                    Management Solutions! Here, you will find information on the
                    latest tools and techniques for integrating technology into
                    your teaching practice to enhance student learning and
                    increase efficiency in managing your classroom.
                  </div>
                </div>
              </label>
            </div>
            <div class="col-md-6 pt-md-5">
              <button
                class="btn btn-info btn-md btn-block mx-auto mt-md-5 mt-3 mb-3"
                @click="submitUserType()"
              >
                Submit
              </button>
            </div>
            <!-- <div class="col-md-3 col-0"></div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VueElementLoading from "vue-element-loading";
import axios from "axios";
export default {
  components: {
    VueElementLoading,
  },
  data() {
    return {
      form: {
        student: "student",
        schoolowner: "school_owner",
        teacher: "teacher",
        others: "others",
        training: "training",
      },
      dt: "",
      loading: false,
    };
  },
  methods: {
    getUserType(data) {
      this.dt = data;
    },
    submitUserType() {
      this.loading = true;
      this.$inertia.visit("/register", {
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
    },
  },
  mounted() {},
};
</script>
<style scoped>
#main {
  background: white !important;
}
#mainNav {
  background: linear-gradient(
    45deg,
    rgba(86, 58, 250, 0.9) 0%,
    rgba(116, 15, 214, 0.9) 100%
  );
}
.link {
  font-size: 17px !important;
  font-weight: 800;
  color: white !important;
}
.link:hover {
  text-decoration: underline;
  color: lawngreen !important;
  font-size: 18px !important;
  font-weight: 800;
}
.box {
  height: fit-content !important;
  border-radius: 10px !important;
}
.content {
  padding: 80px 15px !important;
}
.text-underline {
  font-size: 30px !important;
  font-weight: 800;
}
</style>
