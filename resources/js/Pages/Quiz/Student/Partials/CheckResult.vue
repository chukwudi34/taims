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
                                            <h3>Assessment</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="dashboard_breadcam text-right">
                                            <p>
                                                <inertia-link href="/">Assessment</inertia-link>
                                                <i class="fas fa-caret-right"></i> setup
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card_box position-relative mb_30 white_bg p-4">
                                <div class="box_body">
                                        <button class="btn btn-primary btn-shadow w-25 d-block mx-auto">Print</button>
                                    <div class="report-card mt-5" style="margin-top:5px !important;">
                                        <div class="card-header px-3 mt-3" style="background:#DBEBF8 !important;">
                                            <div>
                                                <div class="d-flex justify-content-center">
                                                    <div>
                                                        <img src="../../../../../assets/img/logo.png" alt="Taims Logo">
                                                    </div>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <div>
                                                        <h4>Quiz Report Card</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body mx-auto">
                                            <div class="mx-auto text-center">
                                                <!-- {{ result }} -->
                                                <div class="ml-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <span class="d-block mt-3"><b>Last name &nbsp;&nbsp;</b>: {{ result.original.student_detail.lname }}
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span class="d-block mt-3"><b>First Name &nbsp;&nbsp;</b>:
                                                                {{ result.original.student_detail.fname }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <span class="d-block mt-3"><b>Quiz Title &nbsp;&nbsp;</b>: {{ result.original.get_distinct_quiz_done_by_student.title }}
                                                                 </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span class="d-block mt-3"><b>Total Question &nbsp;&nbsp;</b>:
                                                                {{result.original.total_question}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <span class="d-block mt-3"><b>Missed Question &nbsp;&nbsp;</b>:
                                                                {{result.original.total_missed_question_mark}}</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span class="d-block mt-3"><b>Correct Answer &nbsp;&nbsp;</b>:
                                                                {{result.original.total_correct_answer}}</span>
                                                        </div>
                                                    </div>
                                                   <h6 class="mt-5">You scored <span class="badge badge-success">{{result.original.total_scored}}</span></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer px-4 py-4" style="background:#DBEBF8 !important;">
                                            <div>
                                                <!-- <div></div> -->
                                                <div>
                                                    <div style="background:white !important;height:120px !important;"
                                                        class="px-4">
                                                        <h5 class="d-inline">Comment:</h5>
                                                        This is to certify that Lorem ipsum dolor sit amet consectetur
                                                        adipisicing elit. Officia repellendus architecto incidunt
                                                        praesentium eaque est, aliquid nemo nisi sit blanditiis esse
                                                        mollitia numquam! Eligendi temporibus consectetur numquam facilis
                                                        odit dolores?


                                                    </div>
                                                    <!-- Grading Scale:  -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
import VueElementLoading from "vue-element-loading";
import axios from "axios";

export default {
    props: ["result"],
    components: {
        layout,
        VueElementLoading
    },
    data() {
        return {
            quizLoading: false,
            quiz: {},
            errorMsg: {},
            result: {}

        }
    },
    mounted() {
        this.result = this.result;
    },
};
</script>
<style>.report-card {
    word-wrap: break-word !important;
    background-color: #fff !important;
    background-clip: border-box !important;
    border: 1px solid rgba(0, 0, 0, .125) !important;
    border-radius: 0.25rem !important;
    width: 30rem !important;
    margin: auto !important;
}</style>
