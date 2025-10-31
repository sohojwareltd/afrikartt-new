@section('title', 'Shopping Cart | Afrikart E-commerce')
@section('meta_description',
    'Review and manage your shopping cart items on Afrikart E-commerce. Secure checkout, easy
    quantity updates, and instant price calculations.')
@section('meta_keywords', 'shopping cart, cart, checkout, ecommerce, online shopping, Afrikart')
@section('canonical_url', route('cart'))
@section('meta_og')
    <meta property="og:title" content="Shopping Cart | Afrikart E-commerce">
    <meta property="og:description"
        content="Review and manage your shopping cart items on Afrikart E-commerce. Secure checkout, easy quantity updates, and instant price calculations.">
    <meta property="og:image" content="{{ Settings::setting('site_logo') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection
@section('meta_twitter')
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Shopping Cart | Afrikart E-commerce">
    <meta name="twitter:description"
        content="Review and manage your shopping cart items on Afrikart E-commerce. Secure checkout, easy quantity updates, and instant price calculations.">
    <meta name="twitter:image" content="{{ Settings::setting('site_logo') }}">
@endsection

@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/shops.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}"> --}}

    <style>
        /* Import centralized color system */
        @import url('{{ asset('assets/css/colors.css') }}');

        body,
        #body {
            background: var(--bg-light);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .cart-section {
            padding: 40px 0 60px 0;
        }

        .cart-container {
            display: flex;
            gap: 2.5rem;
            flex-direction: column;
            background: none;
            box-shadow: none;
            padding: 0;
        }

        @media (min-width: 992px) {
            .cart-container {
                flex-direction: row;
                align-items: flex-start;
            }

            .cart-items {
                flex: 2;
            }

            .order-summary {
                flex: 1;
            }
        }

        .cart-header {
            background: var(--bg-secondary);
            border-radius: 12px;
            box-shadow: 0 2px 8px var(--shadow-primary);
            padding: 32px 32px 0 32px;
            margin-bottom: 0;
            border: none;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .cart-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            font-size: 0.95rem;
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        .item-count {
            font-size: 1rem;
            color: var(--accent-color);
            background: var(--bg-light);
            padding: 0.2rem 0.8rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
        }

        .cart-table-card {
            background: var(--bg-secondary);
            box-shadow: 0 2px 8px var(--shadow-primary);
            padding: 0 32px 32px 32px;
            margin-bottom: 1.5rem;
        }

        .cart-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: none;
            box-shadow: none;
        }

        .cart-table thead {
            background: none;
        }

        .cart-table th {
            padding: 18px 8px 18px 0;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1rem;
            border-bottom: 1px solid var(--border-light);
            background: none;
        }

        .cart-table td {
            padding: 18px 8px 18px 0;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-light);
            background: none;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .product-image {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--medium-gray);
        }

        .product-details h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.2rem;
        }

        .product-details p {
            color: var(--text-secondary);
            font-size: 0.92rem;
            margin-bottom: 0.2rem;
        }

        .remove-btn {
            color: var(--accent-color);
            border: none;
            font-size: 1.1rem;
            cursor: pointer;
            margin-right: 0.5rem;
            transition: color 0.2s;

            background: var(--bg-light);
            padding: 0.2rem 0.6rem;
            border-radius: 1rem;
        }

        .remove-btn:hover {
            color: var(--accent-color);
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            width: 32px;
            height: 32px;
            border: 1px solid var(--border-light);
            background: var(--bg-secondary);
            color: var(--text-dark);
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 700;
            transition: background 0.2s, color 0.2s;
        }

        .quantity-btn:hover {
            background: var(--accent-color);
            color: var(--text-light);
        }

        .quantity-input {
            width: 48px;
            height: 32px;
            text-align: center;
            border: 1px solid var(--border-light);
            border-radius: 6px;
            background: var(--bg-light);
            font-size: 1rem;
        }

        .price {
            font-weight: 600;
            color: var(--text-dark);
        }

        .cart-table tfoot td {
            border: none;
            padding-top: 18px;
        }

        .cart-actions-row {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-top: 1.5rem;
        }

        .coupon-input {
            flex: 1;
            border: 1px solid var(--border-light);
            font-size: 1rem;
            background: var(--bg-light);
        }

        .order-summary {
            background: var(--bg-secondary);
            box-shadow: 0 2px 8px var(--shadow-primary);
            padding: 32px 32px 24px 32px;
            min-width: 320px;
            max-width: 370px;
            margin: 0 auto;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.1rem;
            font-size: 1rem;
        }


        .summary-value {
            font-weight: 600;
            color: var(--text-dark);
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 1.5rem 0 1.2rem 0;
        }

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

        .pulse-alert {
            padding: 1.25rem 1.5rem;
            margin: 1rem 0;
            border-radius: 12px;
            border: none;
            color: white;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .pulse-alert {
            padding: 1.25rem 1.5rem;
            margin: 1rem 0;
            border-radius: 12px;
            border: none;
            color: white;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        /* Success - Vibrant Green Gradient */
        .success-gradient {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .warning-gradient {
            background: linear-gradient(135deg, #ff9966, #ff5e62);
            animation: pulse-warning 2s infinite;
        }


        .alert-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-badge {
            background: rgba(255, 255, 255, 0.3);
            padding: 0.5rem 0.75rem;
            border-radius: 50%;
            font-weight: bold;
            backdrop-filter: blur(10px);
            min-width: 40px;
            text-align: center;
        }

        .alert-message {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-message i {
            font-size: 1.1em;
        }

        @keyframes pulse-success {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        @keyframes pulse-warning {
            0% {
                box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(234, 179, 8, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(234, 179, 8, 0);
            }
        }

        /* Hover effects for interactivity */
        .pulse-alert {
            transform: translateY(0);
            transition: transform 0.2s ease;
        }

        .pulse-alert:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection
@section('content')
    <main>
        <x-app.header />
        @php
            $items = Cart::Content();

            $groupedItems = $items->groupBy(function ($item) {
                return $item->model->shop_id;
            });

            $shipping = Sohoj::freeShippingInfo();

        @endphp
        <section class="cart-section">
            <div class="container mb-5">
                {{-- <div class="cart-header">
                    <div class="breadcrumb">Home &gt; Shopping Cart</div>
                    <h1 class="cart-title">Shopping Cart</h1>
                    <span class="item-count">{{ Cart::count() }} Items</span>
                </div> --}}

                <div class="checkout-hero mb-4 position-relative">
                    <h2 class="fw-bold mb-1 text-light">Shopping Cart</h2>
                    <p class="mb-0">Complete your order and enjoy fast, secure delivery.</p>
                    <div
                        class="checkout-hero-steps d-none d-md-flex position-absolute end-0 top-0 h-100 align-items-center pe-4">
                        <a href="{{ route('homepage') }}"><span class="badge bg-light text-primary me-2">Home</span></a>
                        <span class="badge bg-light text-primary me-2">Cart</span>
                    </div>
                </div>
                @if ($shipping['eligible'] || $shipping['message'])
                    @if ($shipping['eligible'])
                        <div class="pulse-alert success-gradient">
                            <div class="alert-content">
                                <span class="alert-badge">FREE</span>
                                <span class="alert-message">
                                    <i class="fas fa-shipping-fast"></i>
                                    {{ $shipping['message'] }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="pulse-alert warning-gradient">
                            <div class="alert-content">
                                <span class="alert-badge">!</span>
                                <span class="alert-message">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ $shipping['message'] }}
                                </span>
                            </div>
                        </div>
                    @endif
                @endif


                <div class="cart-container mt-4">
                    <div class="cart-items">
                        <div class="cart-table-card">
                            @if (Cart::count() > 0)
                                <div class="table-responsive">
                                    <table class="cart-table">
                                        <thead>
                                            <tr>
                                                <th>Products</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="product-info">
                                                            <button class="remove-btn" title="Remove"
                                                                onclick="window.location='{{ route('cart.destroy', $item->rowId) }}'"><i
                                                                    class="fas fa-trash"></i></button>
                                                            <img src="{{ Storage::url($item->model->image) }}"
                                                                alt="{{ $item->name }}" class="product-image">
                                                            <div class="product-details">
                                                                <h3>{{ $item->name }}</h3>
                                                                <p>{{ Str::limit(strip_tags($item->model->short_description), 40, '...') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="price">{{ Sohoj::price($item->price) }}</td>
                                                    <td>
                                                        <form action="{{ route('cart.update') }}" method="POST"
                                                            style="display:inline-flex;align-items:center;gap:0.5rem;">
                                                            @csrf
                                                            <input type="hidden" name="rowId"
                                                                value="{{ $item->rowId }}" />
                                                            <button type="submit" name="action" value="decrease"
                                                                class="quantity-btn">-</button>
                                                            <input type="number" name="qty"
                                                                value="{{ $item->qty }}" min="1"
                                                                class="quantity-input p-0" readonly>
                                                            <button type="submit" name="action" value="increase"
                                                                class="quantity-btn">+</button>
                                                        </form>
                                                    </td>
                                                    <td class="price">{{ Sohoj::price($item->price * $item->qty) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cart-actions-row">
                                    <form class="d-flex w-100" method="POST" action="{{ route('coupon') }}">
                                        @csrf
                                        <input class="coupon-input me-2" style="height: 45px;" type="text" required
                                            placeholder="Coupon Code" name="coupon_code" value="">
                                        <button class="btn Whoops"
                                            style="background: var(--accent-color); color: var(--text-light);"
                                            type="submit">Apply Coupon Code</button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <h3 class="text-secondary pt-4">Your cart is empty</h3>
                                    <a href="{{ route('homepage') }}" class="btn Whoops mt-4"
                                        style="background: var(--accent-color); color: var(--text-light);">Continue
                                        Shopping</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="order-summary">




                        <div class="summary-row">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value">${{ Cart::subtotal() }}</span>
                        </div>



                        {{-- <div class="summary-row">
                            <span class="summary-label">Tax</span>
                            <span class="summary-value">
                                @if (Sohoj::price(Sohoj::tax()) == 0)
                                    Free
                                @else
                                    {{ Sohoj::price(Sohoj::tax()) }}
                                @endif
                            </span>
                        </div> --}}

                        <div class="summary-row">
                            <span class="summary-label">Discount</span>
                            <span class="summary-value">
                                @if (session()->has('discount'))
                                {{ Sohoj::price(Sohoj::discount()) }}</ @else 0 @endif
                            </span>
                        </div>
                        {{-- @dd(Cart::total()) --}}
                        <div class="summary-total">
                            <span>Total:</span>
                            <span>{{ Sohoj::price(Sohoj::newTotal()) }}</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn Whoops w-100"
                            style="background: var(--accent-color); color: var(--text-light);">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Ec cart page -->


        <!-- New Product Start -->
        <section class="section ec-new-product">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-left">
                        <div class="section-title">

                            <h2 class="related-product-sec-title"> Explore Similer Shops</h2>
                        </div>
                        <div class="ec-spe-section  data-animation=" slideInLeft">


                            <div class="ec-spe-products">
                                @foreach ($latest_shops->chunk(4) as $shop)
                                    <div class="ec-fs-product">
                                        <div class="ec-fs-pro-inner">

                                            <div class="row">

                                                @foreach ($shop as $shop)
                                                    <x-shops-card.card-2 :shop="$shop" />
                                                @endforeach

                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>



                    </div>
                </div>
                <!-- New Product Content -->

            </div>
        </section>
        <!-- New Product end -->
    @endsection
    @section('js')
        <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

        <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
    @endsection
