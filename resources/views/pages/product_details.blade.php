@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/responsive.css') }}" />
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assets/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/product_details.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/star-rating.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/shops.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap');

        /* Optimized CSS with better organization and performance */
        .cart-form {
            margin: 0;
            display: inline;
        }

        .ec-single-desc {
            word-break: break-word !important;
        }

        /* Content Section */
        .product-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .product-category {
            margin-bottom: 8px;
        }

        .product-category span {
            background: linear-gradient(135deg, #e8f5e8, #d4edda);
            color: #01949a;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.3;
            flex-grow: 1;
            font-family: 'Segoe UI', 'Inter', Arial, sans-serif;
            color: #000 !important;
        }

        .product-title a {
            color: #000 !important;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        /* Rating */
        .product-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
        }

        .stars {
            display: flex;
            gap: 1px;
        }

        .stars i {
            color: #ddd;
            font-size: 0.8rem;
        }

        .stars i.filled {
            color: #ffc107;
        }

        .rating-count {
            font-size: 0.75rem;
            color: #6c757d;
        }

        /* Price */
        .product-price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .original-price {
            color: #6c757d;
            text-decoration: line-through;
            font-size: 0.85rem;
        }

        .current-price {
            color: #000;
            font-size: 1.2rem;
            font-weight: 700;
        }

        /* Add to Cart Button */


        .add-to-cart-btn.loading .spinner {
            display: inline-block;
        }

        .add-to-cart-btn.loading .btn-text {
            opacity: 0.6;
        }

        .add-to-cart-btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        /* @keyframes spin {
                                                                                                        from { transform: rotate(0deg); }
                                                                                                        to { transform: rotate(360deg); }
                                                                                                    } */

        .product-title {
            font-size: 0.9rem;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            font-size: 12px;
        }

        @media (max-width: 576px) {
            /* .product-image {
                                    height: 180px;
                                } */

            .product-content {
                padding: 12px;
            }

            .product-title {
                font-size: 0.85rem;
            }

            .add-to-cart-btn {
                padding: 10px 16px;
                font-size: 0.8rem;
            }
        }

        /* Focus states for accessibility */

        /* Product Variations Styling */
        .product-variations-section {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .variations-title {
            color: #2c3e50;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #ffc107;
            display: inline-block;
        }

        .variation-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .variation-card:hover {
            border-color: #ffc107;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .attribute-item {
            margin-bottom: 5px;
        }

        .color-swatch {
            width: 20px;
            height: 20px;
            border-radius: 3px;
            border: 1px solid #ccc;
            display: inline-block;
            margin-right: 8px;
        }

        .variation-select-btn {
            border-radius: 20px;
            font-size: 0.85rem;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .variation-select-btn:hover {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .variation-card {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .variation-card:hover {
            border-color: #28a745;
            background: #f8fff9;
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.1);
            transform: translateY(-2px);
        }

        .variation-card.selected {
            border-color: #28a745;
            background: #f8fff9;
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
            transform: translateY(-2px);
        }

        .selection-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .selection-indicator i {
            transition: opacity 0.3s ease;
        }

        .variation-card.selected .selection-indicator i {
            opacity: 1 !important;
        }

        /* Focus styles for accessibility */
        .variation-card:focus {
            outline: 2px solid #28a745;
            outline-offset: 2px;
        }

        /* Active state for click feedback */
        .variation-card:active {
            transform: scale(0.98);
        }

        /* Disabled state for out-of-stock variations */
        .variation-card.out-of-stock {
            opacity: 0.6;
            cursor: not-allowed;
        }


        /* Enhanced Guest Buy Modal Styling */
        #guestBuyModal .modal-content {
            border: none;
            border-radius: 14px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        #guestBuyModal .modal-header {
            background: #ffffff;
            border-bottom: 1px solid #e9ecef;
            padding: 14px 18px;
        }

        #guestBuyModal .modal-title {
            font-weight: 600;
            color: #2c3e50;
        }

        #guestBuyModal .modal-body {
            padding: 18px;
        }

        .guest-buy-preview {
            width: 100%;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 12px;
        }

        .guest-buy-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .guest-buy-variant {
            display: inline-block;
            margin-top: 4px;
            background: #fffbe6;
            color: #6b5c01;
            border: 1px solid #ffe58f;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 0.75rem;
        }

        .guest-buy-price {
            font-weight: 700;
            color: #000;
            font-size: 1.1rem;
        }

        .guest-buy-compare-price {
            font-size: 0.8rem;
            color: #6c757d;
            text-decoration: line-through;
        }

        #guestBuyModal .modal-footer {
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
            color: #000;
        }

        .variation-card.out-of-stock:hover {
            transform: none;
            border-color: #dee2e6;
            background: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .selection-indicator .badge {
            font-size: 0.7rem;
            padding: 4px 8px;
        }

        .stock-info .badge {
            font-size: 0.75rem;
            padding: 4px 8px;
        }

        .sku-info {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 4px;
        }

        .price-tag {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .placeholder-img {
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .variation-card .row>div {
                margin-bottom: 15px;
            }

            .product-variations-section {
                padding: 15px;
            }

            .variation-select-btn {
                font-size: 0.75rem;
                padding: 6px 12px;
                margin-bottom: 10px;
            }
        }
    </style>
@endsection
@section('canonical_url', route('product_details', $mainProduct->slug))
@section('title', $mainProduct->name . ' | Royalit E-commerce')
@section('meta_description', Str::limit(strip_tags($mainProduct->short_description ?? $mainProduct->description), 150))
@section('meta_keywords', $mainProduct->name . ', ' . ($mainProduct->prodcats->pluck('name')->implode(', ') ??
    'product'))
@section('meta_og')
    <meta property="og:title" content="{{ $mainProduct->name }} | Royalit E-commerce">
    <meta property="og:description"
        content="{{ Str::limit(strip_tags($mainProduct->short_description ?? $mainProduct->description), 150) }}">
    <meta property="og:image" content="{{ Storage::url($mainProduct->image) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="product">
@endsection
@section('meta_twitter')
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $mainProduct->name }} | Royalit E-commerce">
    <meta name="twitter:description"
        content="{{ Str::limit(strip_tags($mainProduct->short_description ?? $mainProduct->description), 150) }}">
    <meta name="twitter:image" content="{{ Storage::url($mainProduct->image) }}">
