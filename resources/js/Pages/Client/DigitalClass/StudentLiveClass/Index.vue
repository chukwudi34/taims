<template>
    <div>
      <div class="card_box position-relative mb_30 white_bg">
        <VueElementLoading
          :active="liveClassLoading"
          spinner="line-wave"
          color="var(--primary)"
        />
        <div class="white_box_tittle">
          <div class="main-title2">
            <h6 class="nowrap float-left mt-1 mb-0">
              <i class="fas fa-video mr-2"></i> Live Class
            </h6>
          </div>
        </div>
        <div class="box_body">
          <div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Subject</span>
                  </div>
                  <select
                    class="custom-select"
                    v-model="filter.subjectId"
                    @change="fetchLiveClassData"
                    required
                  >
                    <option value="">--Filter by Subject--</option>
                    <option
                      v-for="subject in subjects"
                      :key="subject.id"
                      :value="subject.id"
                    >
                      {{ subject.subject_name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <table
            class="table table-bordered table-responsive table-hover"
            v-if="liveclasses.data != ''"
          >
            <thead>
              <tr>
                <th width="3%">#</th>
                <th width="15%">Subject</th>
                <th width="20%">Topic</th>
                <th width="12%">Start Date</th>
                <th width="8%">Start Time</th>
                <th width="13%">Created by</th>
                <th width="8%">Price</th>
                <th>Status</th>
                <th width="10%">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(lcs, index) in liveclasses.data" :key="lcs.id">
                <td>{{ index + 1 }}.</td>
                <td style="text-transform: capitalize">
                  {{ lcs.subject.subject_name }}
                </td>
                <td>{{ lcs.topic && lcs.topic.topic_name }}</td>
                <td>{{ lcs.date }}</td>
                <td>{{ lcs.start_time }}</td>
                <td>{{ lcs.creator.lname }} {{ lcs.creator.fname }}</td>
                <td>
                  <span v-if="lcs.price > 0" class="text-primary font-weight-bold">NGN {{ lcs.price }}</span>
                  <span v-else class="text-success">Free</span>
                </td>
                <td>
                  <div
                    class="badge badge-pill"
                    :class="{
                      'badge-success': lcs.status == 'ongoing',
                      'badge-danger': lcs.status == 'expired',
                      'badge-info': lcs.status == 'not_started',
                    }"
                  >
                    <span v-if="lcs.status == 'ongoing'">ONGOING</span>
                    <span v-if="lcs.status == 'not_started'">SCHEDULED</span>
                    <span v-if="lcs.status == 'expired'">ELAPSED</span>
                  </div>
                </td>
                <td>
                  <template v-if="lcs.status == 'not_started'">
                    <button
                      v-if="lcs.has_access || lcs.price <= 0"
                      class="btn btn-secondary btn-sm"
                      disabled
                    >
                      Enrolled
                    </button>
                    <button
                      v-else
                      @click="payForItem('live_class', lcs.id)"
                      class="btn btn-primary btn-sm"
                      :disabled="paying"
                    >
                      <i class="fas fa-spinner fa-spin" v-if="paying"></i>
                      Pay NGN {{ lcs.price }}
                    </button>
                  </template>
                  <template v-else-if="lcs.status == 'ongoing'">
                    <a
                      v-if="lcs.has_access"
                      :href="`/client/digital_class/live_class/join/${lcs.id}`"
                      class="btn btn-success btn-sm"
                    >
                      Join Class
                    </a>
                    <button
                      v-else
                      @click="payForItem('live_class', lcs.id)"
                      class="btn btn-primary btn-sm"
                      :disabled="paying"
                    >
                      <i class="fas fa-spinner fa-spin" v-if="paying"></i>
                      Pay NGN {{ lcs.price }}
                    </button>
                  </template>
                  <span v-else class="text-muted small">--</span>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="alert alert-info text-center" v-else>
            <h5>No Record Found</h5>
          </div>
        </div>
        <div class="card_footer">
            <pagination
              :data="liveclasses"
              @pagination-change-page="fetchLiveClassData"
            >
              <span slot="prev-nav">&lt; Previous</span>
              <span slot="next-nav">Next &gt;</span>
            </pagination>
        </div>
      </div>
    </div>
  </template>

  <script>
  import VueElementLoading from "vue-element-loading";
  import axios from "axios";

  export default {
    components: {
      VueElementLoading,
    },
    data() {
      return {
        liveClassLoading: false,
        subjects: {},
        currentClass: {},
        liveclasses: {},
        filter: {
          subjectId: "",
        },
        paying: false,
      };
    },
    methods: {
      fetchLiveClassData(page = 1) {
        this.liveClassLoading = true;
        axios
          .post("/client/digital_class/live_class/fetch?page="+page, this.filter)
          .then((res) => {
            this.liveclasses = res.data;
          })
          .catch((err) => {})
          .finally(() => {
            this.liveClassLoading = false;
          });
      },

      getAllSubjects() {
        this.liveClassLoading = true;
        axios
          .get(this.$route("client.curriculum.subjects"))
          .then((res) => {
            this.subjects = res.data;
          })
          .catch((err) => {})
          .finally(() => {
            this.liveClassLoading = false;
          });
      },

      payForItem(itemType, itemId) {
        this.paying = true;
        axios
          .post("/payment/checkout", { item_type: itemType, item_id: itemId })
          .then((res) => {
            if (res.data.free || res.data.already_completed) {
              this.$toast.success("Access granted");
              this.fetchLiveClassData();
              this.paying = false;
              return;
            }
            if (window.PaystackPop) {
              const reference = res.data.reference;
              const handler = PaystackPop.setup({
                key: res.data.public_key,
                email: res.data.email,
                amount: res.data.amount,
                ref: reference,
                callback: () => {
                  axios.get('/payment/callback', { params: { reference } })
                    .then(() => {
                      this.$toast.success("Payment successful! Access granted.");
                      this.fetchLiveClassData();
                    })
                    .catch(() => {
                      this.$toast.error("Payment verification failed. Contact support.");
                    })
                    .finally(() => {
                      this.paying = false;
                    });
                },
                onClose: () => {
                  this.$toast.info("Payment cancelled");
                  this.paying = false;
                },
              });
              handler.openIframe();
            }
          })
          .catch((err) => {
            this.$toast.error(err.response?.data?.error || "Payment failed");
            this.paying = false;
          });
      },

      UpdateStatusForElapsed() {
            axios
                .post("/client/digital_class/live_class/update_elapsed")
                .then((res) => {})
                .catch((err) => {})
                .finally(() => {});
        },
      setCurrentClass(data) {
        this.currentClass = data;
      },

      reloadData() {
        this.fetchLiveClassData();
        this.getAllSubjects()
      },
    },
    mounted() {
      this.reloadData();
    },
  };
  </script>

  <style scoped>
  .selected-row {
    background-color: rgb(181, 253, 223) !important;
  }
  </style>
