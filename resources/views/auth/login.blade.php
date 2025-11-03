@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <style>
        :root {
            --primary-green: var(--accent-color);
            --primary-hover: var(--primary-dark);
            --secondary-color: var(--bg-light);
            --text-dark: var(--text-dark);
            --text-medium: var(--text-secondary);
            --text-light: var(--text-secondary);
            --border-color: var(--border-light);
            --shadow-sm: var(--shadow-light);
            --shadow-md: var(--shadow-medium);
            --shadow-lg: var(--shadow-dark);
            --transition: all 0.3s ease;
        }

        .login-wrapper {
            display: flex;
            min-height: 100vh;
            background-color: var(--bg-light);
        }

        .login-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: var(--bg-secondary);
            border-radius: 12px;
            box-shadow: var(--shadow-medium);
            padding: 2.5rem;
        }

        .brand-logo {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 2rem;
            text-align: center;
            display: block;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--accent-color);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            height: 3rem;
            padding: 0.75rem;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            /* box-shadow: 0 0 0 3px var(--shadow-primary); */
            outline: none;
        }

        .forgot-password {
            text-align: right;
            margin: -0.75rem 0 1rem;
        }

        .forgot-password a {
            color: var(--accent-color);
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-password a:hover {
            color: var(--primary-dark);
        }

        .btn-login {
            width: 100%;
            height: 3rem;
            background: var(--accent-color);
            color: var(--text-light);
            border: none;
            border-radius: 3px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-login:hover {
            background: var(--primary-dark);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: var(--text-secondary);
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid var(--border-light);
        }

        .divider-text {
            padding: 0 1rem;
            font-size: 0.875rem;
        }

        .social-login {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 3rem;
            padding: 0 1rem;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            background: var(--bg-secondary);
            color: var(--accent-color);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-social:hover {
            background: var(--bg-light);
        }

        .btn-social i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .signup-link {
            text-align: center;
            font-size: 0.875rem;
        }

        .signup-link a {
            color: var(--accent-color);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }

        .signup-link a:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 72%;
            transform: translateY(-50%);
            color: var(--accent-color);
        }

        @media (min-width: 768px) {
            .login-image {
                display: block;
            }

            .login-card {
                padding: 3rem;
            }
        }

        @media (min-width: 853px) and (max-width: 1280px) {
            .login-wrapper {
                min-height: 61vh;
            }

            .login-image {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <x-app.header />
    <div class="login-wrapper">
        <!-- Image Section (Visible on desktop) -->
        <!-- Login Form Section -->
        <div class="login-content">
            <div class="login-image d-flex justify-content-center align-items-center d-md-block d-none">
                <img src="{{ asset('/assets/img/login-bg.png') }}" alt="">
            </div>
            <div class="login-card">
                <span class="brand-logo">Royalit Ecommerce</span>
                <div class="login-header">
                    <h1>Welcome Back</h1>
                    <p>Please login to your account</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @if (request('redirect'))
                        <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                    @endif
                    <div class="form-group position-relative">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Enter your email">
                        <i class="fas fa-envelope input-icon"></i>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group position-relative">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" placeholder="Enter your password">
                        <i class="fas fa-lock input-icon"></i>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn-login">Login</button>
                    {{-- <div class="divider">
                        <span class="divider-text">Or Login With</span>
                    </div>
                    <div class="social-login">
                        <button type="button" class="btn-social">
                            <i class="fab fa-google"></i> Google
                        </button>
                    </div> --}}
                    <div class="divider">

                    </div>
                    <div class="signup-link">
                        Don't have an account? <a href="{{ route('register') }}">Signup</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Add any necessary JavaScript here
    </script>
@endsection
