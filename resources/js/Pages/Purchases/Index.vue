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
                    <h3>My Purchases</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card_box position-relative mb_30 white_bg">
              <div class="box_body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Item</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(txn, index) in transactions" :key="txn.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ txn.reference }}</td>
                        <td>{{ txn.item_type | capitalize }} #{{ txn.item_id }}</td>
                        <td>{{ txn.currency }} {{ txn.amount }}</td>
                        <td>
                          <span :class="'badge badge-' + (txn.status === 'completed' ? 'success' : txn.status === 'pending' ? 'warning' : 'danger')">
                            {{ txn.status }}
                          </span>
                        </td>
                        <td>{{ txn.paid_at || txn.created_at }}</td>
                      </tr>
                      <tr v-if="!transactions.length">
                        <td colspan="6" class="text-center">No purchases yet</td>
                      </tr>
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
import layout from "../BaseLayouts/Layout.vue";
export default {
  components: { layout },
  props: { transactions: Array },
  filters: {
    capitalize(val) {
      return val ? val.charAt(0).toUpperCase() + val.slice(1) : "";
    },
  },
};
</script>
