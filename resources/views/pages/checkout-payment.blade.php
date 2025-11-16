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
            color: var(--text-green);
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
            color: var(--text-green);
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
            color: var(--text-green);
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

        /* Enhanced Shipping Options Styles */
        .shipping-rates-container {
            background: var(--bg-light);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid var(--border-light);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .shipping-header {
            border-bottom: 1px solid var(--border-light);
            padding-bottom: 1rem;
        }

        .shipping-header h5 {
            color: var(--text-dark);
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .shipping-options-grid {
            display: grid;
            gap: 1rem;
        }

        .shipping-option-card {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
            border: 2px solid var(--border-light);
        }

        .shipping-option-card:hover {
            border-color: var(--accent-color);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .shipping-option-label {
            display: block;
            cursor: pointer;
            padding: 0;
            margin: 0;
        }

        .shipping-radio-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .shipping-option-content {
            display: flex;
            align-items: center;
            padding: 1.25rem;
            gap: 1rem;
            position: relative;
        }

        .shipping-logo-section {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 60px;
            background: #f8f9fa;
            border-radius: 10px;
            flex-shrink: 0;
        }

        .shipping-logo {
            width: 50px;
            height: 35px;
            object-fit: contain;
            border-radius: 4px;
        }

        .shipping-radio-indicator {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 24px;
            height: 24px;
            border: 3px solid white;
            border-radius: 50%;
            background: var(--border-medium);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .shipping-radio-indicator::after {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
            transition: all 0.3s ease;
            opacity: 0;
            transform: scale(0);
        }

        .shipping-info-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .shipping-company-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .shipping-company-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-green);
            margin: 0;
        }

        .shipping-network {
            font-size: 0.85rem;
            font-style: italic;
        }

        .shipping-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
        }

        .delivery-time {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .delivery-text {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .shipping-cost {
            display: flex;
            align-items: center;
        }

        .cost-amount {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-green);
            background: rgba(var(--accent-color-rgb), 0.1);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid rgba(var(--accent-color-rgb), 0.2);
        }

        .shipping-selection-indicator {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--accent-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0);
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        /* Selected state */
        .shipping-option-card:has(.shipping-radio-input:checked) {
            border-color: var(--accent-color);
            background: linear-gradient(135deg, rgba(var(--accent-color-rgb), 0.05) 0%, rgba(var(--accent-color-rgb), 0.02) 100%);
            box-shadow: 0 8px 25px rgba(var(--accent-color-rgb), 0.15);
        }

        .shipping-option-card:has(.shipping-radio-input:checked) .shipping-radio-indicator {
            background: var(--accent-color);
            border-color: var(--accent-color);
        }

        .shipping-option-card:has(.shipping-radio-input:checked) .shipping-radio-indicator::after {
            opacity: 1;
            transform: scale(1);
        }

        .shipping-option-card:has(.shipping-radio-input:checked) .shipping-selection-indicator {
            opacity: 1;
            transform: scale(1);
        }

        .shipping-option-card:has(.shipping-radio-input:checked) .shipping-company-name {
            color: var(--text-green);
        }

        /* Error state */
        .shipping-error-state {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 12px;
            padding: 2rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .shipping-rates-container {
                padding: 1rem;
            }

            .shipping-option-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .shipping-logo-section {
                width: 100%;
                height: 80px;
            }

            .shipping-logo {
                width: 60px;
                height: 45px;
            }

            .shipping-details {
                flex-direction: column;
                gap: 0.75rem;
            }

            .cost-amount {
                font-size: 1.1rem;
                padding: 0.4rem 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .shipping-option-card {
                margin: 0 -0.5rem;
                border-radius: 8px;
            }

            .shipping-option-content {
                padding: 1rem;
            }
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .payment-card-option {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--bg-light);
            border: 1px solid var(--border-light);
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 1px 3px var(--shadow-light);
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .payment-card-option:hover {
            border-color: var(--border-primary);
            box-shadow: 0 3px 8px var(--shadow-primary);
        }

        .payment-card-option input[type="radio"] {
            display: none;
        }

        .payment-card-option input[type="radio"]:checked+.custom-radio-indicator+.payment-card-content {
            border-color: var(--btn-primary);
            background: var(--gradient-light);
            box-shadow: 0 3px 8px var(--shadow-primary);
        }

        .payment-card-content {
            display: flex;
            align-items: center;
            width: 100%;
            gap: 1rem;
        }

        .payment-img-wrap {
            flex-shrink: 0;
        }

        .pay-img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .payment-text-wrap {
            display: flex;
            flex-direction: column;
            line-height: 1.4;
        }

        .payment-title {
            font-weight: 600;
            color: var(--text-dark);
        }

        .payment-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Terms */
        .terms-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            background: var(--bg-light);
            border: 1px solid var(--border-light);
            border-radius: 8px;
            padding: 0.8rem 1rem;
        }

        .terms-wrapper input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: var(--accent-color);
            margin-top: 3px;
            border: 1px solid var(--accent-color);
        }

        .terms-wrapper label {
            font-size: 0.95rem;
            color: var(--text-dark);
        }

        .link-accent {
            color: var(--link-color);
            transition: color 0.2s ease;
        }

        .link-accent:hover {
            color: var(--link-hover);
        }

        /* Checkout Button */
        .checkout-btn {
            background: var(--accent-color);
            color: var(--text-light);
            font-size: 1.05rem;
            border-radius: 3px;
            /* padding: 10px 24px; */
            border: none;
            transition: all 0.25s ease;
        }

        .checkout-btn:hover {
            background: var(--accent-color);
        }

        /* ✅ Responsive adjustments */
        @media (max-width: 768px) {
            .payment-card-content {
                flex-direction: row;
            }

            .pay-img {
                width: 42px;
                height: 42px;
            }

            .payment-desc {
                font-size: 0.85rem;
            }

            .checkout-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .payment-methods {
                grid-template-columns: 1fr;
            }

            .payment-card-option {
                padding: 0.8rem;
            }

            .payment-title {
                font-size: 0.95rem;
            }

            .payment-desc {
                font-size: 0.8rem;
            }

            .terms-wrapper {
                flex-direction: column;
                align-items: flex-start;
            }

            .terms-wrapper label {
                font-size: 0.9rem;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $prices = Cart::subtotalFloat();
        $shipping = Sohoj::shipping();
        $flatCharge = Sohoj::flatCommision($prices);
        $discount = Sohoj::discount();
        $tax = Sohoj::tax();

        $total = $prices + $shipping + $flatCharge - $discount + $tax;
    @endphp
    <x-app.header />
    <div class="checkout-main-bg py-4">
        @php
            $items = Cart::Content();
            $groupedItems = $items->groupBy(function ($item) {
                return $item->model->shop_id;
            });
        @endphp
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
                            @php
                                $items = $order->products;
                            @endphp
                            @foreach ($items as $item)
                                @php
                                    $sku = null;
                                    $skuImage = $item->image;
                                    $variationData = null;
                                    if ($item->pivot->variation) {
                                        $variationData = json_decode($item->pivot->variation, true);
                                        if (isset($variationData['sku_id'])) {
                                            $sku = \App\Models\Sku::with('attributeValues.attribute')->find(
                                                $variationData['sku_id'],
                                            );
                                            if ($sku && $sku->image) {
                                                $skuImage = $sku->image;
                                            }
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
                                                    <span class="badge bg-light text-dark me-1" style="font-size: 0.7rem;">
                                                        {{ $attrValue->attribute->name ?? 'Unknown' }}:
                                                        {{ $attrValue->getDisplayName() }}
                                                    </span>
                                                @endforeach
                                                @if ($sku->sku)
                                                    <div class="mt-1" style="font-size: 0.7rem;">SKU: {{ $sku->sku }}
                                                    </div>
                                                @endif
                                            @elseif ($variationData && isset($variationData['sku_code']))
                                                <span>Variation: {{ $variationData['sku_code'] }}</span>
                                            @endif
                                            <span class="ms-2">Qty: {{ $item->pivot->quantity }}</span>
                                        </div>
                                    </div>
                                    <div class="fw-bold ms-2" style="white-space:nowrap;">
                                        {{ Sohoj::price($item->pivot->total_price) }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="checkout-summary-list">

                            <div class="border border-lg-1 p-1">
                                <span>Items({{ $items->sum('pivot.quantity') }}):</span>
                                <span id="summaryItems">{{ Sohoj::price($items->sum('pivot.total_price')) }}</span>
                            </div>


                            <div class="border border-lg-1 p-1">
                                <span>Discount:</span>
                                <span id="summaryDiscount">{{ Sohoj::price($order->discount) }}</span>
                            </div>
                            <div class="border border-lg-1 p-1">
                                <span>Shipping:</span>
                                <span id="summaryShipping"><small class="text-danger">This step need to be
                                        completed</small></span>
                            </div>
                        </div>
                        <div class="checkout-summary-total d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Order Total:</span>
                            <span class="fw-bold" id="summaryTotal">{{ Sohoj::price($order->total) }}</span>
                        </div>
                    </div>
                </aside>
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-4 p-0 overflow-hidden">
                        <div class="card-body p-0">
                            <form action="{{ route('checkout.confirmOrder', $order->id) }}" method="POST"
                                id="multiStepCheckoutForm">


                                @csrf
                                <div class="tab-content p-4" id="checkoutStepsContent">
                                    <!-- Step 2: Shipping -->
                                    <div class="tab-pane fade show active" id="step2" role="tabpanel"
                                        aria-labelledby="step2-tab">
                                        <h4 class="fw-semibold mb-3" style="color: #5D6532 !important">Select Shipping Rate
                                        </h4>

                                        <div class="mt-3">
                                            @if (!empty($rates))
                                                <div class="shipping-rates-container">
                                                    <div class="shipping-header mb-3">
                                                        <h5 class="mb-1" style="color: #5D6532">
                                                            <i class="fas fa-truck me-2 text-primary"></i>
                                                            Available Shipping Options
                                                        </h5>
                                                        <p class="text-muted small mb-0">Choose your preferred delivery
                                                            method</p>
                                                    </div>

                                                    <input type="hidden" name="selected_shipping_service"
                                                        id="selected_shipping_service">
                                                    <input type="hidden" name="selected_shipping_amount"
                                                        id="selected_shipping_amount">

                                                    <div class="shipping-options-grid">
                                                        @foreach ($rates['rates'] as $rate)
                                                            <div class="shipping-option-card"
                                                                data-rate="{{ $rate['courier_service']['id'] }}">
                                                                <label class="shipping-option-label">
                                                                    <input type="radio" name="shipping_rate"
                                                                        class="shipping-radio-input"
                                                                        value="{{ $rate['courier_service']['id'] }}"
                                                                        @checked($loop->first) required>
                                                                    <div class="shipping-option-content">
                                                                        <div class="shipping-logo-section">
                                                                            <img src="{{ $rate['courier_service']['logo'] }}"
                                                                                alt="{{ $rate['courier_service']['name'] }}"
                                                                                class="shipping-logo">
                                                                            <div class="shipping-radio-indicator"></div>
                                                                        </div>

                                                                        <div class="shipping-info-section">
                                                                            <div class="shipping-company-info">
                                                                                <h6 class="shipping-company-name mb-1">
                                                                                    {{ $rate['courier_service']['name'] }}
                                                                                </h6>
                                                                                @if (
                                                                                    $rate['courier_service']['umbrella_name'] &&
                                                                                        $rate['courier_service']['umbrella_name'] !== $rate['courier_service']['name']
                                                                                )
                                                                                    <span
                                                                                        class="shipping-network text-muted small">
                                                                                        via
                                                                                        {{ $rate['courier_service']['umbrella_name'] }}
                                                                                    </span>
                                                                                @endif
                                                                            </div>

                                                                            <div class="shipping-details">
                                                                                <div class="delivery-time">
                                                                                    <i
                                                                                        class="fas fa-clock text-warning me-1"></i>
                                                                                    @if ($rate['max_delivery_time'])
                                                                                        <span class="delivery-text">
                                                                                            {{ $rate['max_delivery_time'] }}
                                                                                            business
                                                                                            day{{ $rate['max_delivery_time'] > 1 ? 's' : '' }}
                                                                                        </span>
                                                                                    @else
                                                                                        <span
                                                                                            class="delivery-text text-muted">
                                                                                            Delivery time not specified
                                                                                        </span>
                                                                                    @endif
                                                                                </div>

                                                                                <div class="shipping-cost">
                                                                                    <span class="cost-amount">
                                                                                        {{ $rate['rates_in_origin_currency']['currency'] }}
                                                                                        {{ number_format((float) $rate['rates_in_origin_currency']['total_charge'], 2) }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="shipping-selection-indicator">
                                                                            <i class="fas fa-check-circle"></i>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="shipping-error-state">
                                                    <div class="text-center py-4">
                                                        <i class="fas fa-exclamation-triangle text-warning mb-3"
                                                            style="font-size: 2.5rem;"></i>
                                                        <h5 class="text-warning mb-2">No Shipping Options Available</h5>
                                                        <p class="text-muted mb-3">We couldn't find shipping options for
                                                            your address. Please verify your shipping information.</p>
                                                        <button type="button" class="btn btn-outline-primary"
                                                            onclick="history.back()">
                                                            <i class="fas fa-arrow-left me-2"></i>Go Back & Update Address
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <h4 class="fw-semibold mb-4 mt-4" style="color: #5D6532">Select Payment Method
                                        </h4>

                                        <div class="payment-methods">
                                            <label class="payment-card-option">
                                                <input type="radio" name="payment_method" id="paypal"
                                                    value="paypal" class="form-check-input" required>
                                                <span class="custom-radio-indicator"></span>
                                                <span class="payment-card-content">
                                                    <span class="payment-img-wrap">
                                                        <img src="https://img.icons8.com/color/64/000000/paypal.png"
                                                            alt="PayPal" class="pay-img" />
                                                    </span>
                                                    <span class="payment-text-wrap">
                                                        <span class="payment-title">PayPal</span>
                                                        <span class="payment-desc">Pay securely using your PayPal
                                                            account.</span>
                                                    </span>
                                                </span>
                                            </label>

                                            <label class="payment-card-option">
                                                <input type="radio" name="payment_method" id="stripe"
                                                    value="stripe" class="form-check-input" required>
                                                <span class="custom-radio-indicator"></span>
                                                <span class="payment-card-content">
                                                    <span class="payment-img-wrap">
                                                        <img src="https://img.icons8.com/color/64/000000/bank-card-back-side.png"
                                                            alt="Stripe" class="pay-img" />
                                                    </span>
                                                    <span class="payment-text-wrap">
                                                        <span class="payment-title">Card Payment</span>
                                                        <span class="payment-desc">Pay with any major credit or debit
                                                            card.</span>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>

                                        <div class="terms-wrapper mt-4 mb-3 shadow-sm">
                                            <input type="checkbox" required id="terms" value="1" name="terms"
                                                class="form-check-input me-2 @error('terms') is-invalid @enderror">
                                            <label class="form-check-label" for="terms">
                                                I have read and agree to the
                                                <a href="{{ url('page/policies') }}" target="_blank"
                                                    class="text-decoration-underline fw-semibold link-accent">
                                                    Terms & Conditions
                                                </a>
                                                of Royalit E-commerce
                                            </label>
                                            @error('terms')
                                                <span class="invalid-feedback d-block ms-2">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn checkout-btn shadow-sm">
                                            <i class="fas fa-credit-card me-2"></i> Continue to Payment
                                        </button>


                                    </div>
                                </div>

                                <style>
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
                                </style>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


    </div>







@endsection
@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>

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
        document.addEventListener('DOMContentLoaded', function() {
            const addressInput = document.getElementById('address_1');
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const stateCodeInput = document.getElementById('state_code');
            const countryCodeInput = document.getElementById('country_code');
            const cityInput = document.getElementById('city');
            const stateInput = document.getElementById('state');
            const postalCodeInput = document.getElementById('post_code');

            const autocomplete = new google.maps.places.Autocomplete(addressInput, {
                types: ['geocode'],
            });

            function getComponent(components, type, nameType = 'short_name') {
                const comp = components.find(c => c.types.includes(type));
                return comp ? comp[nameType] : '';
            }

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (!place || !place.address_components) {
                    return;
                }

                const components = place.address_components;

                const streetNumber = getComponent(components, 'street_number', 'short_name');
                const route = getComponent(components, 'route', 'long_name');
                const locality = getComponent(components, 'locality', 'long_name') ||
                    getComponent(components, 'postal_town', 'long_name') ||
                    getComponent(components, 'sublocality_level_1', 'long_name');
                const adminAreaLong = getComponent(components, 'administrative_area_level_1', 'long_name');
                const adminAreaShort = getComponent(components, 'administrative_area_level_1',
                    'short_name');
                const postalCode = getComponent(components, 'postal_code', 'short_name');
                const countryShort = getComponent(components, 'country', 'short_name');

                const addressLine = [streetNumber, route].filter(Boolean).join(' ');

                if (addressLine) addressInput.value = addressLine;
                if (cityInput) cityInput.value = locality;
                if (stateInput) stateInput.value = adminAreaLong || adminAreaShort;
                if (postalCodeInput) postalCodeInput.value = postalCode;
                if (stateCodeInput) stateCodeInput.value = adminAreaShort;
                if (countryCodeInput) countryCodeInput.value = countryShort;

                if (place.geometry) {
                    const lat = place.geometry.location.lat();
                    const lng = place.geometry.location.lng();
                    latitudeInput.value = lat;
                    longitudeInput.value = lng;
                }
            });

            // Prevent form submission when selecting from suggestions
            addressInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceInput = document.getElementById('selected_shipping_service');
            const amountInput = document.getElementById('selected_shipping_amount');
            const radios = document.querySelectorAll('input[name="shipping_rate"]');
            const summaryShipping = document.getElementById('summaryShipping');
            const summaryTotal = document.getElementById('summaryTotal');
            const summaryItems = document.getElementById('summaryItems');
            const summaryDiscount = document.getElementById('summaryDiscount');

            function parseMoney(text) {
                return Number((text || '').toString().replace(/[^0-9.]/g, '')) || 0;
            }

            const itemsAmount = parseMoney(summaryItems ? summaryItems.textContent : '0');
            const discountAmount = parseMoney(summaryDiscount ? summaryDiscount.textContent : '0');

            function extractAmount(labelEl) {
                const priceEl = labelEl.querySelector('.cost-amount');
                if (!priceEl) return '';
                const text = priceEl.textContent.trim();
                const match = text.match(/([0-9]+(?:\.[0-9]{1,2})?)/);
                return match ? match[1] : '';
            }

            function extractCurrency(labelEl) {
                const priceEl = labelEl.querySelector('.cost-amount');
                if (!priceEl) return '';
                const text = priceEl.textContent.trim();
                // take non-digit prefix trimmed
                let cur = text.replace(/\s*[0-9].*$/, '').trim();
                if (cur === 'USD') cur = '$';
                return cur || '';
            }

            function updateHidden() {
                const checked = document.querySelector('input[name="shipping_rate"]:checked');
                if (!checked) return;
                const label = checked.closest('label.shipping-option-label');
                if (serviceInput) serviceInput.value = checked.value;
                if (amountInput) amountInput.value = extractAmount(label);

                const currency = extractCurrency(label);
                const shippingAmount = Number(amountInput.value || 0);

                // Get free shipping status from helper
                const freeShipping = @json(Sohoj::freeShippingInfo()['eligible']);

                let amount = shippingAmount;

                if (freeShipping) {
                    amount = 0;
                }

                if (summaryShipping) {
                    summaryShipping.textContent = (currency ? (currency + ' ') : '') + amount.toFixed(2);

                    if (summaryTotal) {
                        const newTotal = itemsAmount - discountAmount + amount;
                        summaryTotal.textContent = (currency ? (currency + ' ') : '') + newTotal.toFixed(2);
                    }
                }


            }

            if (radios.length) {
                radios.forEach(r => r.addEventListener('change', updateHidden));
                updateHidden();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const step2 = new bootstrap.Tab(document.getElementById('step2-tab'));
            const step3 = new bootstrap.Tab(document.getElementById('step3-tab'));

            const progressBar = document.getElementById('checkoutProgressBar');
            const stepCircles = [
                document.querySelector('.step-circle.step2'),
                document.querySelector('.step-circle.step3')
            ];

            function updateProgress(stepIdx) {
                const percent = [50, 100][stepIdx];
                progressBar.style.width = percent + '%';
                progressBar.setAttribute('aria-valuenow', stepIdx + 1);
                // Mark completed steps
                stepCircles.forEach((el, idx) => {
                    if (idx < stepIdx) {
                        el.classList.add('completed');
                        el.innerHTML = '';
                    } else {
                        el.classList.remove('completed');
                        el.innerHTML = (idx + 1).toString();
                    }
                });
            }

            // Initial state
            updateProgress(0);

            document.getElementById('toStep3').addEventListener('click', function() {
                step3.show();
                updateProgress(1);
            });
            document.getElementById('backToStep2').addEventListener('click', function() {
                step2.show();
                updateProgress(0);
            });

            // Also update on nav click (if user clicks step directly)
            [step2, step3].forEach((tab, idx) => {
                document.getElementById('step' + (idx + 2) + '-tab').addEventListener('shown.bs.tab',
                    function() {
                        updateProgress(idx);
                    });
            });
        });
    </script>
@endsection
