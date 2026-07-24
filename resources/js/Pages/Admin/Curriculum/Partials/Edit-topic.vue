<template>
    <div class="card">
        <VueElementLoading :active="editTopicLoading" spinner="line-wave" color="var(--primary)" />
        <form @submit.prevent="updateTopic">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Topic Name</span>
                            </div>
                            <input type="text" v-model="form.topic_name" class="form-control" placeholder="" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Subject</span>
                            </div>
                            <select v-model="form.subject_id" class="custom-select" required>
                                <option value="">--Select Subject--</option>
                                <option :value="subject.id">{{subject.subject_name}}</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Description</span>
                            </div>
                            <textarea class="form-control" v-model="form.description" rows="2" required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Status</span>
                            </div>
                            <select v-model="form.status" class="custom-select" required>
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
                <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
        currentTopic: Object,
        subject: Object
    },
    data(){
        return {
            editTopicLoading: false,
            form: this.currentTopic
        }
    },
    methods: {
        //  function to edit topic details
        updateTopic(){
            this.editTopicLoading = true;
            axios
                .post(this.$route('admin.curriculum.topics.edit'), this.form)
                .then((res) => {
                    this.$toast.success('Topic Updated successfully');
                    this.$emit('topic-updated');
                    this.closeMe();
                })
                .catch((err) => {
                    this.$toast.error("An error occured. Please, try again");
                })
                .finally(() => {
                    this.editTopicLoading = false;
                })
        },
        closeMe(){
            this.my_modal.hide("edit-topic");
        }
    }

}
</script>
