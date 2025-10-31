<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>@yield('title', 'Afrikart E-commerce')</title>
    <meta name="description" content="@yield('meta_description', 'This is a demo e-commerce website built with Laravel and Voyager.')">
    <meta name="keywords" content="@yield('meta_keywords', 'ecommerce, online shop, afrikart, buy, sell, products')">
    <!-- Open Graph & Twitter Card Placeholders -->
    @yield('meta_og')
    @yield('meta_twitter')
    <meta name="author" content="sayed khan">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- site Favicon -->
    <link rel="icon" href="{{ Settings::setting('site_icon') ?? asset('assets/logo/favicon.png') }}"
        sizes="32x32" />
    <link rel="apple-touch-icon" href="{{ Settings::setting('site_icon') ?? asset('assets/logo/favicon.png') }}" />
    <meta name="msapplication-TileImage"
        content="{{ Settings::setting('site_icon') ?? asset('assets/logo/favicon.png') }}" />


    <!-- css Icon Font -->
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/vendor/ecicons.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    {{-- google font --}}


    <!-- css All Plugins Files -->


    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/countdownTimer.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/nouislider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/slick.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/colors.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/star-rating.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/product-cards.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">


    <link
        href="https://fonts.googleapis.com/css2?family=Arya&family=Great+Vibes&family=Inter:wght@200;400;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter';
            background-color: #ffff !important;
        }

        .category-drop::after {
            top: 7px !important;
        }
    </style>



    <!-- Main Style -->

    @yield('css')

    <style>
        .ec-footer {
            background: var(--bg-secondary) !important;
        }

        .ec-footer .footer-top .ec-footer-widget .ec-footer-links .ec-footer-link:not(:last-child) {
            /* margin-bottom: 0 !important; */

        }

        .ec-footer .footer-top .ec-footer-widget .ec-footer-heading {
            color: var(--text-dark) !important;

        }

        .ec-footer .footer-top .ec-footer-widget .ec-footer-heading::before {
            border-bottom: 1px solid var(--text-primary) !important;
        }

        .footer-bottom .ec-copy .site-name:hover {
            color: var(--text-primary) !important;
            ;
        }

        #scrollUp {
            background-color: var(--text-primary) !important;
        }

        .is-invalid {
            border: 1px solid var(--error-color) !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @livewireStyles
    <link rel="canonical" href="@yield('canonical_url', url()->current())" />
    @yield('jsonld')
    @yield('jsonld_breadcrumb')
    <style>
        .helper-button {
            background-color: #1b4ace;
            height: 25px;
            width: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
            text-decoration: none;
            color: #fff;
        }

        .helper-button:hover {
            background-color: #142145;

        }
    </style>
</head>

<body>
    <!-- <div id="ec-overlay">
        <div class="ec-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div> -->
    <!-- Header start  -->
    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    <!-- Footer Start -->
    <footer class="footer-modern py-5 text-light" id="footer" style="background: var(--primary-color);">
        <div class="container">
            <div class="row gy-5 align-items-start">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h6 class="fw-bold mb-3 text-uppercase">Newsletter</h6>
                    <p class="mb-2" style=" font-size: 0.97rem;">Subscribe to our newsletter and be the
                        first to know about new arrivals, exclusive deals, and special offers!</p>
                    <form class="d-flex" name="ec-newsletter-form" method="post" action="{{ route('subscribe') }}">
                        @csrf
                        <input type="email"
                            class="form-control form-control-sm bg-dark border-0 text-light pe-0 rounded-0"
                            name="email" placeholder="Your email" required>
                        <button class="btn btn-pink btn-sm px-3 h-auto" type="submit">Subscribe</button>
                    </form>
                    <small class="d-block mt-2" style="">Get the latest updates and offers.</small>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6 class="fw-bold mb-3 text-uppercase" style="color:var(--text-light);letter-spacing:1px;">Account
                    </h6>
                    <x-menu name="leftside" />
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6 class="fw-bold mb-3 text-uppercase" style="color:var(--text-light);letter-spacing:1px;">Useful
                        Links</h6>
                    <x-menu name="middle" />
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6 class="fw-bold mb-3 text-uppercase" style="color:var(--text-light);letter-spacing:1px;">Customer
                        Service
                    </h6>
                    <x-menu name="main" />
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6 class="fw-bold mb-3 text-uppercase" style="color:var(--text-light);letter-spacing:1px;">Social
                        links</h6>
                    <p class="mt-3 small">Your trusted marketplace for quality products and
                        great deals.</p>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ Settings::setting('social_fb_link') }}"
                            class="btn btn-outline-light btn-sm rounded-circle"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ Settings::setting('social_inst_link') }}"
                            class="btn btn-outline-light btn-sm rounded-circle"><i class="fab fa-instagram"></i></a>
                        <a href="{{ Settings::setting('social_twitter_link') }}"
                            class="btn btn-outline-light btn-sm rounded-circle"><i class="fab fa-twitter"></i></a>
                        <a href="{{ Settings::setting('social_linkedin') }}"
                            class="btn btn-outline-light btn-sm rounded-circle"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

            </div>
            <style>
                .Copy:hover {
                    color: #ffffff !important;
                }
            </style>
            <hr class="my-4" style="border-color: var(--border-medium);">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start small">
                    &copy; {{ date('Y') }} <a href="{{ route('homepage') }}"
                        class="fw-bold text-light text-decoration-none Copy">Afrikart E-commerce</a>. All rights
                    reserved.
                    <span class="mx-2">|</span>
                    <a href="{{ route('privacy.policy') }}" class="text-light text-decoration-none Copy">Privacy
                        Policy</a>
                    <span class="mx-2">|</span>
                    <a href="{{ route('faqs') }}" class="text-light text-decoration-none Copy">FAQ</a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <img src="{{ asset('assets/img/cards.png') }}" alt="Payment Methods" style="height: 32px;">
                </div>
            </div>
        </div>
    </footer>
    <style>
        .footer-modern h6 {
            /* border-bottom: 2px solid var(--accent-color); */
            color: var(--text-light);
        }

        .footer-modern .footer-link {
            color: var(--text-light);
        }

        .footer-modern .footer-link:hover {
            color: var(--accent-color);
        }

        .footer-modern .btn-outline-light {
            border: 1px solid var(--accent-color);
        }

        .footer-modern .btn-outline-light:hover {
            background: var(--accent-color);
            color: var(--text-light) !important;
        }

        .footer-modern .btn-pink,
        .btn-pink {
            background: var(--bg-orange) !important;
            color: var(--text-light) !important;
            border: none !important;
        }

        .footer-modern .btn-pink:hover,
        .btn-pink:hover {
            background: var(--bg-secondary) !important;
            color: var(--primary-color) !important;
        }

        .footer-modern hr {
            border-color: var(--border-medium);
        }
    </style>
    <!-- Footer Area End -->


    <div class="modal fade" id="ec_quickview_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close qty_close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-body" id="quick_view">

                </div>
            </div>
        </div>
    </div>
    <!-- Floating Country Selector Button -->
    {{-- <button type="button" class="country-fab" data-bs-toggle="modal" data-bs-target="#countryRegionModal"
        aria-label="Select Country">
        <span class="country-flag-slot"><i class="fas fa-globe-africa"></i></span>
    </button> --}}

    <!-- Country Selector Modal (Africa) -->
    <div class="modal fade country-modal countryRegionModal" id="countryRegionModal" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow-lg">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">
                        <i class="fas fa-globe-africa me-2" style="color: var(--harvest-gold);"></i>
                        Choose Your Country (Africa)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="fas fa-search"
                                style="color: var(--hunter-green);"></i></span>
                        <input type="text" id="countrySearch" class="form-control"
                            placeholder="Search countries...">
                    </div>
                    <div id="countryScroll" class="country-scroll">
                        <div class="country-item" data-country="global" data-flag="">
                            <i class="fas fa-globe-africa" style="color: var(--hunter-green);"></i>
                            <span class="country-name">Global</span>
                        </div>

                        @foreach (App\Data\Country\Africa::getCountries() as $country)
                            <div class="country-item" data-country="{{ $country['name'] }}"
                                data-flag="{{ $country['flag'] }}">
                                <img class="country-flag" src="{{ $country['flag'] }}"
                                    alt="{{ $country['name'] }}">
                                <span class="country-name">{{ $country['name'] }}</span>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Modal Start -->
    {{-- <div id="ec-popnews-bg"></div> --}}
    {{-- <div id="ec-popnews-box">
        <div id="ec-popnews-close"><i class="ecicon eci-close"></i></div>
        <div class="row">
            <div class="col-md-6 disp-no-767">
                <img src="{{ Voyager::image(setting('site.newslletter_logo')) }}" alt="newsletter">
            </div>
            <div class="col-md-6">
                <div id="ec-popnews-box-content">
                    <h2>Subscribe Newsletter</h2>
                    <p>Subscribe the ekka ecommerce to get in touch and get the future update. </p>
                    <form id="ec-popnews-form" action="{{ route('subscribe') }}" method="post">
                        @csrf
                        <input type="email" name="email" placeholder="Email Address" required />
                        <button type="submit" class="btn btn-primary" name="subscribe">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Newsletter Modal end -->


    <!-- Footer navigation panel for responsive display -->
    {{-- <div class="ec-nav-toolbar">
        <div class="container">
            <div class="ec-nav-panel">
                <div class="ec-nav-panel-icons">
                    <a href="#ec-mobile-menu" class="navbar-toggler-btn ec-header-btn ec-side-toggle"><i
                            class="fi-rr-menu-burger"></i></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="#ec-side-cart" class="toggle-cart ec-header-btn ec-side-toggle"><i
                            class="fi-rr-shopping-bag"></i><span
                            class="ec-cart-noti ec-header-count cart-count-lable">3</span></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="{{ route('homepage') }}" class="ec-header-btn"><i class="fi-rr-home"></i></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="wishlist.html" class="ec-header-btn"><i class="fi-rr-heart"></i><span
                            class="ec-cart-noti">4</span></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="login.html" class="ec-header-btn"><i class="fi-rr-user"></i></a>
                </div>

            </div>
        </div>
    </div> --}}

    <x-alert :exclude="[route('user.update_profile')]" />

    <!-- Country Selection Bar -->
    @if (session()->has('myCountry'))
        <div id="country-selection-bar" class="country-selection-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col">
                        <span class="country-info">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Currently viewing products from
                            <strong>{{ session('myCountry.name') }}</strong>
                        </span>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-light btn-sm" onclick="setGlobalCountry()">
                            <i class="fas fa-globe-africa me-1"></i>
                            View All Countries
                        </button>
                        <button type="button" class="btn-close btn-close-white ms-2" onclick="hideCountryBar()"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Core Vendor JS -->
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery-3.5.1.min.js') }}"></script>

    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/modernizr-3.11.2.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/countdownTimer.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/nouislider.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/slick.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/infiniteslidev2.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/click-to-call.js') }}"></script>

    <!-- Main scripts -->
    <script src="{{ asset('assets/frontend-assets/js/vendor/index.js') }}"></script>
    <script src="{{ asset('assets/js/star-rating.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- CSRF Token Setup (before custom AJAX ideally) -->
    <script src="{{ asset('js/csrf-setup.js') }}"></script>




    <script>
        function cartQnty() {
            $.ajax({
                type: 'get',
                url: '/cart-qty',
                success: function(response) {

                    $('#cartQty').text(response);
                    $('#cartQty2').text(response);
                    if (response == 0) {
                        $('#cartQty').hide();
                    } else {
                        $('#cartQty').show();
                    }
                },
                error: function(xhr) {
                    // Handle the error response
                    console.log(xhr.responseText);
                }
            });
        }

        cartQnty();
        // console.log(cartQnty())
        $(document).ready(function() {
            $('.cart-store').click(function() {
                var addToCartBtn = $(this);
                var productId = $(this).data('product-id');
                var quantity = $('.addToCartForm_' + productId).find('.qty').val();
                var oldQty = "{{ Cart::count() }}";
                var parentDiv = $(this).closest('.ec-product-inner');

                $.ajax({
                    type: 'POST',
                    url: '/add-cart',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        // Handle the success response
                        console.log(response);
                        cartQnty();
                        addToCartBtn.attr('disabled', true);
                        parentDiv.find('.fi-rr-shopping-basket').addClass('text-success').attr(
                            'disabled', true);
                        parentDiv.find('#addToCartBtn').text('added').attr('disabled', true);

                    },
                    error: function(xhr) {
                        // Handle the error response
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        function quickView(id) {

            $.ajax({
                url: '/quickview',
                method: 'GET',
                data: {
                    product_id: id
                },
                success: function(response) {
                    $('#ec_quickview_modal').modal('show')
                    $('#quick_view').html(response)
                },

            });
        }
    </script>


    <script>
        function wishlist(id) {

            $.ajax({
                url: '/wishlist/add',
                method: 'GET',
                data: {
                    productId: id
                },
                success: function() {
                    var element = $('.add-wish-new_' + id);
                    if (element.hasClass('fa-solid')) {
                        element.addClass('fa-regular').removeClass('fa-solid text-success');
                    } else {
                        element.addClass('fa-solid text-success').removeClass('fa-regular ');
                    }


                }

            });
        }
    </script>



    <script>
        $("#product_rating").rating({
            showCaption: true
        });
        $(".published_rating").rating({
            showCaption: false,
            readonly: true,
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        @if (session()->has('success_msg'))
            $(document).ready(function() {
                $('.toast').toast('show');
            })
            $('.toast_close').click(function() {
                $('.toast').toast('hide');
            })
        @endif
        @if (session()->has('errors'))
            $(document).ready(function() {
                $('.toast').toast('show');
            })
            $('.toast_close').click(function() {
                $('.toast').toast('hide');
            })
        @endif
    </script>
    @if (session()->has('subscribeEmail'))
        <script>
            var dataValue = true;
            ecCreateCookie('ecPopNewsLetter', dataValue, 1);
        </script>
    @endif


    <style>
        .country-fab {
            position: fixed;
            left: 16px;
            bottom: 16px;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: none;
            background: var(--hunter-green);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .18);
            z-index: 1055;
        }

        .country-fab:hover {
            background: var(--harvest-gold);
            color: #fff;
        }

        .country-modal .modal-content {
            background: var(--cosmic-latte);
        }

        .country-modal .btn-primary {
            background: var(--hunter-green);
            border-color: var(--hunter-green);
        }

        .country-modal .btn-primary:hover {
            background: var(--harvest-gold);
            border-color: var(--harvest-gold);
        }

        .country-scroll {
            max-height: 50vh;
            overflow: auto;
            border: 1px solid var(--hunter-green);
            border-radius: 12px;
            background: #fff;
        }

        .country-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            cursor: pointer;
            text-decoration: none;
            color: var(--seal-brown);
        }

        .country-item:hover {
            background: var(--cosmic-latte);
            color: var(--hunter-green);
        }

        .country-item+.country-item {
            border-top: 1px solid rgba(0, 0, 0, .06);
        }

        .country-flag {
            width: 22px;
            height: 16px;
            object-fit: cover;
            border: 1px solid rgba(0, 0, 0, .1);
        }

        .country-flag-fab {
            width: 18px;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 2px;
            border: 1px solid rgba(0, 0, 0, .15);
        }

        /* Country Selection Bar Styles */
        .country-selection-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--hunter-green);
            color: white;
            padding: 8px 0;
            z-index: 1040;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            border-top: 2px solid var(--harvest-gold);
            transition: transform 0.3s ease-in-out;
        }

        .country-selection-bar .country-info {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .country-selection-bar .country-info strong {
            color: var(--harvest-gold);
        }

        .country-selection-bar .btn-outline-light {
            border-color: var(--harvest-gold);
            color: var(--harvest-gold);
            font-size: 0.8rem;
            padding: 4px 12px;
        }

        .country-selection-bar .btn-outline-light:hover {
            background-color: var(--harvest-gold);
            color: var(--hunter-green);
            border-color: var(--harvest-gold);
        }

        .country-selection-bar .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .country-selection-bar .btn-close:hover {
            opacity: 1;
        }

        /* Add bottom padding to body when country bar is visible */
        body:has(.country-selection-bar) {
            padding-bottom: 60px;
        }
    </style>

    <script>
        (function() {
            var fabSlots = document.querySelectorAll('.country-flag-slot');
            if (!fabSlots.length) return;

            function setFab(name, flagUrl) {
                fabSlots.forEach(function(fabSlot) {
                    if (flagUrl) {
                        fabSlot.innerHTML = '<img class="country-flag-fab" alt="' + (name || '') + '" src="' +
                            flagUrl + '">';
                    } else {
                        fabSlot.innerHTML = '<i class="fas fa-globe-africa"></i>';
                    }
                });
            }

            // Initialize from saved selection
            var savedName = localStorage.getItem('selectedCountryName');
            var savedFlag = localStorage.getItem('selectedCountryFlag');
            if (savedFlag) setFab(savedName, savedFlag);

            // Click handler for Blade-rendered items
            document.querySelectorAll('#countryRegionModal .country-item').forEach(function(item) {
                item.addEventListener('click', function() {
                    var name = this.getAttribute('data-country');
                    var flag = this.getAttribute('data-flag');
                    localStorage.setItem('selectedCountryName', name || '');
                    localStorage.setItem('selectedCountryFlag', flag || '');

                    fetch('{{ route('set.country') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            name: name,
                            flag: flag
                        })
                    }).then(function() {
                        // Clear homepage cache
                        return fetch('{{ route('clear.home.cache') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        });
                    }).then(function() {
                        setFab(name, flag);

                        var modal = document.getElementById('countryRegionModal');
                        if (modal) {
                            var bsModal = bootstrap.Modal.getInstance(modal) || new bootstrap
                                .Modal(modal);
                            bsModal.hide();
                        }

                        // Reload page to apply new data
                        location.reload();
                    });
                });
            });

            // Live filter for country list
            var searchInput = document.getElementById('countrySearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    var q = this.value.toLowerCase();
                    document.querySelectorAll('#countryScroll .country-item').forEach(function(row) {
                        var name = (row.querySelector('.country-name')?.textContent || '')
                            .toLowerCase();
                        row.style.display = name.indexOf(q) !== -1 ? '' : 'none';
                    });
                });
            }
        })();
    </script>

    <script>
        // Country bar functions
        function setGlobalCountry() {
            fetch('{{ route('set.country') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: 'global',
                    flag: ''
                })
            }).then(function() {
                // Clear homepage cache
                return fetch('{{ route('clear.home.cache') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });
            }).then(function() {
                // Reload page to apply new data
                localStorage.removeItem('selectedCountryName');
                localStorage.removeItem('selectedCountryFlag');
                location.reload();
            });
        }

        function hideCountryBar() {
            var countryBar = document.getElementById('country-selection-bar');
            if (countryBar) {
                countryBar.style.display = 'none';
                // Add padding back to body since we're hiding the bar
                document.body.style.paddingBottom = '0';
            }
        }

        // Hide country bar if user scrolls down significantly (optional UX enhancement)
        var lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            var countryBar = document.getElementById('country-selection-bar');
            if (!countryBar) return;

            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down and past 100px - hide bar
                countryBar.style.transform = 'translateY(100%)';
            } else {
                // Scrolling up or at top - show bar
                countryBar.style.transform = 'translateY(0)';
            }

            lastScrollTop = scrollTop;
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("img").forEach(img => {
                if (!img.hasAttribute("loading")) {
                    img.setAttribute("loading", "lazy");
                }
            });
        });
    </script>

    <!-- Custom inline scripts -->
    @yield('js')
    @livewireScripts
</body>

</html>
