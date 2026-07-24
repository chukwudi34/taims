<template>
  <div>
    <div class="card_box position-relative mb_30 white_bg">
      <div class="white_box_tittle">
        <div class="main-title2">
          <h4 class="mb-2 nowrap">Live Class</h4>
        </div>
      </div>
      <div class="box_body">
        <div class="row">
          <div class="col-12 text-center mb-4">
            <p class="f-w-400 text-dark">
              The TAIMS Live Class module utilizes the Google Meet
              Plugin. You are required to generate a one-time link from google
              meet to fully use this module. Kindly follow the simple steps
              below:
            </p>
          </div>
          <div class="col-lg-4 mb-4 mb-md-5 text-center">
            <img src="/assets/img/googlemeet.png" alt="" />
            <p class="f-w-400">
              <span class="font-weight-bold text-danger" style="font-size: 20px"
                >1.</span
              >
              Click
              <a
                href="https://meet.google.com"
                onclick="window.open('https://meet.google.com','popup','width=600,height=600'); return false;"
                class="font-weight-bold text-success"
                >Here</a
              >
              to visit google meet
            </p>
          </div>
          <div class="col-lg-4 mb-4 mb-md-5 text-center">
            <img src="/assets/img/newmeeting.png" />
            <p class="f-w-400">
              <span class="font-weight-bold text-danger" style="font-size: 20px"
                >2.</span
              >
              On the window that appears , click
              <b class="text-dark font-weight-bold">Start Meeting</b>. You will
              be redirected to the 'Sign In' page to login to google meet.
              <i
                >(You can skip this step if you aleady have a google meet
                account)</i
              >
            </p>
          </div>
          <div class="col-lg-4 mb-4 mb-md-5 text-center">
            <img src="/assets/img/meet.png" width="300" />
            <p class="f-w-400">
              <span class="font-weight-bold text-danger" style="font-size: 20px"
                >3.</span
              >
              Once you are logged in successfully, click
              <b class="font-weight-bold text-dark">New Meeting</b>
            </p>
          </div>
          <div class="col-lg-4 mb-4 mb-md-5 text-center">
            <img src="/assets/img/meetinglink.png" width="300" />
            <p class="f-w-400">
              <span class="font-weight-bold text-danger" style="font-size: 20px"
                >4.</span
              >
              Then select
              <span class="font-weight-bold text-dark">Get Meeting Link</span>
              from the options that pops up
            </p>
          </div>
          <div class="col-lg-4 mb-4 mb-md-5 text-center">
            <img src="/assets/img/meetinglink3.png" width="300" />
            <p class="f-w-400 mb-3">
              <span class="font-weight-bold text-danger" style="font-size: 20px"
                >5.</span
              >
              Copy the generated link, paste it in the input field below and
              click on <span class="font-weight-bold text-dark">Save</span>:
            </p>
            <form class="form-inline" @submit.prevent="createMeetingLink">
              <input
                type="text"
                class="form-control mb-2 mr-sm-2"
                placeholder="Enter Meeting Link here"
                required
                v-model="form.link"
              />
              <button type="submit" class="btn btn-primary mb-2" :disabled="form.link == ''">
                <span v-if="loading"><i class="fa fa-spinner fa-pulse fa-1x mr-1 "></i></span>
                <span v-else><i class="mdi mdi-video-outline mr-1"></i> Save</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            loading: false,
            form: {
                link: ''
            },

        }
    },
    methods: {
        createMeetingLink() {
            this.loading = true;
            axios.post(this.$route('client.digital_class.live_class.meeting_link.create'), this.form)
                .then(({ data }) => {
                    this.$toast.success('Meeting Link saved successfully')
                    this.$inertia.reload(this.$route("client.digital_class.live_class.index"))
                    this.$emit("meeting-Created");

                })
                .catch((err) => {
                this.loading = false;
                this.$swal(
                    "Error",
                    "meeting Link not saved",
                    "error"
                );
                // console.log(err)
                });
    },
    }
};
</script>
