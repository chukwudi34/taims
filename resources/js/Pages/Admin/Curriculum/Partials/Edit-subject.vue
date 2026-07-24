<template>
    <div class="card">
        <VueElementLoading :active="subjectEditLoading" spinner="line-wave" color="var(--primary)" />
        <form @submit.prevent="updateSubject">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Subject Name</span>
                            </div>
                            <input type="text" class="form-control" v-model="form.subject_name" placeholder="">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Subject Code</span>
                            </div>
                            <input type="text" class="form-control" v-model="form.subject_code" placeholder="">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Status</span>
                            </div>
                            <select name="cars" class="custom-select" v-model="form.status">
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
import VueElementLoading from "vue-element-loading";
import axios from 'axios'

export default {
    components: {
        VueElementLoading
    },
    props:{
        my_modal: Object,
        currentSubject: Object
    },
    data(){
        return {
            subjectEditLoading: false,
            form: this.currentSubject
        }
    },
    methods: {
        //  function to update subject details
        updateSubject(){
            this.subjectEditLoading = true;
            axios
                .post(this.$route('admin.curriculum.subject.edit'), this.form)
                .then((res) => {
                    this.$toast.success('Subject Updated successfully');
                    this.$emit('subject-updated');
                    this.closeMe();
                })
                .catch(err => {
                    this.$toast.error('An error occured, Please, try again')
                })
                .finally(() => {
                    this.subjectEditLoading = false;
                });
        },
        closeMe(){
            this.my_modal.hide("edit-subject");
        }
    }

}
</script>
