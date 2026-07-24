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
                                            <h3>Attendance</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="dashboard_breadcam text-right">
                                            <p>
                                                <inertia-link href="/">Attendance</inertia-link>
                                                <i class="fas fa-caret-right"></i> Attendance
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card_box position-relative mb_30 white_bg">
                                <VueElementLoading :active="quizLoading" spinner="line-wave" color="var(--primary)" />
                                <div class="box_body">
                                   <div class="alert alert-primary text-center">This module is not yet ready</div>
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
import layout from "../BaseLayouts/Layout.vue";
import VueElementLoading from "vue-element-loading";
import axios from "axios";

export default {
    components: {
        layout,
        VueElementLoading
    },
    data() {
        return {
            quizLoading: false,
            quiz_category: {},
            errorMsg: {}
        }
    },
    methods: {


    },
    mounted() {
    },
};
</script>
