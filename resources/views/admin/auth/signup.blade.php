<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8" />
    <title>Sign Up | Larkon - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template" />
    <meta name="author" content="Techzaa" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Vendor css -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Theme config -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body class="h-100">
    <div class="d-flex flex-column h-100 p-3">
        <div class="d-flex flex-column flex-grow-1">
            <div class="row h-100">
                <div class="col-xxl-7">
                    <div class="row justify-content-center h-100">
                        <div class="col-lg-6 py-lg-5">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="auth-logo mb-4">
                                    <a href="{{ url('/') }}" class="logo-dark">
                                        <img src="{{ asset('assets/images/logo-dark.png') }}" height="24" alt="logo dark">
                                    </a>
                                    <a href="{{ url('/') }}" class="logo-light">
                                        <img src="{{ asset('assets/images/logo-light.png') }}" height="24" alt="logo light">
                                    </a>
                                </div>

                                <h2 class="fw-bold fs-24">Sign Up</h2>
                                <p class="text-muted mt-1 mb-4">New to our platform? Sign up now! It only takes a minute.</p>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('admin.register') }}" class="authentication-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="checkbox-terms" required>
                                            <label class="form-check-label" for="checkbox-terms">I accept Terms and Conditions</label>
                                        </div>
                                    </div>

                                    <div class="mb-1 text-center d-grid">
                                        <button class="btn btn-soft-primary" type="submit">Sign Up</button>
                                    </div>
                                </form>

                                <p class="mt-4 text-danger text-center">Already have an account?
                                    <a href="{{ route('admin.login') }}" class="text-dark fw-bold ms-1">Sign In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-5 d-none d-xxl-flex">
                    <div class="card h-100 mb-0 overflow-hidden">
                        <div class="d-flex flex-column h-100">
                            <img src="{{ asset('assets/images/small/img-10.jpg') }}" alt="" class="w-100 h-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/vendor.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
