@extends('layouts.app')
@section('content')
    <x-app.header />

    <!-- Privacy Policy Hero Section -->
    <div class="privacy-hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="privacy-hero-title">{{ $$whySell->title }}</h1>
                    <p class="privacy-hero-subtitle text-dark">{{ $$whySell->excerpt }}</p>
                    <div class="last-updated mt-3">
                        {{-- <span class="badge bg-primary">Last Updated: {{ date('F d, Y') }}</span> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Content Section -->
    <div class="privacy-content-section">
        <div class="container">
            {!! $$whySell->body !!}
        </div>
    </div>

    <!-- Privacy Policy Custom Styles -->
    <style>
        /* Privacy Policy Hero Section */
        .privacy-hero-section {
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .privacy-hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .privacy-hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
            opacity: 0.9;
        }

        .last-updated {
            position: relative;
            z-index: 2;
        }

        /* Privacy Content Section */
        .privacy-content-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        /* Privacy Navigation */
        .privacy-navigation {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 100px;
        }

        .nav-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .privacy-nav-list .list-group-item {
            border: none;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            padding: 15px 20px;
            cursor: pointer;
        }

        .list-group-item.active {
            z-index: 2;
            color: #ffffff;
            background-color: var(--accent-color, #667eea) !important;
            border-color: var(--accent-color-dark, #555) !important;
        }

        /* Privacy Content Wrapper */
        .privacy-content-wrapper {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        /* Privacy Sections */
        .privacy-section {
            margin-bottom: 50px;
            scroll-margin-top: 100px;
        }

        .privacy-section:last-child {
            margin-bottom: 0;
        }

        .section-header {
            margin-bottom: 30px;
        }

        .section-header h2 {
            color: #2d3748;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .section-header h2 i {
            color: var(--accent-color, #667eea);
        }

        .section-divider {
            height: 4px;
            background: linear-gradient(90deg, var(--accent-color, #667eea) 0%, transparent 100%);
            border-radius: 2px;
            width: 60px;
        }

        .section-content {
            line-height: 1.8;
            color: #4a5568;
        }

        .section-content .lead {
            font-size: 1.2rem;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .section-content h4 {
            color: #2d3748;
            font-weight: 600;
            margin: 25px 0 15px 0;
            font-size: 1.3rem;
        }

        .section-content h5 {
            color: #2d3748;
            font-weight: 600;
            margin: 20px 0 10px 0;
            font-size: 1.1rem;
        }

        /* Privacy Lists */
        .privacy-list {
            margin: 15px 0;
            padding-left: 0;
        }

        .privacy-list li {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
            list-style: none;
        }

        .privacy-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--accent-color, #667eea);
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* Use Categories */
        .use-category {
            background: #f7fafc;
            /* border-radius: 12px; */
            padding: 25px;
            margin: 20px 0;
            /* border-left: 4px solid var(--accent-color, #667eea); */
        }

        .use-category h4 {
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .use-category h4 i {
            color: var(--accent-color, #667eea);
        }

        /* Sharing Categories */
        .sharing-category {
            background: #f7fafc;
            /* border-radius: 12px; */
            padding: 25px;
            margin: 20px 0;
            /* border-left: 4px solid #48bb78; */
        }

        .sharing-category h4 {
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .sharing-category h4 i {
            color: var(--accent-color);
        }

        /* Security Measures */
        .security-measures {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .security-item {
            background: #f7fafc;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .security-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .security-icon {
            width: 60px;
            height: 60px;
            background: var(--accent-color, #667eea);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .security-icon i {
            color: white;
            font-size: 1.5rem;
        }

        .security-content h5 {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .security-content p {
            color: #718096;
            margin: 0;
            font-size: 0.95rem;
        }

        /* Cookie Types */
        .cookie-types {
            margin: 30px 0;
        }

        .cookie-type {
            background: #f7fafc;
            /* border-radius: 12px; */
            padding: 25px;
            margin: 20px 0;
            /* border-left: 4px solid #ff6b6b; */
        }

        .cookie-type h4 {
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .cookie-type h4 i {
            color: #ff6b6b;
        }

        .cookie-control {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        /* Rights Grid */
        .rights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .right-item {
            background: #f7fafc;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .right-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .right-icon {
            width: 50px;
            height: 50px;
            background: var(--accent-color, #667eea);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .right-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .right-item h5 {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .right-item p {
            color: #718096;
            margin: 0;
            font-size: 0.9rem;
        }

        .rights-exercise {
            background: #e6fffa;
            border: 1px solid #b2f5ea;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        /* Vendor Data Sections */
        .vendor-data-section {
            background: #f7fafc;
            /* border-radius: 12px; */
            padding: 25px;
            margin: 20px 0;
            /* border-left: 4px solid #38a169; */
        }

        .vendor-data-section h4 {
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .vendor-data-section h4 i {
            color: #38a169;
        }

        /* Contact Methods */
        .contact-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .contact-method {
            background: #f7fafc;
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }

        .contact-method:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: var(--accent-color, #667eea);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .contact-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .contact-details h5 {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .contact-details p {
            color: #718096;
            margin: 0;
            font-size: 0.95rem;
        }

        .response-time {
            margin: 30px 0;
        }

        /* Update Notification */
        .update-notification,
        .continued-use {
            background: #f0fff4;
            border: 1px solid #c6f6d5;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .privacy-hero-title {
                font-size: 2.5rem;
            }

            .privacy-hero-subtitle {
                font-size: 1rem;
            }

            .privacy-content-wrapper {
                padding: 20px;
            }

            .privacy-navigation {
                padding: 20px;
                position: static;
            }

            .section-header h2 {
                font-size: 1.5rem;
            }

            .security-measures {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .rights-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .contact-methods {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .contact-method {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
@endsection
