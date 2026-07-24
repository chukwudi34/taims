<template>
    <div class="card">
        <VueElementLoading :active="topicLoading" spinner="line-wave" color="var(--primary)" />
        <form @submit.prevent="addTopic">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Topic Name</span>
                            </div>
                            <input type="text" class="form-control" v-model="form.topicName" placeholder="">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Subject</span>
                            </div>
                            <select name="cars" class="custom-select" v-model="form.subjectId">
                                <option value="">--Select Subject--</option>
                                <option :value="subject.id">{{subject.subject_name}}</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Description</span>
                            </div>
                            <textarea class="form-control" v-model="form.description" rows="2"></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Status</span>
                            </div>
                            <select v-model="form.status" class="custom-select">
                                <option value="">--Select Status--</option>
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                                <option value="declined">Declined</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block text-right card-footer">
                <button type="button" class="mr-2 btn btn-link btn-sm" @click="closeMe">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios'
import VueElementLoading from 'vue-element-loading'

export default {
    components: {
        VueElementLoading
    },
    props:{
        my_modal: Object,
        subject: Object
    },
    data(){
        return {
            topicLoading: false,
            form: {
                topicName: '',
                subjectId: '',
                description: '',
                status: ''
            }
        }
    },
    methods: {
        // function to send form field data to server
        addTopic(){
            this.topicLoading = true;
            axios
                .post(this.$route('admin.curriculum.topics.create'), this.form)
                .then((res) => {
                    this.$toast.success('Topic created successfully');
                    this.$emit('topic-created');
                    this.closeMe();
                })
                .catch((err) => {
                    this.$toast.error("An error occured. Please, try again");
                })
                .finally(() => {
                    this.topicLoading = false;
                })
        },
        closeMe(){
            this.my_modal.hide("create-topic");
        }
    }

}
</script>
