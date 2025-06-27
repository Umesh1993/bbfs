<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.in/larkon/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 09 May 2025 10:13:19 GMT -->

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>@yield('title', 'My Laravel App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template" />
    <meta name="author" content="Techzaa" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{ asset('assets/css/vendor.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Icons css (Require in all Page) -->
    <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- App css (Require in all Page) -->
    <link href="{{ asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{ asset('assets/js/config.js')}}"></script>

    @stack('styles')
</head>

<body>

    <!-- START Wrapper -->
    <div class="wrapper">

        {{-- Header --}}
        @include('admin.layouts.partials.header')

        {{-- Sidebar --}}
        @include('admin.layouts.partials.sidebar')

        <!-- ==================================================== -->
        <!-- Start right Content here -->
        <!-- ==================================================== -->
        <div class="page-content">

            <!-- Start Container Fluid -->
            @yield('content')

            {{-- Footer --}}
            @include('admin.layouts.partials.footer')

        </div>

    </div>

    {{-- Custom JavaScript --}}
    <!-- Vendor Javascript (Require in all Page) -->
    <script src="{{ asset('assets/js/vendor.js')}}"></script>

    <!-- App Javascript (Require in all Page) -->
    <script src="{{ asset('assets/js/app.js')}}"></script>

    <!-- Vector Map Js -->
    <script src="{{ asset('assets/vendor/jsvectormap/js/jsvectormap.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/jsvectormap/maps/world-merc.js')}}"></script>
    <script src="{{ asset('assets/vendor/jsvectormap/maps/world.js')}}"></script>

    <!-- Dashboard Js -->
    <script src="{{ asset('assets/js/pages/dashboard.js')}}"></script>
    @stack('scripts')
</body>

</html>