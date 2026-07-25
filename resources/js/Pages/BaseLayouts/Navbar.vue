<template>
  <div>
    <div class="container-fluid no-gutters">
      <div class="row">
        <div class="col-lg-12 p-0">
          <div
            class="header_iner d-flex justify-content-between align-items-center"
          >
            <div class="sidebar_icon d-lg-none">
              <i class="ti-menu" v-b-toggle.sidebar-backdrop></i>
            </div>
            <div class="d-flex align-items-center mr-sm-4">
              <h4>
                <em>Technology Assisted Instructional Management Solution</em>
              </h4>
            </div>
            <div
              class="header_right d-flex justify-content-between align-items-center"
            >
              <div class="profile_info">
                <img :src="url" alt="#" />
                <div class="profile_info_iner">
                  <div class="profile_author_name">
                    <p>{{ $page.props.auth.user.user_type.user_type_name }}</p>
                    <h5>
                      {{
                        $page.props.auth.user.lname +
                        " " +
                        $page.props.auth.user.fname
                      }}
                    </h5>
                  </div>
                  <div class="profile_info_details">
                    <inertia-link class="inertia-link" href="/profile/"
                      >My Profile</inertia-link
                    >

                    <button
                      class="btn btn_link"
                      type="button"
                      @click="doLogout()"
                    >
                      <span>Log Out</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- left Sidebar content -->
    <b-sidebar
      id="sidebar-backdrop"
      aria-labelledby="sidebar-no-header-title"
      no-header
      :backdrop-variant="'dark'"
      backdrop
      shadow
      class="left-nav test"
    >
      <template>
        <nav
          class="sidebar vertical-scroll ps-container ps-theme-default ps-active-y"
        >
          <div class="logo d-flex justify-content-between">
            <inertia-link href="/">
              <h1 style="text-decoration: overline">
                <span style="color: #002147 !important">TA</span
                ><span style="color: #fdc800 !important">IM</span
                ><span style="display: inline-block">S</span>
              </h1>
            </inertia-link>
          </div>
          <div class="treeview-animated">
            <ul id="sidebar_menu" class="treeview-animated-list">
              <li
                class="treeview-animated-items"
                v-for="item in visibleNavItems"
                :key="item.href"
              >
                <inertia-link
                  :href="item.href"
                  aria-expanded="false"
                  :class="[item.activeMatch($page.url) ? 'active' : 'side-menu-link']"
                >
                  <div class="icon_menu">
                    <span :class="'mdi ' + item.icon"></span>
                  </div>
                  <span class="text">{{ item.label }}</span>
                </inertia-link>
              </li>
            </ul>
          </div>
        </nav>
      </template>
    </b-sidebar>
  </div>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue";
import axios from "axios";
import { navItems } from "../../shared/sidebarNav";

export default {
  components: {
    "inertia-link": Link,
  },
  data() {
    return {
      loading: false,
      url: "",
    };
  },
  computed: {
    visibleNavItems() {
      const userTypeId = this.$page.props.auth?.user?.user_type_id;
      return navItems.filter(
        (item) => !item.roles || item.roles.includes(userTypeId)
      );
    },
  },
  methods: {
    doLogout() {
      axios
        .post("/logout")
        .then((res) => {
          window.location.href = "/";
        })
        .catch((err) => {})
        .finally(() => {
          this.loading = false;
        });
    },
  },
  mounted() {
    if (
      this.$page.props.auth.user.image ==
      "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSyudBxqf1sdD2e3L4nI3nqsMt1_tceOyuZ7A&usqp=CAU"
    ) {
      this.url =
        "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSyudBxqf1sdD2e3L4nI3nqsMt1_tceOyuZ7A&usqp=CAU";
    } else {
      this.url = "storage/images/" + this.$page.props.auth.user.image;
    }
    $(function () {
      $(".bell_notification_clicker").on("click", function () {
        $(".Menu_NOtification_Wrap").toggleClass("active");
      });
      $(document).click(function (event) {
        if (
          !$(event.target).closest(
            ".bell_notification_clicker ,.Menu_NOtification_Wrap"
          ).length
        ) {
          $("body").find(".Menu_NOtification_Wrap").removeClass("active");
        }
      });
      $(".CHATBOX_open").on("click", function () {
        $(".CHAT_MESSAGE_POPUPBOX").toggleClass("active");
      });
      $(".MSEESAGE_CHATBOX_CLOSE").on("click", function () {
        $(".CHAT_MESSAGE_POPUPBOX").removeClass("active");
      });
      $(document).click(function (event) {
        if (
          !$(event.target).closest(".CHAT_MESSAGE_POPUPBOX, .CHATBOX_open")
            .length
        ) {
          $("body").find(".CHAT_MESSAGE_POPUPBOX").removeClass("active");
        }
      });
    });
  },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Nunito");
.active {
  font-weight: bold;
  background: #002147 !important;
  border-radius: 12px !important;
  padding: 10px !important;
}

.active .text {
  color: #fdc800 !important;
}

.active .icon_menu span,
.active .icon_menu i {
  color: #fdc800 !important;
  font-size: 23px !important;
}

.side-menu-link {
  font-weight: bold;
  background: #f2f7ff !important;
  border-radius: 12px !important;
  padding: 10px !important;
}
.side-menu-link .icon_menu span,
.side-menu-link .icon_menu i {
  color: #002147 !important;
  font-size: 23px !important;
}
.side-menu-link .text {
  color: #002147 !important;
}

.sidebar {
  left: 0 !important;
}

.closed .mdi:before {
  font-size: 22px !important;
}

.closed .mdi-chevron-right::before {
  color: #a1a4b9 !important;
}

.sidebar #sidebar_menu > li a {
  font-size: 15px !important;
}

.sidebar #sidebar_menu > li {
  margin-right: 0px !important;
}

.sidebar #sidebar_menu > li ul li a {
  font-size: 13px !important;
}

.icon_menu {
  color: #4448e7 !important;
  font-size: 23px !important;
}

.btn_link {
  color: #2e4765;
  font-size: 14px;
  display: block;
  padding: 10px 0;
  font-weight: 400;
}

@media (max-width: 991px) {
  .sidebar .logo {
    padding: 10px 0 !important;
  }
}
</style>
