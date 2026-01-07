<!doctype html>
<html class="no-js" lang="zxx">
<head>
     <!-- for home page -->
     @php
        use App\Models\HomeContent;

         $home = HomeContent::first();

     @endphp 
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset($home->system_logo ?? 'img/favicon.ico') }}">
 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="/css/sweet-alert.css">

    <link rel="stylesheet" href="/css/bootstrap-5.css">

      <!-- TOASTR CSS -->
    <link rel="stylesheet" href="{{asset('/toastr/build/toastr.min.css') }}" >
    <script src="/js/sweet-alert.js"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>


    <style>
        .hero-title {
            font-size: clamp(2.188rem, 1.158rem + 5.147vi, 4.375rem);
        }

        .text-title {
            font-size: clamp(1.688rem, 1.246rem + 2.206vi, 2.625rem);
        }

        .text-sub-title {
            font-size: clamp(1.875rem, 1.728rem + 0.735vi, 2.188rem);
        }

        .scale:hover {
            width: 100%;
            transform: scale(1.05);
            -webkit-transition: 0.4s;
            -moz-transition: 0.4s;
            -o-transition: 0.4s;
            transition: 0.4s;
        }

        .slick-dots {
            display: flex;
            gap: 2px;
            text-decoration: none;
            list-style-type: none;
        }

        .slick-dots > li > button{
            background-color: none;
        }

        .section-padding{
          padding-block: clamp(1.875rem, 0.11rem + 8.824vi, 5.625rem);
        }

        .active-page{
            background-color: #09cc7f;
            color: white;
        }

        .nav-link{
             color: inherit !important;
        }

    #backToTop {
        display: block; 
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        border: none;
        outline: none;
        background: green; 
        color: white;
        cursor: pointer;
        padding: 15px;
        border-radius: 10px;
        transition: background 0.3s ease; 
    }

    #backToTop:hover {
        background: linear-gradient(45deg, red, blue, yellow); 
    }

    </style>
    <!-- CSS here -->
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/slicknav.css">
    <link rel="stylesheet" href="/css/flaticon.css">
    <link rel="stylesheet" href="/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="/css/gijgo.css">

    <link rel="stylesheet" href="/css/animate.min.css">
    {{--        <link rel="stylesheet" href="/css/animated-headline.css">--}}
    <link rel="stylesheet" href="/css/magnific-popup.css">
    <link rel="stylesheet" href="/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="/css/themify-icons.css">
    <link rel="stylesheet" href="/css/slick.css">

{{--    <link rel="stylesheet" href="/css/nice-select.css">--}}
    {{--    <link rel="stylesheet" href="/css/style.css">--}}
    {{--    <link rel="stylesheet" href="/css/base.css">--}}

    @yield('files')
    @yield('styles')

    <style>
        .modal{
            top: 130px !important
        } 
    </style>
