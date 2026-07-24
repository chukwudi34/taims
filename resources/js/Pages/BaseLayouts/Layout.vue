<template>
  <div>
    <appSidebar />
    <section class="main_content dashboard_part large_header_bg">
      <appNavbar />
      <slot />
    </section>
    <appFooter />
    <ChatWidget />

    <div id="back-top" style="display: none">
      <a title="Go to Top" href="#">
        <i class="ti-angle-up"></i>
      </a>
    </div>
  </div>
</template>
<script>
import appNavbar from "./Navbar.vue";
import appSidebar from "./Sidebar.vue";
import appFooter from "./Footer.vue";
import ChatWidget from "../../components/ChatWidget.vue";
export default {
  components: {
    appNavbar,
    appSidebar,
    appFooter,
    ChatWidget,
  },
};
</script>
