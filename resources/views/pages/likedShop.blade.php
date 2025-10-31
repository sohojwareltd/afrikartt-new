@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/shops.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        .checkout-hero {
            background: var(--accent-color);
            color: var(--text-light);
            /* border-radius: var(--border-radius); */
            box-shadow: var(--shadow-medium);
            padding: 2rem 2.5rem 1.5rem 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .checkout-hero::after {
            content: '';
            position: absolute;
            right: -60px;
            top: -40px;
            width: 180px;
            height: 180px;
            background: var(--bg-light);
            opacity: 0.12;
            border-radius: 50%;
            z-index: 0;
        }

        .checkout-hero h2,
        .checkout-hero p,
        .checkout-hero-steps {
            position: relative;
            z-index: 1;
        }
    </style>
@endsection
@section('content')
    <x-app.header />

    @auth
        @if (auth()->user()->followedShops->count() > 0)
            <div class="container">
                <div class="row">
                    <div class="checkout-hero mb-4 mt-5 position-relative">
                        <h2 class="fw-bold mb-1 text-light">Followed Shops</h2>
                        <p class="mb-0 text-light">Browse your favorite shops and complete your orders with fast and secure
                            delivery.</p>
                        <div
                            class="checkout-hero-steps d-none d-md-flex position-absolute end-0 top-0 h-100 align-items-center pe-4">
                            <span class="badge bg-light text-primary me-2">Home</span>
                            <span class="badge bg-light text-primary">Followed Shops</span>
                        </div>
                    </div>
                    <div class="row">
                        @foreach (auth()->user()->followedShops as $shop)
                            <div class="col-lg-3 col-12 mb-4 pro-gl-content-shop">
                                <x-shops-card.card-1 :shop="$shop" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <h3 class="m-4 poppins text-center "> No Shop in liked</h3>
        @endif
    @else
        <div class="container">
            <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
                <div class="col-md-7 col-lg-6">
                    <div class="card shadow border-0 rounded-4 p-5 text-center bg-light position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 opacity-10" style="z-index:0; pointer-events:none;">
                            <svg width="120" height="120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="60" cy="60" r="60" fill="var(--accent-color)" opacity="0.08" />
                                <circle cx="60" cy="60" r="40" fill="var(--accent-color)" opacity="0.06" />
                            </svg>
                        </div>
                        <div class="mb-4">
                            <svg width="64" height="64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="32" cy="32" r="32" fill="var(--accent-color)" opacity="0.12" />
                                <path d="M32 40c-6.5 0-13-3.5-13-8.5V27a7 7 0 0 1 7-7h12a7 7 0 0 1 7 7v4.5c0 5-6.5 8.5-13 8.5Z"
                                    fill="var(--accent-color)" opacity="0.7" />
                                <circle cx="32" cy="22" r="6" fill="var(--accent-color)" opacity="0.7" />
                            </svg>
                        </div>
                        <h2 class="fw-bold mb-2 poppins" style="color:var(--accent-color);">Login Required</h2>
                        <p class="mb-4 text-secondary">
                            Please sign in to view your liked shops and enjoy a personalized shopping experience.
                        </p>
                        <a href="{{ route('login') }}" class="btn fw-semibold shadow-sm px-5"
                            style="background:var(--accent-color); color:#fff;">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <!-- End User history section -->
@endsection
@section('js')
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
@endsection
