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
                            <h3>Users</h3>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="dashboard_breadcam text-right">
                            <p>
                              <inertia-link href="/">User Manager</inertia-link>
                              <i class="fas fa-caret-right"></i> users
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- <div class="white_box_tittle">
                              <div class="main-title2">
                                <h6 class="nowrap float-left mt-1 mb-0">
                                  <i class="fas fa-edit mr-1"></i> classes
                                </h6>
                                <div class="float-right">
                                  <button
                                    style="font-size: 13px"
                                    @click="$bvModal.show('create-class')"
                                    class="btn shadow-md btn-info btn-sm px-3 py-1"
                                  >
                                    <i class="mdi mdi-plus-circle-outline mr-1"></i>
                                    New Class
                                  </button>
                                </div>
                              </div>
                            </div> -->
                            <div class="box_body mt-5">
                             <div v-if="users.data != ''">
                                <div class="row">
                                    <div class="col-md-4" v-for="(user,i) in users.data" :key="i">
                                        <div class="card_user border rounded-sm shadow-sm" style="width:200px;important;height:320px !important;background-color:#FFFFFF !important;">
                                            <div class="card_user_header">
                                                <div class="card_user_image px-0 mx-0" style="background-color:#E7E7E7 important;">
                                                    <img v-if="user.image != '' && user.image != 'https://res.cloudinary.com/crownbirthltd/image/upload/v1597424758/psitywq3w0z4wzpojmp8.png'" class="img-fluid" :src="'storage/images/'+user.image" alt="">
                                                    <img v-else-if="user.image == 'https://res.cloudinary.com/crownbirthltd/image/upload/v1597424758/psitywq3w0z4wzpojmp8.png'" class="img-fluid" src="https://res.cloudinary.com/crownbirthltd/image/upload/v1597424758/psitywq3w0z4wzpojmp8.png" alt="">
                                                    <img v-else class="img-fluid" src="https://res.cloudinary.com/crownbirthltd/image/upload/v1597424758/psitywq3w0z4wzpojmp8.png" alt="">
                                                </div>
                                            </div>
                                            <div class="card_user_body px-0 mx-0">
                                                <div class="mx-auto pt-2">
                                                    <span class="text-muted d-block text-center">{{user.lname.charAt(0).toUpperCase()+user.lname.slice(1) +' '+ user.fname.charAt(0).toUpperCase()+user.fname.slice(1)}}</span>
                                                </div>
                                                <div class="pt-1 d-flex justify-content-between mt-2">
                                                    <span class="text-muted pl-1 ml-1 d-block text-capitalize px-2"><span class=" badge badge-primary">{{user.user_type.user_type_name}}</span></span>
                                                    <span class="text-light pr-1 mr-1 badge text-capitalize  px-2" :class="{'badge-success':user.status=='active','badge-danger':user.status=='inactive'}">Status:{{user.status}}</span>
                                                </div>
                                                <div class="mx-auto text-center mt-2">
                                                    <button @click=" $bvModal.show('more');setCurrent(user)" class="btn btn btn_color text-light w-50 p-0 d-block mx-auto">More</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                              <div class="alert alert-info text-center" v-else>
                                <h5>No Record Found</h5>
                              </div>
                              <div class="mt-3">
                                <pagination :data="users" @pagination-change-page="getUsers">
                                    <span slot="prev-nav">&lt; Previous</span>
                                    <span slot="next-nav">Next &gt;</span>
                                </pagination>
                            </div>
                            </div>
                            <b-modal id="more" hide-footer no-close-on-esc no-close-on-backdrop hide-header-close>
                                <template #modal-title>
                                    <div class="d-block mx-auto">
                                        <i class="text-center mdi mdi-trash-can-outline"></i>
                                    </div>
                                    <h5 class="text-capitalize">{{
                                        `${currentUser.lname} ${currentUser.fname}'s full deatils`
                                    }}</h5>
                                </template>
                                <moreView size="sm" :user="currentUser" @resetted="getUsers" :my_modal="$bvModal" />
                            </b-modal>
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
  import layout from "../../BaseLayouts/Layout.vue";
  import VueElementLoading from 'vue-element-loading'
  import swal from "sweetalert";
  import axios from 'axios';
  import MoreView from './Partials/MoreView.vue';
  export default {
    components: {
      layout,
      VueElementLoading,
      'moreView':MoreView
    },
    data() {
      return {
        loading: false,
        users: {},
        currentUser: {},
        full_name:'',
      };
    },
    methods: {
        capitalizeFirstLetter(lname,fname) {
            this.full_name = lname.charAt(0).toUpperCase() + fname.charAt(0).toUpperCase();
        },
        getUsers(){
            axios
            .post(this.$route('manage-user.all'))
            .then((res) => {
            this.users = res.data;
            })
            .catch((err) => {
              swal("Error", "Unable to fetch users", "error");
            })
            .finally(() => {
            this.subjectLoading = false;
            });
        },
        setCurrent(data){
            this.currentUser = data;
        }
    },
    mounted() {
        this.getUsers();
    },
  };
  </script>
  <style scoped>
  .btn_color{
    background: #4448E7 !important;
  }
  </style>
