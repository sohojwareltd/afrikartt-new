@php
    $route = route('shops');

    // Check if any filters are active
    $hasActiveFilters =
        request('category') ||
        request('brand') ||
        request('ratings') ||
        request('priceMin') ||
        request('priceMax') ||
        request('filter_products') ||
        request('search');

    // Get current filter values
    $currentCategory = request('category');
    $currentRating = request('ratings');
    $currentPriceMin = request('priceMin', 0);
    $currentPriceMax = request('priceMax', 1000);
    $currentFilterProducts = request('filter_products', 'most-sold');
@endphp

@section('title', 'All Shops | Royalit E-commerce')
@section('meta_description',
    'Browse all shops on Royalit E-commerce. Find top-rated vendors, trending stores, and the
    best deals in one place.')
@section('meta_keywords', 'shops, vendors, ecommerce, online stores, Royalit')
@section('meta_og')
    <meta property="og:title" content="All Shops | Royalit E-commerce">
    <meta property="og:description"
        content="Browse all shops on Royalit E-commerce. Find top-rated vendors, trending stores, and the best deals in one place.">
    <meta property="og:image" content="{{ Settings::setting('site_logo') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection
@section('meta_twitter')
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="All Shops | Royalit E-commerce">
    <meta name="twitter:description"
        content="Browse all shops on Royalit E-commerce. Find top-rated vendors, trending stores, and the best deals in one place.">
    <meta name="twitter:image" content="{{ Settings::setting('site_logo') }}">
@endsection
@section('canonical_url', route('shops'))



@extends('layouts.app')

@section('content')
    <main>
        <x-app.header />
        <section class="modern-shops-container">
            <div class="container">
                {{-- <div class="checkout-hero mb-4 position-relative">
                    <h2 class="fw-bold mb-1 text-light">Explore Our Shops</h2>
                    <p class="mb-0">Browse your favorite stores and enjoy fast, secure delivery on every order.</p>

                    <div
                        class="checkout-hero-steps d-none d-md-flex position-absolute end-0 top-0 h-100 align-items-center pe-4">
                        <a href="{{ route('homepage') }}"><span class="badge bg-light text-primary me-2">Home</span></a>
                        <span class="badge bg-light text-primary me-2">Shops</span>
                    </div>
                </div> --}}
                <div class="row">
                    <!-- Desktop Filter Sidebar -->
                    <div class="col-md-3 d-none d-md-block">
                        <div class="modern-filter-sidebar">
                            <div class="filter-header">
                                <h2 class="filter-title">
                                    <i class="fas fa-filter"></i>
                                    Filters
                                </h2>
                                @if ($hasActiveFilters)
                                    <a href="{{ route('shops') }}" class="clear-filters-btn" style="color: #ffffff">
                                        <i class="fas fa-times"></i>
                                        Clear All
                                    </a>
                                @endif
                            </div>
                            <!-- Price Range Filter -->
                            <div class="filter-section">
                                <h3 class="filter-section-title">
                                    <i class="fas fa-dollar-sign"></i>
                                    Price Range
                                </h3>
                                <div class="price-range-container">
                                    <div class="price-range-title">Set your budget</div>
                                    <div id="price-slider" class="price-slider"></div>
                                    <div id="price-display" class="price-display">
                                        <span>Min: <span id="minPriceDisplay">${{ $currentPriceMin }}</span></span>
                                        <span>Max: <span id="maxPriceDisplay">${{ $currentPriceMax }}</span></span>
                                    </div>
                                </div>
                            </div>
                            <!-- Categories Filter -->
                            <div class="filter-section">
                                <h3 class="filter-section-title">
                                    <i class="fas fa-tags"></i>
                                    Categories
                                </h3>
                                <ul class="category-list">
                                    @foreach ($categories as $category)
                                        <li class="category-item">
                                            <a href="javascript:void(0)"
                                                class="category-link {{ $currentCategory == $category->slug ? 'active' : '' }}"
                                                onclick='updateSearchParams("category","{{ $category->slug }}","{{ $route }}")'>
                                                <span>{{ $category->name }}</span>
                                                <span class="category-badge">{{ $category->products->count() }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Brand Filter -->
                            <div class="filter-section">
                                <h3 class="filter-section-title">
                                    <i class="fas fa-certificate"></i>
                                    Brands
                                </h3>
                                <ul class="category-list">
                                    @foreach ($brands as $brand)
                                        <li class="category-item">
                                            <a href="javascript:void(0)"
                                                class="category-link {{ request('brand') == $brand->id ? 'active' : '' }}"
                                                onclick='updateSearchParams("brand","{{ $brand->id }}","{{ $route }}")'>
                                                <span>{{ $brand->name }}</span>
                                                <span class="category-badge">{{ $brand->products_count }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Rating Filter -->
                            <div class="filter-section">
                                <h3 class="filter-section-title">
                                    <i class="fas fa-star"></i>
                                    Rating
                                </h3>
                                <div class="rating-container">
                                    <form class="rating" id="ratingForm">
                                        <div class="rating-option">
                                            <input type="checkbox" value="5"
                                                {{ $currentRating == 5 ? 'checked' : '' }}>
                                            <span class="rating-checkmark"></span>
                                            <div class="rating-stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="rating-text">5</span>
                                        </div>
                                        <div class="rating-option">
                                            <input type="checkbox" value="4"
                                                {{ $currentRating == 4 ? 'checked' : '' }}>
                                            <span class="rating-checkmark"></span>
                                            <div class="rating-stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <span class="rating-text">4</span>
                                        </div>
                                        <div class="rating-option">
                                            <input type="checkbox" value="3"
                                                {{ $currentRating == 3 ? 'checked' : '' }}>
                                            <span class="rating-checkmark"></span>
                                            <div class="rating-stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <span class="rating-text">3</span>
                                        </div>
                                        <div class="rating-option">
                                            <input type="checkbox" value="2"
                                                {{ $currentRating == 2 ? 'checked' : '' }}>
                                            <span class="rating-checkmark"></span>
                                            <div class="rating-stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <span class="rating-text">2</span>
                                        </div>
                                        <div class="rating-option">
                                            <input type="checkbox" value="1"
                                                {{ $currentRating == 1 ? 'checked' : '' }}>
                                            <span class="rating-checkmark"></span>
                                            <div class="rating-stars">
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <span class="rating-text">1</span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Filter Button - Fixed Position -->
                    <div class="mobile-filter-floating d-md-none">
                        <button
                            class="btn btn-primary mobile-filter-btn rounded-circle mb-2 d-flex justify-content-center align-items-center"
                            style="height: 50px; width: 50px; background-color: var(--harvest-gold);" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
                            <i class="fas fa-filter"></i>

                            {{-- @if ($hasActiveFilters)
                                <span
                                    class="badge bg-light text-primary ms-2">{{ collect([$currentCategory, $currentRating, request('priceMin'), request('priceMax')])->filter()->count() }}</span>
                            @endif --}}
                        </button>
                    </div>
                    <style>
                        .mobile-filter-floating {
                            position: fixed;
                            bottom: 70px;
                            z-index: 1050;
                            border-radius: 50px;
                        }
                    </style>
                    <!-- Main Content Area -->
                    <section class="col-md-9 col-12">
                        <div class="modern-content-area">
                            <!-- Content Header -->
                            <div class="content-header">
                                <div class="search-results">
                                    Results for "<span
                                        class="search-term">{{ request()->search ?: 'All Products' }}</span>"
                                </div>
                                <div class="sort-container d-none d-md-block">
                                    <span class="sort-label">Sort by:</span>
                                    <select name="ec-select" class="sort-select"
                                        onchange='updateSearchParams("filter_products",this.value,"{{ $route }}")'>
                                        <option value="most-sold"
                                            {{ $currentFilterProducts == 'most-sold' ? 'selected' : '' }}>Most Sold
                                        </option>
                                        <option value="price-low-high"
                                            {{ $currentFilterProducts == 'price-low-high' ? 'selected' : '' }}>Price,
                                            low to high</option>
                                        <option value="price-high-low"
                                            {{ $currentFilterProducts == 'price-high-low' ? 'selected' : '' }}>Price,
                                            high to low</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Products Grid -->
                            <div class="shop-pro-content">
                                <div class="shop-pro-inner">
                                    <div class="row row-cols-lg-4 row-cols-md-2 row-cols-sm-1 cols-1">
                                        @foreach ($products as $product)
                                            <x-products.product :product="$product" :variant="'green'" :showMultipleCategories="true" />
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            {{ $products->withQueryString()->links('pagination::custom') }}
                        </div>
                    </section>
                </div>
            </div>
        </section>

        <!-- Mobile Filter Offcanvas -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas"
            aria-labelledby="filterOffcanvasLabel">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title fw-bold" id="filterOffcanvasLabel">
                    <i class="fas fa-filter me-2"></i>
                    Filters & Sort
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                <!-- Mobile Sort Section -->
                <div class="mobile-sort-section p-3 bg-light border-bottom">
                    <h6 class="mb-2 fw-bold">
                        <i class="fas fa-sort me-2"></i>
                        Sort By
                    </h6>
                    <select name="ec-select" class="form-select"
                        onchange='updateSearchParams("filter_products",this.value,"{{ $route }}")'>
                        <option value="most-sold" {{ $currentFilterProducts == 'most-sold' ? 'selected' : '' }}>Most Sold
                        </option>
                        <option value="price-low-high" {{ $currentFilterProducts == 'price-low-high' ? 'selected' : '' }}>
                            Price, low to high</option>
                        <option value="price-high-low" {{ $currentFilterProducts == 'price-high-low' ? 'selected' : '' }}>
                            Price, high to low</option>
                    </select>
                </div>

                <!-- Filter Content -->
                <div class="mobile-filter-content p-3">
                    <!-- Price Range Filter -->
                    <div class="filter-section">
                        <h3 class="filter-section-title">
                            <i class="fas fa-dollar-sign"></i>
                            Price Range
                        </h3>
                        <div class="price-range-container">
                            <div class="price-range-title">Set your budget</div>
                            <div id="mobile-price-slider" class="price-slider"></div>
                            <div id="mobile-price-display" class="price-display">
                                <span>Min: <span id="mobileminPriceDisplay">${{ $currentPriceMin }}</span></span>
                                <span>Max: <span id="mobilemaxPriceDisplay">${{ $currentPriceMax }}</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Filter -->
                    <div class="filter-section">
                        <h3 class="filter-section-title">
                            <i class="fas fa-tags"></i>
                            Categories
                        </h3>
                        <ul class="category-list">
                            @foreach ($categories as $category)
                                <li class="category-item">
                                    <a href="javascript:void(0)"
                                        class="category-link {{ $currentCategory == $category->slug ? 'active' : '' }}"
                                        onclick='updateSearchParams("category","{{ $category->slug }}","{{ $route }}")'>
                                        <span>{{ $category->name }}</span>
                                        <span class="category-badge">{{ $category->products->count() }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Brand Filter -->
                    <div class="filter-section">
                        <h3 class="filter-section-title">
                            <i class="fas fa-certificate"></i>
                            Brands
                        </h3>
                        <ul class="category-list">
                            @foreach ($brands as $brand)
                                <li class="category-item">
                                    <a href="javascript:void(0)"
                                        class="category-link {{ request('brand') == $brand->id ? 'active' : '' }}"
                                        onclick='updateSearchParams("brand","{{ $brand->id }}","{{ $route }}")'>
                                        <span>{{ $brand->name }}</span>
                                        <span class="category-badge">{{ $brand->products_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Rating Filter -->
                    <div class="filter-section">
                        <h3 class="filter-section-title">
                            <i class="fas fa-star"></i>
                            Rating
                        </h3>
                        <div class="rating-container">
                            <form class="rating" id="mobileRatingForm">
                                <div class="rating-option">
                                    <input type="checkbox" value="5" {{ $currentRating == 5 ? 'checked' : '' }}>
                                    <span class="rating-checkmark"></span>
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-text">5</span>
                                </div>
                                <div class="rating-option">
                                    <input type="checkbox" value="4" {{ $currentRating == 4 ? 'checked' : '' }}>
                                    <span class="rating-checkmark"></span>
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-text">4</span>
                                </div>
                                <div class="rating-option">
                                    <input type="checkbox" value="3" {{ $currentRating == 3 ? 'checked' : '' }}>
                                    <span class="rating-checkmark"></span>
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-text">3</span>
                                </div>
                                <div class="rating-option">
                                    <input type="checkbox" value="2" {{ $currentRating == 2 ? 'checked' : '' }}>
                                    <span class="rating-checkmark"></span>
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-text">2</span>
                                </div>
                                <div class="rating-option">
                                    <input type="checkbox" value="1" {{ $currentRating == 1 ? 'checked' : '' }}>
                                    <span class="rating-checkmark"></span>
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-text">1</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="offcanvas-footer p-3 border-top bg-light">
                    <div class="row g-2">
                        @if ($hasActiveFilters)
                            <div class="col-6">
                                <a href="{{ route('shops') }}" style="background: red; color: white;"
                                    class="btn btn-danger w-100 text-light">
                                    <i class="fas fa-times me-2"></i>
                                    Clear All
                                </a>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary w-100"
                                    style="background-color: var(--harvest-gold);" data-bs-dismiss="offcanvas">
                                    <i class="fas fa-check me-2"></i>
                                    Apply Filters
                                </button>
                            </div>
                        @else
                            <div class="col-12">
                                <button type="button" class="btn btn-primary w-100"
                                    style="background-color: var(--harvest-gold);" data-bs-dismiss="offcanvas">
                                    <i class="fas fa-check me-2"></i>
                                    Apply Filters
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>

    <script>
        var shopUrl = "{{ route('shops') }}";
        var currentPriceMin = {{ $currentPriceMin }};
        var currentPriceMax = {{ $currentPriceMax }};

        $(document).ready(function() {
            // Initialize price slider with current values
            $("#price-slider").slider({
                range: true,
                min: 0,
                max: 1000,
                values: [currentPriceMin, currentPriceMax],
                slide: function(event, ui) {
                    $("#minPriceDisplay").text('$' + ui.values[0]);
                    $("#maxPriceDisplay").text('$' + ui.values[1]);
                },
                stop: function(event, ui) {
                    updateSearchParams('', '', shopUrl, ui.values[0], ui.values[1]);
                }
            });

            // Display initial price values
            $("#minPriceDisplay").text('$' + $("#price-slider").slider("values", 0));
            $("#maxPriceDisplay").text('$' + $("#price-slider").slider("values", 1));

            // Rating filter functionality
            $('#ratingForm input[type="checkbox"]').on('change', function() {
                if ($(this).is(':checked')) {
                    updateSearchParams("ratings", $(this).val(), shopUrl);
                } else {
                    removeSearchParam("ratings", shopUrl);
                }
            });

            // Mobile price slider initialization
            $("#mobile-price-slider").slider({
                range: true,
                min: 0,
                max: 1000,
                values: [currentPriceMin, currentPriceMax],
                slide: function(event, ui) {
                    $("#mobileminPriceDisplay").text('$' + ui.values[0]);
                    $("#mobilemaxPriceDisplay").text('$' + ui.values[1]);
                },
                stop: function(event, ui) {
                    updateSearchParams('', '', shopUrl, ui.values[0], ui.values[1]);
                }
            });

            // Display initial mobile price values
            $("#mobileminPriceDisplay").text('$' + $("#mobile-price-slider").slider("values", 0));
            $("#mobilemaxPriceDisplay").text('$' + $("#mobile-price-slider").slider("values", 1));

            // Mobile rating filter functionality
            $('#mobileRatingForm input[type="checkbox"]').on('change', function() {
                if ($(this).is(':checked')) {
                    updateSearchParams("ratings", $(this).val(), shopUrl);
                } else {
                    removeSearchParam("ratings", shopUrl);
                }
            });

            // Auto-close offcanvas when filter is applied (optional)
            $('.category-link, .rating-option input').on('click change', function() {
                // Add a small delay before closing to show the selection
                setTimeout(function() {
                    if (window.innerWidth <= 767) {
                        // Optional: Auto-close on mobile after selection
                        // var offcanvasElement = document.getElementById('filterOffcanvas');
                        // var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                        // if (offcanvas) offcanvas.hide();
                    }
                }, 100);
            });
        });

        function updateSearchParams(searchParam, searchValue, route, priceMin, priceMax) {
            var url;

            if (window.location.pathname !== "/shops") {
                url = new URL(route);
            } else {
                url = new URL(window.location.href);
            }

            if (searchParam) {
                url.searchParams.set(searchParam, searchValue);
            }

            // Set the price range parameters if provided
            if (priceMin !== undefined) {
                url.searchParams.set('priceMin', priceMin);
            }

            if (priceMax !== undefined) {
                url.searchParams.set('priceMax', priceMax);
            }

            // Preserve existing parameters
            var existingParams = new URLSearchParams(window.location.search);
            existingParams.forEach(function(value, key) {
                if (key !== searchParam && key !== 'priceMin' && key !== 'priceMax') {
                    url.searchParams.set(key, value);
                }
            });

            window.location = url.href;
        }

        function removeSearchParam(searchParam, route) {
            var url;

            if (window.location.pathname !== "/shops") {
                url = new URL(route);
            } else {
                url = new URL(window.location.href);
            }

            var existingParams = new URLSearchParams(window.location.search);
            existingParams.delete(searchParam);

            var newUrl = url.href.split('?')[0] + '?' + existingParams.toString();
            window.location = newUrl;
        }
    </script>
@endsection
