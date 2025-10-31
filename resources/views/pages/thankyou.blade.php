@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/shops.css') }}" />
    <style>
        .thankyou-wrapper {
            min-height: 60vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            margin: 2rem 0;
            padding: 3rem 1rem 2rem 1rem;
        }

        .thankyou-icon {
            font-size: 5rem;
            color: #DE991B;
            margin-bottom: 1.5rem;
        }

        .thankyou-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #DE991B;
            margin-bottom: 0.5rem;
        }

        .thankyou-subtitle {
            font-size: 1.25rem;
            color: #495057;
            margin-bottom: 1.5rem;
        }

        .thankyou-track {
            margin-top: 2rem;
        }

        .btn-green,
        .btn-green:active,
        .btn-green:focus {
            background: #DE991B;
            color: #fff;
            border: none;
        }

        .btn-green:hover {
            background: #c2841a;
            color: #fff;
        }

        .new-arrivals-section {
            margin-top: 3rem;
        }

        .new-arrivals-title {
            color: #DE991B;
            font-weight: 700;
            font-size: 2rem;
        }
    </style>
@endsection

@section('content')
    <x-app.header />
    <div class="container">
        <div class="thankyou-wrapper text-center">
            <i class="ecicon eci-check-circle thankyou-icon" aria-hidden="true"></i>
            <div class="thankyou-title">Thank You!</div>
            <div class="thankyou-subtitle">Your order was placed successfully.<br>We appreciate your business.</div>
            <div class="thankyou-track">
                <a href="{{ route('user.ordersIndex') }}" class="btn btn-green btn-lg rounded-pill px-4">Track Order</a>
            </div>
        </div>
        <div class="new-arrivals-section">
            <div class="text-center mb-4">
                <div class="new-arrivals-title">New Arrivals</div>
                <div class="text-muted">Browse the collection of top products</div>
            </div>
            <div class="row">
                <!-- New Product Content -->
                <div class="ec-spe-section  data-animation=" slideInLeft">
                    <div class="ec-spe-products">
                        @foreach ($latest_products->chunk(5) as $products)
                            <div class="ec-fs-product">
                                <div class="ec-fs-pro-inner">
                                    <div class="row row-cols-lg-5 cols-2 mt-4">
                                        @foreach ($products as $product)
                                            <x-products.product :product="$product" :variant="'red'" :showMultipleCategories="true" />
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
@endsection
