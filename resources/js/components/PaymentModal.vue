<template>
  <div class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);" v-if="visible">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Payment</h5>
          <button type="button" class="close" @click="$emit('close')">&times;</button>
        </div>
        <div class="modal-body">
          <p>You are about to purchase:</p>
          <h4>{{ itemType | capitalize }} #{{ itemId }}</h4>
          <h3 class="text-primary">NGN {{ amount }}</h3>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="$emit('close')" :disabled="loading">Cancel</button>
          <button type="button" class="btn btn-primary" @click="pay" :disabled="loading">
            <i class="fas fa-spinner fa-spin" v-if="loading"></i>
            {{ loading ? 'Processing...' : 'Pay Now' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  props: {
    visible: Boolean,
    itemType: String,
    itemId: Number,
    amount: [String, Number],
  },
  data() {
    return { loading: false };
  },
  filters: {
    capitalize(val) {
      return val ? val.charAt(0).toUpperCase() + val.slice(1) : "";
    },
  },
  methods: {
    pay() {
      this.loading = true;
      axios
        .post("/payment/checkout", {
          item_type: this.itemType,
          item_id: this.itemId,
        })
        .then((res) => {
          if (res.data.already_completed) {
            this.$toast.success("Access granted");
            this.$emit('close');
            return;
          }
          window.location.href = res.data.authorization_url;
        })
        .catch((err) => {
          this.$toast.error(err.response?.data?.error || "Payment failed");
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
};
</script>
