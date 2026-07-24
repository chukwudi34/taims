<template>
  <div>
    <div class="container-fluid p-0">
      <!-- start nav section -->
      <nav
        class="navbar navbar-expand-md bg-dark navbar-dark fixed-top"
        id="mainNav"
      >
        <a class="navbar-brand" href="/">
          <h5 class="text-underline">
            <span style="color: #452d8b">TA</span
            ><span style="color: #e76021">IM</span><span>S</span>
            <sub class=""><small> </small></sub>
          </h5>
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#collapsibleNavbar"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav mx-auto mr-md-5 pl-md-5">
            <li class="nav-item pl-md-5 pl-0">
              <a class="nav-link link" href="#main-land">Home</a>
            </li>
            <li class="nav-item pl-md-5 pl-0">
              <a class="nav-link link" href="#about-page">About</a>
            </li>
            <li class="nav-item pl-md-5 pl-0">
              <a class="nav-link link" href="#contact-page">Contact</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item pl-md-4">
              <inertia-link type="button" class="btn btn-info" href="login"
                >Login <i class="fa fa-sign-in" aria-hidden="true"></i
              ></inertia-link>
            </li>
            <li class="nav-item pl-md-4">
              <inertia-link type="button" href="user-type" class="btn btn-info"
                >Register <i class="fa fa-user-plus" aria-hidden="true"></i
              ></inertia-link>
            </li>
          </ul>
        </div>
      </nav>
      <!-- end nav section -->
      <!-- start main setcion -->
      <section class="main-land" id="main-land">
        <div class="row">
          <div class="col-md-7 col-lg-7 col-12 col-sm-12 pt-md-3 pb-3">
            <h3 class="tech-desc pt-md-5 pb-5">
              <b id="tech"><em>T</em></b
              >echnology&nbsp;&nbsp;<b id="tech"><em>A</em></b
              >ssisted &nbsp;&nbsp;<b id="tech"><em>I</em></b
              >nstructional &nbsp;&nbsp;<b id="tech"><em>M</em></b
              >anagement &nbsp;&nbsp;<b id="tech"><em>S</em></b
              >olutions &nbsp;<strong><em>(TAIMS)</em></strong
              >&nbsp; are increasingly being adopted by educational institutions
              as a way to improve the efficiency and effectiveness of teaching
              and learning. These solutions typically involve the use of digital
              tools and platforms to manage and support various aspects of
              instruction, such as, course materials, assessments, and student
              performance tracking...
            </h3>
          </div>
          <div class="col-md-5 col-lg-5 col-sm-12 col-12" id="img">
            <img
              src="https://bootstrapmade.com/demo/templates/Techie/assets/img/hero-img.png"
              alt=""
              class="img-fluid animated"
            />
          </div>
        </div>
      </section>
      <!-- end main setcion -->
      <!-- start about section -->
      <section class="about-page" id="about-page">
        <h2 class="text-center about_">ABOUT TAIMS</h2>
        <div class="row">
          <div class="col-md-7">
            <h2 class="about-text" id="about-text">
              <em
                >ABOUT TECHNOLOGY-ASSITED INSTRUCTIONAL MANAGEMENT SOLUTION</em
              >
            </h2>
            <p id="desc">
              <i
                >"Technology Assisted Instructional Management Solution (TAIMS)
                is a web-based platform that streamlines the educational process
                for students, teachers, and other stakeholders. TAIMS offers
                features such as assignment tracking, progress monitoring, and
                communication tools to improve the overall learning experience
                and increase collaboration between all parties involved."
              </i>
            </p>
            <button class="read-more mt-3 btn btn-md btn-lg btn-xl">
              Read More
            </button>
          </div>
          <div class="col-md-5 img-fluid">
            <img
              src="https://bootstrapmade.com/demo/templates/Techie/assets/img/about.jpg"
              class="img-fluid"
              id="img2"
              alt=""
            />
          </div>
        </div>
      </section>
      <!-- end about section -->
      <!-- start contact section -->
      <section class="contact-page" id="contact-page">
        <h2 class="text-center about_ pt-5">CONTACT TAIMS</h2>
        <p class="text-center pb-0 mb-0" id="c_c_s">Contact customer support</p>
        <p class="mx-auto d-block text-center mt-3">
          Have a question? Need help? Click this button to chat with our support
          team! You can also email us at contact@taims.com
        </p>
        <div class="row mt-5">
          <div class="col-md-6 col-lg-6 col-12">
            <div class="info mb-4">
              <i class="bi bi-geo-alt"></i>
              <h3>Our Address</h3>
              <p>No 1 Prince olaide street Ijebu Ife, Ogun state, Nigeria</p>
            </div>
          </div>
          <div class="col-md-3 col-lg-3 col-6">
            <div class="info mb-4">
              <i class="bi bi-envelope"></i>
              <h3>Email Us</h3>
              <p>taims@gmail.com</p>
            </div>
          </div>
          <div class="col-md-3 col-lg-3 col-6">
            <div class="info mb-4">
              <i class="bi bi-telephone"></i>
              <h3>Call Us</h3>
              <p>+2348050443437</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-6 col-12">
            <div class="embed-responsive">
              <iframe
                width="100%"
                height="391"
                frameborder="0"
                scrolling="no"
                marginheight="0"
                marginwidth="0"
                id="gmap_canvas"
                src="https://maps.google.com/maps?width=1069&amp;height=400&amp;hl=en&amp;q=%20Lagos+()&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
              ></iframe>
            </div>
          </div>
          <div class="col-md-6 col-lg-6 col-12">
            <div class="form-group">
              <form>
                <div class="row">
                  <div class="col-md-6 col-lg-6">
                    <input
                      type="text"
                      placeholder="Your Name"
                      required="required"
                      class="field mb-3 form-control"
                    />
                  </div>
                  <div class="col-md-6 col-lg-6">
                    <input
                      type="email"
                      placeholder="Your Email"
                      required="required"
                      class="field mb-3 form-control"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-12 col-lg-12">
                    <input
                      type="text"
                      placeholder="Subject"
                      required="required"
                      class="field sub mb-3 form-control"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-12">
                    <textarea
                      rows="6"
                      placeholder="Message"
                      class="form-control"
                      style="
                        width: 100%;
                        border-radius: 5px;
                        border: 1px solid rgb(206, 212, 218);
                        margin-bottom: 20px;
                        padding-left: 10px;
                      "
                    ></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-lg-12 text-center">
                    <div id="btn-submit">
                      <button class="btn text-white" id="submit">
                        Send Message
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
      <!-- end contact section -->
      <!-- start footer section -->
      <footer class="footer" id="footer">
        <div class="row">
          <div class="col-md-3">
            <h2 class="footer_heading">Our Services</h2>
            <div class="row">
              <div class="col-md-12 col-lg-12 col-12">
                <p class="service">Online Testing</p>
                <p class="service">Virtual Instructional Engagement</p>
                <p class="service">Administration Of Standardized Tests</p>
                <p class="service">Automatic Scoring Of Result</p>
                <p class="service">Educational Consultancy</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h2 class="footer_heading">Quick Links</h2>
            <div class="row">
              <div class="col-md-12 col-lg-12 col-12">
                <p><a href="#" class="link-two">Home</a></p>
                <p><a href="#" class="link-two">About US</a></p>
                <p><a href="#" class="link-two">Contact Us</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h2 class="footer_heading">Location</h2>
            <address class="service">
              No 1 Prince olaide street Ijebu Ife, Ogun state, Nigeria
            </address>
          </div>
          <div class="col-md-3">
            <h2 class="footer_heading">Join Our Newsletter</h2>
            <div class="row">
              <div class="col-md-12 col-lg-12 col-12">
                <div class="input-group mb-3">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Your Email"
                  />
                  <div class="input-group-append">
                    <span class="input-group-text bh">subscribe</span>
                  </div>
                </div>
              </div>
            </div>
            <p class="service">Phone: +2348050443437</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div>
              <p
                class="text-white text-center"
                style="color: white"
                id="p_copy_right"
              >
                Copyright © <span id="myYear">2023</span> All rights reserved |
                TAIMS
              </p>
            </div>
          </div>
        </div>
      </footer>
      <!-- end footer section -->
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      devYear: "",
    };
  },
  mounted() {
    const d = new Date();
    this.devYear = d.getFullYear();
  },
};
</script>
<style scoped>
#mainNav {
  background: linear-gradient(
    45deg,
    rgba(86, 58, 250, 0.9) 0%,
    rgba(116, 15, 214, 0.9) 100%
  );
  /* background: #6639E8; */
}
.link {
  font-size: 17px !important;
  font-weight: 800;
  color: white !important;
}
.link:hover {
  text-decoration: underline;
  color: lawngreen !important;
  font-size: 18px !important;
  font-weight: 800;
}
#tech {
  font-size: 50px !important;
  font-weight: 800 !important;
}
#main-land {
  background: linear-gradient(
      45deg,
      rgba(86, 58, 250, 0.9) 0%,
      rgba(116, 15, 214, 0.9) 100%
    ),
    url(https://bootstrapmade.com/demo/templates/Techie/assets/img/hero-bg.jpg)
      center center no-repeat;
  background-size: cover !important;
  height: fit-content;
  /* height: 100vh !important; */
  padding: 120px 15px !important;
}
#img {
  animation-duration: 4s;
  animation-delay: 2s;
  animation: 4s linear infinite alternate;
}
.tech-desc {
  color: white !important;
  font-size: 17px !important;
  font-weight: 600;
  line-height: 2.5em !important;
}
#about-text {
  font-weight: 700 !important;
  color: #14256a !important;
  line-height: 1.3em !important;
}
#about-page {
  padding: 30px 15px !important;
}
#desc {
  font-weight: 400 !important;
  line-height: 2.5em !important;
}
.read-more {
  background: linear-gradient(45deg, #5846f9 0%, #7b27d8 100%) !important;
  border-radius: 5px !important;
  font-size: 16px !important;
  font-weight: 600 !important;
  letter-spacing: 1px !important;
  color: #fff !important;
}
.about_ {
  font-size: 30px;
  font-weight: 800;
  color: #000;
}
#c_c_s {
  line-height: 24px;
  font-size: 14px;
  color: #828bb2;
  font-weight: 300;
  letter-spacing: 0.6em !important;
}
.info {
  color: #444444 !important;
  text-align: center !important;
  box-shadow: 0 0 30px rgb(214 215 216 / 60%) !important ;
  padding: 20px 0 30px 0 !important;
  background: #fff !important;
  border-radius: 8px !important;
}
.info i {
  font-size: 32px !important;
  color: #5846f9 !important;
  border-radius: 50% !important;
  padding: 8px !important;
}
.info h3 {
  font-size: 20px !important;
  color: #2c4964 !important;
  font-weight: 700 !important;
  margin: 10px 0 !important;
  line-height: 1.2 !important;
}
.info p {
  padding: 0 !important;
  line-height: 24px !important;
  font-size: 14px !important;
  margin-bottom: 0 !important;
}
.form-group {
  box-shadow: 0 0 30px rgb(214 215 216 / 60%) !important;
  padding: 30px !important;
  background: #fff !important;
  border-radius: 8px !important;
}

