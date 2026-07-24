<template>
  <div>
    <layout>
      <div class="main_content_iner">
        <div class="container-fluid p-0 sm_padding_15px">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="dashboard_header mb_50">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="dashboard_header_title">
                      <h3>Digital Learning</h3>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="dashboard_breadcam text-right">
                      <p>
                        <inertia-link href="/">Dashboard</inertia-link>
                        <i class="fas fa-caret-right"></i> Live Class
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12" v-if="$page.props.auth.user.user_type_id == 2">
                <div class="row">
                    <div class="col-lg-12" v-if="$page.props.auth.user.google_meet_link == null">
                        <meetingLink />
                    </div>
                    <div class="col-lg-12" v-else>
                        <LiveClassVue />
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="$page.props.auth.user.user_type_id == 1">
                <div class="row">
                    <div class="col-lg-12">
                        <StudentLive />
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </layout>
  </div>
</template>
<script>
import layout from "../../../BaseLayouts/Layout.vue";
import LiveClassVue from "./LiveClass.vue";
import meetingLink from "./CreateMeetingLink.vue";
import StudentLive from "../StudentLiveClass/Index.vue";

export default {
  components: {
    layout,
    LiveClassVue,
    meetingLink,
    StudentLive
  },
};
</script>
