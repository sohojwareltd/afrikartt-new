@extends('layouts.app')
@section('title', 'Royalit E-commerce | Home')
@section('meta_description',
    'Discover trending products, top shops, and exclusive deals on Royalit E-commerce. Shop by
    category and enjoy a seamless online shopping experience.')
@section('meta_keywords', 'ecommerce, online shopping, trending products, best shops, Royalit')
@section('meta_og')
    <meta property="og:title" content="Royalit E-commerce | Home">
    <meta property="og:description"
        content="Discover trending products, top shops, and exclusive deals on Royalit E-commerce. Shop by category and enjoy a seamless online shopping experience.">
    <meta property="og:image" content="{{ Settings::setting('site_logo') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection
@section('meta_twitter')
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Royalit E-commerce | Home">
    <meta name="twitter:description"
        content="Discover trending products, top shops, and exclusive deals on Royalit E-commerce. Shop by category and enjoy a seamless online shopping experience.">
    <meta name="twitter:image" content="{{ Settings::setting('site_logo') }}">
@endsection
@section('canonical_url', route('homepage'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/responsive.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/demo2.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/shops.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/demo3.css') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        @media screen and (max-width:768px) {

            .category-thumbnail {
                height: auto !important;
            }
        }

        .border-hover:hover {
            border: 1px solid black;
        }

        .border-hover {
            border-radius: 10px;
        }

        .hero-slider-wrapper {
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(141, 110, 99, 0.08);
        }

        .hero-slider {
            display: flex;
            overflow: hidden;
            scroll-snap-type: x mandatory;
            aspect-ratio: 16/9;
            width: 100%;
        }

        .hero__item {
            flex: 0 0 100%;
            height: 100%;
            background-size: 100% 100%;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            padding: 0 5%;
            scroll-snap-align: start;
            transition: transform 0.5s ease-in-out;
        }

        .hero__text {
            max-width: 600px;
        }

        .hero__text span {
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 4px;
            color: var(--accent-color);
        }

        .hero__text h2 {
            font-size: clamp(28px, 5vw, 46px);
            color: var(--text-dark);
            line-height: 1.2;
            font-weight: 700;
            margin: 10px 0;
        }

        .hero__text p {
            margin-bottom: 35px;
            font-size: 16px;
            color: var(--text-secondary);
        }

        .primary-btn {
            display: inline-block;
            font-size: 14px;
            padding: 10px 28px;
            color: var(--text-light);
            text-transform: uppercase;
            font-weight: 700;
            background: var(--accent-color);
            border-radius: 4px;
            letter-spacing: 1px;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .primary-btn:hover,
        .primary-btn:focus {
            background: var(--primary-dark);
            outline: 2px solid var(--text-light);
            outline-offset: 2px;
        }

        .slider-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .slider-dots .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .slider-dots .dot.active {
            background: var(--accent-color);
        }

        /* Desktop: sync hero slider and left banner heights */
        @media (min-width: 992px) {
            .hero-slider {
                aspect-ratio: auto;
                height: 430px;
            }

            .home-left-banner {
                height: 430px;
            }

            .hero__item {
                height: 100%;
            }
        }

        /* Fallback for browsers that don't support aspect-ratio */
        @supports not (aspect-ratio: 16/9) {
            .hero-slider {
                height: 56.25vw;
                /* 16:9 aspect ratio fallback */
                max-height: 500px;
                min-height: 300px;
            }
        }

        @media (min-width: 768px) {
            .hero__item {
                padding-left: 75px;
            }
        }

        @media (max-width: 767px) {
            .hero-slider {
                aspect-ratio: 4/3;
                /* Slightly taller on mobile for better mobile experience */
            }

            @supports not (aspect-ratio: 4/3) {
                .hero-slider {
                    height: 75vw;
                    /* 4:3 aspect ratio fallback for mobile */
                    max-height: 400px;
                    min-height: 250px;
                }
            }
        }





        /* Header */
        .hero__categories__all {
            background: var(--accent-color) !important;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .hero__categories__all::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .hero__categories__all:hover::before {
            left: 100%;
        }

        .hero__categories__all:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px var(--shadow-primary);
        }

        .category-icon-wrapper {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .category-toggle-icon {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .category-toggle-icon:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* Category List Styling */
        .category-list-wrapper {
            background: #f8f9fa;
        }

        .category-item {
            transition: all 0.3s ease;
        }

        .category-link {
            background: var(--bg-secondary);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .category-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, var(--shadow-primary), transparent);
            transition: left 0.5s ease;
        }

        .category-link:hover::before {
            left: 100%;
        }

        .category-link:hover {
            background: var(--bg-light);
            border-color: var(--accent-color);
            transform: translateX(5px);
            box-shadow: 0 4px 15px var(--shadow-primary);
        }

        .category-link:hover .fas.fa-chevron-right {
            transform: translateX(3px);
            color: var(--accent-color) !important;
        }

        .category-icon {
            background: var(--accent-color);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light) !important;
            font-size: 12px;
        }

        .category-sub-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
        }

        .category-sub-icon .fas.fa-circle {
            color: #6c757d !important;
        }

        /* Scrollbar styling */
        #static-category-list::-webkit-scrollbar {
            width: 6px;
        }

        #static-category-list::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #3bb77e, #2d9d6b);
            border-radius: 4px;
        }

        #static-category-list::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 4px;
        }

        /* Animation for chevron */
        .transition {
            transition: all 0.3s ease;
        }

        /* Hover effects for category items */
        .category-item:hover .category-icon {
            transform: scale(1.1);
            box-shadow: 0 4px 12px var(--shadow-primary);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero__categories {
                margin-bottom: 1rem;
            }

            .category-link {
                padding: 0.75rem !important;
            }

            .category-icon {
                width: 28px;
                height: 28px;
                font-size: 10px;
            }
        }

        /* New Category Cards Design */
        .category-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--accent-color);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .category-card:hover::before {
            transform: scaleX(1);
        }

        .category-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 20px 60px var(--shadow-medium);
            border-color: var(--accent-color);
        }

        .category-card-inner {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .category-image-wrapper {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .category-image {
            position: relative;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .category-img {
            /* width: 100%; */
            height: 100% !important;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .category-card:hover .category-img {
            transform: scale(1.1);
        }

        .category-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--accent-color);
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease;
        }

        .category-card:hover .category-overlay {
            opacity: 1;
        }

        .category-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .category-icon i {
            color: var(--text-light);
            font-size: 20px;
        }

        /* Category Badge */
        .category-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 2;
        }

        .category-badge .badge {
            background: var(--accent-color) !important;
            border: 2px solid var(--text-light);
            box-shadow: 0 2px 8px var(--shadow-medium);
            font-weight: 600;
            font-size: 0.75rem;
        }

        /* Category Stats */
        .category-stats {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            z-index: 2;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #2c3e50;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-item i {
            color: var(--accent-color);
            font-size: 0.7rem;
        }

        .category-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .category-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0;
            line-height: 1.3;
            flex: 1;
        }

        .category-rating {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stars {
            display: flex;
            gap: 2px;
        }

        .stars i {
            color: #ffc107;
            font-size: 0.8rem;
        }

        .rating-text {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
        }

        .category-meta {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .shop-count {
            font-size: 0.85rem;
            color: #6c757d;
            display: flex;
            align-items: center;
        }

        .shop-count i {
            color: var(--accent-color);
        }

        .product-count {
            font-size: 0.85rem;
            color: #6c757d;
            display: flex;
            align-items: center;
        }

        .product-count i {
            color: #6c757d;
        }

        /* Category Tags */
        .category-tags {
            display: flex;
            gap: 6px;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .tag {
            background: var(--bg-light);
            color: var(--accent-color);
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            border: 1px solid var(--border-light);
        }

        .category-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            margin-top: auto;
            padding: 12px 16px;
            background: var(--bg-light);
            border-radius: 12px;
            border: 1px solid var(--border-light);
        }

        .category-link:hover {
            color: var(--primary-dark);
            background: var(--bg-light);
            border-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--shadow-primary);
        }

        .link-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: var(--accent-color);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .link-icon i {
            color: var(--text-light);
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .category-link:hover .link-icon {
            background: var(--primary-dark);
            transform: scale(1.1);
        }

        .category-link:hover .link-icon i {
            transform: translateX(2px);
        }

        /* Category section responsive */
        @media (max-width: 768px) {
            .category-card {
                margin-bottom: 1rem;
            }

            .category-image {
                height: 150px;
            }

            .category-content {
                padding: 1rem;
            }

            .category-title {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .category-image {
                height: 120px;
            }

            .category-content {
                padding: 0.75rem;
            }

            .category-title {
                font-size: 0.9rem;
            }

            .category-link {
                font-size: 0.8rem;
            }
        }

        /* Category Slider Styles */
        .category-slider-container {
            position: relative;
            margin: 0 auto;
        }

        .category-slider-wrapper {
            position: relative;
            overflow: hidden;
            padding: 20px 0;
        }

        .category-slider {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            gap: 30px;
        }

        .category-slide {
            flex: 0 0 calc(25% - 22.5px);
            min-width: 280px;
            max-width: 320px;
        }





        /* Responsive Slider */
        @media (max-width: 1200px) {
            .category-slide {
                flex: 0 0 calc(33.333% - 20px);
            }
        }

        @media (max-width: 992px) {
            .category-slide {
                flex: 0 0 calc(50% - 15px);
            }

            .category-slider-container {
                padding: 0 50px;
            }
        }

        @media (max-width: 768px) {
            .category-slide {
                flex: 0 0 calc(100% - 10px);
                min-width: 250px;
            }
        }

        @media (max-width: 576px) {
            .category-slider-wrapper {
                padding: 15px 0;
            }
        }

        /* View More Shops Button Design */
        .view-more-shops-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 1rem;
        }

        .view-more-shops-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 9px 12px;
            border-radius: 3px;
            background: var(--accent-color);
            color: var(--text-light);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 32px var(--shadow-primary);
            border: 2px solid transparent;
            min-width: 280px;
            justify-content: center;
        }

        .view-more-shops-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .view-more-shops-btn:hover::before {
            left: 100%;
        }

        .view-more-shops-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 16px 48px var(--shadow-primary);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .view-more-shops-btn:active {
            transform: translateY(-2px) scale(1.01);
        }

        .btn-text {
            position: relative;
            z-index: 2;
            font-weight: 700;
        }

        .btn-icon {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .btn-icon i {
            font-size: 14px;
            color: var(--text-light);
        }

        .view-more-shops-btn:hover .btn-icon {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1) rotate(5deg);
        }

        .btn-arrow {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .btn-arrow i {
            font-size: 12px;
            color: var(--text-light);
            transition: transform 0.3s ease;
        }

        .view-more-shops-btn:hover .btn-arrow {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.1);
        }

        .view-more-shops-btn:hover .btn-arrow i {
            transform: translateX(3px);
        }

        .btn-shine {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .view-more-shops-btn:hover .btn-shine {
            opacity: 1;
        }

        /* Button responsive design */
        @media (max-width: 768px) {
            .view-more-shops-btn {
                padding: 16px 28px;
                font-size: 1rem;
                min-width: 260px;
                gap: 10px;
            }

            .btn-icon {
                width: 28px;
                height: 28px;
            }

            .btn-icon i {
                font-size: 12px;
            }

            .btn-arrow {
                width: 20px;
                height: 20px;
            }

            .btn-arrow i {
                font-size: 10px;
            }
        }

        @media (max-width: 576px) {
            .view-more-shops-btn {
                padding: 14px 24px;
                font-size: 0.95rem;
                min-width: 240px;
                gap: 8px;
            }

            .btn-text {
                font-size: 0.9rem;
            }
        }

        /* Button animation on page load */
        @keyframes buttonEntrance {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.9);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .view-more-shops-btn {
            animation: buttonEntrance 0.6s ease-out;
        }

        /* Category Carousel Section */
        /* Container */
        .category-carousel-container {
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 20px 0;
        }

        /* Carousel */
        .category-carousel {
            display: flex;
            flex-wrap: wrap;
            gap: 32px 24px;
            justify-content: center;
            width: 100%;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 0 60px;
            scrollbar-width: none;
        }

        .category-carousel::-webkit-scrollbar {
            display: none;
        }

        /* Category Item */
        .category-circle-link {
            text-decoration: none;
        }

        /* 2-Row Grid for Categories */
        .category-slide-grid {
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100%;
            justify-content: center;
            align-items: center;
        }

        .category-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: box-shadow 0.2s, transform 0.2s, border 0.2s;
            cursor: pointer;
            border: 2px solid #0000004f;
            position: relative;
        }

        .category-circle:hover {
            box-shadow: 0 8px 24px var(--shadow-primary);
            border: 2px solid var(--accent-color);
            transform: translateY(-4px) scale(1.04);
            background: var(--bg-light);
        }

        /* Circle Icon */
        .circle-icon {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .circle-icon img {
            width: 100%;
            /* height: 70%; */
            object-fit: contain;
        }

        /* Category Name */
        .category-name {
            font-size: 14px;
            color: #222;
            word-break: break-word;
            margin-top: 2px;
        }

        /* Arrow Buttons */
        .category-arrow {
            position: absolute;
            top: 60%;
            transform: translateY(-50%);
            z-index: 2;
            background: #fff;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.13);
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.5rem;
            transition: background 0.2s;
        }



        .category-arrow:hover {
            background: var(--bg-light);
        }

        .left-arrow {
            left: 10px;
        }

        .right-arrow {
            right: 10px;
        }

        @media (max-width: 992px) {
            .category-carousel {
                gap: 24px 12px;
                padding: 0 20px;
            }

            .category-circle {
                width: 110px;
                height: 110px;
            }
        }

        @media (max-width: 576px) {
            .category-carousel {
                gap: 16px 8px;
                padding: 0 5px;
            }

            .category-circle {
                width: 90px;
                height: 90px;
            }

            .circle-icon {
                width: 100%;
                height: 100%;
                font-size: 1.2rem;
            }

            .category-name {
                font-size: 0.85rem;
            }
        }


        .custom-scroll {
            display: block;
            max-height: 324px;
            overflow-y: auto;
            background-color: #f9f9f9;
            padding-right: 8px;
            margin-bottom: 10px;
        }

        /* Chrome, Edge, Safari */
        .custom-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        /* Firefox */
        .custom-scroll {
            scrollbar-width: none;
            scrollbar-color: #888 #f0f0f0;
        }


        .banner-bg {
            background: linear-gradient(90deg, var(--clay-orange) 0%, var(--clay-light) 100%);
        }

        .banner-bg-white {
            background-color: var(--bg-light);
        }

        .card {
            border-radius: 10px;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card-title {
            font-size: 1rem;
        }
    </style>
    <livewire:styles />
@endsection

@section('content')

    @php
        // Use Laravel cache for expensive queries
        use Illuminate\Support\Facades\Cache;
        use App\Models\Prodcat;
        use App\Models\Shop;
        $categories = Cache::remember('header_categories', 3600, function () {
            return Prodcat::whereNull('parent_id')->orderBy('role', 'asc')->with('childrens')->get();
        });

        $shops = Cache::remember('header_shops', 3600, function () {
            return Shop::latest()->get();
        });
    @endphp
    <x-app.header />
    <section class="hero">
        <div class="container">
            <div class="hero-slider-wrapper mt-4">
                {{-- <div class="col-lg-5 d-none d-lg-block" style="min-height: 100%;">
                    <x-banner.home-left-banner />
                </div> --}}
                <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000"
                    data-bs-pause="hover">
                    <div class="carousel-inner">
                        @foreach ($sliders as $index => $slider)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ Storage::url($slider->image) }}" class="d-block w-100" style="cursor: pointer;"
                                    onclick="window.location.href='{{ $slider->url }}'" alt="Slider {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- hero section end -->


    <!-- Main Slider End -->

    <!--  category Section Start -->
    <section class="section ec-category-section mt-3">
        <div class="container">
            {{-- <div class="row">
                <div class="col-12">
                    <div class="mb-5 mt-5">
                        <h1 class="related-product-sec-title mb-3">Browse Shops by Categories</h1>
                        <p class="text-muted fs-6">Discover amazing shops organized by categories</p>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="swiper category-swiper pb-5 pt-5">
                <div class="swiper-wrapper">
                    @foreach ($categories->chunk(2) as $categoryChunk)
                        <div class="swiper-slide">
                            <div class="category-slide-grid">
                                @foreach ($categoryChunk as $category)
                                    <a href="{{ route('shops', ['category' => $category->slug]) }}"
                                        class="category-circle-link d-flex justify-content-center align-items-center text-center">
                                        <div class="">
                                            <div class="category-circle text-center">
                                                <div class="circle-icon mx-auto mb-2"
                                                    style="margin-bottom: 0px !important;">
                                                    @if (!empty($category->logo))
                                                        <img src="{{ Storage::url($category->logo) }}"
                                                            alt="{{ $category->name }}">
                                                    @else
                                                        <img src="{{ asset('assets/img/test.jpg') }}" alt="No Image">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="category-name px-3">
                                                {{ Str::limit($category->name, 10) }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> --}}
        </div>
    </section>
    <!--category Section End -->

    <!-- Product tab Area Start -->

    <section class="section ec-product-tab">
        <div class="container">
            <div class="row">

                <!-- Product area start -->
                @if ($latest_products->count() > 0)
                    <section class="section ec-new-product">
                        <div class="">
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <div class="section-title">

                                        <h2 id="trending" class="related-product-sec-title"> Trending Products</h2>
                                    </div>
                                    <div class="ec-spe-section" data-animation="slideInLeft">
                                        <div class="ec-spe-products">
                                            @foreach ($latest_products->chunk(6) as $products)
                                                <div class="ec-fs-product">
                                                    <div class="ec-fs-pro-inner">
                                                        <div
                                                            class="row row-cols-lg-6 row-cols-md-3 row-cols-2 mt-4 ms-0 me-0">
                                                            @foreach ($products as $product)
                                                                {{-- @dd($product) --}}
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
                        </div>
                    </section>
                @endif

                <!-- product area end -->
                <!-- Offer section  -->
                <div class="container">
                    <div class="row" style="height: max-content;">
                        <div class="col-lg-4 ps-0 d-flex mid-bn   " style="">
                            <x-banner.home-one-left />
                        </div>

                        <div class="col-lg-8 mid-bn mb-4 " style="height: 100%;">
                            <x-banner.home-one-right />
                        </div>
                    </div>
                </div>
                <!-- Offer section end -->
                <!-- Product area start -->
                @if ($bestsaleproducts->count() > 0)
                    <section class="section ec-new-product">
                        <div class="">
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <div class="section-title">

                                        <h2 id="bestSeller" class="related-product-sec-title"> Our Best Sellers</h2>
                                    </div>
                                    <div class="ec-spe-section" data-animation="slideInLeft">
                                        <div class="ec-spe-products">
                                            @if ($recommandProducts->count() > 0)
                                                @foreach ($recommandProducts->chunk(6) as $products)
                                                    <div class="ec-fs-product">
                                                        <div class="ec-fs-pro-inner">
                                                            <div
                                                                class="row row-cols-lg-6 row-cols-md-3 row-cols-2 mt-4 me-0 ms-0">
                                                                @foreach ($products as $product)
                                                                    <x-products.product :product="$product" />
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                @foreach ($bestsaleproducts->chunk(6) as $products)
                                                    <div class="ec-fs-product">
                                                        <div class="ec-fs-pro-inner">
                                                            <div
                                                                class="row row-cols-lg-6 row-cols-md-3 row-cols-2 mt-4 me-0 ms-0">
                                                                @foreach ($products as $product)
                                                                    <x-products.product :product="$product" />
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- New Product Content -->
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </section>
    <!-- ec Product tab Area End -->
    <x-banner.home-mid-four-card-banner />
    <!-- Product tab Area Start -->
    <section class="section ec-product-tab section-space-p">
        <div class="container">
            <div class="row">
                <div class=" col-md-12">
                    <h2 class="related-product-sec-title">Our catalogue</h2>
                </div>

                <div class="tab-pane fade show active" id="all">
                    <div class="row row-cols-lg-6 row-cols-md-3 row-cols-2 mt-4">
                        @foreach ($allproducts as $index => $product)
                            <x-products.product :product="$product" />

                            {{-- Banners that remain after the 12th product --}}
                            @if ($index + 1 == 12)
                    </div>
                    {{-- <div class="row">
                        <div class="container my-4">
                            <div class="row" style="height: max-content;">
                                <div class="col-lg-4 ps-0 d-flex mid-bn">
                                    <x-banner.home-catalog-mid-left />
                                </div>
                                <div class="col-lg-12 mid-bn mb-4" style="height: 100%;">
                                    <x-banner.home-catalog-mid-right />
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <x-banner.home-mid-six-image-banner />
                    <div class="row">
                        @endif

                        {{-- Banners that will now appear after the 24th product --}}
                        @if ($index + 1 == 36)
                    </div>
                    <div class="container">
                        <div class="row" style="height: max-content;">
                            <div class="col-lg-4 ps-0 d-flex mid-bn">
                                <x-banner.home-catalog-end-left />
                            </div>
                            <div class="col-lg-8 mid-bn mb-4" style="height: 100%;">
                                <x-banner.home-catalog-end-right />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ec Product tab Area End -->
    @if ($showcaseProducts->count() > 0)
        <section class="section ec-new-product">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-left">
                        <div class="section-title">

                            <h2 id="showcase" class="related-product-sec-title"> ShowCase Products</h2>
                        </div>
                        <div class="ec-spe-section" data-animation="slideInLeft">
                            <div class="ec-spe-products">
                                @foreach ($showcaseProducts->chunk(6) as $products)
                                    <div class="ec-fs-product">
                                        <div class="ec-fs-pro-inner">
                                            <div class="row row-cols-lg-6 row-cols-md-3 row-cols-2 mt-4 me-0 ms-0">
                                                @foreach ($products as $product)
                                                    {{-- @dd($product) --}}
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
            </div>
            <!-- New Product Content -->


        </section>
    @endif

    <x-banner.home-end-four-card-banner />
    <!-- Explore shop -->
    @if ($allproducts->count() > 0)
        <section class="section ec-new-product">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-left">
                        <div class="section-title">

                            <h2 class="related-product-sec-title"> Trending Shops</h2>
                        </div>
                        <div class="ec-spe-section" data-animation="slideInLeft">
                            <div class="ec-spe-products">
                                @foreach ($latest_shops->chunk(4) as $shops)
                                    <div class="ec-fs-product">
                                        <div class="ec-fs-pro-inner">

                                            <div class="row mt-4 ms-0 me-0">
                                                @foreach ($shops as $shop)
                                                    <div class="col-lg-3 col-12 mb-4 pro-gl-content-shop">
                                                        <x-shops-card.card-1 :shop="$shop" />
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                @endforeach

                            </div>


                        </div>

                        <div class="view-more-shops-container mb-5">
                            <a href="{{ route('vendors') }}" class="view-more-shops-btn">
                                <span class="btn-text" style="color: #ffffff">Explore All Shops</span>
                                <div class="btn-icon">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div class="btn-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                                <div class="btn-shine"></div>
                            </a>
                        </div>

                    </div>
                </div>
                <!-- New Product Content -->

            </div>
        </section>
    @endif

    <!-- Product tab area end -->
    </main>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    {{-- <livewire:scripts /> --}}
    <script src="{{ asset('assets/frontend-assets/js/demo-8.js') }}"></script>
    {{-- <script src="{{ asset('assets/frontend-assets/js/demo-3.js') }}"></script> --}}

    <script>
        function scrollCategories(direction) {
            const carousel = document.getElementById('categoryCarousel');
            const scrollAmount = 300;
            carousel.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>


    <script>
        const swiper = new Swiper('.category-swiper', {
            slidesPerView: 4,
            spaceBetween: 24,
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                0: {
                    slidesPerView: 3,
                },
                576: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 5,
                },
                1200: {
                    slidesPerView: 7,
                }
            },
        });
    </script>

@endsection