</head>
<body>
<!-- ? Preloader Start -->
{{--<div id="preloader-active">--}}
{{--    <div class="preloader d-flex align-items-center justify-content-center">--}}
{{--        <div class="preloader-inner position-relative">--}}
{{--            <div class="preloader-circle"></div>--}}
{{--            <div class="preloader-img pere-text">--}}
{{--                <img src="/img/logo/loder.png" alt="">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="position-sticky top-0 bg-white" style="z-index: 1059">
    <header class="d-none d-md-block py-2">
        <div class="ps-5 d-flex gap-2 align-items-center">
            <a class="small text-secondary text-decoration-none border-end border-secondary border-1 pe-2">Telephone {{$home->telephone ?? ''}}</a>
            <a class="small text-secondary text-decoration-none border-end border-secondary border-1 pe-2">Email:
                {{$home->contact_email ?? ''}}</a>
            <a class="small text-secondary text-decoration-none" href="#">
                <i class='bx bx-xs bxl-twitter'></i>
            </a>
            <a class="small text-secondary text-decoration-none" href="https://www.facebook.com/sai4ull">
                <i class='bx bx-xs bxl-facebook'></i>
            </a>
            <a class="small text-secondary text-decoration-none" href="#">
                <i class='bx bx-xs bxl-linkedin'></i>
            </a>
            <a class="small text-secondary text-decoration-none" href="#">
                <i class='bx bx-xs bxl-google-plus'></i>
            </a>
        </div>
    </header>
    <nav  class="navbar navbar-expand-lg navbar-light bg-white shadow py-0">
        <div class="container-fluid px-2 px-lg-5 " style="min-height: 90px; heigh: max-content">
            <div class="navbar-brand">
                <a href="/" style="text-decoration:none;">
                <p class="fw-bold mb-0 pb-0 text-wrap">Missionaries of Charity Brothers</p>
                {{-- <img src="/img/logo/logo.png" alt="Charity"> --}}
                </a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list text-success" style="font-size: 25px"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-end bg-white" id="navbarNav">
                <ul class="navbar-nav me-3 gap-2">
                    <li class="nav-item {{ Request::is('charity') ? 'active-page' : '' }}">
                        <a style="width: 120px" class="text-center nav-link text-primary" href="/charity">Home</a></li>
                    <!-- <li class="nav-item {{ Request::is('charity/announcements') ? 'active-page' : '' }}">
                        <a class="nav-link text-primary" href="/charity/announcements">Announcement</a>
                    </li>
                    <li class="nav-item {{ Request::is('charity/events') ? 'active-page' : '' }}">
                        <a class="nav-link text-primary" href="/charity/events">Social Events</a></li> -->
                    <li class="nav-item {{ Request::is('charity/contact-us') ? 'active-page' : '' }}">
                        <a style="width: 120px" class="text-center nav-link text-primary" href="/charity/contact-us">Contact</a>
                    </li>
                    <!-- <li class="nav-item {{ Request::is('charity/about-us') ? 'active-page' : '' }}">
                        <a class="nav-link text-primary" href="/charity/about-us">About</a>
                    </li> -->
                </ul>
                <div class="d-none d-lg-block">
                    <a style="width: 120px" href="/charity/appointment" class="btn {{ Request::is('charity/appointment') ? 'active-page' : '' }} text-white">Appointment</a>
                </div>
            </div>
        </div>
    </nav>
</div>

<main>
    @yield('body')
</main>

<footer>
    <div class="footer-wrapper py-5" style="background-color: #040c1c"
         data-background="/img/assets/img/gallery/footer_bg.png">
        <!-- Footer Top-->
        <div class="footer-area footer-padding text-secondary">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-footer-caption mb-50">
                            <div class="single-footer-caption mb-30">
                                <div class="footer-tittle">
                                    <div class="footer-logo mb-20">
                                        <a href="#"><img src="/img/logo/logo2_footer.png" alt=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4 class="text-white mb-5">Contact Info</h4>
                                <ul class="list-inline">
                                    <li>
                                        <p>Address :{{$home->address ?? ''}}.</p>
                                    </li>
                                    <li>Telephone: {{$home->telephone ?? ''}}</li>
                                    <li>Email : {{$home->contact_email ?? ''}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4 class="text-white mb-5">Important Link</h4>
                                <ul class="list-inline">
                                    <a class="nav-link text-primary" href="/charity/about-us">About Us</a>
                                    <a class="nav-link text-primary" href="/charity/events">Events</a>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4 class="text-white mb-5">Newsletter</h4>
                                <div class="footer-pera footer-pera2">
                                    <p>Heaven fruitful doesn't over lesser in days. Appear creeping.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer-bottom -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="footer-border border-top border-secondary pt-5">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-10 col-lg-9 ">
                            <div class="footer-copy-right">
                                <p class="text-secondary">
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    &copy;<script>document.write(new Date().getFullYear());</script>
                                    Missionaries of Charity Brothers</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3">
                            <div class="footer-social f-right text-secondary">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
  <!-- BACK TO TOP NIGG -->
  <button onclick="topFunction()" id="backToTop" title="Go to top">
            <i class="fas fa-arrow-up"></i>
            </button>
<!-- JS here -->

{{--<script src="/js/vendor/modernizr-3.5.0.min.js"></script>--}}
{{--<!-- Jquery, Popper, Bootstrap -->--}}
{{--<script src="/js/vendor/jquery-1.12.4.min.js"></script>--}}
{{--<script src="/js/popper.min.js"></script>--}}
{{--<script src="/js/bootstrap.min.js"></script>--}}
{{--<!-- Jquery Mobile Menu -->--}}
{{--<script src="/js/jquery.slicknav.min.js"></script>--}}

{{--<!-- Jquery Slick , Owl-Carousel Plugins -->--}}
{{--<script src="/js/owl.carousel.min.js"></script>--}}
{{--<script src="/js/slick.min.js"></script>--}}

{{--<!-- One Page, Animated-HeadLin -->--}}
{{--<script src="/js/wow.min.js"></script>--}}
{{--<script src="/js/animated.headline.js"></script>--}}
{{--<script src="/js/jquery.magnific-popup.js"></script>--}}

{{--<!-- Date Picker -->--}}
{{--<script src="/js/gijgo.min.js"></script>--}}
{{--<!-- Nice-select, sticky -->--}}
{{--<script src="/js/jquery.nice-select.min.js"></script>--}}
{{--<script src="/js/jquery.sticky.js"></script>--}}
{{--<!-- Progress -->--}}
{{--<script src="/js/jquery.barfiller.js"></script>--}}

{{--<!-- counter , waypoint,Hover Direction -->--}}
{{--<script src="/js/jquery.counterup.min.js"></script>--}}
{{--<script src="/js/waypoints.min.js"></script>--}}
{{--<script src="/js/jquery.countdown.min.js"></script>--}}
{{--<script src="/js/hover-direction-snake.min.js"></script>--}}

{{--<!-- contact js -->--}}
{{--<script src="/js/contact.js"></script>--}}
{{--<script src="/js/jquery.form.js"></script>--}}
{{--<script src="/js/jquery.validate.min.js"></script>--}}
{{--<script src="/js/mail-script.js"></script>--}}
{{--<script src="/js/jquery.ajaxchimp.min.js"></script>--}}

<!-- Jquery Plugins, main Jquery -->
{{--<script src="/js/plugins.js"></script>--}}
{{--<script src="/js/main.js"></script>--}}

<!-- TOASTER JS -->
<script src="{{ asset('/toastr/build/toastr.min.js') }}"></script>
<script>
    // Check for the flash message and display it
    @if(session('success'))
        toastr.success('{{ session('success') }}', 'Success', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
    @endif

    @if(session('status'))
        toastr.success('{{ session('status') }}', 'Success', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
    @endif

    @if(session('error'))
        toastr.error('{{ session('error') }}', 'Error', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
    @endif

    // Display validation errors
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}', 'Validation Error', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
        @endforeach
    @endif
</script>
<script>
function topFunction() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
    console.log('Back to Top button clicked');
}
</script>
@yield('scripts')

</body>
</html>
