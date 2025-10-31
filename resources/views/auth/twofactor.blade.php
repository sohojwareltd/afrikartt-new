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
            box-shadow: 0 0 0 3px var(--shadow-primary);
            outline: none;
        }

        .btn-login {
            width: 100%;
            height: 3rem;
            background: var(--accent-color);
            color: var(--text-light);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-login:hover {
            background: var(--primary-dark);
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

        /* New styles for the links row */
        .links-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }

        .links-container a {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .links-container a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
    <x-app.header />
    <div class="login-wrapper">
        <div class="login-content">
            <div class="login-image d-flex justify-content-center align-items-center d-md-block d-none">
                <img src="{{ asset('/assets/img/login-bg.png') }}" alt="">
            </div>
            <div class="login-card">
                <span class="brand-logo">Afrikart Ecommerce</span>
                <div class="login-header">
                    <h1>Verify your login</h1>
                    <p>Enter the 6-digit code we sent to your email</p>
                    <p class="text-danger" style="margin-top: .25rem; color: var(--text-secondary); font-size: .9rem;">
                        It may take up to a minute to receive the code. The code is valid for 10 minutes.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('twofactor.verify') }}">
                    @csrf
                    <div class="form-group">
                        <label for="code" class="form-label">Verification Code</label>
                        <input id="code" type="text" class="form-control" name="code" required autofocus
                            autocomplete="one-time-code" maxlength="6" placeholder="123456">
                    </div>
                    <button type="submit" class="btn-login">Verify</button>
                </form>

                <!-- Updated links container with both links in one row -->
                <div class="links-container">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                    <a href="{{ route('twofactor.resend') }}">Resend code</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
