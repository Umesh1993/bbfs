<!DOCTYPE html>
<html lang="zxx">


<!-- Mirrored from themewagon.github.io/ashion/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 May 2025 08:43:45 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ashion | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&amp;display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/website/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/website/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/website/css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/website/css/magnific-popup.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/website/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/website/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/website/css/style.css')}}" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    {{-- Header --}}
    @include('website.layouts.partials.header')

    <!-- ==================================================== -->
    <!-- Start right Content here -->
    <!-- ==================================================== -->
        <!-- Start Container Fluid -->
    @yield('content')

    {{-- Footer --}}
    @include('website.layouts.partials.footer')

    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <!-- Js Plugins -->
    <script src="{{ asset('assets/website/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('assets/website/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/website/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('assets/website/js/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/website/js/mixitup.min.js')}}"></script>
    <script src="{{ asset('assets/website/js/jquery.countdown.min.js')}}"></script>
    <script src="{{ asset('assets/website/js/jquery.slicknav.js')}}"></script>
    <script src="{{ asset('assets/website/js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/website/js/jquery.nicescroll.min.js')}}"></script>
    <script src="{{ asset('assets/website/js/main.js')}}"></script>
     @stack('scripts')
    </body>


<!-- Mirrored from themewagon.github.io/ashion/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 May 2025 08:44:46 GMT -->
</html>