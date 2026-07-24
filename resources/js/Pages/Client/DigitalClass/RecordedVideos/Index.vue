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
                      <h3>Recorded Video</h3>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="dashboard_breadcam text-right">
                      <p>
                        <inertia-link href="/">Dashboard</inertia-link>
                        <i class="fas fa-caret-right"></i> Recorded videos
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="row">
                <div class="col-lg-12">
                  <RecordedVideos />
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
import VideosVue from "./Videos.vue";

export default {
  components: {
    layout,
    RecordedVideos: VideosVue,
  },
};
</script>
