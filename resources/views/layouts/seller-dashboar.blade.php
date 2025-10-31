@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/slick.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/seller.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/multiple-select.css') }}">
    <style>
        .note-editable ul,
        .note-editable ol,
        .note-editable li {
            list-style: initial !important;
            margin: 10px !important;
        }
    </style>
@endsection

@section('content')
    <x-app.seller_header />
    <!-- Vendor dashboard section -->
    <section class="ec-page-content ec-vendor-dashboard section-space-p">
        <div class="container">
            <div class="row">
                <!-- Sidebar Area Start -->
                <x-app.seller_sidebar />
                @yield('dashboard-content')
            </div>
        </div>
    </section>
    <!-- End Vendor dashboard section -->
@endsection
@section('js')
    <script src="{{ asset('assets/frontend-assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/multiple-select.js') }}"></script>

    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
@endsection
