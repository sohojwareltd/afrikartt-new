@section('title', 'Checkout | Afrikart E-commerce')
@section('meta_description',
    'Complete your purchase securely on Afrikart E-commerce. Fast, safe checkout with multiple
    payment options and order tracking.')
@section('meta_keywords', 'checkout, payment, order, purchase, ecommerce, online shopping, Afrikart')
@section('canonical_url', route('checkout'))
@section('meta_og')
    <meta property="og:title" content="Checkout | Afrikart E-commerce">
    <meta property="og:description"
        content="Complete your purchase securely on Afrikart E-commerce. Fast, safe checkout with multiple payment options and order tracking.">
    <meta property="og:image" content="{{ Settings::setting('site_logo') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection
@section('meta_twitter')
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Checkout | Afrikart E-commerce">
    <meta name="twitter:description"
        content="Complete your purchase securely on Afrikart E-commerce. Fast, safe checkout with multiple payment options and order tracking.">
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
            color: var(--accent-color);
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
    </style>
@endsection

@section('content')

    <x-app.header />
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
                                <div class="d-flex align-items-center mb-5">
                                    <img src="{{ Storage::url($item->model->image) }}" alt="{{ $item->name }}"
                                        style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #eee;margin-right:12px;">
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold" style="font-size:1rem;">{{ $item->name }}</div>
                                        <div class="text-muted small">
                                            @if ($item->options && isset($item->options['variation']))
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

                                                <div class="col-md-6 mt-2">
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
                                                    <select class="form-control" id="state" name="state">
                                                        <option value="">Select State</option>
                                                    </select>
                                                    @error('state')
                                                        <span class="text-danger small position-absolute"
                                                            style="top:100%;left:0;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="city" class="form-label">City</label>
                                                    <select class="form-control" id="city" name="city">
                                                        <option value="">Select City</option>
                                                    </select>
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
                                            <button type="submit" class="btn btn-primary mt-5" id="continue-to-payment"
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
                            @foreach ($related_products->chunk(4) as $products)
                                <div class="ec-fs-product">
                                    <div class="ec-fs-pro-inner">

                                        <div class="row">

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
            const citySelect = document.getElementById('city');
            const stateSelect = document.getElementById('state');
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

            // Initialize Choices.js for searchable selects
            const countryChoices = new Choices(countrySelect, {
                searchEnabled: true,
                shouldSort: true,
                itemSelectText: ''
            });
            const stateChoices = new Choices(stateSelect, {
                searchEnabled: true,
                shouldSort: true,
                itemSelectText: ''
            });
            const cityChoices = new Choices(citySelect, {
                searchEnabled: true,
                shouldSort: true,
                itemSelectText: ''
            });
            const postalCodeInput = document.getElementById('post_code');

            function isFilled(el) {
                return el && String(el.value).trim().length > 0;
            }

            function isSelectFilled(el) {
                if (!el) return false;
                // Check both the native select value and Choices.js instance
                if (el.value && String(el.value).trim() !== '') return true;
                // Check if it's a Choices.js select and has a selected value
                if (el.choices && el.choices._store && el.choices._store.activeItems && el.choices._store
                    .activeItems.length > 0) {
                    return true;
                }
                return false;
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
                    isSelectFilled(citySelect) &&
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
                        city: isSelectFilled(citySelect),
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

                // Resolve to your dataset's IDs and names
                try {
                    let resolvedCountry = null;
                    const countryLong = getComponent(place.address_components, 'country',
                        'long_name');
                    const countryRequests = [];
                    if (countryShort) countryRequests.push(cachedFetchJson(
                        `/api/geo/resolve/country?needle=${encodeURIComponent(countryShort)}`
                    ));
                    if (countryLong) countryRequests.push(cachedFetchJson(
                        `/api/geo/resolve/country?needle=${encodeURIComponent(countryLong)}`
                    ));
                    for (const req of countryRequests) {
                        try {
                            const r = await req;
                            if (r && r.id) {
                                resolvedCountry = r;
                                break;
                            }
                        } catch (_) {
                            /* ignore */
                        }
                    }

                    if (resolvedCountry && resolvedCountry.id) {
                        // Select the country by ID
                        ensureChoice(countrySelect, resolvedCountry.id, resolvedCountry.name ||
                            resolvedCountry.iso2 || resolvedCountry.code || countryShort);

                        // Load the correct states list for this country, then set state
                        try {
                            const statesMap = await cachedFetchJson(
                                `/json/states/${encodeURIComponent(resolvedCountry.id)}`);
                            populateSelect(stateSelect, statesMap, 'Select State');
                        } catch (e) {
                            /* ignore */
                        }

                        // Resolve state within this country using short or long code
                        const stateNeedlePrimary = adminAreaShort || adminAreaLong;
                        if (stateNeedlePrimary) {
                            let resolvedState = null;
                            const stateRequests = [
                                cachedFetchJson(
                                    `/api/geo/resolve/state?country=${encodeURIComponent(resolvedCountry.id)}&needle=${encodeURIComponent(stateNeedlePrimary)}`
                                )
                            ];
                            if (adminAreaLong && adminAreaLong !== stateNeedlePrimary) {
                                stateRequests.push(cachedFetchJson(
                                    `/api/geo/resolve/state?country=${encodeURIComponent(resolvedCountry.id)}&needle=${encodeURIComponent(adminAreaLong)}`
                                ));
                            }
                            for (const req of stateRequests) {
                                try {
                                    const r = await req;
                                    if (r && r.id) {
                                        resolvedState = r;
                                        break;
                                    }
                                } catch (_) {
                                    /* ignore */
                                }
                            }
                            if (resolvedState && resolvedState.id) {
                                ensureChoice(stateSelect, resolvedState.id, resolvedState.name ||
                                    stateNeedlePrimary);
                            } else {
                                // Fallback search
                                try {
                                    const found = await cachedFetchJson(
                                        `/api/geo/search/state?country=${encodeURIComponent(resolvedCountry.id)}&q=${encodeURIComponent(stateNeedlePrimary)}`
                                    );
                                    const firstId = Object.keys(found)[0];
                                    const firstName = firstId ? found[firstId] : null;
                                    if (firstId) {
                                        ensureChoice(stateSelect, firstId, firstName ||
                                            stateNeedlePrimary);
                                    } else {
                                        ensureChoice(stateSelect, stateNeedlePrimary,
                                            stateNeedlePrimary);
                                    }
                                } catch (_) {
                                    ensureChoice(stateSelect, stateNeedlePrimary,
                                        stateNeedlePrimary);
                                }
                            }
                        }
                    } else {
                        // Country fallback to short code
                        if (countryShort) ensureChoice(countrySelect, countryShort, countryShort);
                        const stateLabel = adminAreaLong || adminAreaShort;
                        if (stateLabel) ensureChoice(stateSelect, stateLabel, stateLabel);
                    }

                    if (citySelect && locality) ensureChoice(citySelect, locality, locality);
                } catch (e) {
                    // On any error, fallback to string labels
                    if (countryShort) ensureChoice(countrySelect, countryShort, countryShort);
                    const stateLabel = adminAreaLong || adminAreaShort;
                    if (stateLabel) ensureChoice(stateSelect, stateLabel, stateLabel);
                    if (citySelect && locality) ensureChoice(citySelect, locality, locality);
                }

                if (place.geometry) {
                    const lat = place.geometry.location.lat();
                    const lng = place.geometry.location.lng();
                    latitudeInput.value = lat;
                    longitudeInput.value = lng;
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

            // Helpers
            function clearOptions(selectEl, placeholder = 'Select') {
                const instance = selectEl === countrySelect ? countryChoices : selectEl === stateSelect ?
                    stateChoices : cityChoices;
                instance.clearStore();
                instance.setChoices([{
                    value: '',
                    label: placeholder,
                    selected: true
                }], 'value', 'label', true);
            }

            function setSelected(selectEl, label) {
                const instance = selectEl === countrySelect ? countryChoices : selectEl === stateSelect ?
                    stateChoices : cityChoices;
                const found = instance._store.choices.find(c => c.label === label);
                if (found) instance.setChoiceByValue(found.value);
            }

            // Ensure an option exists in the Choices select; add and select if missing
            function ensureChoice(selectEl, value, label) {
                const instance = selectEl === countrySelect ? countryChoices : selectEl === stateSelect ?
                    stateChoices : cityChoices;
                const valueStr = String(value);
                let hasOption = false;
                for (let i = 0; i < selectEl.options.length; i++) {
                    if (String(selectEl.options[i].value) === valueStr) {
                        hasOption = true;
                        break;
                    }
                }
                if (!hasOption) {
                    const opt = document.createElement('option');
                    opt.value = valueStr;
                    opt.text = label || valueStr;
                    selectEl.appendChild(opt);
                    // Append without resetting existing to avoid full re-render cost
                    instance.setChoices([{
                        value: valueStr,
                        label: label || valueStr
                    }], 'value', 'label', false);
                }
                instance.setChoiceByValue(valueStr);
                // Trigger coalesced continue button state update
                scheduleUpdateContinueState(false);
            }

            async function fetchJson(url) {
                return cachedFetchJson(url);
            }

            function populateSelect(selectEl, data, placeholder) {
                const instance = selectEl === countrySelect ? countryChoices : selectEl === stateSelect ?
                    stateChoices : cityChoices;
                const choices = [{
                    value: '',
                    label: placeholder,
                    selected: true
                }];
                for (const [id, name] of Object.entries(data)) {
                    choices.push({
                        value: id,
                        label: name
                    });
                }
                instance.setChoices(choices, 'value', 'label', true);
            }

            // Load countries
            try {
                const countries = await fetchJson('/api/geo/countries');
                populateSelect(countrySelect, countries, 'Select Country');
            } catch (e) {
                /* ignore */
            }

            // On country change -> load states
            countrySelect.addEventListener('change', async function() {
                scheduleUpdateContinueState(true);
                const countryId = this.value;
                clearOptions(stateSelect, 'Select State');
                clearOptions(citySelect, 'Select City');
                if (!countryId) return;
                try {
                    const states = await fetchJson('/api/geo/states/' + encodeURIComponent(
                        countryId));
                    populateSelect(stateSelect, states, 'Select State');
                } catch (e) {
                    /* ignore */
                }
                scheduleUpdateContinueState(false);
            });

            // On state change -> load cities
            stateSelect.addEventListener('change', async function() {
                scheduleUpdateContinueState(true);
                const stateId = this.value;
                const countryId = countrySelect.value;
                clearOptions(citySelect, 'Select City');
                if (!countryId || !stateId) return;
                try {
                    const cities = await fetchJson('/api/geo/cities/' + encodeURIComponent(
                        countryId) + '/' + encodeURIComponent(stateId));
                    populateSelect(citySelect, cities, 'Select City');
                } catch (e) {
                    /* ignore */
                }
                scheduleUpdateContinueState(false);
            });

            // Reactively validate inputs and selects
            ['first_name', 'last_name', 'email', 'phone', 'address_1', 'post_code'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.addEventListener('input', () => updateContinueState(false));
            });

            // Add event listeners for Choices.js select elements
            [countrySelect, stateSelect, citySelect].forEach(el => {
                if (el) {
                    el.addEventListener('change', () => updateContinueState(false));
                    // Also listen for Choices.js specific events
                    if (el.choices) {
                        el.choices.passedElement.element.addEventListener('change', () =>
                            updateContinueState(false));
                    }
                }
            });

            // Initial evaluation
            updateContinueState(false);
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
