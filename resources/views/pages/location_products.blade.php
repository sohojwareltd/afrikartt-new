@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/shops.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/shops.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        .ec-product-inner .ec-pro-image .ec-pro-actions .wishlist {
            position: absolute !important;
            right: 10px !important;
            bottom: 62px !important;
            border: 1px solid #eeeeee;
        }

        label {
            display: block;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        #price-range {
            margin-top: 20px;
        }

        #price-display {
            margin-top: 10px;
        }
        @media screen and (max-width:720px){
            .location-drop{
                display: block !important;
            }
        }
        @media screen and (max-width:480px){
            .location-drop{
                display: block !important;
            }
            .header-search .form-control{
                border-top-left-radius: 0px !important;
                border-bottom-left-radius: 0px !important;
            }
            #desktop-search{
                display: block;
            }
        }

        /* .rating-container .filled-stars {
            left: 5px;
        } */
    </style>
@endsection
@section('content')
    <x-app.header />
    <div class="">
        <div class="row justify-content-end">
            <div class="col-md-6">
                <div class="align-self-center">
                    <div class="header-search">
                        <form class="ec-btn-group-form d-flex" action="" method="get">
                            <div id="desktop-search" class="ec-sort-select ">
                                <input type="hidden" name="state" value="{{request()->state}}">
                                <input type="hidden" name="post_city" value="{{request()->post_city}}">
                                <div class="ec-select-inner-cat ec-select-inner header-drop location-drop">

                                    <select name="category" id="ec-select" style="border: 1px solid #373737;">
                                        <option selected value="">Categories</option>
                                        @foreach ($categories as $category)
                                            <option @if (request('category') == $category->slug) selected @endif
                                                value="{{ $category->slug }}">{{ $category->name }}</option>
                                            @foreach ($category->childrens as $child)
                                                <option value="{{ $child->slug }}" style="font-weight:300">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $child->name }}
                                                </option>
                                            @endforeach
                                        @endforeach


                                    </select>

                                </div>
                            </div>
                            <input class="form-control ec-search-bar" style="border: 1px solid #373737;"
                                name="search" value="{{ request('search') }}" placeholder="Search products..."
                                type="text">
                            <button class="submit header-search-btn" type="submit"><i
                                    class="fi-rr-search"></i></button>

                        </form>


                    </div>

                </div>
            </div>
        </div>
        <div class="row container-fluid">

         
            <div class="col-md-12">

                <section class="ec-page-content section-space-p">
                    <div class="container">
                        <div class="row">
                            <div class="ec-shop-rightside col-lg-12 col-md-12">
                                <!-- Shop Top Start -->
                                <div class="ec-pro-list-top d-flex ">
                                    <div class="col-md-6 ec-grid-list">
                                        <div class="ec-gl-btn">
                                            {{-- <p>Results For “ <span style="color:#3BB77E ">{{ request()->location }}</span> ”
                                            </p> --}}
                                        </div>
                                    </div>

                                </div>
                                {{-- <div class="row justify-content-end mb-3">
                                    <div class="col-md-5">
                                        <form action="" method="get">
                                            <div class="input-group mb-3">
                                                <input type="text" name="location" class="form-control"
                                                    placeholder="Search for products by zip code"
                                                    aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <button type="submit" class="input-group-text btn-dark"
                                                        id="basic-addon2" style="padding: 12px 25px">Search</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div> --}}



                                <div>
                                    @if ( $shops->count() > 0)
                                
                                            @foreach ($shops as $shop)
                                                <div class="row mb-4">
                                                    <div class="col-md-3">
                                                        <x-shops-card.card-1 :shop="$shop" />
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="ec-spe-products">
                                                            @foreach ($shop->products->chunk(4) as $products)
                                                                <div class="ec-fs-product">
                                                                    <div class="ec-fs-pro-inner">

                                                                        <div class="row">
                                                                            {{-- @php

                                                                                $last = $loop->last;
                                                                                $count = $items[0]->shop->products->count();
                                                                            @endphp --}}
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
                                            @endforeach
                                        @else
                                            <h3 class="text-center text-danger my-5"> Please Change zip code to see more
                                                products.</h3>
                                        @endif
                             
                                </div>
                                <div class=" d-flex justify-content-center  align-items-center mt-4">
                                    <a href="{{ route('vendors') }}" class="btn btn-dark rounded rounded-3 px-5">View
                                        More Shops <i class="fa-solid fa-angle-right ms-2"></i></a>
                                </div>
                                {{-- <livewire:shops /> --}}
                                <!-- Shop Top End -->
                                {{-- End sort by popular --}}
                            </div>

                        </div>


                    </div>
            </div>
            </section>
        </div>
    </div>
    </div>
    <!-- End Shop page -->
@endsection
@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
@endsection
