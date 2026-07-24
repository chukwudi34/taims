<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        TAIMS
    </title>
    <script src="https://unpkg.com/vue@3.2.45"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js"
        integrity="sha512-lTLt+W7MrmDfKam+r3D2LURu0F47a3QaW5nF0c6Hl0JDZ57ruei+ovbg7BrZ+0bjVJ5YgzsAWE+RreERbpPE1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://unpkg.com/vue-element-loading"></script> -->


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/meanmenu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/default.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web_asset/css/responsive.css')}}">
    <style>
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

        .box {
            height: 200px !important;
            border-radius: 10px !important;
        }

        /* .content {
            padding: 10px 2px !important;
        } */

        .text-underline {
            font-size: 30px !important;
            font-weight: 800;
        }

        @media (max-width: 768px) {
            .box {
                height: 350px !important;
            }
        }

        @media (max-width: 576px) {
            .box {
                height: 250px !important;
            }
        }

        @media (min-width: 1200px) {
            .box {
                height: 250px !important;
            }
        }

        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .toast {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
    </style>



</head>

<body>
    <div id="app">

        <header id="home" class="white-bg">
            <div class="header-area header-sticky">
                <!-- header-bottom -->
                <div class="header-bottom-area header-sticky" style="transition: .6s;">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-2 col-lg-2 col-md-6 col-6">
                                <div class="logo">
                                    <a href="/">
                                        <h1 style="text-decoration: overline;">
                                            <span style="color: rgb(69, 45, 139);">TA</span><span style="color: #fdc800 !important;">IM</span><span style="display: inline-block;">S</span>
                                        </h1>

                                        <!-- <img src="img/logo/logo.png" alt=""> -->
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-6 col-6">
                                <div class="header-bottom-icon f-right">

                                </div>
                                <div class="main-menu f-right">
                                    <nav id="mobile-menu" style="display: block;">
                                        <ul>

                                            <li>
                                                <a href="/"> <- Back To Home</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mobile-menu"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /end header-bottom -->
            </div>
        </header>
        <div class="container p-md-0">
            <div class="main" id="main">

                <div class="content mt-sm-5">
                    <div class="row">
                        <div class="col-md-6">
                            <label
                                for="student"
                                class="shadow-md shadow-lg border hover-shadow box p-md-2 p-2 d-block ">
                                <div class="form-check">
                                    <label class="form-check-label"><input
                                            type="radio"
                                            name="optradio"
                                            id="student"
                                            class="form-check-input"
                                            v-model="userType"
                                            value="learner" /></label>
                                </div>
                                <div class="ml-md-5 ml-5">
                                    <h3 class="font-weight-bold">Learner</h3>
                                    <div>
                                        Welcome to our Technology Assisted Instructional Management
                                        Solution! This platform helps you stay organized and
                                        connected with your course materials, assignments, and
                                        grades. With our easy-to-use interface, you can easily
                                        access all of your course information and stay on top of
                                        your studies. Let's get started!
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label
                                for="teacher"
                                class="shadow-md shadow-lg border hover-shadow box p-md-2 d-block p-2">
                                <div class="form-check">
                                    <label class="form-check-label"><input
                                            type="radio"
                                            name="optradio"
                                            id="teacher"
                                            class="form-check-input"
                                            v-model="userType"
                                            value="instructor" /></label>
                                </div>
                                <div class="ml-md-5 ml-5">
                                    <h3 class="font-weight-bold">Instructor</h3>
                                    <div>
                                        Welcome to our page on Technology Assisted Instructional
                                        Management Solutions! Here, you will find information on the
                                        latest tools and techniques for integrating technology into
                                        your teaching practice to enhance student learning and
                                        increase efficiency in managing your classroom.
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <button
                                type="button"
                                class="btn btn-md btn-block mx-auto mt-md-5 mt-3 mb-3"
                                style="
                                    background-color: #002147 !important;
                                    color: white !important;
                                "
                                @click="submitUserType">
                                Submit
                            </button>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>

    <footer id="contact">
        <div class="footer-area primary-bg pt-150">
            <div class="container">
                <div class="footer-top pb-35">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="footer-widget">
                                <h1>
                                    <span style="color: rgb(69, 45, 139);">TA</span><span style="color: #fdc800 !important;">IM</span><span style="display: inline-block;">S</span>
                                </h1>
                                <div class="footer-para">
                                    <p>
                                        are increasingly being adopted by educational institutions as a way to improve the efficiency and effectiveness of teaching and learning.
                                    </p>
                                </div>
                                <!-- <div class="footer-socila-icon">
                                    <span>Follow Us</span>
                                    <div class="footer-social-icon-list">
                                        <ul>
                                            <li><a href="#"><span class="ti-facebook"></span></a></li>
                                            <li><a href="#"><span class="ti-twitter-alt"></span></a></li>
                                            <li><a href="#"><span class="ti-dribbble"></span></a></li>
                                            <li><a href="#"><span class="ti-google"></span></a></li>
                                            <li><a href="#"><span class="ti-pinterest"></span></a></li>
                                            <li><a href="#"><span class="ti-instagram"></span></a></li>
                                        </ul>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="footer-widget mb-30">
                                <div class="footer-heading">
                                    <h1>Quick Links</h1>
                                </div>
                                <div class="footer-menu-2">
                                    <ul>
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">About Us</a></li>
                                        <li><a href="#">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="footer-widget mb-30">
                                <div class="footer-heading">
                                    <h1>Our Services</h1>
                                </div>
                                <div class="footer-menu-2">
                                    <ul>
                                        <li><a href="#">Online Testing</a></li>
                                        <li><a href="#">Virtual Instructional Engagement</a></li>
                                        <li><a href="#">Administration Of Standardized Tests</a></li>
                                        <li><a href="#">Automatic Scoring Of Result</a></li>
                                        <li><a href="#">Educational Consultancy</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-4  col-md-6">
                            <div class="footer-widget mb-30">
                                <div class="footer-heading">
                                    <h1>Contact Us</h1>
                                </div>
                                <div class="footer-contact-list">
                                    <div class="single-footer-contact-info">
                                        <span class="ti-headphone "></span>
                                        <span class="footer-contact-list-text">(+234) 805 044 3437</span>
                                    </div>
                                    <div class="single-footer-contact-info">
                                        <span class="ti-email "></span>
                                        <span class="footer-contact-list-text">taims@gmail.com</span>
                                    </div>
                                    <div class="single-footer-contact-info">
                                        <span class="ti-location-pin"></span>
                                        <span class="footer-contact-list-text">No 1 Prince olaide street Ijebu Ife, Ogun state, Nigeria</span>
                                    </div>
                                </div>
                                <!-- <div class="opening-time">
                                    <span>Opening Hour</span>
                                    <span class="opening-date">
                                        Sun - Sat : 10:00 am - 05:00 pm
                                    </span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom pt-25 pb-25">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="footer-copyright text-center">
                                    <span><a target="_blank" href="#" class="text-white">
                                            Copyright © <span id="myYear">2024</span> All rights reserved |
                                            TAIMS
                                        </a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    </div>



    <script>
        // import axios from 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';

        const app = Vue.createApp({
            data() {
                return {
                    loading: false,
                    userType: null,
                    showToast: false,
                    toastMessage: '',
                }
            },
            methods: {
                submitUserType() {
                    if (!this.userType) {
                        alert('Please select a user type!');
                        return;
                    }
                    localStorage.setItem('userType', this.userType);
                    // this.$toast.success("User Type selected successfully");

                    window.location.href = '/register';
                },
            },
            mounted() {},
        });

        app.mount('#app');
    </script>
    <!-- footer end -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Flutterwave Inline JS -->
    <script src="https://checkout.flutterwave.com/v3.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{asset('assets/web_asset/js/vendor/modernizr-3.5.0.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/one-page-nav-min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/slick.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/jquery.meanmenu.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/ajax-form.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/wow.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/jquery.barfiller.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/waypoints.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/plugins.js')}}"></script>
    <script src="{{asset('assets/web_asset/js/main.js')}}"></script>

</body>

</html>