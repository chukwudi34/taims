<template>
    <div>
        <div>
            <vue-element-loading :active="loading" spinner="bar-fade-scale" />
            <form class="" @submit.prevent="updateUser()">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="company_name">First name:</label>
                      <input
                        type="text"
                        class="form-control"
                        id="company_name"
                        disabled
                        v-model="form.fname"
                      />

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="company_name">Last name:</label>
                      <input
                        type="text"
                        class="form-control"
                        id="company_name"
                        v-model="form.lname"
                        disabled
                      />

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="company_name">Middle name:</label>
                      <input
                        type="text"
                        class="form-control"
                        id="company_name"
                        v-model="form.mname"
                        disabled
                      />

                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                            <div class="form-group">
                              <label for="name_of_business">Email:</label>
                              <input
                                type="text"
                                class="form-control"
                                id="name_of_business"
                                v-model="form.email"
                                disabled
                              />

                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="name_of_business">Region:</label>
                          <input
                            type="text"
                            class="form-control"
                            id="name_of_business"
                            v-model="form.region"
                            disabled
                          />

                        </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                            <div class="form-group">
                              <label for="name_of_business">DOB:</label>
                              <input
                                type="text"
                                class="form-control"
                                id="name_of_business"
                                v-model="form.dob"
                                disabled
                              />

                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="name_of_business">Phone:</label>
                          <input
                            type="text"
                            class="form-control"
                            id="name_of_business"
                            v-model="form.phone"
                            disabled
                          />

                        </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button class="btn btn-danger btn-block" type="button" @click="cancel">Cancel</button>
                    </div>
                    <!-- <div class="col-md-6 mb-3">
                        <button class="btn btn-info btn-block" type="submit">Update</button>
                    </div> -->
                </div>
              </form>
        </div>
    </div>
</template>
<script>
import VueElementLoading from 'vue-element-loading'
import Swal from "sweetalert2";
import axios from "axios";

export default {
    components: {
      VueElementLoading
    },
    props:['user','my_modal'],
    data() {
        return {
            form:this.user,
            errMsg:{},
            loading:false
        }
    },
    methods: {
        cancel(){
         this.my_modal.hide('more');
        },
    },
    mounted() {

    },
}
</script>
