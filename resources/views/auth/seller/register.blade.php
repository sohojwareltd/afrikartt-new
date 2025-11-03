@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/slick.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">
    <style>
        .register-header {
            background: var(--accent-color) !important;
        }

        .register-header h2,
        .register-header p {
            color: #fff !important;
        }

        .input-group-text,
        .rounded-circle,
        .form-check-input:checked {
            background-color: var(--accent-color) !important;
            color: #ffffff !important;
            border-color: #b6e2ce !important;
        }

        .form-label,
        .form-check-label,
        .card-title {
            color: var(--accent-color) !important;
        }

        .btn-green,
        .btn-green:active,
        .btn-green:focus {
            background: var(--accent-color) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 3px;
        }

        .btn-green:hover {
            background: var(--accent-color) !important;
            color: #fff !important;
            filter: brightness(0.9);
        }

        .alert {
            border-left: 4px solid var(--accent-color) !important;
        }

        .register-benefit-icon {
            background-color: #e6f4ec !important;
            color: var(--accent-color) !important;
        }

        .form-control:focus {
            border-color: var(--accent-color) !important;
            box-shadow: none !important;
            outline: none !important;
        }

        a {
            color: var(--accent-color);
        }

        a:hover {
            color: var(--accent-color);
            filter: brightness(0.9);
        }
    </style>
@endsection
@section('content')
    <x-app.header />
    <section class="ec-page-content section-space-p" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                        <!-- Green Header -->
                        <div class="py-4 text-center register-header">
                            <h2 class="mb-1">Start Selling on <strong>Royalit Ecommerce</strong></h2>
                            <p class="mb-0">Join our marketplace and grow your business</p>
                        </div>
                        <div class="card-body p-5">
                            <!-- Promo Banner -->
                            <div class="alert mb-4" style="background-color: #f0f0f0;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-gift fs-4 me-3" style="color: var(--primary-green);"></i>
                                    <div>
                                        <strong style="color: var(--primary-green);">Try Royalit Ecommerce Pro for
                                            Free!</strong>
                                        <div class="small text-muted">Start selling with zero setup fees</div>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('vendor.register.store') }}">
                                @csrf
                                <!-- Name Section -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">First Name <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input id="name" type="text" placeholder="First name"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="l_name" class="form-label">Last Name <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input id="l_name" type="text" placeholder="Last Name"
                                                class="form-control @error('l_name') is-invalid @enderror" name="l_name"
                                                value="{{ old('l_name') }}" required autocomplete="name">
                                        </div>
                                        @error('l_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Email Section -->
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email Address <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input id="email" type="email" placeholder="your@email.com"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Password Section -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input id="password" type="password" placeholder="Create password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="new-password">
                                            <button class="btn toggle-password h-auto"
                                                style="background: var(--accent-color);" type="button"><i
                                                    class="fas fa-eye text-light"></i></button>
                                        </div>
                                        <div class="form-text text-muted">Minimum 8 characters</div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password-confirm" class="form-label">Confirm Password <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input id="password-confirm" type="password" placeholder="Confirm password"
                                                class="form-control" name="password_confirmation" required
                                                autocomplete="new-password">
                                            <button class="btn toggle-password h-auto"
                                                style="background: var(--accent-color);" type="button"><i
                                                    class="fas fa-eye text-light"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Terms Checkbox -->
                                <div class="form-check mb-4">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                                        id="terms" name="terms" required>
                                    <label class="form-check-label ms-2" for="terms">
                                        I agree to the <a href="{{ url('page/policies') }}" target="_blank">Terms &
                                            Conditions</a> and
                                        <a href="#">Privacy Policy</a>
                                    </label>
                                    @error('terms')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Attractive Register Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-green btn-lg rounded-3 fw-bold">
                                        <i class="fas fa-store me-2"></i> Register as Vendor
                                    </button>
                                </div>
                                <input type="hidden" value="3" name="role_id">
                                <!-- Login Link -->
                                <div class="text-center pt-3">
                                    <p class="mb-0">Already have an account?
                                        <a href="{{ route('login') }}"
                                            style="font-weight: bold; text-decoration: underline;">Sign In</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Benefits Section -->
                    <div class="row mt-4 g-3">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <div class="rounded-circle p-3 d-inline-block mb-3 register-benefit-icon">
                                        <i class="fas fa-rocket fs-3"></i>
                                    </div>
                                    <h5 class="card-title">Easy Setup</h5>
                                    <p class="card-text small text-muted">Get your store running in minutes with our simple
                                        onboarding</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <div class="rounded-circle p-3 d-inline-block mb-3 register-benefit-icon">
                                        <i class="fas fa-chart-line fs-3"></i>
                                    </div>
                                    <h5 class="card-title">Grow Faster</h5>
                                    <p class="card-text small text-muted">Access millions of customers and powerful
                                        marketing tools</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <div class="rounded-circle p-3 d-inline-block mb-3 register-benefit-icon">
                                        <i class="fas fa-headset fs-3"></i>
                                    </div>
                                    <h5 class="card-title">24/7 Support</h5>
                                    <p class="card-text small text-muted">Dedicated support team ready to help you succeed
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(button) {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('input');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
@endsection
