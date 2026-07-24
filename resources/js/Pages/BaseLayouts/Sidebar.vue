<template>
  <div>
    <nav
      class="sidebar vertical-scroll d-none d-md-block ps-container ps-theme-default ps-active-y"
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
          <li class="treeview-animated-items">
            <inertia-link
              href="/dashboard"
              aria-expanded="false"
              :class="[
                $page.url === '/dashboard' ? 'active' : 'side-menu-link',
              ]"
            >
              <div class="icon_menu">
                <span class="mdi mdi-view-dashboard"></span>
              </div>
              <span class="text">Dashboard</span>
            </inertia-link>
          </li>
          <li class="treeview-animated-items">
            <inertia-link
              href="/admin/class"
              aria-expanded="false"
              :class="[
                $page.url === '/admin/class' ? 'active' : 'side-menu-link',
              ]"
              v-if="
                $page.props.auth.user.user_type_id == 3 ||
                $page.props.auth.user.user_type_id == 1
              "
            >
              <div class="icon_menu">
                <span class="mdi mdi-school"></span>
              </div>
              <span class="text">Class Manager</span>
            </inertia-link>
          </li>
          <li class="treeview-animated-items">
            <inertia-link
              href="/subject/manager"
              aria-expanded="false"
              :class="[
                $page.url === '/subject/manager' ? 'active' : 'side-menu-link',
              ]"
            >
              <div class="icon_menu">
                <span class="mdi mdi-book-open-page-variant"></span>
              </div>
              <span class="text">Curriculum</span>
            </inertia-link>
          </li>
          <li class="treeview-animated-items">
            <inertia-link
              href="/client/digital_class/live_class"
              aria-expanded="false"
              :class="[
                $page.url === '/client/digital_class/live_class'
                  ? 'active'
                  : 'side-menu-link',
              ]"
            >
              <div class="icon_menu">
                <span class="mdi mdi-cast"></span>
              </div>
              <span class="text">Live Class</span>
            </inertia-link>
          </li>
          <li class="treeview-animated-items">
            <inertia-link
              href="/client/digital_class/recorded_videos"
              aria-expanded="false"
              :class="[
                $page.url === '/client/digital_class/recorded_videos'
                  ? 'active'
                  : 'side-menu-link',
              ]"
            >
              <div class="icon_menu">
                <span class="mdi mdi-video-vintage"></span>
              </div>
              <span class="text">Recorded Video</span>
            </inertia-link>
          </li>

          <li class="treeview-animated-items">
            <inertia-link
              href="/assessment"
              aria-expanded="false"
              :class="[
                $page.url === '/assessment' ? 'active' : 'side-menu-link',
              ]"
              v-if="$page.props.auth.user.user_type_id == 3"
            >
              <div class="icon_menu">
                <span class="mdi mdi-pencil"></span>
              </div>
              <span class="text">Assessment Setup</span>
            </inertia-link>
          </li>
          <li class="treeview-animated-items">
            <inertia-link
              href="/assessment/quiz_bank"
              aria-expanded="false"
              :class="[
                $page.url === '/assessment/quiz_bank'
                  ? 'active'
                  : 'side-menu-link',
              ]"
              v-if="
                $page.props.auth.user.user_type_id == 3 ||
                $page.props.auth.user.user_type_id == 1
              "
            >
              <div class="icon_menu">
                <span class="mdi mdi-bank"></span>
              </div>
              <span class="text">Assessment Bank</span>
            </inertia-link>
          </li>
          <li class="treeview-animated-items">
            <inertia-link
              href="/assessment/take_quiz_index"
              aria-expanded="false"
              :class="[
                $page.url === '/assessment/take_quiz_index'
                  ? 'active'
                  : 'side-menu-link',
              ]"
              v-if="$page.props.auth.user.user_type_id == 2"
            >
              <div class="icon_menu">
                <span class="mdi mdi-comment-question"></span>
              </div>
              <span class="text">Assessment Quiz</span>
            </inertia-link>
          </li>
          <li class="treeview-animated-items">
            <inertia-link
              href="/manage-user"
              aria-expanded="false"
              :class="[
                $page.url === '/manage-user' ? 'active' : 'side-menu-link',
              ]"
              v-if="$page.props.auth.user.user_type_id == 3"
            >
              <div class="icon_menu">
                <span class="mdi mdi-account-group"></span>
              </div>
              <span class="text">Manage Users</span>
            </inertia-link>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>
<script>
export default {
  data() {
    return {
      isDropdownOpen: false,
    };
  },

  methods: {
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
  },
  mounted() {
    $(function () {
      let $allPanels = $(".nested").hide();
      let $elements = $(".treeview-animated-element");

      $(".closed").click(function () {
        let mainDiv = $(this);
        let target = mainDiv.siblings(".nested");
        let pointer = mainDiv.children(".mdi-chevron-right");

        mainDiv.toggleClass("open");
        pointer.toggleClass("down");

        !target.hasClass("active")
          ? target.addClass("active").slideDown()
          : target.removeClass("active").slideUp();

        return false;
      });

      $elements.click(function () {
        mainDiv = $(this);

        mainDiv.hasClass("opened")
          ? mainDiv.removeClass("opened")
          : ($elements.removeClass("opened"), mainDiv.addClass("opened"));
      });
    });
  },
};
</script>
<style scoped>
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

/* .closed .mdi:before {
  font-size: 22px !important;
} */
.closed .mdi-chevron-right::before {
  color: #a1a4b9 !important;
}

.sidebar #sidebar_menu > li a {
  font-size: 15px !important;
}
/* .sidebar #sidebar_menu > li {
  margin-right: 0px !important;
} */

.sidebar #sidebar_menu > li ul li a {
  font-size: 13px !important;
}
.sidebar #sidebar_menu > li a {
  font-size: 15px !important;
}
.icon_menu {
  /* color: #4448e7 !important; */
  /* font-size: 23px !important; */
}
</style>