.field {
  border: 1px solid #ced4da !important;
  border-radius: 5px !important;
}
#submit {
  background: #5846f9 !important;
  border-radius: 5px !important;
}
#footer {
  background: linear-gradient(
    45deg,
    rgba(86, 58, 250, 0.9) 0%,
    rgba(116, 15, 214, 0.9) 100%
  );
  /* background: linear-gradient( 45deg, rgba(86, 58, 250, 0.9) 0%, rgba(116, 15, 214, 0.9) 100% ); */
  height: fit-content !important;
  padding: 10px 20px !important;
}
.footer_heading {
  font-size: 25px !important;
  font-weight: 500;
  color: white !important;
  cursor: pointer;
  font-family: "Rubik";
}

#footer form {
  margin-top: 30px;
  background: #fff;
  padding: 6px 10px;
  position: relative;
  border-radius: 5px;
  text-align: left;
  border: 1px solid white;
}
.input1 {
  border: 0;
  padding: 4px 8px;
  width: 120px;
}
.link-two {
  font-weight: 400;
  color: white !important;
}

.service {
  font-weight: 400;
  color: white !important;
}
#contact-page {
  padding: 20px !important;
}
#p_copy_right {
  font-family: "Rubik";
  font-style: normal;
  font-weight: 400;
  font-size: 18px;
  line-height: 30px;
}
.bh {
  background: rgba(123, 39, 216, 0.8) !important;
  color: white !important;
}
.text-underline {
  font-size: 30px !important;
  font-weight: 800;
}
</style>
