@extends('layouts.app')
@section('content')
    <x-app.header />

    <!-- Terms and Conditions Hero Section -->
    <div class="terms-hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="terms-hero-title">{{ $termsAndConditions->title ?? 'Terms and Conditions' }}</h1>
                    <p class="terms-hero-subtitle text-dark">
                        {{ $termsAndConditions->excerpt ?? 'Please read these terms and conditions carefully before using our platform.' }}
                    </p>
                    <div class="last-updated mt-3">
                        {{-- <span class="badge bg-primary">Last Updated: {{ date('F d, Y') }}</span> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms and Conditions Content Section -->
    <div class="terms-content-section">
        <div class="container">
            @if ($termsAndConditions && $termsAndConditions->body)
                {!! $termsAndConditions->body !!}
            @else
                <!-- Default Terms and Conditions Content -->
                <div class="terms-content-wrapper">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> This is a default terms and conditions template. Please create a page with
                        slug 'terms-and-conditions' in your admin panel to customize this content.
                    </div>

                    <!-- Introduction -->
                    <div class="terms-section" id="introduction">
                        <div class="section-header">
                            <h2>Introduction</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p class="lead">Welcome to Afrikart.com, a premier multi-vendor marketplace connecting art
                                enthusiasts worldwide with authentic African artists and cultural artisans.</p>
                            <p>By accessing and using our platform, you agree to be bound by these Terms and Conditions. If
                                you do not agree to these terms, please do not use our services.</p>
                        </div>
                    </div>

                    <!-- Acceptance of Terms -->
                    <div class="terms-section" id="acceptance">
                        <div class="section-header">
                            <h2><i class="fas fa-check-circle me-3"></i>Acceptance of Terms</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p>By creating an account, browsing our marketplace, or purchasing artwork, you acknowledge that
                                you have read, understood, and agree to be bound by these Terms and Conditions.</p>
                            <ul class="terms-list">
                                <li>You must be at least 18 years old to use our platform</li>
                                <li>You are legally capable of entering into binding agreements</li>
                                <li>All information provided is accurate and current</li>
                                <li>You will comply with all applicable laws and regulations</li>
                            </ul>
                        </div>
                    </div>

                    <!-- User Accounts -->
                    <div class="terms-section" id="user-accounts">
                        <div class="section-header">
                            <h2><i class="fas fa-user me-3"></i>User Accounts</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <h4>Account Registration</h4>
                            <p>To access certain features of our platform, you must create an account. You are responsible
                                for:</p>
                            <ul class="terms-list">
                                <li>Providing accurate and complete registration information</li>
                                <li>Maintaining the security of your account credentials</li>
                                <li>All activities that occur under your account</li>
                                <li>Promptly notifying us of any unauthorized access</li>
                            </ul>

                            <h4>Account Termination</h4>
                            <p>We reserve the right to suspend or terminate accounts that violate these terms or engage in
                                fraudulent activities.</p>
                        </div>
                    </div>

                    <!-- Marketplace Rules -->
                    <div class="terms-section" id="marketplace-rules">
                        <div class="section-header">
                            <h2><i class="fas fa-store me-3"></i>Marketplace Rules</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <h4>For Customers</h4>
                            <ul class="terms-list">
                                <li>Respect the intellectual property rights of artists</li>
                                <li>Provide accurate shipping and payment information</li>
                                <li>Follow our dispute resolution process for any issues</li>
                                <li>Comply with international shipping regulations</li>
                            </ul>

                            <h4>For Artists/Vendors</h4>
                            <ul class="terms-list">
                                <li>Ensure all artwork is authentic and original</li>
                                <li>Provide accurate product descriptions and images</li>
                                <li>Maintain professional communication with customers</li>
                                <li>Fulfill orders within agreed timeframes</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Payment Terms -->
                    <div class="terms-section" id="payment-terms">
                        <div class="section-header">
                            <h2><i class="fas fa-credit-card me-3"></i>Payment Terms</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p>All transactions are processed securely through our certified payment partners. Payment terms
                                include:</p>
                            <ul class="terms-list">
                                <li>Payment is required before order processing begins</li>
                                <li>We accept major credit cards and digital payment methods</li>
                                <li>All prices are in USD unless otherwise specified</li>
                                <li>Additional taxes and fees may apply based on location</li>
                                <li>Refunds are processed according to our return policy</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Intellectual Property -->
                    <div class="terms-section" id="intellectual-property">
                        <div class="section-header">
                            <h2><i class="fas fa-copyright me-3"></i>Intellectual Property</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p>All content on Afrikart.com, including but not limited to text, graphics, logos, and images,
                                is protected by copyright and other intellectual property laws.</p>
                            <ul class="terms-list">
                                <li>Artists retain ownership of their original artwork</li>
                                <li>Platform content is owned by Afrikart.com or licensed to us</li>
                                <li>Users may not reproduce content without permission</li>
                                <li>Unauthorized use may result in legal action</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Limitation of Liability -->
                    <div class="terms-section" id="liability">
                        <div class="section-header">
                            <h2><i class="fas fa-shield-alt me-3"></i>Limitation of Liability</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p>Afrikart.com provides our platform "as is" and makes no warranties regarding the accuracy,
                                completeness, or reliability of content or services.</p>
                            <ul class="terms-list">
                                <li>We are not liable for damages arising from platform use</li>
                                <li>Users assume responsibility for their transactions</li>
                                <li>Our liability is limited to the maximum extent permitted by law</li>
                                <li>Force majeure events may affect service availability</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="terms-section" id="contact-info">
                        <div class="section-header">
                            <h2><i class="fas fa-envelope me-3"></i>Contact Us</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p>If you have questions about these Terms and Conditions, please contact us:</p>
                            <div class="contact-methods">
                                <div class="contact-method">
                                    <div class="contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-details">
                                        <h5>Email</h5>
                                        <p>{{ settings::setting('site_email') ?? 'support@afrikart.com' }}</p>
                                    </div>
                                </div>
                                <div class="contact-method">
                                    <div class="contact-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="contact-details">
                                        <h5>Phone</h5>
                                        <p>{{ settings::setting('site_phone') ?? '+1 (555) 123-4567' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Terms and Conditions Custom Styles -->
    <style>
        /* Terms Hero Section */
        .terms-hero-section {
            background: linear-gradient(135deg, #de991b 0%, #fadca4 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .terms-hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .terms-hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
            opacity: 0.9;
        }

        /* Terms Content Section */
        .terms-content-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        /* Terms Content Wrapper */
        .terms-content-wrapper {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        /* Terms Sections */
        .terms-section {
            margin-bottom: 50px;
            scroll-margin-top: 100px;
        }

        .terms-section:last-child {
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

        /* Terms Lists */
        .terms-list {
            margin: 15px 0;
            padding-left: 0;
        }

        .terms-list li {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
            list-style: none;
        }

        .terms-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--accent-color, #667eea);
            font-weight: bold;
            font-size: 1.1rem;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .terms-hero-title {
                font-size: 2.5rem;
            }

            .terms-hero-subtitle {
                font-size: 1rem;
            }

            .terms-content-wrapper {
                padding: 20px;
                margin: 0 15px;
            }

            .section-header h2 {
                font-size: 1.5rem;
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
