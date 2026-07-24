<template>
  <layout>
    <div class="main_content_iner">
      <div class="container-fluid p-0 sm_padding_15px">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="dashboard_header mb_50">
              <div class="row">
                <div class="col-lg-6">
                  <div class="dashboard_header_title">
                    <h3>My Profile</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card_box mb_30 white_bg text-center">
              <div class="box_body p-4">
                <div class="mb-3">
                  <img :src="avatarUrl" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <h5>{{ user.fname }} {{ user.lname }}</h5>
                <p class="text-muted">{{ user.user_type?.user_type_name }}</p>
                <form @submit.prevent="uploadAvatar">
                  <div class="custom-file mb-2">
                    <input type="file" class="custom-file-input" id="avatarInput" @change="onAvatarChange" accept="image/*">
                    <label class="custom-file-label" for="avatarInput">{{ avatarFile ? avatarFile.name : 'Choose image' }}</label>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm" :disabled="!avatarFile">
                    <i class="fas fa-upload"></i> Upload
                  </button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="card_box mb_30 white_bg">
              <div class="box_header">
                <div class="main-title"><h4>Edit Profile</h4></div>
              </div>
              <div class="box_body">
                <form @submit.prevent="updateProfile">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label>First Name</label>
                      <input v-model="form.fname" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label>Last Name</label>
                      <input v-model="form.lname" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label>Email</label>
                      <input :value="user.email" class="form-control" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label>Phone</label>
                      <input v-model="form.phone" class="form-control">
                    </div>
                    <div class="col-12 mb-3">
                      <label>Address</label>
                      <textarea v-model="form.address" class="form-control" rows="2"></textarea>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                </form>
              </div>
            </div>
            <div class="card_box mb_30 white_bg">
              <div class="box_header">
                <div class="main-title"><h4>Change Password</h4></div>
              </div>
              <div class="box_body">
                <form @submit.prevent="changePassword">
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <label>Current Password</label>
                      <input v-model="pw.current_password" type="password" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label>New Password</label>
                      <input v-model="pw.new_password" type="password" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label>Confirm New Password</label>
                      <input v-model="pw.new_password_confirmation" type="password" class="form-control" required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-warning"><i class="fas fa-key"></i> Change Password</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>
<script>
import layout from "../BaseLayouts/Layout.vue";
import axios from "axios";
export default {
  components: { layout },
  props: { user: Object },
  data() {
    return {
      form: {
        fname: this.user.fname,
        lname: this.user.lname,
        phone: this.user.phone || "",
        address: this.user.address || "",
      },
      pw: {
        current_password: "",
        new_password: "",
        new_password_confirmation: "",
      },
      avatarFile: null,
    };
  },
  computed: {
    avatarUrl() {
      return this.user.image ? "/storage/" + this.user.image : "https://ui-avatars.com/api/?name=" + this.user.fname + "+" + this.user.lname;
    },
  },
  methods: {
    onAvatarChange(e) {
      this.avatarFile = e.target.files[0];
    },
    uploadAvatar() {
      if (!this.avatarFile) return;
      const fd = new FormData();
      fd.append("avatar", this.avatarFile);
      axios.post("/profile/upload-avatar", fd).then(() => {
        this.$toast.success("Avatar updated");
        location.reload();
      });
    },
    updateProfile() {
      axios.post("/profile/update", this.form).then(() => {
        this.$toast.success("Profile updated");
      });
    },
    changePassword() {
      axios.post("/profile/change-password", this.pw).then(() => {
        this.$toast.success("Password changed");
        this.pw = { current_password: "", new_password: "", new_password_confirmation: "" };
      });
    },
  },
};
</script>
