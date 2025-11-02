@extends('layouts.app')
@section('title', $shop->name . ' | Shop on Royalit E-commerce')
@section('meta_description',
    Str::limit(
    $shop->description ??
    ($shop->short_description ??
    'Shop ' .
    $shop->name .
    ' on
    Royalit E-commerce. Quality products, great deals, and excellent customer service.'),
    160,
    ))
@section('meta_keywords', $shop->name . ', shop, store, ecommerce, online shopping, Royalit, ' . $shop->city . ', ' .
    $shop->state)
@section('canonical_url', route('store_front', $shop->slug))
@section('meta_og')
    <meta property="og:title" content="{{ $shop->name }} | Shop on Royalit E-commerce">
    <meta property="og:description"
        content="{{ Str::limit($shop->description ?? ($shop->short_description ?? 'Shop ' . $shop->name . ' on Royalit E-commerce. Quality products, great deals, and excellent customer service.'), 160) }}">
    <meta property="og:image" content="{{ Storage::url($shop->logo) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection
@section('meta_twitter')
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $shop->name }} | Shop on Royalit E-commerce">
    <meta name="twitter:description"
        content="{{ Str::limit($shop->description ?? ($shop->short_description ?? 'Shop ' . $shop->name . ' on Royalit E-commerce. Quality products, great deals, and excellent customer service.'), 160) }}">
    <meta name="twitter:image" content="{{ Storage::url($shop->logo) }}">
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/store_front.css') }}">
@endsection

