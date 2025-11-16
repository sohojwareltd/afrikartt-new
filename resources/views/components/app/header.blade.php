<header class="main-header shadow-sm">
    <div class="header-top mt-0 d-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                {{-- Social Icons --}}
                <a href="{{ Settings::setting('social_fb_link') }}" class="text-light me-2" title="Facebook"><i
                        class="fab fa-facebook-f"></i></a>
                <a href="{{ Settings::setting('social_inst_link') }}" class="text-light me-2" title="Instagram"><i
                        class="fab fa-instagram"></i></a>
                <a href="{{ Settings::setting('social_twitter_link') }}" class="text-light me-2" title="Twitter"><i
                        class="fab fa-twitter"></i></a>
                <a href="{{ Settings::setting('social_linkedin') }}" class="text-light me-2" title="LinkedIn"><i
                        class="fab fa-linkedin-in"></i></a>
            </div>

            {{-- Announcement Marquee --}}
            {{-- <div class="announcement-wrapper overflow-hidden position-relative flex-grow-1 ms-3">
                <div class="announcement-text">
                    {{ Settings::setting('site_announcement') ? Settings::setting('site_announcement') : 'Royalit Grand Opening Is Here! Enjoy 15% OFF Across Our Entire Collection of Handcrafted African Goods.' }}
                </div>
            </div> --}}
            <div class="">
                <img src="{{ Settings::setting('site_nav_image') }}" style="width: 100%;" alt="brands-top-strip">
            </div>
        </div>
    </div>

    @php
        use Illuminate\Support\Facades\Cache;
        use App\Models\Prodcat;
        $wishlist = session()->get('wishlist', []);

        // Fetch categories for the search bar dropdown and category nav
        $categories = Cache::remember('header_categories', 3600, function () {
            return Prodcat::whereNull('parent_id')->orderBy('role', 'asc')->with('childrens')->get();
        });
    @endphp

    <div class="header-main py-3 bg-white" style="background-color: var(--bg-light) !important;">
        <div class="container py-2 px-3">

            {{-- ================================================================= --}}
            {{-- DESKTOP HEADER LAYOUT (Visible from md breakpoint and up) --}}
            {{-- ================================================================= --}}
            <div class="row align-items-center g-3 d-none d-md-flex">

                {{-- Logo Column --}}
                <div class="col-auto">
                    <a href="{{ route('homepage') }}" class="navbar-brand">
                        <img src="{{ Settings::setting('site_logo') }}" alt="Royalit" style="height: 48px;">
                    </a>
                </div>

                {{-- Country Selector - Desktop --}}
                <div class="col-auto">
                    <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                        title="Select Country" data-bs-target="#countryRegionModal" aria-label="Select Country">
                        <span class="country-flag-slot"><i class="fas fa-globe-africa"></i></span>
                    </button>
                </div>

                {{-- Search Bar (Includes Categories Dropdown) --}}
                <div class="col-md">
                    <form action="{{ route('shops') }}" method="get">
                        <div class="input-group">
                            {{-- <select class="form-select border-0 bg-black h-auto" name="category"
                                style="max-width: 200px; color: var(--bg-light) !important;">
                                <option value="" class="text-dark">All Categories</option>
                                @foreach ($categories as $category)
                                    @if ($category->childrens->count())
                                        <optgroup label="{{ $category->name }}">
                                            @foreach ($category->childrens as $child)
                                                <option value="{{ $child->slug }}" class="text-dark"
                                                    @if (request('category') == $child->slug) selected @endif>
                                                    {{ $child->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <option value="{{ $category->slug }}"
                                            @if (request('category') == $category->slug) selected @endif class="text-dark">
                                            {{ $category->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select> --}}

                            <input type="text" class="form-control h-auto" name="search"
                                placeholder="Search products..." value="{{ request('search') }}">

                            <button style="border-top-right-radius: 3px; border-bottom-right-radius: 3px;"
                                class="btn btn-success px-3 h-auto text-light" type="submit" title="Search">
                                <i class="fas fa-search me-2"></i> <span class="d-none d-md-inline">Search</span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Action Icons (Desktop Only) --}}
                <div class="col-auto">
                    <div class="d-flex align-items-center gap-2">

                        {{-- Wishlist Icon --}}
                        <a href="{{ route('wishlist.index') }}" class="header-icon-btn position-relative"
                            title="Wishlist">
                            <i class="far fa-heart"></i>
                            @if (count($wishlist) > 0)
                                <span class="header-icon-badge">{{ count($wishlist) }}</span>
                            @endif
                        </a>

                        {{-- Account/Login Dropdown --}}
                        @auth
                            <div class="dropdown">
                                <a class="header-icon-btn user-dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                    title="Account">
                                    <i class="fas fa-user-circle"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu">
                                    @if (Auth()->user()->role_id == 1)
                                        <li><a class="dropdown-item" href="{{ url('admin') }}"><i
                                                    class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</a></li>
                                    @elseif (Auth()->user()->role_id == 2)
                                        <li><a class="dropdown-item" href="{{ route('user.dashboard') }}"><i
                                                    class="fas fa-user me-2"></i>Profile</a></li>
                                    @endif
                                    @if (Auth()->user()->role_id == 3)
                                        <li><a class="dropdown-item" href="{{ url('vendor') }}"><i
                                                    class="fas fa-store me-2"></i>Vendor Profile</a></li>
                                    @endif
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </a>
                                        <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST"
                                            class="d-none">@csrf</form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="dropdown">
                                <a class="header-icon-btn user-dropdown-toggle signup-btn px-2 py-1 border rounded-pill"
                                    href="#" data-bs-toggle="dropdown" title="Login">
                                    <i class="fas fa-key me-2"></i>
                                    <span>Log in</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('login') }}"><i
                                                class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register') }}"><i
                                                class="fas fa-user-plus me-2"></i>Register</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('vendor.create') }}"><i
                                                class="fas fa-store me-2"></i>Register as Vendor</a></li>
                                </ul>
                            </div>
                        @endauth

                        {{-- Cart Icon --}}
                        <a href="#" class="header-icon-btn position-relative" data-bs-toggle="offcanvas"
                            data-bs-target="#cartOffcanvas" title="Cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="header-icon-badge">{{ Cart::content()->count() }}</span>
                        </a>

                        {{-- Contact Us Icon --}}
                        <a href="{{ route('contact') }}" class="header-icon-btn position-relative"
                            title="Contact Us">
                            <i class="fa fa-question"></i>
                        </a>
                    </div>
                </div>
            </div>


            {{-- ================================================================= --}}
            {{-- MOBILE HEADER LAYOUT (Hidden from md breakpoint and up) --}}
            {{-- ================================================================= --}}
            <div class="d-md-none">
                {{-- Mobile Row 1: Logo and Icons --}}
                <div class="row align-items-center g-2">

                    {{-- Logo Column --}}
                    <div class="col-auto">
                        <a href="{{ route('homepage') }}" class="navbar-brand p-0">
                            <img src="{{ Settings::setting('site_logo') }}" alt="Royalit" style="height: 40px;">
                        </a>
                    </div>

                    {{-- Mobile Menu/Account Toggles and Icons (Pushed to the right) --}}
                    <div class="col d-flex justify-content-end align-items-center gap-2">

                        {{-- Country Selector --}}
                        <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal"
                            title="Select Country" data-bs-target="#countryRegionModal" aria-label="Select Country">
                            <span class="country-flag-slot"><i class="fas fa-globe-africa"></i></span>
                        </button>

                        {{-- Wishlist Icon --}}
                        <a href="{{ route('wishlist.index') }}" class="header-icon-btn position-relative"
                            title="Wishlist">
                            <i class="far fa-heart"></i>
                            @if (count($wishlist) > 0)
                                <span class="header-icon-badge">{{ count($wishlist) }}</span>
                            @endif
                        </a>

                        {{-- Cart Icon --}}
                        <a href="#" class="header-icon-btn position-relative" data-bs-toggle="offcanvas"
                            data-bs-target="#cartOffcanvas" title="Cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="header-icon-badge">{{ Cart::content()->count() }}</span>
                        </a>

                        {{-- Mobile Menu Toggle --}}
                        <button class="btn btn-sm" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#mobileMenu" title="Menu">
                            <i class="fas fa-bars fs-4"></i>
                        </button>
                    </div>
                </div>

                {{-- Mobile Row 2: Search Bar with Categories (Full Width) --}}
                <div class="row mt-2">
                    <div class="col-12">
                        <form action="{{ route('shops') }}" method="get">
                            <div class="input-group overflow-hidden shadow-sm">
                                {{-- <select class="form-select border-start border-end h-auto" name="category"
                                    style="max-width: 130px;">
                                    <option value="" class="text-dark">All Categories</option>
                                    @foreach ($categories as $category)
                                        @if ($category->childrens->count())
                                            <optgroup label="{{ $category->name }}">
                                                @foreach ($category->childrens as $child)
                                                    <option value="{{ $child->slug }}" class="text-dark"
                                                        @if (request('category') == $child->slug) selected @endif>
                                                        {{ $child->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @else
                                            <option value="{{ $category->slug }}"
                                                @if (request('category') == $category->slug) selected @endif class="text-dark">
                                                {{ $category->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select> --}}

                                <input type="text" class="form-control border-0 h-auto" name="search"
                                    placeholder="Search products..." value="{{ request('search') }}">

                                {{-- Categories Dropdown is now included in mobile search --}}

                                <button class="btn btn-success h-auto" type="submit" title="Search"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="container-fluid py-2 px-3" style="background-color: #415f4247 !important;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 px-0">
                    <div class="category-scroll-container">
                        <div class="d-flex gap-2 category-scroll">
                            @foreach ($categories as $category)
                                @if ($category->childrens->count())
                                    <button type="button"
                                        class="category-btn flex-shrink-0 @if (request('category') == $category->slug) active @endif"
                                        data-bs-toggle="modal" data-bs-target="#categoryModal-{{ $category->id }}">
                                        {{ $category->name }}
                                    </button>

                                    <div class="modal fade category-modal" id="categoryModal-{{ $category->id }}"
                                        tabindex="-1" aria-hidden="true">
                                        <div
                                            class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content rounded-3 border-0 shadow-lg">
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title fw-semibold">{{ $category->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0">
                                                    <div class="list-group list-group-flush">
                                                        <a href="{{ route('shops', ['category' => $category->slug]) }}"
                                                            class="list-group-item list-group-item-action py-3 fw-semibold">
                                                            All {{ $category->name }}
                                                        </a>
                                                        @foreach ($category->childrens as $child)
                                                            <a href="{{ route('shops', ['category' => $child->slug]) }}"
                                                                class="list-group-item list-group-item-action py-3 @if (request('category') == $child->slug) active @endif">
                                                                {{ $child->name }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('shops', ['category' => $category->slug]) }}"
                                        class="category-btn flex-shrink-0 @if (request('category') == $category->slug) active @endif">
                                        {{ $category->name }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <nav class="navbar navbar-expand-md navbar-light bg-light shadow">
        <div class="container">
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('homepage') }}">Home</a></li>

                    {{-- Categories Mega Menu --}}
                    <li class="nav-item mega-menu-wrapper position-relative">
                        <a class="nav-link d-flex align-items-center" href="#" id="categoriesMenuToggle">
                            Categories
                            <i class="fas fa-chevron-down ms-2 mega-menu-icon"></i>
                        </a>

                        {{-- Mega Menu Dropdown --}}
                        <div class="mega-menu" id="categoriesMegaMenu">
                            <button class="mega-menu-close d-lg-none" aria-label="Close menu">
                                <i class="fas fa-times"></i>
                            </button>

                            <div class="container-fluid">
                                <div class="row g-4">
                                    @foreach ($categories as $category)
                                        <div class="col-lg-3 col-6 mega-menu-column">
                                            @if ($category->childrens->count())
                                                {{-- Parent with Children --}}
                                                <h6 class="mega-menu-parent">
                                                    <a href="{{ route('shops', ['category' => $category->slug]) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </h6>
                                                <ul class="mega-menu-list">
                                                    @foreach ($category->childrens as $child)
                                                        <li>
                                                            <a
                                                                href="{{ route('shops', ['category' => $child->slug]) }}">
                                                                {{ $child->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                {{-- Parent without Children --}}
                                                <h6 class="mega-menu-parent">
                                                    <a href="{{ route('shops', ['category' => $category->slug]) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </h6>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Mobile Overlay Backdrop --}}
                        <div class="mega-menu-backdrop d-lg-none" id="megaMenuBackdrop"></div>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('shops') }}">Products</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('shops', ['filter_products' => 'trending']) }}">Trending</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('shops', ['filter_products' => 'most-popular']) }}">Best Seller</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/vendors') }}">Shops</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('faqs') }}">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('blogs') }}">Blogs</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('vendor.create') }}">Become a Vendor</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('homepage') }}">Home</a></li>

                {{-- Categories Accordion --}}
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse"
                        href="#categoriesCollapse" role="button" aria-expanded="false"
                        aria-controls="categoriesCollapse">
                        Categories
                        <i class="fas fa-chevron-down ms-2"></i>
                    </a>
                    <div class="collapse" id="categoriesCollapse">
                        <div class="mobile-categories-wrapper">
                            @foreach ($categories as $category)
                                <div class="mobile-category-group">
                                    @if ($category->childrens->count())
                                        {{-- Parent with Children --}}
                                        <h6 class="mobile-category-parent">
                                            <a href="{{ route('shops', ['category' => $category->slug]) }}">
                                                {{ $category->name }}
                                            </a>
                                        </h6>
                                        <ul class="mobile-category-list">
                                            @foreach ($category->childrens as $child)
                                                <li>
                                                    <a href="{{ route('shops', ['category' => $child->slug]) }}">
                                                        {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{-- Parent without Children --}}
                                        <h6 class="mobile-category-parent">
                                            <a href="{{ route('shops', ['category' => $category->slug]) }}">
                                                {{ $category->name }}
                                            </a>
                                        </h6>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </li>

                <li class="nav-item"><a class="nav-link" href="{{ route('shops') }}">Products</a></li>
                <li class="nav-item"><a class="nav-link"
                        href="{{ route('shops', ['filter_products' => 'trending']) }}">Trending</a></li>
                <li class="nav-item"><a class="nav-link"
                        href="{{ route('shops', ['filter_products' => 'most-popular']) }}">Best Seller</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/vendors') }}">Vendors</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('faqs') }}">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('blogs') }}">Blogs</a></li>

                {{-- Mobile Auth Links --}}
                @auth
                    <hr class="mt-3">

                    @if (Auth()->user()->role_id == 1)
                        <li class="nav-item mt-2"><a class="btn btn-primary d-block" href="{{ url('admin') }}"><i
                                    class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</a></li>
                    @elseif (Auth()->user()->role_id == 2)
                        <li class="nav-item mt-2"><a class="btn btn-primary d-block"
                                href="{{ route('user.dashboard') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                    @endif
                    @if (Auth()->user()->role_id == 3)
                        <li class="nav-item mt-2"><a class="btn btn-primary d-block" href="{{ url('vendor') }}"><i
                                    class="fas fa-store me-2"></i>Vendor Profile</a></li>
                    @endif
                    <li class="nav-item mt-2">
                        <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="d-grid">
                            @csrf
                            <button class="btn btn-secondary d-block"><i class="fas fa-key me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                @else
                    <hr class="mt-3">
                    <li class="nav-item"><a class="btn btn-primary d-block" href="{{ route('login') }}">Login </a></li>
                    <li class="nav-item mt-2"><a class="btn btn-primary d-block" href="{{ route('register') }}">Register
                        </a></li>
                    <li class="nav-item mt-2"><a class="btn btn-secondary d-block" href="{{ route('vendor.create') }}">
                            <i class="fas fa-store me-2"></i> Become a Vendor </a></li>
                @endauth
            </ul>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel">
                <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if (Cart::count() > 0)
                <div class="cart-items">
                    @foreach (Cart::content() as $product)
                        @php
                            $sku = null;
                            $skuImage = $product->model->image;
                            if (isset($product->options['sku_id']) && $product->options['sku_id']) {
                                $sku = \App\Models\Sku::with('attributeValues.attribute')->find(
                                    $product->options['sku_id'],
                                );
                                if ($sku && $sku->image) {
                                    $skuImage = $sku->image;
                                }
                            }
                        @endphp
                        <div class="cart-item d-flex align-items-center mb-3 p-3 border rounded">
                            <img src="{{ Storage::url($skuImage) }}" alt="{{ $product->name }}" class="me-3"
                                style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $product->name }}</h6>
                                @if ($sku)
                                    <p class="mb-1 text-muted" style="font-size: 0.75rem;">
                                        @foreach ($sku->attributeValues as $attrValue)
                                            {{ $attrValue->attribute->name ?? 'Unknown' }}:
                                            {{ $attrValue->getDisplayName() }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </p>
                                @endif
                                <p class="mb-1 text-muted">Qty: {{ $product->qty }}</p>
                                <p class="mb-0 fw-bold">${{ $product->price }}</p>
                            </div>
                            <a href="{{ route('cart.destroy', $product->rowId) }}"
                                onclick="return confirm('Remove this item?');" class="btn-sm removeBtn rounded-circle"
                                title="Remove Item">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
                <hr>
                <div class="cart-summary">

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span class="fw-bold">${{ Cart::subtotal() }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Total:</span>
                        <span class="fw-bold text-success">${{ Cart::subtotal() }}</span>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('cart') }}" class="btn"
                            style="background: #e72104; color: #ffffff !important;">View Cart</a>
                        <a href="{{ route('checkout') }}" class="btn btn-success"
                            style="color:#ffffff !important">Checkout</a>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Your cart is empty</h5>
                    <p class="text-muted">Add some products to your cart to see them here.</p>
                    <a href="{{ route('shops') }}" class="btn btn-primary">Start Shopping</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Custom Styles --}}
    <style>
        /* Responsive Logo/Alignment */
        @media (max-width: 400px) {
            .header-main .container {
                flex-wrap: wrap !important;
            }

            .header-main .navbar-brand {
                flex: 1 1 100%;
                text-align: center;
                margin-bottom: 8px;
            }

            .header-main .btn,
            .header-main .header-icon-btn {
                flex-shrink: 0;
            }
        }

        @media (max-width: 767.98px) {
            .header-main .d-flex.align-items-center.gap-2 {
                width: 100%;
                justify-content: center;
                margin-top: 0.25rem;
            }
        }

        /* Announcement Marquee */
        .announcement-wrapper {
            height: 1.5rem;
        }

        .announcement-text {
            display: inline-block;
            white-space: nowrap;
            color: #ffffff;
            font-weight: 500;
            animation: scroll-left 15s linear infinite;
        }

        @keyframes scroll-left {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* Category Scroll Bar Styling */
        .main-header .category-scroll {
            overflow-x: auto !important;
            overflow-y: visible !important;
            -ms-overflow-style: none;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
            touch-action: pan-x;
        }

        .main-header .category-scroll::-webkit-scrollbar {
            display: none;
        }

        /* Category Modal Styling */
        .main-header .category-modal .modal-content {
            background: var(--cosmic-latte);
            box-shadow: 0 12px 40px var(--shadow-primary);
        }

        .main-header .category-modal .modal-header .modal-title {
            color: var(--harvest-gold);
        }

        .main-header .category-modal .btn-close:focus {
            box-shadow: 0 0 0 0.2rem var(--harvest-gold);
        }

        .main-header .category-modal .list-group-item {
            border: none;
            border-radius: 10px;
            margin-bottom: 6px;
            background: #fff;
            color: var(--seal-brown);
        }

        .main-header .category-modal .list-group-item:hover {
            background: var(--cosmic-latte);
            color: var(--hunter-green);
        }

        .main-header .category-modal .list-group-item.active {
            background: var(--hunter-green);
            color: #fff;
        }

        /* Category Button */
        .category-btn {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.5;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 50px;
            height: 30px;
            background: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
            transition: all 0.15s ease-in-out;
        }

        .category-btn:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white !important;
            text-decoration: none;
        }

        .category-btn:focus {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(1, 148, 154, 0.25);
        }

        .category-btn.active {
            background: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }

        /* Top Bar Styling */
        .main-header .header-top {
            font-size: 0.95rem;
            background: var(--burgundy) !important;
            color: var(--text-light) !important;
        }

        .main-header .header-top a,
        .main-header .header-top i {
            color: var(--text-light) !important;
        }

        .main-header .header-top a:hover {
            color: var(--bg-light) !important;
        }

        /* Navigation Bar Links */
        .main-header .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-dark);
            margin: 0 10px;
            transition: color 0.2s, border-bottom 0.2s;
            border-bottom: 2px solid transparent;
        }

        .main-header .navbar-nav .nav-link:hover,
        .main-header .navbar-nav .nav-link.active {
            color: var(--accent-color);
            border-bottom: 2px solid var(--accent-color);
            background: var(--shadow-primary);
            /* This background on hover seems unusual for a nav link, consider removing if unintended. Kept to preserve original design logic. */
        }

        .main-header .navbar-light .navbar-nav .nav-link {
            color: var(--text-dark);
        }

        .main-header .navbar-light .navbar-nav .nav-link:hover,
        .main-header .navbar-light .navbar-nav .nav-link.active {
            color: var(--accent-color);
        }

        /* Form Select (Category Dropdown in Search) */
        .main-header .form-select {
            background-color: var(--burgundy);
            /* border: 2px solid var(--accent-color); */
            margin-left: unset !important;
            border-radius: 3px !important;
            color: var(--text-light) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .main-header .form-select:focus {
            background-color: var(--bg-light);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem var(--shadow-primary);
            color: var(--text-dark);
        }

        .main-header .form-select:hover {
            border-color: var(--accent-color);
            background-color: var(--burgundy);
        }

        /* Optgroup and Option Styling */
        .main-header .form-select optgroup {
            font-weight: 600;
            color: var(--accent-color);
            background-color: var(--bg-light);
        }

        .main-header .form-select option {
            background-color: var(--bg-secondary);
            color: var(--text-secondary);
            padding: 8px 12px;
        }

        /* Button Colors */
        .main-header .btn-success,
        .main-header .btn-primary {
            background: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
        }

        .main-header .btn-success:hover,
        .main-header .btn-primary:hover {
            background: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }

        /* Dropdown Menu Styling */
        .main-header .dropdown-menu {
            border-top: 2px solid var(--accent-color);
        }

        .main-header .dropdown-item.active,
        .main-header .dropdown-item:active {
            background-color: var(--accent-color);
            color: var(--text-light);
        }

        .main-header .dropdown-item:hover {
            background-color: var(--bg-light);
            color: var(--accent-color);
        }

        /* Badge/Offcanvas */
        .main-header .badge.bg-danger {
            background: var(--accent-color) !important;
        }

        .main-header .offcanvas-title {
            color: var(--text-green);
        }

        .main-header .btn-close:focus {
            box-shadow: 0 0 0 0.2rem var(--shadow-primary);
        }

        /* Header Icons */
        .header-icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--bg-light);
            color: var(--accent-color);
            font-size: 1.5rem;
            position: relative;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            /* box-shadow: 0 2px 8px var(--shadow-primary); */
            text-decoration: none;
        }

        .header-icon-btn:hover,
        .header-icon-btn:focus {
            color: var(--primary-dark) !important;
            /* box-shadow: 0 4px 16px var(--shadow-primary);  */
        }

        .header-icon-badge {
            position: absolute;
            top: -4px;
            right: 1px;
            background: var(--error-color);
            color: var(--text-light);
            font-size: 0.75rem;
            border-radius: 50%;
            padding: 2px 6px;
            min-width: 20px;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 2px 8px var(--shadow-primary);
        }

        /* User Dropdown */
        .user-dropdown-toggle {
            background: var(--bg-light);
        }

        .user-dropdown-toggle:hover,
        .user-dropdown-toggle:focus {
            color: var(--text-light);
        }

        .user-dropdown-menu {
            min-width: 200px;
            border-radius: 12px;
            box-shadow: 0 8px 32px var(--shadow-primary);
            border-top: 3px solid var(--accent-color);
            padding: 0.5rem 0;
        }

        .user-dropdown-menu .dropdown-item {
            font-weight: 500;
            color: var(--text-dark);
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
        }

        .user-dropdown-menu .dropdown-item i {
            color: var(--accent-color);
            min-width: 18px;
            text-align: center;
        }

        .user-dropdown-menu .dropdown-item:hover,
        .user-dropdown-menu .dropdown-item:focus {
            background: var(--bg-light);
            color: var(--accent-color);
        }

        .user-dropdown-menu .dropdown-divider {
            margin: 0.3rem 0;
        }

        /* Cart Remove Button */
        .removeBtn {
            background: var(--border-light);
            color: var(--primary-dark) !important;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, color 0.2s;
        }

        .removeBtn:hover {
            color: var(--error-color) !important;
        }

        /* Signup/Login Button (Desktop) */
        .signup-btn {
            width: auto !important;
            height: 44px;
            /* border-radius: 22px !important; */
            border: 0px !important;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .signup-btn i {
            font-size: 1rem;
        }

        /* ============================================ */
        /* MEGA MENU STYLES */
        /* ============================================ */

        /* Mega Menu Wrapper */
        .mega-menu-wrapper {
            position: static;
        }

        .mega-menu-icon {
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .mega-menu-wrapper:hover .mega-menu-icon,
        .mega-menu-wrapper.active .mega-menu-icon {
            transform: rotate(180deg);
        }

        /* Mega Menu Container - Desktop */
        .mega-menu {
            display: none;
            position: absolute;
            left: 10%;
            width: 900px !important;
            background: #ffffff;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            padding: 40px 30px;
            z-index: 1050;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            margin-top: 2px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .mega-menu-wrapper:hover .mega-menu {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .mega-menu-wrapper.active .mega-menu {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Mega Menu Close Button (Mobile Only) */
        .mega-menu-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            cursor: pointer;
            z-index: 10;
            /* width: 40px; */
            /* height: 40px; */
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .mega-menu-close:hover {
            background: var(--bg-light);
            color: var(--accent-color);
        }

        /* Mega Menu Column */
        .mega-menu-column {
            margin-bottom: 20px;
        }

        /* Parent Category Title */
        .mega-menu-parent {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--accent-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .mega-menu-parent a {
            color: var(--text-green);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .mega-menu-parent a:hover {
            color: var(--text-green);
        }

        /* Child Categories List */
        .mega-menu-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mega-menu-list li {
            margin-bottom: 8px;
        }

        .mega-menu-list li a {
            color: #000000;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: block;
            /* padding: 5px 0; */
            transition: all 0.2s ease;
            position: relative;
            padding-left: 15px;
        }

        .mega-menu-list li a:before {
            content: '›';
            position: absolute;
            left: 0;
            color: var(--accent-color);
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .mega-menu-list li a:hover {
            color: var(--accent-color);
            padding-left: 20px;
        }

        .mega-menu-list li a:hover:before {
            opacity: 1;
        }

        /* Mega Menu Backdrop (Mobile) */
        .mega-menu-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mega-menu-backdrop.active {
            display: block;
            opacity: 1;
        }

        /* Scrollbar Styling for Mega Menu */
        .mega-menu::-webkit-scrollbar {
            width: 8px;
        }

        .mega-menu::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .mega-menu::-webkit-scrollbar-thumb {
            background: var(--accent-color);
            border-radius: 10px;
        }

        .mega-menu::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* ============================================ */
        /* MOBILE OFFCANVAS CATEGORIES STYLES */
        /* ============================================ */
        .mobile-categories-wrapper {
            padding: 15px 10px;
            background: var(--bg-light);
            border-radius: 8px;
            margin: 10px 10px 0px 10px;
            max-height: 400px;
            overflow-y: auto;
        }

        .mobile-category-group {
            margin-bottom: 20px;
        }

        .mobile-category-parent {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid var(--accent-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .mobile-category-parent a {
            color: var(--text-dark);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .mobile-category-parent a:hover {
            color: var(--accent-color);
        }

        .mobile-category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-category-list li {
            margin-bottom: 8px;
        }

        .mobile-category-list li a {
            color: #000000;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            display: block;
            padding: 6px 0 6px 15px;
            transition: all 0.2s ease;
            position: relative;
        }

        .mobile-category-list li a:before {
            content: '›';
            position: absolute;
            left: 0;
            color: var(--accent-color);
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .mobile-category-list li a:hover {
            color: var(--accent-color);
            padding-left: 20px;
        }

        .mobile-category-list li a:hover:before {
            opacity: 1;
        }

        /* Scrollbar for Mobile Categories */
        .mobile-categories-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .mobile-categories-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .mobile-categories-wrapper::-webkit-scrollbar-thumb {
            background: var(--accent-color);
            border-radius: 10px;
        }

        .mobile-categories-wrapper::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Collapse Icon Animation */
        .nav-link[data-bs-toggle="collapse"] i {
            transition: transform 0.3s ease;
        }

        .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] i {
            transform: rotate(180deg);
        }

        /* ============================================ */
        /* MOBILE RESPONSIVE STYLES (< 992px) */
        /* ============================================ */
        @media (max-width: 991.98px) {
            .mega-menu-wrapper {
                position: relative;
            }

            .mega-menu {
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                height: 80vh;
                max-height: 80vh;
                border-radius: 0 0 20px 20px;
                padding: 60px 20px 30px;
                margin-top: 0;
                z-index: 1050;
                transform: translateY(-100%);
            }

            .mega-menu-wrapper.active .mega-menu {
                transform: translateY(0);
            }

            /* 2-Column Grid on Mobile */
            .mega-menu-column {
                margin-bottom: 25px;
            }

            .mega-menu-parent {
                font-size: 0.95rem;
            }

            .mega-menu-list li a {
                font-size: 0.85rem;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 575.98px) {
            .mega-menu {
                padding: 50px 15px 20px;
            }

            .mega-menu-parent {
                font-size: 0.9rem;
                margin-bottom: 10px;
            }

            .mega-menu-list li a {
                font-size: 0.8rem;
            }
        }
    </style>

    {{-- Mega Menu JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const megaMenuWrapper = document.querySelector('.mega-menu-wrapper');
            const megaMenu = document.getElementById('categoriesMegaMenu');
            const megaMenuBackdrop = document.getElementById('megaMenuBackdrop');
            const megaMenuClose = document.querySelector('.mega-menu-close');
            const categoriesToggle = document.getElementById('categoriesMenuToggle');

            // Mobile: Click to toggle
            if (window.innerWidth < 992) {
                categoriesToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    megaMenuWrapper.classList.toggle('active');
                    megaMenuBackdrop.classList.toggle('active');
                    document.body.style.overflow = megaMenuWrapper.classList.contains('active') ? 'hidden' :
                        '';
                });

                // Close button
                megaMenuClose.addEventListener('click', function() {
                    megaMenuWrapper.classList.remove('active');
                    megaMenuBackdrop.classList.remove('active');
                    document.body.style.overflow = '';
                });

                // Close on backdrop click
                megaMenuBackdrop.addEventListener('click', function() {
                    megaMenuWrapper.classList.remove('active');
                    megaMenuBackdrop.classList.remove('active');
                    document.body.style.overflow = '';
                });
            } else {
                // Desktop: Hover behavior (handled by CSS)
                // Optional: Click to navigate on desktop
                categoriesToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            }

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth >= 992) {
                        megaMenuWrapper.classList.remove('active');
                        megaMenuBackdrop.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }, 250);
            });
        });
    </script>
</header>
