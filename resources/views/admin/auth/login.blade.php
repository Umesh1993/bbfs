<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8" />
    <title>Sign In | Larkon - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template" />
    <meta name="author" content="Techzaa" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Vendor css -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />
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

                                <h2 class="fw-bold fs-24">Sign In</h2>
                                <p class="text-muted mt-1 mb-4">Enter your email address and password to access admin panel.</p>

                               @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('admin.login') }}" class="authentication-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                                    </div>

                                    <div class="mb-3">
                                        <a href="#" class="float-end text-muted text-unline-dashed ms-1">Reset password</a>
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                            <label class="form-check-label" for="remember">Remember me</label>
                                        </div>
                                    </div>

                                    <div class="mb-1 text-center d-grid">
                                        <button class="btn btn-soft-primary" type="submit">Sign In</button>
                                    </div>
                                </form>

                               <p class="text-danger text-center mt-4">
                                    Don't have an account?
                                    <a href="{{ route('admin.register.form')}}" class="text-dark fw-bold ms-1">Sign Up</a>
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
