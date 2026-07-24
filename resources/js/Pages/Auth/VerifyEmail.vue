<template>
    <!-- Section: Design Block -->
    <section class="background-radial-gradient overflow-hidden">
        <div class="container px-4 w-50 py-5 px-md-5 text-lg-start my-5">
            <div class="row mx-auto gx-lg-5 align-items-center mb-5">
                <div class="col-lg-12 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card shadow-2xl rounded-xlg bg-glass">
                        <div class="card-body px-3 py-5 px-md-5">
                            <div class="mb-3 text-center">
                                <span class="b-avatar badge-light-info rounded-circle" style="width: 90px; height: 90px;">
                                    <span class="b-avatar-custom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="44px" height="44px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                    </span><!---->
                                </span>
                            </div>
                            <div v-if="!resent" class="alert alert-success" role="alert my-2">
                                A fresh verification link has been sent to your email address.
                            </div>
                            <div>
                                Before proceeding, please check your email for a verification
                                link. If you did not receive the email,
                                <!-- :href="route('verification.send')" -->
                                <span class="text-left">
                                    <inertia-link
                                        :href="$route('verification.send')"
                                        class="btn-link"
                                        method="post"
                                        as="button"
                                        style="font-size: 14px !important"
                                        >click here to request another</inertia-link
                                    >
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Design Block -->
</template>

<script>
import VueElementLoading from 'vue-element-loading'
import axios from 'axios'

export default {
  name: 'VerifyEmail',
  props: {
    errors: Object,
    resent: Boolean,
  },
  data() {
    return {
    };
  },
  methods: {

  },
};
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito');
    .background-radial-gradient {
      background-color: hsl(218, 41%, 15%);
      background-image: radial-gradient(650px circle at 0% 0%,
          hsl(218, 41%, 35%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%),
        radial-gradient(1250px circle at 100% 100%,
          hsl(218, 41%, 45%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%);
    }

    .display-5  {
        font-size: 3.8rem !important;
        font-family: 'Nunito', sans-serif !important;
        margin-bottom: 40px !important;
    }

    .sub-text {
        font-size: 15px !important;
        width: 80%;
    }

    #radius-shape-1 {
      height: 220px;
      width: 220px;
      top: -60px;
      left: -130px;
      background: radial-gradient(#44006b, #ad1fff);
      overflow: hidden;
    }

    #radius-shape-2 {
      border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
      bottom: -60px;
      right: -110px;
      width: 300px;
      height: 300px;
      background: radial-gradient(#44006b, #ad1fff);
      overflow: hidden;
    }

    .rounded-xlg {
        border-radius: 1.5rem;
    }

    .bg-glass {
      background-color: hsla(0, 0%, 100%, 0.9) !important;
      backdrop-filter: saturate(200%) blur(25px);
    }

    .b-avatar.badge-light-primary {
    background-color: rgba(115,103,240,.12);
}
  .b-avatar.badge-light-primary {
    color: #7367f0;
  }
  .b-avatar.badge-light-info {
    background-color: rgba(0,207,232,.12);
  }
  .b-avatar.badge-light-info {
    color: #00cfe8;
  }
  .b-avatar.badge-light-danger {
    background-color: rgba(234,84,85,.12);
  }
  .b-avatar.badge-light-danger {
    color: #ea5455;
  }
  .b-avatar.badge-light-success {
    background-color: rgba(40,199,111,.12);
  }
  .b-avatar.badge-light-success {
    color: #28c76f;
  }
  .b-avatar.badge-light-warning {
    background-color: rgba(255,159,67,.12);
  }
  .b-avatar.badge-light-warning {
      color: #ff9f43;
  }
  .b-avatar.badge-light-secondary {
    background-color: rgba(130,134,139,.12);
  }
  .b-avatar.badge-light-secondary {
      color: #82868b;
  }
  </style>
