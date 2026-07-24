<template>
  <div class="card">
    <VueElementLoading
      :active="classCreateLoading"
      spinner="line-wave"
      color="var(--primary)"
    />
    <form @submit.prevent="saveClass">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="input-group mb-4">
              <div class="input-group-prepend">
                <span class="input-group-text">Name</span>
              </div>
              <input
                type="text"
                v-model="form.class_name"
                class="form-control"
                placeholder=""
              />
            </div>
            <div class="input-group mb-4">
              <div class="input-group-prepend">
                <span class="input-group-text">Code</span>
              </div>
              <input
                type="text"
                v-model="form.class_code"
                class="form-control"
                placeholder=""
              />
            </div>
            <div class="input-group mb-4">
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
        <button type="button" class="mr-2 btn btn-link btn-sm" @click="closeMe">
          Cancel
        </button>
        <button
          type="submit"
          class="btn btn-sm"
          style="background-color: #002147 !important; color: white !important"
        >
          Save
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import VueElementLoading from "vue-element-loading";
import toastr from "toastr";
import axios from "axios";

export default {
  components: {
    VueElementLoading,
  },
  props: {
    my_modal: Object,
  },
  data() {
    return {
      classCreateLoading: false,
      form: {
        class_name: "",
        class_code: "",
        status: "",
      },
    };
  },
  methods: {
    //  method to send form data to server for database entry
    saveClass() {
      this.classCreateLoading = true;
      axios
        .post(this.$route("admin.class.create"), this.form)
        .then((response) => {
          this.$toast.success("Class created successfully");
          this.$emit("class-created");
          this.closeMe();
        })
        .catch((err) => {
          this.$toast.error("Unable to save Class");
        })
        .finally(() => {
          this.classCreateLoading = false;
        });
    },
    closeMe() {
      this.my_modal.hide("create-class");
    },
  },
};
</script>
