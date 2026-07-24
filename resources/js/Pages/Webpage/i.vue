<template>
    <div>
        <div class="page-wrapper">
            <section class="menu cid-rVsd9bMrH3" once="menu" id="menu1-2y">
                <nav class="navbar navbar-expand-md  navbar-dark navbar-short">
                    <!-- Brand -->
                    <div class="navbar-brand">
                      <span class="navbar-caption-wrap"><a class="navbar-caption text-black display-2" href="index.html">TECHASSISTMES</a></span>
                    </div>

                    <!-- Toggler/collapsibe Button -->
                    <button class="navbar-toggler text-black" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                      <span class="navbar-toggler-icon text-black"></span>
                    </button>

                    <!-- Navbar links -->
                    <div class="collapse navbar-collapse mx-auto" id="collapsibleNavbar">
                      <ul class="navbar-nav mx-auto px-5 justify-content-between">
                        <li class="nav-item">
                          <a class="nav-link text-black display-7" href="#">About </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link text-black display-7" href="#"></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link text-black display-7" href="#">Contact</a>
                        </li>
                      </ul>
                      <ul class="navbar-nav ml-auto px-2">
                        <li class="nav-item">
                          <a class="nav-link text-black display-7" href="#">Login</a>
                        </li>
                        <li class="nav-item">
                          <inertia-link class="nav-link text-black btn-text navbar-buttons btn btn-sm btn-primary display-7 text-underline-none" href="user-type">
                              Get Started
                          </inertia-link>
                        </li>
                      </ul>

                    </div>
                  </nav>
            </section>
        </div>
    </div>
</template>
<script>
 export default {
    data(){

    }
 }
</script>
<style scoped>
*{
    box-sizing: border-box !important;
}
  .page-wrapper{
    background-color: #eeeeee !important;
  }
  .cid-rVsd9bMrH3 .navbar {
    box-shadow: 0 8px 20px 0 rgb(0 0 0 / 10%);
    min-height: 77px !important;
    transition: all .3s !important;
    background: #ffffff !important;
}
.cid-rVsd9bMrH3 .navbar-dropdown {
  padding: 0.5rem 1rem !important;
  position: fixed !important;
}
.cid-rVsd9bMrH3 .container {
  max-width: 1800px !important;
  display: flex !important;
  margin: auto !important;
}
.cid-rVsd9bMrH3 .navbar-brand {
  -webkit-flex-shrink: 0 !important;
  flex-shrink: 0 !important;
  -webkit-align-items: center !important;
  align-items: center !important;
  margin-right: 0 !important;
  padding: 0 !important;
  transition: all .3s !important;
  word-break: break-word !important;
  z-index: 1 !important;
}
.menu .navbar-brand .navbar-caption-wrap {
  display: -webkit-flex !important;
}
.navbar-dropdown .navbar-brand span {
  vertical-align: -4px;
}
.cid-rVsd9bMrH3 .navbar-brand .navbar-caption {
  line-height: inherit !important;
}
.navbar-dropdown .navbar-caption, .navbar-dropdown .navbar-caption:hover {
  color: inherit;
  text-decoration: none;
}
.navbar-dropdown .navbar-caption {
  font-weight: 700;
  white-space: normal;
  vertical-align: -4px;
  line-height: 3.125rem !important;
}
.text-black {
  color: #000000 !important;
}
.display-2 {
  font-family: 'Be Vietnam', sans-serif !important;
  font-size: 2.4rem !important;
  line-height: 1.3 !important;
}
a {
  font-style: normal !important;
  font-weight: 400 !important;
  cursor: pointer !important;
}
.display-7 {
  font-family: 'Be Vietnam', sans-serif;
  font-size: 1.1rem;
  line-height: 2;
}

</style>
