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
  </div>
</template>
<script>
import { navItems } from "../../shared/sidebarNav";
export default {
  computed: {
    visibleNavItems() {
      const userTypeId = this.$page.props.auth?.user?.user_type_id;
      return navItems.filter(
        (item) => !item.roles || item.roles.includes(userTypeId)
      );
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

.closed .mdi-chevron-right::before {
  color: #a1a4b9 !important;
}

.sidebar #sidebar_menu > li a {
  font-size: 15px !important;
}

.sidebar #sidebar_menu > li ul li a {
  font-size: 13px !important;
}
.sidebar #sidebar_menu > li a {
  font-size: 15px !important;
}
</style>