@section('content')
    <x-app.header />

    <!-- Cover Photo Section -->
    <div class="cover-photo-container">
        @php
            $bannerPath = $shop->banner;
            $extension = strtolower(pathinfo($bannerPath, PATHINFO_EXTENSION));
            $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
            $imageExtensions = ['jpeg', 'png', 'webp', 'jpg', 'gif', 'svg', 'svg+xml', 'avif'];
            $isVideo = in_array($extension, $videoExtensions);
            $isImage = in_array($extension, $imageExtensions);
        @endphp

        @if ($bannerPath)
            @if ($isVideo)
                <video src="{{ Storage::url($bannerPath) }}" autoplay muted loop></video>
            @elseif ($isImage)
                <img class="cover-photo" src="{{ Storage::url($bannerPath) }}" alt="{{ $shop->name }} cover photo">
            @else
                <div class="cover-placeholder">Invalid banner format</div>
            @endif
        @else
            <div class="cover-placeholder">No banner available</div>
        @endif
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Left Sidebar - Brand Information -->
            <div class="col-12 col-md-12 col-lg-3 mb-4">
                <div class="brand-sidebar">
                    <!-- Brand Logo and Name -->
                    <div class="brand-header text-center mb-4">
                        <img class="brand-logo" src="{{ Storage::url($shop->logo) }}" alt="{{ $shop->name }} logo">
                        <h2 class="brand-name mt-3">{{ $shop->name }}</h2>
                        <p class="brand-tagline text-muted">
                            {{ Illuminate\Support\Str::limit($shop->short_description, 200) }}
                        </p>
                    </div>

                    <!-- Contact Information -->
                    <div class="brand-info-card">
                        <h5 class="info-title"><i class="fas fa-info-circle me-2"></i>Shop Information</h5>
                        <ul class="info-list">
                            <li>
                                <i class="fas fa-user me-2"></i>
                                <span>Owner: {{ $shop->user->name }}</span>
                            </li>
                            <li>
                                <i class="fas fa-building me-2"></i>
                                <span>Company: {{ $shop->company_name }}</span>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <span> {{ $shop->city }}, {{ $shop->state }}</span>
                            </li>
                            <li>
                                <i class="fas fa-phone me-2"></i>
                                <span>{{ $shop->phone }}</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope me-2"></i>
                                <span>{{ $shop->email }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Stats -->
                    <div class="brand-stats-card mb-4">
                        <div class="stat-item">
                            <div class="stat-value">{{ number_format(Sohoj::average_rating($shop->ratings), 1) }}</div>
                            <div class="stat-label">Average Rating</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $shop->orders->count() }}</div>
                            <div class="stat-label">Total Sales</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $shop->ratings->count() }}</div>
                            <div class="stat-label">Reviews</div>
                        </div>
                    </div>

                    <!-- Follow/Message Buttons -->
                    <div class="brand-actions mb-4">
                        @auth
                            <form action="{{ route('follow', $shop) }}" method="post">
                                @csrf
                                @php
                                    $follow = auth()->user()->follows($shop);
                                @endphp
                                <button class="add-to-cart-btn">
                                    <i class="fas fa-user-plus me-2 py-2 "></i>
                                    {{ $follow ? 'Unfollow Shop' : 'Follow Shop' }}
                                </button>
                            </form>
                        @else
                            <a class="add-to-cart-btn py-2 text-white" href="{{ route('login') }}">
                                <i class="fas fa-user-plus me-2"></i>
                                Follow Shop
                            </a>
                        @endauth

                        <a href="{{ route('massage.create', $shop->id) }}" class="btn btn-block btn-message">
                            <i class="fas fa-envelope me-2"></i>
                            Contact Seller
                        </a>
                    </div>

                    <!-- Social Links -->
                    @if (!empty($shop->social_links) && (isset($shop->social_links['tiktok']) || isset($shop->social_links['instagram'])))
                        <div class="brand-social-card">
                            <h5 class="social-title">Follow Us</h5>
                            <div class="social-links">
                                @if (isset($shop->social_links['tiktok']) && $shop->social_links['tiktok'])
                                    <a href="{{ $shop->social_links['tiktok'] }}" target="_blank" class="social-link">
                                        <i class="fab fa-tiktok fa-2xl"></i>
                                    </a>
                                @endif
                                @if (isset($shop->social_links['instagram']) && $shop->social_links['instagram'])
                                    <a href="{{ $shop->social_links['instagram'] }}" target="_blank" class="social-link">
                                        <i class="fab fa-instagram fa-2xl"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="col-12 col-md-12 col-lg-9">
                <!-- Navigation Tabs with Search Box -->
                <div class="brand-content-tabs">
                    <div class="tabs-header">
                        <ul class="nav nav-tabs" id="shopTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                    type="button" role="tab">
                                    <i class="fas fa-home me-2"></i>Home
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products"
                                    type="button" role="tab">
                                    <i class="fas fa-box me-2"></i>Products
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about"
                                    type="button" role="tab">
                                    <i class="fas fa-info-circle me-2"></i>About
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                    type="button" role="tab">
                                    <i class="fas fa-star me-2"></i>Reviews
                                </button>
                            </li>
                        </ul>

                        <!-- Search Box moved to right side -->
                        <div class="search-container">
                            <form action="{{ route('store_front', $shop->slug) }}" method="get" class="search-form">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search products...">
                                    <button type="submit" class="btn btn-search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab-content" id="shopTabsContent">
                        <!-- Home Tab -->
                        <div class="tab-pane fade show active" id="home" role="tabpanel">
                            @if (count($shop->products) > 0)
                                @php
                                    $products = $shop->products->where('featured', 1)->chunk(4);
                                    $bannerToggle = false; // Flag to alternate between your two banner styles
                                @endphp

                                @foreach ($products as $productGroup)
                                    <!-- Product Group (4 products) -->
                                    <div class="content-card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach ($productGroup as $product)
                                                    <x-products.product :product="$product" />
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Banner after each product group -->
                                    @if ($bannerToggle)
                                        <!-- First Banner Style -->
                                        @if ($shop->category1)
                                            <div class="row mb-4">
                                                <div class="col-lg-12 ps-0 d-flex mid-bn me-5 margin-left"
                                                    style="height: 180px; overflow:hidden;position:relative;background-size: cover; background-image: url({{ $shop->image1 ? Storage::url($shop->image1) : asset('assets/img/store_front/bnwatch.png') }})">
                                                    <div class="p-4 ms-4">
                                                        <p style="font-size:14px ;color: #fff !important;">
                                                            {{ $shop->category1 ? $shop->category1 : 'Please Category Add' }}
                                                        </p>
                                                        <h4 style="font-size:1.2rem;color: #fff !important;">
                                                            {{ $shop->title1 ? $shop->title1 : 'Please Add title' }}
                                                        </h4>
                                                        <a class="mid-btn mt-2 btn btn-dark"
                                                            href="{{ $shop->link1 }}"><span style="font-size: 10px">View
                                                                Collection</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <!-- Second Banner Style -->
                                        @if ($shop->category2)
                                            <div class="row mb-4">
                                                <div class="col-lg-12 mid-bn"
                                                    style="height: 180px; overflow: hidden; background-size: cover;background-image: url({{ $shop->image2 ? Storage::url($shop->image2) : asset('assets/img/store_front/bnbag.png') }})">
                                                    <div class="p-4 ms-4">
                                                        <p style="font-size:14px ;color: #fff !important;">
                                                            {{ $shop->category2 ? $shop->category2 : 'Please Add Category' }}
                                                        </p>
                                                        <h4 style="font-size:1.2rem;color: #fff !important;">
                                                            {{ $shop->title2 ? $shop->title2 : 'Please add Title' }}
                                                        </h4>
                                                        <a class="mid-btn mt-2 btn btn-dark"
                                                            href="{{ $shop->link2 }}"><span style="font-size: 10px">View
                                                                Collection</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    @php $bannerToggle = !$bannerToggle; @endphp
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No products available</h5>
                                </div>
                            @endif
                        </div>

                        <!-- Products Tab -->
                        <div class="tab-pane fade" id="products" role="tabpanel">
                            <div class="content-card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>All Products</h4>
                                    <div class="product-filters">
                                        <select class="form-select form-select-sm">
                                            <option>Sort by</option>
                                            <option>Price: Low to High</option>
                                            <option>Price: High to Low</option>
                                            <option>Newest</option>
                                            <option>Popular</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if (count($shop->products) > 0)
                                        <div class="row">
                                            @foreach ($shop->products as $product)
                                                <x-products.product :product="$product" />
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No products available</h5>
                                            <p class="text-muted">This shop hasn't added any products yet.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- About Tab -->
                        <div class="tab-pane fade" id="about" role="tabpanel">
                            <div class="content-card mb-4">
                                <div class="card-header">
                                    <h4>About {{ $shop->name }}</h4>
                                </div>
                                <div class="card-body">
                                    {!! $shop->description !!}
                                </div>
                            </div>

                            @if ($shop->shopPolicy)
                                <div class="content-card">
                                    <div class="card-header">
                                        <h4>Shop Policies</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="policy-item">
                                                    <div class="policy-icon text-danger">
                                                        <i class="fas fa-ban"></i>
                                                    </div>
                                                    <div class="policy-details">
                                                        <h6>Cancellation Policy</h6>
                                                        <p>{{ $shop->shopPolicy->cancellation }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="policy-item">
                                                    <div class="policy-icon text-warning">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </div>
                                                    <div class="policy-details">
                                                        <h6>Return & Exchange</h6>
                                                        <p>{{ $shop->shopPolicy->return_exchange }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="policy-item">
                                                    <div class="policy-icon text-success">
                                                        <i class="fas fa-credit-card"></i>
                                                    </div>
                                                    <div class="policy-details">
                                                        <h6>Payment Options</h6>
                                                        <p>{{ $shop->shopPolicy->payment_option }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="policy-item">
                                                    <div class="policy-icon text-primary">
                                                        <i class="fas fa-truck"></i>
                                                    </div>
                                                    <div class="policy-details">
                                                        <h6>Delivery Information</h6>
                                                        <p>{{ $shop->shopPolicy->delivery }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="content-card">
                                <div class="card-header">
                                    <h4>Customer Reviews</h4>
                                    <div class="rating-summary">
                                        <div class="average-rating">
                                            {{ number_format(Sohoj::average_rating($shop->ratings), 1) }}
                                            <input name="rating" type="number"
                                                value="{{ Sohoj::average_rating($shop->ratings) }}"
                                                class="rating published_rating" data-size="xs" readonly>
                                        </div>
                                        <div class="total-reviews">{{ $shop->ratings->count() }} reviews</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($shop->ratings()->count() > 0)
                                        @foreach ($shop->ratings as $rating)
                                            <div class="review-item mb-4">
                                                <div class="review-header">
                                                    <img class="review-avatar"
                                                        src="{{ asset('assets/img/single_product/person.png') }}"
                                                        alt="Reviewer">
                                                    <div class="reviewer-info">
                                                        <h6>{{ $rating->name }}</h6>
                                                        <div class="review-date">
                                                            {{ $rating->created_at->format('M d, Y') }}</div>
                                                    </div>
                                                    <div class="review-rating">
                                                        <input name="rating" type="number"
                                                            value="{{ $rating->rating }}" class="rating published_rating"
                                                            data-size="xs" readonly>
                                                    </div>
                                                </div>
                                                <div class="review-content">
                                                    <p>{{ $rating->review }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No reviews yet</h5>
                                            <p class="text-muted">Be the first to review this shop!</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Modal -->
    <div class="modal fade" id="massageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Send Message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('massage.store', $shop) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" required name="email" id="email"
                                aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="massage">Message</label>
                            <textarea class="form-control" rows="5" name="massage" id="massage"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>

    <script>
        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });

            // Remove active class from all tabs
            document.querySelectorAll('.nav-tab-fb').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected tab content
            document.getElementById(tabName + '-tab').style.display = 'block';

            // Add active class to clicked tab
            event.target.classList.add('active');
        }

        // Banner image loading with fallback
        document.addEventListener('DOMContentLoaded', function() {
            const bannerImage = document.querySelector('.cover-photo');

            if (bannerImage) {
                // Set initial placeholder
                bannerImage.src = '{{ asset('placeholder/shop_banner.webp') }}';

                // Try to load the actual banner image
                const actualBannerSrc =
                    '{{ $shop->banner ? Storage::url($shop->banner) : asset('placeholder/shop_banner.webp') }}';

                if (actualBannerSrc && actualBannerSrc !== '{{ asset('placeholder/shop_banner.webp') }}') {
                    const tempImage = new Image();

                    tempImage.onload = function() {
                        // Actual image loaded successfully
                        bannerImage.src = actualBannerSrc;
                        bannerImage.classList.add('loaded');
                    };

                    tempImage.onerror = function() {
                        // Actual image failed to load, keep placeholder
                        bannerImage.classList.add('error');
                        console.log('Banner image failed to load, using placeholder');
                    };

                    // Start loading the actual image
                    tempImage.src = actualBannerSrc;
                } else {
                    // No custom banner, use placeholder
                    bannerImage.classList.add('placeholder');
                }
            }

            // Add loading animation
            bannerImage.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        });
    </script>
@endsection
