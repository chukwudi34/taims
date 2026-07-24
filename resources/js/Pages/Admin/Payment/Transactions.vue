<template>
  <layout>
    <div class="main_content_iner">
      <div class="container-fluid p-0 sm_padding_15px">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="dashboard_header mb_50">
              <div class="row">
                <div class="col-lg-6">
                  <div class="dashboard_header_title"><h3>All Transactions</h3></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card_box white_bg">
              <div class="box_body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Reference</th>
                        <th>User</th>
                        <th>Item</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(t, i) in transactions.data" :key="t.id">
                        <td>{{ i+1 }}</td>
                        <td>{{ t.reference }}</td>
                        <td>{{ t.user?.fname }} {{ t.user?.lname }}</td>
                        <td>{{ t.item_type }} #{{ t.item_id }}</td>
                        <td>NGN {{ t.amount }}</td>
                        <td><span :class="'badge badge-' + (t.status === 'completed' ? 'success' : t.status === 'pending' ? 'warning' : 'danger')">{{ t.status }}</span></td>
                        <td>{{ t.created_at }}</td>
                      </tr>
                      <tr v-if="!transactions.data?.length"><td colspan="7" class="text-center">No transactions</td></tr>
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
export default {
  components: { layout },
  props: { transactions: Object },
};
</script>