@endsection
@section('content')
    <main>
        <x-app.header />
        @php
            if (is_string($mainProduct->images)) {
                $images = json_decode($mainProduct->images) ?? [];
            } else {
                $images = $mainProduct->images ?? [];
            }
            // Pre-calculate values for better performance
            $averageRating = Sohoj::average_rating($mainProduct->ratings);
            $ratingCount = $mainProduct->ratings->count();
            $currentPrice = $mainProduct->sale_price ?? $mainProduct->price;
            $originalPrice = $mainProduct->price;
            $hasDiscount = $mainProduct->sale_price && $mainProduct->sale_price < $mainProduct->price;
            $discountPercentage = $hasDiscount ? round((($originalPrice - $currentPrice) / $originalPrice) * 100) : 0;
            $fullStars = floor($averageRating);
            $hasHalfStar = $averageRating - $fullStars >= 0.5;

            // Process variations data - now they are Varient objects
            $variations = $mainProduct->variations ?? [];
        @endphp

        <!-- Sart Single product -->
        <section class="ec-page-content section-space-p product_details-body">
            <div class="container">
                <div class="row">
                    <div class="ec-pro-rightside ec-common-rightside col-lg-12 col-md-12">

                        <!-- Single product content Start -->
                        <div class="single-pro-block">
                            <div class="single-pro-inner">
                                <div class="row">
                                    <div class="single-pro-img single-pro-img-no-sidebar ">
                                        <div class="single-product-scroll">

                                            <div class="single-product-cover">
                                                <div class="single-slide zoom-image-hover" style="height: 500px">
                                                    <img class="img-responsive"
                                                        style="object-fit: contain;
                                                width: 100%;
                                                height: 100%;"
                                                        src="{{ Storage::url($mainProduct->image) }}"
                                                        alt="{{ $mainProduct->name }}">
                                                </div>
                                                @if ($images)
                                                    @foreach ($images as $key => $image)
                                                        <div class="single-slide zoom-image-hover" style="height: 500px">
                                                            <img class="img-responsive"
                                                                style="object-fit: cover;
                                                width: 100%;
                                                height: 100%;"
                                                                src="{{ Storage::url($image) }}"
                                                                alt="{{ $mainProduct->name }} image {{ $loop->iteration }}">
                                                        </div>
                                                    @endforeach
                                                @endif

                                            </div>

                                            <div class="single-nav-thumb">
                                                <div class="single-slide" style="">
                                                    <img class="img-responsive" style="object-fit: cover; height:100px"
                                                        src="{{ Storage::url($mainProduct->image) }}"
                                                        alt="{{ $mainProduct->name }} thumbnail">
                                                </div>
                                                @if ($images)
                                                    @foreach ($images as $key => $image)
                                                        <div class="single-slide">
                                                            <img class="img-responsive" style="height:100px"
                                                                src="{{ Storage::url($image) }}"
                                                                alt="{{ $mainProduct->name }} thumbnail {{ $loop->iteration }}">
                                                        </div>
                                                    @endforeach
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-pro-desc single-pro-desc-no-sidebar">
                                        <div class="single-pro-content d-flex flex-column justify-content-between"
                                            style="height:100%">
                                            <div>
                                                <h1 class="ec-single-title mb-2 "
                                                    style="font-family: 'Inter', sans-serif; font-weight: 500">
                                                    {{ $mainProduct->name }}
                                                </h1>
                                                <span>Shop:

                                                    <a href="{{ route('store_front', $mainProduct->shop->slug) }}">
                                                        {{ $mainProduct->shop->name }}</a>
                                                </span>

                                                <div class="ec-single-rating-wrap mt-3">
                                                    <div class="ec-single-rating">
                                                        <input value="{{ Sohoj::average_rating($mainProduct->ratings) }}"
                                                            class="rating published_rating" data-size="sm">
                                                    </div>

                                                </div>
                                                <div class="ec-single-desc ">
                                                    <p class="text-warning">shipped on Nov 15</p>
                                                    <span>{!! $mainProduct->short_description !!}</span>
                                                </div>

                                                {{-- Product Variations Display --}}
                                                @if ($mainProduct->is_variable_product && $variations && count($variations) > 0)
                                                    <div class="product-variations-section mt-4 mb-4">
                                                        <h4 class="variations-title mb-3"
                                                            style="font-weight: 600; color: #2c3e50;">Available Variations
                                                        </h4>
                                                        <div class="variations-container">
                                                            @foreach ($variations as $index => $variation)
                                                                @php
                                                                    $isOutOfStock =
                                                                        $variation->track_quantity &&
                                                                        $variation->stock <= 0;
                                                                    $cardClasses =
                                                                        'variation-card border rounded-lg p-3 mb-3';
                                                                    if ($isOutOfStock) {
                                                                        $cardClasses .= ' out-of-stock';
                                                                    }
                                                                @endphp
                                                                <div class="{{ $cardClasses }}"
                                                                    style="border: 1px solid #dee2e6; background: #f8f9fa; transition: all 0.3s ease;"
                                                                    data-variation-index="{{ $index }}"
                                                                    data-variation-sku="{{ $variation->sku ?? '' }}"
                                                                    data-variation-price="{{ $variation->price ?? 0 }}"
                                                                    data-variation-compare-price="{{ $variation->compare_at_price ?? 0 }}"
                                                                    data-variation-stock="{{ $variation->stock ?? 0 }}"
                                                                    data-variation-track-quantity="{{ $variation->track_quantity ?? false }}"
                                                                    data-variation-image="{{ $variation->variant_image ? Storage::url($variation->variant_image) : '' }}"
                                                                    @if ($isOutOfStock) data-out-of-stock="true" @endif>
                                                                    <div class="row align-items-center">
                                                                        {{-- Variation Image --}}
                                                                        <div class="col-md-2 col-sm-3">
                                                                            @if ($variation->variant_image)
                                                                                <img src="{{ Storage::url($variation->variant_image) }}"
                                                                                    alt="Variation {{ $index + 1 }}"
                                                                                    class="img-fluid rounded variation-image"
                                                                                    style="width: 80px; height: 80px; object-fit: cover;"
                                                                                    data-variation-index="{{ $index }}">
                                                                            @else
                                                                                <div class="placeholder-img d-flex align-items-center justify-content-center rounded"
                                                                                    style="width: 80px; height: 80px; background: #e9ecef; color: #6c757d;">
                                                                                    <i class="fas fa-image"></i>
                                                                                </div>
                                                                            @endif
                                                                        </div>

                                                                        {{-- Variation Details --}}
                                                                        <div class="col-md-8 col-sm-6">
                                                                            <div class="row">
                                                                                {{-- Attributes --}}
                                                                                <div class="col-md-4">
                                                                                    <h6 class="mb-2"
                                                                                        style="font-weight: 600; color: #495057;">
                                                                                        Attributes</h6>
                                                                                    @if ($variation->attributes && is_array($variation->attributes))
                                                                                        <div class="attributes-list">
                                                                                            @foreach ($variation->attributes as $attr)
                                                                                                <div
                                                                                                    class="attribute-item d-flex align-items-center mb-1">
                                                                                                    <span
                                                                                                        class="attribute-name me-2"
                                                                                                        style="font-size: 0.85rem; color: #6c757d;">{{ $attr['attribute'] ?? 'N/A' }}:</span>
                                                                                                    @if (isset($attr['value']) && str_starts_with($attr['value'], '#'))
                                                                                                        <div class="color-swatch me-2"
                                                                                                            style="width: 20px; height: 20px; background-color: {{ $attr['value'] }}; border: 1px solid #ccc; border-radius: 3px;">
                                                                                                        </div>
                                                                                                    @endif
                                                                                                    <span
                                                                                                        class="attribute-value"
                                                                                                        style="font-size: 0.85rem; font-weight: 500;">{{ $attr['value'] ?? 'N/A' }}</span>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    @endif
                                                                                </div>

                                                                                {{-- Pricing --}}
                                                                                <div class="col-md-4">
                                                                                    <h6 class="mb-2"
                                                                                        style="font-weight: 600; color: #495057;">
                                                                                        Pricing</h6>
                                                                                    <div class="price-info">
                                                                                        <div class="current-price"
                                                                                            style="font-size: 1.1rem; font-weight: 700; color: #28a745;">
                                                                                            ${{ number_format($variation->price ?? 0, 2) }}
                                                                                        </div>
                                                                                        @if (
                                                                                            $variation->compare_at_price &&
                                                                                                $variation->compare_at_price > 0 &&
                                                                                                $variation->compare_at_price > $variation->price)
                                                                                            <div class="compare-price"
                                                                                                style="font-size: 0.9rem; color: #6c757d; text-decoration: line-through;">
                                                                                                ${{ number_format($variation->compare_at_price, 2) }}
                                                                                            </div>
                                                                                        @endif
                                                                                        @if ($variation->cost_per_item && $variation->cost_per_item > 0)
                                                                                            <div class="cost-price"
                                                                                                style="font-size: 0.8rem; color: #6c757d;">
                                                                                                Cost:
                                                                                                ${{ number_format($variation->cost_per_item, 2) }}
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>

                                                                                {{-- Stock Information --}}
                                                                                <div class="col-md-4">
                                                                                    <h6 class="mb-2"
                                                                                        style="font-weight: 600; color: #495057;">
                                                                                        Stock</h6>
                                                                                    <div class="stock-info">
                                                                                        <div class="stock-quantity">
                                                                                            <span
                                                                                                class="badge {{ $variation->getStockBadgeClass() }}">
                                                                                                {{ $variation->getStockDisplayText() }}
                                                                                            </span>
                                                                                        </div>
                                                                                        @if ($variation->sku)
                                                                                            <div class="sku-info mt-1"
                                                                                                style="font-size: 0.8rem; color: #6c757d;">
                                                                                                SKU: {{ $variation->sku }}
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Selection Indicator --}}
                                                                        <div class="col-md-2 col-sm-3 text-end">
                                                                            <div class="selection-indicator">
                                                                                @if ($isOutOfStock)
                                                                                    <span class="badge bg-danger">Out of
                                                                                        Stock</span>
                                                                                @else
                                                                                    <i class="fas fa-check-circle text-success"
                                                                                        style="font-size: 1.2rem; opacity: 0;"></i>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mb-5">
                                                <div class="stock product_details-body">
                                                    <span>Availability: <span id="stock-display"
                                                            style="color: #D81919E5">{{ $mainProduct->quantity }}</span>
                                                        in
                                                        Stock
                                                    </span>
                                                </div>

                                                <div class="ec-single-price-stoke">
                                                    <div class="ec-single-price product-price">

                                                        <div class="d-flex align-items-center">

                                                            @if ($mainProduct->sale_price ?? $mainProduct->price)
                                                                <span class="ec-price d-flex align-items-center">

                                                                    <span
                                                                        class="new-price product-ammount product_details-body">{{ Sohoj::price($mainProduct->sale_price ?? $mainProduct->price) }}</span>
                                                                    @if ($mainProduct->sale_price)
                                                                        <del><span
                                                                                class="old-price">{{ Sohoj::price($mainProduct->price) }}</span></del>
                                                                    @endif
                                                                @else
                                                                    <span class="ec-price d-flex align-items-center">
                                                                        <span
                                                                            class="new-price product-ammount product_details-body">Price
                                                                            Not Available</span>
                                                                    </span>
                                                            @endif
                                                            </span>

                                                        </div>
                                                        <p>Sku: <span class="product-sku-info">{{ $mainProduct->sku }}</p>
                                                    </div>
                                                </div>

                                            </div>

                                            <form id="buy-now-form" action="{{ route('cart.boynow') }}" method="POST">
                                                @csrf
                                                @if ($mainProduct->is_variable_product && count($mainProduct->subproductsuser) > 0)
                                                    @foreach ($mainProduct->attributes as $attribute)
                                                        <div class="row mt-2 pt-2 w-100 mb-2">
                                                            <div class="form-group col-md-12 pl-0 ">
                                                                <h5 class="ms-3">
                                                                    {{ str_replace('_', ' ', $attribute->name) }}</h4>
                                                                    <div class="btn-group ms-2" role="group">
                                                                        @foreach ($attribute->value as $value)
                                                                            <input type="radio"
                                                                                class="btn-check {{ str_replace(' ', '_', $attribute->name) }}"
                                                                                name="variable_attribute[{{ $attribute->name }}]"
                                                                                id="{{ str_replace(' ', '_', $value) }}"
                                                                                value="{{ $value }}" required
                                                                                onclick="change_variable()">
                                                                            <label class="btn btn-outline-primary"
                                                                                for="{{ str_replace(' ', '_', $value) }}">{{ str_replace('_', ' ', $value) }}</label>
                                                                        @endforeach
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                {{-- Hidden input for selected variant SKU --}}
                                                <input type="hidden" name="selected_variant_sku"
                                                    id="selected_variant_sku" value="" />

                                                {{-- Hidden input for buy intent --}}
                                                <input type="hidden" name="buy_intent" id="buy_intent"
                                                    value="" />

                                                {{-- Selected variant info display --}}
                                                <div id="selected-variant-info" class="alert alert-info mt-3"
                                                    style="display: none;">
                                                    <strong>Selected Variant:</strong> <span
                                                        id="selected-variant-details"></span>
                                                </div>

                                                <div class="ec-single-qty align-items-center">

                                                    <input type="hidden" name="product_id"
                                                        value="{{ $mainProduct->id }}" />

                                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                                        @if ($mainProduct->sale_price ?? $mainProduct->price)
                                                            <div class="qty-plus-minus">
                                                                <input class="qty-input qty" type="text"
                                                                    name="quantity" value="1" />
                                                            </div>

                                                            <div class="d-flex gap-2 flex-grow-1">
                                                                <input type="submit"
                                                                    class="btn btn-sm btn-success flex-fill"
                                                                    name="add_to_cart" id="add-to-cart-btn"
                                                                    value="Add to Cart">


                                                                <button class="btn btn-sm btn-burgundy flex-fill"
                                                                    style="width: 100%" type="submit" id="buy-now-btn">
                                                                    Buy Now
                                                                </button>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            @if (!in_array($mainProduct->id, session()->get('wishlist', [])))
                                                                <a href="{{ route('wishlist.add', ['productId' => $mainProduct->id]) }}"
                                                                    class="btn btn-outline-dark wishlist">
                                                                    Add to wishlist
                                                                </a>
                                                            @else
                                                                <a href="{{ route('wishlist.remove', ['productId' => $mainProduct->id]) }}"
                                                                    class="btn btn-dark wishlist">
                                                                    Remove from wishlist
                                                                </a>
                                                            @endif
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
                </div>
            </div>
            <!-- Single product tab start -->
            <div class="ec-single-pro-tab" id="ratings">
                <div class="ec-single-pro-tab-wrapper">
                    <div class="ec-single-pro-tab-nav d-flex justify-content-center">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link {{ Request()->has('id') ? '' : 'active' }} " data-bs-toggle="tab"
                                    data-bs-target="#ec-spt-nav-details" role="tablist">Detail</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#ec-spt-nav-info"
                                    role="tablist">More Information</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request()->has('id') ? ' active' : '' }}" data-bs-toggle="tab"
                                    data-bs-target="#ec-spt-nav-review" role="tablist">Reviews</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content  ec-single-pro-tab-content">
                        <div id="ec-spt-nav-details" class="tab-pane fade show active">
                            <div class="ec-single-pro-tab-desc"
                                style="word-break: normal; overflow-wrap: normal; white-space: normal; hyphens: none;">

                                <p>{!! $mainProduct->description !!}</p>
                            </div>
                        </div>
                        <div id="ec-spt-nav-info" class="tab-pane fade">
                            <div class="ec-single-pro-tab-moreinfo">
                                <ul>
                                    <li><span>Weight</span> {{ $mainProduct->weight }} {{ $mainProduct->weight_unit }}
                                    </li>
                                    <li><span>Dimensions</span> {{ $mainProduct->dimensions }} cm</li>
                                    <li><span>Shipping Cost</span> {{ Sohoj::price($mainProduct->shipping_cost) }}</li>
                                </ul>
                            </div>
                        </div>

                        <div id="ec-spt-nav-review"
                            class="tab-pane fade {{ Request()->has('id') ? 'show active' : '' }}">
                            <div class="row">
                                <div class="ec-t-review-wrapper">
                                    @foreach ($mainProduct->ratings as $rating)
                                        <div class="ec-t-review-item">
                                            <div class="ec-t-review-avtar">
                                                <img src="{{ asset('assets/img/single_product/person.png') }}"
                                                    alt="" />
                                            </div>
                                            <div class="ec-t-review-content">
                                                <div class="ec-t-review-top">
                                                    <div class="ec-t-review-name">{{ $rating->name }}</div>
                                                    <div class="ec-t-review-rating">
                                                        <input name="rating" type="number"
                                                            value="{{ $rating->rating }}" class="rating published_rating"
                                                            data-size="sm">
                                                    </div>
                                                </div>

                                                <div class="ec-t-review-bottom">
                                                    <p>
                                                        {{ $rating->review }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @php
                                    $user = Auth()->id();
                                    $rating = App\Models\Rating::where('user_id', $user)
                                        ->where('product_id', $mainProduct->id)
                                        ->get();

                                @endphp
                                @if (Auth::check())
                                    @if ($rating->count() == 0)
                                        <div class="ec-ratting-content">
                                            <h3>Add a Review</h3>
                                            <div class="ec-ratting-form">
                                                <form action="{{ route('rating', ['product_id' => $mainProduct->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="ec-ratting-star">
                                                        <span>Your rating:</span>
                                                        <input value="1" name="rating"
                                                            class="rating product_rating" data-size="xs">
                                                    </div>


                                                    <div class="ec-ratting-input form-submit">
                                                        <textarea name="review" placeholder="Enter Your Comment"></textarea>
                                                        <button class="btn btn-dark" type="submit"
                                                            value="Submit">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-warning d-flex align-items-center gap-3 p-4 rounded shadow-sm"
                                        style="background: linear-gradient(90deg, #fffbe6 60%, #fff9cc 100%); border-left: 4px solid #ffc107;">
                                        <i class="fas fa-info-circle fa-lg text-warning"></i>
                                        <div>
                                            <span style="font-weight: 500; color: #856404;">
                                                <strong>Note:</strong>
                                                Please <a href="{{ route('login') }}"
                                                    class="text-decoration-underline text-warning"
                                                    style="font-weight:600;">login</a> to add a review.
                                            </span>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- product details description area end -->
        </section>
        <!-- End Single product -->

        <!-- Guest Buy Modal -->
        <!-- Store main product data to avoid Blade variable shadowing in later loops -->
        <div id="main-product-data" hidden data-image="{{ Storage::url($mainProduct->image) }}"
            data-name="{{ $mainProduct->name }}" data-sku="{{ $mainProduct->sku }}"
            data-price="{{ Sohoj::price($mainProduct->sale_price ?? $mainProduct->price) }}"
            data-compare-price="{{ $mainProduct->sale_price ? Sohoj::price($mainProduct->price) : '' }}"
            data-stock="{{ $mainProduct->quantity }}"></div>
        <div class="modal fade" id="guestBuyModal" tabindex="-1" aria-labelledby="guestBuyModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 d-flex align-items-center gap-2" id="guestBuyModalLabel">
                            <i class="fas fa-shopping-bag text-warning"></i>
                            Complete your purchase
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="guest-buy-preview d-flex align-items-center gap-3">
                            <img id="guest-buy-product-image" src="" alt=""
                                style="width:70px;height:70px;object-fit:cover;border-radius:6px;">
                            <div class="flex-grow-1">
                                <div class="guest-buy-name" id="guest-buy-product-name"></div>
                                <div class="guest-buy-variant" id="guest-buy-variant-text" style="display:none;"></div>
                                <div class="guest-buy-sku" id="guest-buy-sku-text"
                                    style="font-size:0.8rem;color:#6c757d;margin-top:2px;">

                                </div>
                            </div>
                            <div class="text-end">
                                <div class="guest-buy-price" id="guest-buy-price-text"></div>
                                <div class="guest-buy-compare-price" id="guest-buy-compare-price-text"
                                    style="display:none;font-size:0.8rem;color:#6c757d;text-decoration:line-through;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex flex-column align-items-stretch gap-2">
                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}"
                            class="btn btn-burgundy w-100" id="signin-buy-btn"><i
                                class="fas fa-sign-in-alt me-2"></i>Sign in
                            and Buy</a>
                        <a href="{{ route('register') }}?redirect={{ urlencode(request()->fullUrl()) }}"
                            class="btn btn-outline-dark w-100" id="signup-buy-btn"><i
                                class="fas fa-user-plus me-2"></i>Sign up and Buy</a>
                        <button type="button" class="btn btn-guest-warning w-100" id="guest-buy-btn"><i
                                class="fas fa-bolt me-2"></i>Buy as Guest</button>
                    </div>
                </div>
            </div>
        </div>


        <section class="section ec-new-product" style="margin-bottom: 100px">
            <div class="container">
                <div class="row">
                    <div class="section-title">
                        <h2 class="related-product-sec-title">Related products</h2>
                    </div>

                    <div class="row">
                        @foreach ($related_products as $product)
                            <x-products.product :product="$product" />
                        @endforeach
                    </div>

                </div>
            </div>
        </section>
    </main>

