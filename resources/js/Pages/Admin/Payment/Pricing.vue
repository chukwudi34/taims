<template>
  <layout>
    <div class="main_content_iner">
      <div class="container-fluid p-0 sm_padding_15px">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="dashboard_header mb_50">
              <div class="row">
                <div class="col-lg-6">
                  <div class="dashboard_header_title"><h3>Pricing Manager</h3></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card_box mb_30 white_bg">
              <div class="box_header">
                <div class="main-title"><h4>Set Price</h4></div>
              </div>
              <div class="box_body">
                <form @submit.prevent="setPrice" class="row">
                  <div class="col-md-3 mb-2">
                    <select v-model="form.item_type" class="form-control" required>
                      <option value="">Select type</option>
                      <option value="class">Class</option>
                      <option value="video">Video</option>
                      <option value="live_class">Live Class</option>
                      <option value="quiz">Quiz</option>
                    </select>
                  </div>
                  <div class="col-md-3 mb-2">
                    <input v-model="form.item_id" type="number" class="form-control" placeholder="Item ID" required>
                  </div>
                  <div class="col-md-3 mb-2">
                    <input v-model="form.amount" type="number" step="0.01" class="form-control" placeholder="Amount (NGN)" required>
                  </div>
                  <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Set Price</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="card_box white_bg">
              <div class="box_header">
                <div class="main-title"><h4>Current Pricing</h4></div>
              </div>
              <div class="box_body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Item ID</th>
                        <th>Amount</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(p, i) in pricing" :key="p.id">
                        <td>{{ i+1 }}</td>
                        <td>{{ p.item_type }}</td>
                        <td>{{ p.item_id }}</td>
                        <td>NGN {{ p.amount }}</td>
                        <td><button class="btn btn-sm btn-danger" @click="remove(p.item_type, p.item_id)">Remove</button></td>
                      </tr>
                      <tr v-if="!pricing.length"><td colspan="5" class="text-center">No pricing set</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>
<script>
import layout from "../../BaseLayouts/Layout.vue";
import axios from "axios";
export default {
  components: { layout },
  props: { pricing: Array },
  data() {
    return { form: { item_type: "", item_id: "", amount: "" } };
  },
  methods: {
    setPrice() {
      axios.post("/admin/payment/pricing/set", this.form).then(() => {
        this.$toast.success("Price set");
        location.reload();
      });
    },
    remove(type, id) {
      axios.post("/admin/payment/pricing/remove", { item_type: type, item_id: id }).then(() => {
        this.$toast.success("Price removed");
        location.reload();
      });
    },
  },
};
</script>
