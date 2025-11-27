@section('title', 'Checkout | Royalit E-commerce')
@section('meta_description',
    'Complete your purchase securely on Royalit E-commerce. Fast, safe checkout with multiple
    payment options and order tracking.')
@section('meta_keywords', 'checkout, payment, order, purchase, ecommerce, online shopping, Royalit')
@section('canonical_url', route('checkout'))
@section('meta_og')
    <meta property="og:title" content="Checkout | Royalit E-commerce">
    <meta property="og:description"
        content="Complete your purchase securely on Royalit E-commerce. Fast, safe checkout with multiple payment options and order tracking.">
    <meta property="og:image" content="{{ Settings::setting('site_logo') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection
@section('meta_twitter')
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Checkout | Royalit E-commerce">
    <meta name="twitter:description"
        content="Complete your purchase securely on Royalit E-commerce. Fast, safe checkout with multiple payment options and order tracking.">
    <meta name="twitter:image" content="{{ Settings::setting('site_logo') }}">
@endsection
@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <style>
        /* Import centralized color system */
        @import url('{{ asset('assets/css/colors.css') }}');


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

        .checkout-card {
            background: var(--bg-secondary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-light);
        }

        .checkout-table {
            background: var(--bg-secondary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            padding: 1.5rem 1.5rem 0 1.5rem;
        }

        .checkout-table .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            font-family: 'Inter', Arial, sans-serif;
            background: transparent;
        }

        .checkout-table .table thead th {
            padding: 1.1rem 1.5rem;
            background: var(--bg-light);
            border: none !important;
            font-weight: 700;
            color: var(--accent-color) !important;
            font-size: 1.05rem;
            letter-spacing: 0.5px;
            border-bottom: none !important;
        }

        .checkout-table .table tbody td {
            background: var(--bg-secondary);
            border: none;
            padding: 1.1rem 1.5rem;
            vertical-align: middle;
            font-size: 1rem;
            color: var(--text-dark);
            border-radius: 8px;
            box-shadow: 0 2px 8px var(--shadow-light);
        }

        .checkout-product-image {
            border-radius: 8px;
            margin-right: 18px;
            box-shadow: 0 2px 8px var(--shadow-light);
            background: var(--bg-light);
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .remove-item {
            color: var(--accent-color);
            transition: 0.2s;
            border-radius: 50%;
            background: var(--bg-light);
            border: 1px solid var(--border-light);
            padding: 8px;
        }

        .remove-item:hover {
            color: var(--error-color);
            background: var(--bg-light);
            border-color: var(--error-color);
        }

        .checkout-summary {
            background: var(--bg-secondary);
            /* border-radius: var(--border-radius); */
            box-shadow: 0 2px 8px var(--shadow-primary);
            padding: 1.5rem 1.5rem 1rem 1.5rem;
            border: 1px solid var(--border-light);
        }

        .checkout-summary-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-green);
            margin-bottom: 1.2rem;
            letter-spacing: 0.5px;
        }

        .checkout-summary-list>div {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.7rem;
        }

        .checkout-summary-total {
            border-top: 2px solid var(--border-light);
            padding-top: 1rem;
            margin-top: 1.2rem;
            font-size: 1.2rem;
            color: var(--text-dark);
        }

        .checkout-summary-total span {
            color: var(--text-green) !important;
        }

        .checkout-btn {
            background: var(--accent-color) !important;
            color: var(--text-light) !important;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 2px 8px var(--shadow-primary);
            border: none;
            transition: 0.2s;
        }

        .checkout-btn:hover {
            background: var(--primary-dark) !important;
            color: var(--text-light) !important;
            box-shadow: 0 4px 16px var(--shadow-primary);
        }

        .form-control,
        .form-check-input {
            border-radius: 8px;
            border: 1px solid var(--border-light);
            font-size: 1rem;
            padding: 0.7rem 1rem;
            transition: 0.2s;
        }

        .form-control:focus,
        .form-check-input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px var(--shadow-primary);
        }

        .badge.bg-light.text-black {
            background: var(--bg-light) !important;
            color: var(--accent-color) !important;
            font-weight: 600;
            border-radius: 6px;
            letter-spacing: 0.2px;
        }

        .card {
            box-shadow: 0 2px 8px var(--shadow-light);
        }

        .pay-img {
            width: 38px;
            height: 24px;
            object-fit: contain;
            margin-right: 10px;
        }

        @media (max-width: 991px) {

            .checkout-card,
            .checkout-table,
            .checkout-summary {
                padding: 1rem !important;
            }

            .checkout-hero {
                padding: 1.2rem 1rem;
            }
        }

        @media (max-width: 767px) {

            .checkout-card,
            .checkout-table,
            .checkout-summary {
                padding: 0.5rem !important;
            }

            .checkout-hero {
                padding: 0.7rem 0.5rem;
            }

            .checkout-table .table thead th,
            .checkout-table .table tbody td {
                padding: 0.7rem 0.5rem;
                font-size: 0.95rem;
            }
        }

        .payment-card-option {
            position: relative;
            display: flex;
            align-items: center;
            border: 2px solid var(--border-light);
            border-radius: 12px;
            padding: 1rem;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s, transform 0.15s;
            background: var(--bg-light);
            margin-bottom: 0.5rem;
            gap: 1rem;
            box-shadow: 0 2px 8px var(--shadow-light);
        }

        .payment-card-option input[type="radio"] {
            opacity: 0;
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            margin: 0;
            z-index: 2;
            cursor: pointer;
        }

        .custom-radio-indicator {
            width: 22px;
            height: 22px;
            border: 2px solid var(--border-medium);
            border-radius: 50%;
            background: var(--bg-secondary);
            display: inline-block;
            margin-right: 1rem;
            position: relative;
            transition: border-color 0.2s, box-shadow 0.2s;
            flex-shrink: 0;
        }

        .payment-card-option input[type="radio"]:checked+.custom-radio-indicator {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px var(--shadow-primary);
        }

        .payment-card-option input[type="radio"]:checked+.custom-radio-indicator::after {
            content: '';
            display: block;
            width: 12px;
            height: 12px;
            background: var(--accent-color);
            border-radius: 50%;
            position: absolute;
            top: 3px;
            left: 3px;
        }

        .payment-card-option input[type="radio"]:checked~.payment-card-content {
            /* Highlight the card background and border */
            background: var(--bg-light);
            border-radius: 10px;
            box-shadow: 0 4px 18px var(--shadow-primary);
            /* Optional: scale up a bit */
            transform: scale(1.02);
        }

        .payment-card-option input[type="radio"]:checked~.payment-card-content .payment-title {
            color: var(--accent-color);
        }

        /* Optional: checkmark in the top-right corner of the selected card */
        .payment-card-option input[type="radio"]:checked~.payment-card-content::after {
            content: '✔';
            position: absolute;
            top: 12px;
            right: 18px;
            font-size: 1.3rem;
            color: var(--accent-color);
            background: var(--bg-secondary);
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px var(--shadow-primary);
            z-index: 3;
            pointer-events: none;
        }

        .payment-card-option:hover,
        .payment-card-option input[type="radio"]:focus+.custom-radio-indicator {
            border-color: var(--accent-color);
            box-shadow: 0 4px 16px var(--shadow-primary);
        }

        .payment-card-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            width: 100%;
        }

        .payment-img-wrap {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: var(--bg-secondary);
            border-radius: 8px;
            box-shadow: 0 2px 8px var(--shadow-light);
        }

        .pay-img {
            width: 44px;
            height: 44px;
            object-fit: contain;
            margin: 0;
            display: block;
        }

        .payment-text-wrap {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
        }

        .payment-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .payment-desc {
            font-size: 0.97rem;
            color: #000;
            margin-top: 2px;
            font-weight: 400;
            line-height: 1.3;
        }

        .checkout-card .form-floating>label>i {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .checkout-card .form-floating>input {
            padding-left: 2.5rem;
        }

        .address-card {
            border: 2px solid #e3eafc;
            transition: box-shadow 0.2s, border-color 0.2s;
            cursor: pointer;
        }

        .address-card:hover,
        .address-card:focus-within {
            border-color: var(--primary);
            box-shadow: 0 4px 16px rgba(30, 136, 229, 0.10);
        }

        .address-card .form-check-input:checked~.address-label {
            color: var(--primary);
        }

        .address-card .form-check-input:checked {
            border-color: var(--primary);
            background-color: var(--primary);
        }

        @media (max-width: 767px) {
            .checkout-card {
                padding: 0.7rem !important;
            }

            .address-card {
                padding: 1rem !important;
            }
        }


        #guestCheckoutModal .modal-content {
            border: none;
            border-radius: 14px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        #guestCheckoutModal .modal-header {
            background: #ffffff;
            border-bottom: 1px solid #e9ecef;
            padding: 14px 18px;
        }

        #guestCheckoutModal .modal-title {
            font-weight: 600;
            color: #2c3e50;
        }

        #guestCheckoutModal .modal-body {
            padding: 18px;
        }

        #guestCheckoutModal .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 14px 18px 18px 18px;
        }

        .btn-guest-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .btn-guest-warning:hover {
            background-color: #ffb400;
            border-color: #ffb400;
        }
    </style>