@endsection
@section('js')




    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/star-rating.js') }}"></script>

<script>
    $("#product_rating").rating({
        showCaption: true
    });
    $(".published_rating").rating({
        showCaption: false,
        readonly: true,
    });
</script> --}}


    <!-- Add Swiper JS just before </body> -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" /> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script> --}}

    <script>
        // const swiper = new Swiper('.related-products-slider', {
        //     slidesPerView: 4,
        //     spaceBetween: 30,
        //     loop: true,
        //     navigation: {
        //         nextEl: '.swiper-button-next',
        //         prevEl: '.swiper-button-prev',
        //     },
        //     pagination: {
        //         el: '.swiper-pagination',
        //         clickable: true,
        //     },
        //     breakpoints: {
        //         0: {
        //             slidesPerView: 1,
        //         },
        //         576: {
        //             slidesPerView: 2,
        //         },
        //         768: {
        //             slidesPerView: 3,
        //         },
        //         992: {
        //             slidesPerView: 5,
        //         },
        //     },
        // });

        // Product Variations Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const variationCards = document.querySelectorAll('.variation-card');
            const priceElement = document.querySelector('.new-price');
            const oldPriceElement = document.querySelector('.old-price');

            console.log(oldPriceElement);

            const stockElement = document.getElementById('stock-display');
            const productSku = document.querySelector('.product-sku-info');
            const selectedSkuInput = document.getElementById('selected_variant_sku');
            const buyNowBtn = document.getElementById('buy-now-btn');
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            const buyIntentInput = document.getElementById('buy_intent');
            const mainProductImage = document.querySelector('.single-product-cover .single-slide img');
            const selectedVariantInfo = document.getElementById('selected-variant-info');
            const selectedVariantDetails = document.getElementById('selected-variant-details');

            // Main product data from hidden element (avoids Blade variable conflicts)
            const mainDataEl = document.getElementById('main-product-data');
            const MAIN_PRODUCT = mainDataEl ? {
                image: mainDataEl.getAttribute('data-image') || '',
                name: mainDataEl.getAttribute('data-name') || '',
                sku: mainDataEl.getAttribute('data-sku') || '',
                price: mainDataEl.getAttribute('data-price') || '',
                comparePrice: mainDataEl.getAttribute('data-compare-price') || '',
                stock: mainDataEl.getAttribute('data-stock') || ''
            } : {
                image: '',
                name: '',
                sku: '',
                price: '',
                comparePrice: '',
                stock: ''
            };

            // Store original product data from MAIN_PRODUCT
            const originalPrice = MAIN_PRODUCT.price;
            const originalOldPrice = MAIN_PRODUCT.comparePrice;
            const originalStock = MAIN_PRODUCT.stock;
            const originalImage = MAIN_PRODUCT.image;

            variationCards.forEach(function(card) {
                card.addEventListener('click', function() {
                    // Check if variation is out of stock
                    if (this.dataset.outOfStock === 'true') {
                        return; // Don't allow selection of out-of-stock variations
                    }

                    // Remove active class from all cards
                    variationCards.forEach(c => c.classList.remove('selected'));

                    // Add active class to clicked card
                    this.classList.add('selected');

                    // Get variation data from data attributes
                    const sku = this.dataset.variationSku;
                    const price = parseFloat(this.dataset.variationPrice);
                    const comparePrice = parseFloat(this.dataset.variationComparePrice);
                    const stock = parseInt(this.dataset.variationStock);
                    const trackQuantity = this.dataset.variationTrackQuantity === '1';

                    const variantImage = this.dataset.variationImage;

                    // Update price
                    if (priceElement && price > 0) {
                        priceElement.textContent = '$' + price.toFixed(2);
                    }


                    // Update compare price
                    if (oldPriceElement && comparePrice > 0 && comparePrice > price) {
                        priceElement.textContent = '$' + price.toFixed(2);
                        oldPriceElement.textContent = '$' + comparePrice.toFixed(2);
                        if (oldPriceElement.parentElement) {
                            oldPriceElement.parentElement.style.display = 'inline';
                        }
                    } else {
                        if (oldPriceElement && oldPriceElement.parentElement) {
                            oldPriceElement.parentElement.style.display = 'none';
                        }
                    }

                    // Update stock
                    if (stockElement) {
                        if (trackQuantity == 1) {
                            stockElement.textContent = stock;
                        } else {
                            stockElement.textContent = 'Unlimited';
                        }
                    }
                    productSku.textContent = sku;

                    // Update main product image if variant has image
                    if (variantImage && mainProductImage) {
                        mainProductImage.src = variantImage;
                        mainProductImage.alt = 'Selected variant image';
                    }

                    // Update selected SKU
                    if (selectedSkuInput) {
                        selectedSkuInput.value = sku;
                    }

                    // Show selected variant info
                    if (selectedVariantInfo && selectedVariantDetails) {
                        const attributes = this.querySelectorAll('.attribute-value');
                        const attributeText = Array.from(attributes).map(attr => attr.textContent
                            .trim()).join(', ');
                        selectedVariantDetails.textContent =
                            `${attributeText} - $${price.toFixed(2)}`;
                        selectedVariantInfo.style.display = 'block';
                    }

                    // Enable buy now button
                    if (buyNowBtn) {
                        buyNowBtn.disabled = false;
                        buyNowBtn.textContent = 'Buy Now';
                    }

                    // Show selection indicator
                    const selectionIndicator = this.querySelector('.selection-indicator i');
                    if (selectionIndicator) {
                        selectionIndicator.style.opacity = '1';
                    }

                    // Add visual feedback
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);

                    // Update guest modal content if it exists and user is not logged in
                    @if (!Auth::check())
                        updateGuestModalContent();
                    @endif
                });
            });

            // Add keyboard navigation support
            variationCards.forEach(function(card) {
                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });

                // Make cards focusable for accessibility
                card.setAttribute('tabindex', '0');
                card.setAttribute('role', 'button');
                card.setAttribute('aria-label', 'Select variation');
            });

            // Form validation - require variant selection for variable products
            const cartForm = document.getElementById('buy-now-form');
            if (cartForm && {{ $mainProduct->is_variable_product ? 'true' : 'false' }}) {
                cartForm.addEventListener('submit', function(e) {
                    const selectedSku = selectedSkuInput.value;
                    if (!selectedSku) {
                        e.preventDefault();
                        alert('Please select a variant before adding to cart.');
                        return false;
                    }
                });
            }

            if (buyNowBtn) {
                let isVariable = {{ $mainProduct->is_variable_product ? 'true' : 'false' }};

                if (isVariable) {
                    buyNowBtn.disabled = true;
                    buyNowBtn.textContent = 'BUY NOW';
                } else {
                    buyNowBtn.disabled = false;
                }
            }



            // For logged-in users: ensure intent is set before submitting via Buy Now
            if (buyNowBtn) {
                buyNowBtn.addEventListener('click', function() {
                    // For logged-in users, Buy Now should add to cart and go to cart page
                    if (buyIntentInput) buyIntentInput.value = 'buy_now';
                });
            }

            // Intercept Buy Now for guests
            @if (!Auth::check())
                if (buyNowBtn) {
                    buyNowBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (buyIntentInput) buyIntentInput.value = '';

                        // Populate modal with product/variant details
                        updateGuestModalContent();

                        const modalEl = document.getElementById('guestBuyModal');
                        try {
                            if (window.bootstrap && typeof window.bootstrap.Modal === 'function') {
                                const modal = new window.bootstrap.Modal(modalEl);
                                modal.show();
                            } else if (window.$ && typeof window.$(modalEl).modal === 'function') {
                                window.$(modalEl).modal('show');
                            } else {
                                // Very basic fallback
                                modalEl.classList.add('show');
                                modalEl.style.display = 'block';
                                modalEl.removeAttribute('aria-hidden');
                            }
                        } catch (e) {
                            if (window.$ && typeof window.$(modalEl).modal === 'function') {
                                window.$(modalEl).modal('show');
                            } else {
                                modalEl.classList.add('show');
                                modalEl.style.display = 'block';
                                modalEl.removeAttribute('aria-hidden');
                            }
                        }
                    });
                }

                // Function to update guest modal content
                function updateGuestModalContent() {
                    const modalImg = document.getElementById('guest-buy-product-image');
                    const modalName = document.getElementById('guest-buy-product-name');
                    const modalVariant = document.getElementById('guest-buy-variant-text');
                    const modalSku = document.getElementById('guest-buy-sku-text');
                    const modalPrice = document.getElementById('guest-buy-price-text');
                    const modalComparePrice = document.getElementById('guest-buy-compare-price-text');
                    const signinBtn = document.getElementById('signin-buy-btn');
                    const signupBtn = document.getElementById('signup-buy-btn');

                    const selectedCard = document.querySelector('.variation-card.selected');

                    if (selectedCard) {
                        // Update with variant information
                        const variantImg = selectedCard.dataset.variationImage;
                        const variantSku = selectedCard.dataset.variationSku;
                        const variantPrice = parseFloat(selectedCard.dataset.variationPrice);
                        const variantComparePrice = parseFloat(selectedCard.dataset.variationComparePrice);
                        const attributes = selectedCard.querySelectorAll('.attribute-value');
                        const attributeText = Array.from(attributes).map(a => a.textContent.trim()).join(', ');

                        // Update image
                        modalImg.src = variantImg || MAIN_PRODUCT.image;

                        // Update variant text
                        if (attributeText) {
                            modalVariant.textContent = attributeText;
                            modalVariant.style.display = 'block';
                        } else {
                            modalVariant.style.display = 'none';
                        }

                        // Update SKU
                        modalSku.textContent = 'SKU: ' + (variantSku || MAIN_PRODUCT.sku);

                        // Update price
                        modalPrice.textContent = '$' + variantPrice.toFixed(2);

                        // Update compare price
                        if (variantComparePrice > 0 && variantComparePrice > variantPrice) {
                            modalComparePrice.textContent = '$' + variantComparePrice.toFixed(2);
                            modalComparePrice.style.display = 'block';
                        } else {
                            modalComparePrice.style.display = 'none';
                        }

                        // Name
                        modalName.textContent = MAIN_PRODUCT.name;
                    } else {
                        // Reset to original product information
                        modalImg.src = MAIN_PRODUCT.image;
                        modalName.textContent = MAIN_PRODUCT.name;
                        modalVariant.style.display = 'none';
                        modalSku.textContent = 'SKU: ' + MAIN_PRODUCT.sku;
                        modalPrice.textContent = MAIN_PRODUCT.price;
                        if (MAIN_PRODUCT.comparePrice) {
                            modalComparePrice.textContent = MAIN_PRODUCT.comparePrice;
                            modalComparePrice.style.display = 'block';
                        } else {
                            modalComparePrice.style.display = 'none';
                        }
                    }

                    // Set up sign in/sign up buttons to submit form with appropriate intent
                    signinBtn.onclick = function(e) {
                        e.preventDefault();
                        submitFormWithIntent('buy_now_signin');
                    };

                    signupBtn.onclick = function(e) {
                        e.preventDefault();
                        submitFormWithIntent('buy_now_signup');
                    };
                }

                // Function to submit form with specific intent
                function submitFormWithIntent(intent) {
                    // Close the modal first
                    const modalEl = document.getElementById('guestBuyModal');
                    try {
                        if (window.bootstrap && typeof window.bootstrap.Modal === 'function') {
                            const modal = window.bootstrap.Modal.getInstance(modalEl);
                            if (modal) modal.hide();
                        } else if (window.$ && typeof window.$(modalEl).modal === 'function') {
                            window.$(modalEl).modal('hide');
                        } else {
                            modalEl.classList.remove('show');
                            modalEl.style.display = 'none';
                            modalEl.setAttribute('aria-hidden', 'true');
                        }
                    } catch (e) {
                        // Fallback
                        modalEl.classList.remove('show');
                        modalEl.style.display = 'none';
                        modalEl.setAttribute('aria-hidden', 'true');
                    }

                    // Variant validation (since form.submit() bypasses handlers)
                    const selectedSku = selectedSkuInput ? selectedSkuInput.value : '';
                    if ({{ $mainProduct->is_variable_product ? 'true' : 'false' }} && !selectedSku) {
                        alert('Please select a variant before proceeding.');
                        return;
                    }

                    // Ensure the form submits as Buy Now (not add to cart)
                    if (addToCartBtn) {
                        addToCartBtn.disabled = true;
                    }

                    if (buyIntentInput) buyIntentInput.value = intent;

                    // Prefer requestSubmit to trigger native submit events/validation
                    try {
                        if (typeof cartForm.requestSubmit === 'function') {
                            cartForm.requestSubmit();
                        } else {
                            cartForm.submit();
                        }
                    } catch (err) {
                        cartForm.submit();
                    }
                }

                // Guest: submit the existing form as guest when clicking Buy as Guest
                const guestBuyBtn = document.getElementById('guest-buy-btn');
                if (guestBuyBtn && cartForm) {
                    guestBuyBtn.addEventListener('click', function() {
                        submitFormWithIntent('buy_now_guest');
                    });
                }
            @endif
        });
    </script>
@endsection