@endsection

@section('content')


    <x-app.header />

    @guest
        <!-- Guest Authentication Modal -->
        <div class="modal" id="guestCheckoutModal" tabindex="-1" aria-labelledby="guestCheckoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="guestCheckoutModalLabel">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 640 640">
                                <path fill="#FFD43B"
                                    d="M256 144C256 108.7 284.7 80 320 80C355.3 80 384 108.7 384 144L384 192L256 192L256 144zM208 192L144 192C117.5 192 96 213.5 96 240L96 448C96 501 139 544 192 544L448 544C501 544 544 501 544 448L544 240C544 213.5 522.5 192 496 192L432 192L432 144C432 82.1 381.9 32 320 32C258.1 32 208 82.1 208 144L208 192zM232 240C245.3 240 256 250.7 256 264C256 277.3 245.3 288 232 288C218.7 288 208 277.3 208 264C208 250.7 218.7 240 232 240zM384 264C384 250.7 394.7 240 408 240C421.3 240 432 250.7 432 264C432 277.3 421.3 288 408 288C394.7 288 384 277.3 384 264z" />
                            </svg>
                            Complete your purchase
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted mb-4">To proceed with checkout, please choose one of the following options:</p>
                    </div>
                    <div class="modal-footer d-flex flex-column align-items-stretch gap-2">
                        <a href="{{ route('login') }}?redirect={{ urlencode(route('checkout')) }}"
                            class="btn btn-burgundy w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" style="margin-right: 8px;"
                                viewBox="0 0 640 640">
                                <path fill="white"
                                    d="M409 337C418.4 327.6 418.4 312.4 409 303.1L265 159C258.1 152.1 247.8 150.1 238.8 153.8C229.8 157.5 224 166.3 224 176L224 256L112 256C85.5 256 64 277.5 64 304L64 336C64 362.5 85.5 384 112 384L224 384L224 464C224 473.7 229.8 482.5 238.8 486.2C247.8 489.9 258.1 487.9 265 481L409 337zM416 480C398.3 480 384 494.3 384 512C384 529.7 398.3 544 416 544L480 544C533 544 576 501 576 448L576 192C576 139 533 96 480 96L416 96C398.3 96 384 110.3 384 128C384 145.7 398.3 160 416 160L480 160C497.7 160 512 174.3 512 192L512 448C512 465.7 497.7 480 480 480L416 480z" />
                            </svg>
                            Sign in and Buy
                        </a>
                        <a href="{{ route('register') }}?redirect={{ urlencode(route('checkout')) }}"
                            class="btn btn-outline-dark w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 448 512">
                                <path fill="currentColor"
                                    d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm89.6 32h-11.8c-22.2 10.3-46.9 16-73.8 16s-51.6-5.7-73.8-16h-11.8C62.1 288 0 350.1 0 426.4V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48v-37.6C448 350.1 385.9 288 313.6 288z" />
                            </svg>
                            <span class="ms-2">Sign up and Buy</span>
                        </a>

                        <button type="button" class="btn btn-guest-warning w-100" id="guest-checkout-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 384 512">
                                <path fill="currentColor"
                                    d="M361 215c3.4-8.6 .7-18.4-6.6-24.2l-70.6-57.6 21.8-89.4c2.2-9.1-.8-18.7-7.7-24.9s-16.7-8.4-25.5-5.1l-88.3 34.5L95.7 14c-8.8-3.4-18.7-1.6-25.5 5.1s-9.9 15.8-7.7 24.9l21.8 89.4L13.6 190.8C6.3 196.6 3.6 206.4 7 215s12.1 14 21.6 14H142l27 80H215l27-80H339.4c9.5 0 17.9-5.4 21.6-14zM192 384c-44.2 0-80 35.8-80 80h48c0-17.7 14.3-32 32-32s32 14.3 32 32h48c0-44.2-35.8-80-80-80z" />
                            </svg>
                            <span class="ms-2">Buy as Guest</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endguest
    <div class="checkout-main-bg py-4">

        <div class="container">
            <div class="checkout-hero mb-4 position-relative">
                <h2 class="fw-bold mb-1 text-light">Checkout</h2>
                <p class="mb-0">Complete your order and enjoy fast, secure delivery.</p>
                <div
                    class="checkout-hero-steps d-none d-md-flex position-absolute end-0 top-0 h-100 align-items-center pe-4">
                    <span class="badge bg-light text-primary me-2">Shipping</span>
                    <span class="badge bg-light text-primary">Payment</span>
                </div>
            </div>
            <!-- Multi-Step Checkout -->
            <div class="row g-4 flex-lg-row-reverse">
                <aside class="col-lg-4 d-none d-lg-block">
                    <div class="checkout-summary sticky-top" style="top: 32px; z-index: 2;">
                        <div class="checkout-summary-title">Order Summary</div>
                        <div class="checkout-summary-content">

                            @foreach ($items as $item)
                                @php
                                    $sku = null;
                                    $skuImage = $item->model->image;
                                    if (isset($item->options['sku_id']) && $item->options['sku_id']) {
                                        $sku = \App\Models\Sku::with('attributeValues.attribute')->find(
                                            $item->options['sku_id'],
                                        );
                                        if ($sku && $sku->image) {
                                            $skuImage = $sku->image;
                                        }
                                    }
                                @endphp
                                <div class="d-flex align-items-center mb-5">
                                    <img src="{{ Storage::url($skuImage) }}" alt="{{ $item->name }}"
                                        style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #eee;margin-right:12px;">
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold" style="font-size:1rem;">{{ $item->name }}</div>
                                        <div class="text-muted small">
                                            @if ($sku)
                                                @foreach ($sku->attributeValues as $attrValue)
                                                    <span class="badge bg-light text-dark me-1"
                                                        style="font-size: 0.7rem;">
                                                        {{ $attrValue->attribute->name ?? 'Unknown' }}:
                                                        {{ $attrValue->getDisplayName() }}
                                                    </span>
                                                @endforeach
                                                @if ($sku->sku)
                                                    <div class="mt-1" style="font-size: 0.7rem;">SKU:
                                                        {{ $sku->sku }}
                                                    </div>
                                                @endif
                                            @elseif ($item->options && isset($item->options['variation']))
                                                <span>Variation: {{ $item->options['variation'] }}</span>
                                            @endif
                                            <span class="ms-2">Qty: {{ $item->qty }}</span>
                                        </div>
                                    </div>
                                    <div class="fw-bold ms-2" style="white-space:nowrap;">
                                        {{ Sohoj::price($item->price * $item->qty) }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="checkout-summary-list">

                            <div class="border border-lg-1 p-1">
                                <span>Items({{ Cart::count() }}):</span>
                                <span>{{ Sohoj::price(Cart::subtotal()) }}</span>
                            </div>


                            <div class="border border-lg-1 p-1">
                                <span>Discount:</span>
                                <span>{{ Sohoj::price(Sohoj::discount()) }}</span>
                            </div>
                            @php
                                $shipping = Sohoj::freeShippingInfo();
                            @endphp

                            @if ($shipping['eligible'])
                                <div class="alert alert-success">{{ $shipping['message'] }}</div>
                            @else
                                <div class="border border-lg-1 p-1">
                                    <span>Shipping:</span>
                                    <span><small
                                            class="text-danger">{{ $shipping['message'] ?? 'This step needs to be completed' }}</small></span>
                                </div>
                            @endif


                        </div>
                        <div class="checkout-summary-total d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Order Total:</span>
                            <span class="fw-bold">{{ Sohoj::price(Sohoj::newTotal()) }}</span>
                        </div>
                    </div>
                </aside>
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-4 p-0 overflow-hidden">
                        <div class="card-body p-0">
                            <form action="{{ route('checkout.storeBillingAndShippingInformation') }}" method="POST"
                                id="multiStepCheckoutForm">
                                @csrf
                                <div class="tab-content p-4" id="checkoutStepsContent">
                                    <!-- Step 2: Shipping -->
                                    <div class="tab-pane fade show active" id="step2" role="tabpanel"
                                        aria-labelledby="step2-tab">
                                        <h4 class="fw-semibold mb-3">Shipping & Contact Info</h4>
                                        <div class="checkout-card mb-4 p-4 shadow-sm border-0 rounded-4"
                                            style="background: var(--bg-light); border: 1px solid var(--border-light);">
                                            <div class="row g-3 align-items-end">
                                                <div class="col-md-6">
                                                    <label for="first_name" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="first_name"
                                                        value="{{ old('first_name', Auth()->user() ? Auth()->user()->name : '') }}"
                                                        name="first_name" placeholder="First Name">
                                                    @error('first_name')
                                                        <span class="text-danger small position-absolute"
                                                            style="top:100%;left:0;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="last_name" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="last_name"
                                                        value="{{ old('last_name', Auth()->user() ? Auth()->user()->l_name : '') }}"
                                                        name="last_name" placeholder="Last Name">
                                                    @error('last_name')
                                                        <span class="text-danger small position-absolute"
                                                            style="top:100%;left:0;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12 mt-2">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        aria-describedby="email"
                                                        value="{{ old('email', Auth()->user() ? Auth()->user()->email : '') }}"
                                                        name="email" placeholder="Email Address">
                                                    @error('email')
                                                        <span class="text-danger small position-absolute"
                                                            style="top:100%;left:0;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="phone"
                                                        value="{{ old('phone', Auth()->user() ? Auth()->user()->phone : '') }}"
                                                        name="phone" placeholder="Phone Number">
                                                    @error('phone')
                                                        <span class="text-danger small position-absolute"
                                                            style="top:100%;left:0;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="delivery_option" class="form-label">Delivery
                                                        Option</label>
                                                    <select
                                                        class="form-control @error('delivery_option') is-invalid @enderror"
                                                        id="delivery_option" name="delivery_option">
                                                        <option disabled selected>Select Delivery Option</option>
                                                        <option value="home_delivery" {{ old('delivery_option') == 'home_delivery' ? 'selected' : '' }}>Home Delivery
                                                        </option>
                                                        <option value="pickup_point" {{ old('delivery_option') == 'pickup_point' ? 'selected' : '' }}>Pickup Point</option>
                                                    </select>
                                                    @error('delivery_option')
                                                        <span class="text-danger small position-absolute"
                                                            style="top:100%;left:0;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12 mt-2 position-relative">
                                                    <label for="address_1" class="form-label">Address</label>
                                                    <input type="text"
                                                        class="form-control @error('address_1') is-invalid @enderror"
                                                        id="address_1" name="address_1" value="{{ old('address_1') }}"
                                                        placeholder="Address Line 1" autocomplete="off">

                                                    @error('address_1')
                                                        <span class="text-danger small position-absolute"
                                                            style="top:100%;left:0;">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror


                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label for="country" class="form-label">Country</label>
                                                    <select class="form-control" id="country" name="country">
                                                        <option value="">Select Country</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="state" class="form-label">State</label>
                                                    <select class="form-control" id="state" name="state" disabled>
                                                        <option value="">Select State</option>
                                                    </select>
                                                    @error('state')
                                                        <span class="text-danger small position-absolute"
                                                            style="top:100%;left:0;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="city" class="form-label">City</label>
                                                    <input type="text" class="form-control" id="city"
                                                        name="city"
                                                        value="{{ old('city', Auth()->user() ? Auth()->user()->city : '') }}"
                                                        placeholder="City">
                                                    @error('city')
                                                        <span class="text-danger small position-absolute"
                                                            style="top:100%;left:0;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label for="post_code" class="form-label">Zip Code</label>
                                                    <input type="text" class="form-control" id="post_code"
                                                        name="post_code"
                                                        value="{{ old('post_code', Auth()->user() ? Auth()->user()->post_code : '') }}"
                                                        placeholder="Post Code">
                                                    @error('post_code')
                                                        <span class="text-danger small position-absolute"
                                                            style="top:100%;left:0;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <button type="submit" class="btn  mt-5" id="continue-to-payment"
                                                style="background: var(--accent-color); color: var(--text-light);"
                                                disabled>Continue to Payment</button>
                                        </div>


                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Product Start -->
    <section class="section ec-new-product">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-left">
                    <div class="section-title">

                        <h2 class="related-product-sec-title"> Explore Similer Products</h2>
                    </div>
                    <div class="ec-spe-section  data-animation=" slideInLeft">


                        <div class="ec-spe-products">
                            @foreach ($related_products->chunk(6) as $products)
                                <div class="ec-fs-product">
                                    <div class="ec-fs-pro-inner">

                                        <div class="row row-cols-lg-6 row-cols-md-2 row-cols-sm-1 cols-1 ms-0 me-0">

                                            @foreach ($products as $product)
                                                <x-products.product :product="$product" />
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
    </div>


@endsection

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe("{{ Settings::setting('stripe_key') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            e.preventDefault();

            cardButton.disabled = true;

            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                toastr.error(error.message || 'Something went wrong. Try again later.');
                cardButton.disabled = false;
                return;
            }

            // success: inject payment_method and submit form
            document.getElementById('paymentmethod').value = setupIntent.payment_method;
            toastr.success('Card added');
            document.getElementById('payment-form').submit();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const addressInput = document.getElementById('address_1');
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const stateCodeInput = document.getElementById('state_code');
            const countryCodeInput = document.getElementById('country_code');
            const cityInput = document.getElementById('city'); // Changed to input
            const stateInput = document.getElementById('state'); // Changed to input
            const countrySelect = document.getElementById('country');
            const continueBtn = document.getElementById('continue-to-payment');

            // Lightweight in-memory cache for API responses and de-duped inflight requests
            const apiCache = new Map();
            const inflight = new Map();

            async function cachedFetchJson(url) {
                if (apiCache.has(url)) return apiCache.get(url);
                if (inflight.has(url)) return inflight.get(url);
                const p = fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network error');
                        return res.json();
                    })
                    .then(data => {
                        apiCache.set(url, data);
                        inflight.delete(url);
                        return data;
                    })
                    .catch(err => {
                        inflight.delete(url);
                        throw err;
                    });
                inflight.set(url, p);
                return p;
            }

            const stateSelect = document.getElementById('state');

            // Disable state select initially
            stateSelect.disabled = true;

            const postalCodeInput = document.getElementById('post_code');

            function isFilled(el) {
                return el && String(el.value).trim().length > 0;
            }

            function isSelectFilled(el) {
                if (!el) return false;
                return el.value && String(el.value).trim() !== '';
            }

            // Coalesce frequent enable/disable calls to a single frame
            let updateScheduled = false;

            function scheduleUpdateContinueState(pending = false) {
                if (!continueBtn) return;
                if (pending) {
                    continueBtn.disabled = true;
                    return;
                }
                if (updateScheduled) return;
                updateScheduled = true;
                requestAnimationFrame(() => {
                    updateScheduled = false;
                    updateContinueState(false);
                });
            }

            function updateContinueState(pending = false) {
                if (!continueBtn) return;
                const requiredOk = isFilled(document.getElementById('first_name')) &&
                    isFilled(document.getElementById('last_name')) &&
                    isFilled(document.getElementById('email')) &&
                    isFilled(document.getElementById('phone')) &&
                    isFilled(document.getElementById('address_1')) &&
                    isSelectFilled(countrySelect) &&
                    isSelectFilled(stateSelect) &&
                    isFilled(cityInput) &&
                    isFilled(document.getElementById('post_code'));

                continueBtn.disabled = pending || !requiredOk;

                // Debug logging to help troubleshoot
                if (window.location.search.includes('debug=1')) {
                    console.log('Continue button state:', {
                        first_name: isFilled(document.getElementById('first_name')),
                        last_name: isFilled(document.getElementById('last_name')),
                        email: isFilled(document.getElementById('email')),
                        phone: isFilled(document.getElementById('phone')),
                        address_1: isFilled(document.getElementById('address_1')),
                        country: isSelectFilled(countrySelect),
                        state: isSelectFilled(stateSelect),
                        city: isFilled(cityInput),
                        post_code: isFilled(document.getElementById('post_code')),
                        requiredOk: requiredOk,
                        disabled: continueBtn.disabled
                    });
                }
            }

            const autocomplete = new google.maps.places.Autocomplete(addressInput, {
                types: ['geocode'],
            });

            function getComponent(components, type, nameType = 'short_name') {
                const comp = components.find(c => c.types.includes(type));
                return comp ? comp[nameType] : '';
            }

            autocomplete.addListener('place_changed', async function() {
                scheduleUpdateContinueState(true);
                const place = autocomplete.getPlace();
                if (!place || !place.address_components) {
                    scheduleUpdateContinueState(false);
                    return;
                }

                const components = place.address_components;

                const streetNumber = getComponent(components, 'street_number', 'short_name');
                const route = getComponent(components, 'route', 'long_name');
                const locality = getComponent(components, 'locality', 'long_name') ||
                    getComponent(components, 'postal_town', 'long_name') ||
                    getComponent(components, 'sublocality_level_1', 'long_name');
                const adminAreaLong = getComponent(components, 'administrative_area_level_1',
                    'long_name');
                const adminAreaShort = getComponent(components, 'administrative_area_level_1',
                    'short_name');
                const postalCode = getComponent(components, 'postal_code', 'short_name');
                const countryShort = getComponent(components, 'country', 'short_name');

                const addressLine = [streetNumber, route].filter(Boolean).join(' ');

                if (addressLine) addressInput.value = addressLine;
                if (postalCodeInput) postalCodeInput.value = postalCode;
                if (stateCodeInput) stateCodeInput.value = adminAreaShort;
                if (countryCodeInput) countryCodeInput.value = countryShort;

                // Set city input directly
                // if (cityInput && locality) {
                //     cityInput.value = locality;
                // }

                // Country and state should be manually selected from dropdowns

                if (place.geometry) {
                    const lat = place.geometry.location.lat();
                    const lng = place.geometry.location.lng();
                    if (latitudeInput) latitudeInput.value = lat;
                    if (longitudeInput) longitudeInput.value = lng;
                }
                // finalize state after async operations
                scheduleUpdateContinueState(false);
            });

            // Prevent form submission when selecting from suggestions
            addressInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });



            async function fetchJson(url) {
                return cachedFetchJson(url);
            }

            function populateSelect(selectEl, data, placeholder) {
                // Clear existing options
                selectEl.innerHTML = '';

                // Add placeholder option
                const placeholderOption = document.createElement('option');
                placeholderOption.value = '';
                placeholderOption.textContent = placeholder;
                selectEl.appendChild(placeholderOption);

                // Add data options
                for (const [id, name] of Object.entries(data)) {
                    const option = document.createElement('option');
                    option.value = id;
                    option.textContent = name;
                    selectEl.appendChild(option);
                }
            }

            // Load countries
            try {
                const countries = await fetchJson('/api/geo/countries');
                populateSelect(countrySelect, countries, 'Select Country');
            } catch (e) {
                console.error('Failed to load countries:', e);
            }

            // Load states when country changes
            countrySelect.addEventListener('change', async function() {
                const countryId = this.value;

                // Clear state select and reset
                stateSelect.innerHTML = '<option value="">Select State</option>';
                stateSelect.value = '';

                if (countryId) {
                    // Disable state select while loading
                    stateSelect.disabled = true;

                    try {
                        const states = await fetchJson(`/api/geo/states/${countryId}`);
                        populateSelect(stateSelect, states, 'Select State');
                        // Enable state select after loading
                        stateSelect.disabled = false;
                    } catch (e) {
                        console.error('Failed to load states:', e);
                        stateSelect.disabled = false;
                    }
                } else {
                    // Keep state disabled if no country selected
                    stateSelect.disabled = true;
                }

                updateContinueState(false);
            }); // Reactively validate inputs and selects
            ['first_name', 'last_name', 'email', 'phone', 'address_1', 'post_code', 'city'].forEach(
                id => {
                    const el = document.getElementById(id);
                    if (el) el.addEventListener('input', () => updateContinueState(false));
                });

            // Add event listener for state select (country already has listener above)
            if (stateSelect) {
                stateSelect.addEventListener('change', () => updateContinueState(false));
            }

            // Initial evaluation
            updateContinueState(false);
        });
    </script>

    <script>
        // Free shipping logic
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.getElementById('country');
            const shippingMessage = document.getElementById('shipping-message');
            const shippingDisplay = document.getElementById('shipping-display');

            // Get the order subtotal from your backend
            const orderSubtotal = {{ Cart::subtotal() }};
            const freeShippingThreshold =
            {{ Settings::setting('free_shipping_amount', 75) }}; // $75 threshold for free shipping

            function updateShippingDisplay() {
                const selectedCountry = countrySelect.value;

                if (selectedCountry) {
                    // Get selected country name from dropdown
                    const selectedOption = countrySelect.options[countrySelect.selectedIndex];
                    const countryName = selectedOption ? selectedOption.textContent : '';

                    // Check if it's United States (by name)
                    if (countryName === 'United States') {
                        if (orderSubtotal >= freeShippingThreshold) {
                            // Eligible for free shipping
                            shippingMessage.innerHTML = '<span class="text-success">Free Shipping</span>';
                            shippingDisplay.classList.remove('border-danger');
                            shippingDisplay.classList.add('border-success');
                        } else {
                            // Not eligible for free shipping
                            const amountNeeded = freeShippingThreshold - orderSubtotal;
                            shippingMessage.innerHTML =
                                `<small class="text-danger">Add $${amountNeeded.toFixed(2)} more for free shipping</small>`;
                            shippingDisplay.classList.remove('border-success');
                            shippingDisplay.classList.add('border-danger');
                        }
                    } else {
                        // For non-US countries
                        shippingMessage.innerHTML =
                            '<small class="text-muted">Shipping calculated at next step</small>';
                        shippingDisplay.classList.remove('border-success', 'border-danger');
                    }
                } else {
                    // No country selected
                    shippingMessage.innerHTML =
                        '<small class="text-muted">Select a country to calculate shipping</small>';
                    shippingDisplay.classList.remove('border-success', 'border-danger');
                }
            }

            // Add event listener for country changes
            countrySelect.addEventListener('change', updateShippingDisplay);

            // Initial update
            updateShippingDisplay();
        });
    </script>

    @guest
        <script>
            // Auto-open guest checkout modal
            document.addEventListener('DOMContentLoaded', function() {
                // Only show modal if not guest checkout
                const urlParams = new URLSearchParams(window.location.search);
                if (!urlParams.has('guest')) {
                    const guestModal = new bootstrap.Modal(document.getElementById('guestCheckoutModal'));
                    guestModal.show();
                }

                // Handle guest checkout button
                const guestBtn = document.getElementById('guest-checkout-btn');
                if (guestBtn) {
                    guestBtn.addEventListener('click', function() {
                        // Close modal
                        const modalEl = document.getElementById('guestCheckoutModal');
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();

                        // Add guest parameter to URL
                        window.location.href = '{{ route('checkout') }}?guest=1';
                    });
                }
            });
        </script>
    @endguest
@endsection
