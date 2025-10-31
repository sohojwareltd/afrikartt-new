@extends('layouts.app')
@section('content')
    <x-app.header />

    <!-- Privacy Policy Hero Section -->
    <div class="privacy-hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="privacy-hero-title">{{ $privacyPolicy->title }}</h1>
                    <p class="privacy-hero-subtitle text-dark">{{ $privacyPolicy->excerpt }}</p>
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
            {{-- <div class="row">
                <!-- Privacy Policy Navigation Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="privacy-navigation">
                        <h5 class="nav-title">Quick Navigation</h5>
                        <div class="list-group privacy-nav-list">
                            <a href="#information-collection" class="list-group-item list-group-item-action active">
                                <i class="fas fa-database me-2"></i>Information We Collect
                            </a>
                            <a href="#information-use" class="list-group-item list-group-item-action">
                                <i class="fas fa-cogs me-2"></i>How We Use Information
                            </a>
                            <a href="#information-sharing" class="list-group-item list-group-item-action">
                                <i class="fas fa-share-alt me-2"></i>Information Sharing
                            </a>
                            <a href="#data-security" class="list-group-item list-group-item-action">
                                <i class="fas fa-shield-alt me-2"></i>Data Security
                            </a>
                            <a href="#cookies" class="list-group-item list-group-item-action">
                                <i class="fas fa-cookie-bite me-2"></i>Cookies & Tracking
                            </a>
                            <a href="#user-rights" class="list-group-item list-group-item-action">
                                <i class="fas fa-user-shield me-2"></i>Your Rights
                            </a>
                            <a href="#vendor-data" class="list-group-item list-group-item-action">
                                <i class="fas fa-store me-2"></i>Vendor Data
                            </a>
                            <a href="#contact-info" class="list-group-item list-group-item-action">
                                <i class="fas fa-envelope me-2"></i>Contact Us
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Privacy Policy Content -->
                <div class="col-lg-9">
                    <div class="privacy-content-wrapper">

                        <!-- Introduction -->
                        <div class="privacy-section" id="introduction">
                            <div class="section-header">
                                <h2>Introduction</h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <p class="lead">Welcome to AfrikArtt.com, a premier multi-vendor marketplace connecting
                                    art enthusiasts worldwide with authentic African artists and cultural artisans. This Privacy Policy explains how we collect,
                                    use, disclose, and safeguard your information when you visit our website at http://afrikartt.com and use our
                                    marketplace services.</p>
                                <p>By using our platform, you consent to the data practices described in this policy. This
                                    policy applies to all users of our marketplace, including customers, African artists, vendors, and
                                    website visitors browsing our collection of authentic African art.</p>
                            </div>
                        </div>

                        <!-- Information We Collect -->
                        <div class="privacy-section" id="information-collection">
                            <div class="section-header">
                                <h2><i class="fas fa-database me-3"></i>Information We Collect</h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <h4>Personal Information</h4>
                                <p>We collect information you provide directly to us, including:</p>
                                <ul class="privacy-list">
                                    <li><strong>Account Information:</strong> Name, email address, phone number, and
                                        password when you create an account on AfrikArtt.com</li>
                                    <li><strong>Profile Information:</strong> Profile picture, bio, art preferences, cultural interests, and other
                                        optional profile details</li>
                                    <li><strong>Payment Information:</strong> Billing address, shipping address, payment method details
                                        (processed securely through our certified payment partners)</li>
                                    <li><strong>Communication Data:</strong> Messages between buyers and African artists, artwork reviews, ratings, and other
                                        communications on our platform</li>
                                    <li><strong>Artist/Vendor Information:</strong> For African artists - business details, portfolio information, cultural background, tax information, bank account
                                        details for commission payments</li>
                                </ul>

                                <h4>Automatically Collected Information</h4>
                                <ul class="privacy-list">
                                    <li><strong>Usage Data:</strong> Pages visited, artworks viewed, time spent browsing, clicks, searches for African art, and
                                        browsing behavior on AfrikArtt.com</li>
                                    <li><strong>Device Information:</strong> IP address, browser type, operating system,
                                        device identifiers used to access our African art marketplace</li>
                                    <li><strong>Location Data:</strong> General location based on IP address to show relevant African artists and shipping options (with your
                                        consent for precise location)</li>
                                    <li><strong>Cookies and Tracking:</strong> Information collected through cookies and
                                        similar technologies to enhance your art browsing experience</li>
                                </ul>
                            </div>
                        </div>

                        <!-- How We Use Information -->
                        <div class="privacy-section" id="information-use">
                            <div class="section-header">
                                <h2><i class="fas fa-cogs me-3"></i>How We Use Your Information</h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <p>We use the collected information for various purposes:</p>

                                <div class="use-category">
                                    <h4><i class="fas fa-shopping-cart me-2"></i>Marketplace Services</h4>
                                    <ul class="privacy-list">
                                        <li>Process and fulfill orders for authentic African artworks from multiple artists</li>
                                        <li>Facilitate communication between art buyers and African artists/vendors</li>
                                        <li>Provide customer support for artwork purchases and resolve disputes</li>
                                        <li>Manage user accounts and African artist profiles on AfrikArtt.com</li>
                                        <li>Verify authenticity of African art pieces and artist credentials</li>
                                    </ul>
                                </div>

                                <div class="use-category">
                                    <h4><i class="fas fa-chart-line me-2"></i>Platform Enhancement</h4>
                                    <ul class="privacy-list">
                                        <li>Analyze browsing patterns to improve our African art marketplace</li>
                                        <li>Personalize your art discovery experience and recommend similar African artworks</li>
                                        <li>Develop new features for connecting with African artists</li>
                                        <li>Conduct research on African art trends and cultural preferences</li>
                                        <li>Curate collections and featured African artist showcases</li>
                                    </ul>
                                </div>

                                <div class="use-category">
                                    <h4><i class="fas fa-envelope me-2"></i>Communication & Updates</h4>
                                    <ul class="privacy-list">
                                        <li>Send order confirmations and shipping updates for your African art purchases</li>
                                        <li>Provide customer service and support for artwork inquiries</li>
                                        <li>Send newsletters about new African artists and artwork collections (with your consent)</li>
                                        <li>Notify you of policy changes and important AfrikArtt.com updates</li>
                                        <li>Share information about African art exhibitions and cultural events</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Information Sharing -->
                        <div class="privacy-section" id="information-sharing">
                            <div class="section-header">
                                <h2><i class="fas fa-share-alt me-3"></i>Information Sharing and Disclosure</h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <p>We may share your information in the following circumstances:</p>

                                <div class="sharing-category">
                                    <h4><i class="fas fa-store me-2"></i>With African Artists & Vendors</h4>
                                    <p>When you purchase African artwork, we share necessary information with the relevant artist(s)
                                        to fulfill your order, including:</p>
                                    <ul class="privacy-list">
                                        <li>Your name and shipping address for artwork delivery</li>
                                        <li>Contact information for delivery coordination and artwork updates</li>
                                        <li>Order details, artwork specifications, and any special preferences</li>
                                        <li>Communication preferences for follow-up on your African art purchase</li>
                                    </ul>
                                </div>

                                <div class="sharing-category">
                                    <h4><i class="fas fa-handshake me-2"></i>With Trusted Service Providers</h4>
                                    <p>We work with carefully selected third-party service providers who assist us in:</p>
                                    <ul class="privacy-list">
                                        <li>Payment processing and fraud prevention for art transactions</li>
                                        <li>International shipping and logistics for African artwork delivery</li>
                                        <li>Email and communication services for customer updates</li>
                                        <li>Analytics and marketing services to promote African art</li>
                                        <li>Customer support and live chat services for artwork inquiries</li>
                                        <li>Art authentication and verification services</li>
                                    </ul>
                                </div>

                                <div class="sharing-category">
                                    <h4><i class="fas fa-balance-scale me-2"></i>Legal Requirements & Safety</h4>
                                    <p>We may disclose information when required by law or to protect AfrikArtt.com and our users:</p>
                                    <ul class="privacy-list">
                                        <li>Comply with legal processes and government requests</li>
                                        <li>Protect our rights, property, and the safety of our African art community</li>
                                        <li>Prevent fraud and ensure marketplace security for all users</li>
                                        <li>Enforce our terms of service and community guidelines</li>
                                        <li>Protect the intellectual property rights of African artists</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Data Security -->
                        <div class="privacy-section" id="data-security">
                            <div class="section-header">
                                <h2><i class="fas fa-shield-alt me-3"></i>Data Security</h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <p>We implement comprehensive security measures to protect your personal information and ensure the safety of our African art marketplace:</p>

                                <div class="security-measures">
                                    <div class="security-item">
                                        <div class="security-icon">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <div class="security-content">
                                            <h5>Encryption</h5>
                                            <p>All sensitive data is encrypted in transit and at rest using
                                                industry-standard encryption protocols.</p>
                                        </div>
                                    </div>

                                    <div class="security-item">
                                        <div class="security-icon">
                                            <i class="fas fa-server"></i>
                                        </div>
                                        <div class="security-content">
                                            <h5>Secure Infrastructure</h5>
                                            <p>Our servers are hosted in secure data centers with 24/7 monitoring and access
                                                controls.</p>
                                        </div>
                                    </div>

                                    <div class="security-item">
                                        <div class="security-icon">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                        <div class="security-content">
                                            <h5>Access Controls</h5>
                                            <p>Strict access controls ensure only authorized personnel can access personal
                                                information.</p>
                                        </div>
                                    </div>

                                    <div class="security-item">
                                        <div class="security-icon">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                        <div class="security-content">
                                            <h5>Regular Monitoring</h5>
                                            <p>Continuous monitoring for suspicious activities and potential security
                                                threats.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cookies and Tracking -->
                        <div class="privacy-section" id="cookies">
                            <div class="section-header">
                                <h2><i class="fas fa-cookie-bite me-3"></i>Cookies and Tracking Technologies</h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <p>We use cookies and similar technologies to enhance your experience on AfrikArtt.com:</p>

                                <div class="cookie-types">
                                    <div class="cookie-type">
                                        <h4><i class="fas fa-cog me-2"></i>Essential Cookies</h4>
                                        <p>Required for basic AfrikArtt.com functionality, including:</p>
                                        <ul class="privacy-list">
                                            <li>User authentication and secure session management</li>
                                            <li>Shopping cart functionality for artwork purchases</li>
                                            <li>Security and fraud prevention for the marketplace</li>
                                            <li>Language and currency preferences for international users</li>
                                        </ul>
                                    </div>

                                    <div class="cookie-type">
                                        <h4><i class="fas fa-chart-bar me-2"></i>Analytics Cookies</h4>
                                        <p>Help us understand how visitors explore African art on our site:</p>
                                        <ul class="privacy-list">
                                            <li>Page views and artwork interactions</li>
                                            <li>Popular African art categories and search terms</li>
                                            <li>Performance optimization for better browsing experience</li>
                                            <li>Artist profile visits and engagement metrics</li>
                                        </ul>
                                    </div>

                                    <div class="cookie-type">
                                        <h4><i class="fas fa-bullseye me-2"></i>Marketing Cookies</h4>
                                        <p>Used to deliver relevant advertisements and content:</p>
                                        <ul class="privacy-list">
                                            <li>Personalized African artwork recommendations</li>
                                            <li>Retargeting campaigns for viewed artworks</li>
                                            <li>Social media integration for sharing African art</li>
                                            <li>Newsletter personalization based on art preferences</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="cookie-control">
                                    <h4>Cookie Management</h4>
                                    <p>You can control cookies through your browser settings. Note that disabling certain
                                        cookies may affect your ability to browse and purchase African artworks on AfrikArtt.com.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Your Rights -->
                        <div class="privacy-section" id="user-rights">
                            <div class="section-header">
                                <h2><i class="fas fa-user-shield me-3"></i>Your Privacy Rights</h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <p>You have several rights regarding your personal information:</p>

                                <div class="rights-grid">
                                    <div class="right-item">
                                        <div class="right-icon">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                        <h5>Access</h5>
                                        <p>Request a copy of the personal information we hold about you</p>
                                    </div>

                                    <div class="right-item">
                                        <div class="right-icon">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <h5>Correction</h5>
                                        <p>Update or correct inaccurate personal information</p>
                                    </div>

                                    <div class="right-item">
                                        <div class="right-icon">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                        <h5>Deletion</h5>
                                        <p>Request deletion of your personal information (subject to legal requirements)</p>
                                    </div>

                                    <div class="right-item">
                                        <div class="right-icon">
                                            <i class="fas fa-download"></i>
                                        </div>
                                        <h5>Portability</h5>
                                        <p>Receive your data in a portable format</p>
                                    </div>

                                    <div class="right-item">
                                        <div class="right-icon">
                                            <i class="fas fa-ban"></i>
                                        </div>
                                        <h5>Objection</h5>
                                        <p>Object to certain processing of your personal information</p>
                                    </div>

                                    <div class="right-item">
                                        <div class="right-icon">
                                            <i class="fas fa-pause"></i>
                                        </div>
                                        <h5>Restriction</h5>
                                        <p>Request restriction of processing in certain circumstances</p>
                                    </div>
                                </div>

                                <div class="rights-exercise">
                                    <h4>How to Exercise Your Rights</h4>
                                    <p>To exercise any of these rights, please contact us using the information provided in
                                        the "Contact Us" section. We will respond to your request within 30 days.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Vendor Data -->
                        <div class="privacy-section" id="vendor-data">
                            <div class="section-header">
                                <h2><i class="fas fa-store me-3"></i>Vendor Data Handling</h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <p>As a multi-vendor marketplace showcasing authentic African art, we have specific practices for artist and vendor data:</p>

                                <div class="vendor-data-section">
                                    <h4><i class="fas fa-user-tie me-2"></i>African Artist Information</h4>
                                    <p>We collect and process information from our verified African artists including:</p>
                                    <ul class="privacy-list">
                                        <li>Artist credentials and cultural background verification</li>
                                        <li>Business registration and tax information for international sales</li>
                                        <li>Bank account and payment details for commission processing</li>
                                        <li>Artwork listings, descriptions, and portfolio information</li>
                                        <li>Sales performance and customer feedback analytics</li>
                                        <li>Cultural stories and artistic inspiration behind each piece</li>
                                    </ul>
                                </div>

                                <div class="vendor-data-section">
                                    <h4><i class="fas fa-handshake me-2"></i>Data Sharing with Artists</h4>
                                    <p>African artists receive customer information necessary for artwork fulfillment:</p>
                                    <ul class="privacy-list">
                                        <li>Customer name and delivery address for artwork shipping</li>
                                        <li>Contact information for delivery coordination and updates</li>
                                        <li>Order details, artwork specifications, and special instructions</li>
                                        <li>Customer preferences for personalized artwork experiences</li>
                                    </ul>
                                    <p><strong>Important:</strong> Artists are contractually obligated to use customer
                                        information only for order fulfillment and are prohibited from using it for
                                        marketing or other purposes without explicit consent from AfrikArtt.com.</p>
                                </div>

                                <div class="vendor-data-section">
                                    <h4><i class="fas fa-shield-alt me-2"></i>Artist Responsibilities</h4>
                                    <p>Our verified African artists must:</p>
                                    <ul class="privacy-list">
                                        <li>Comply with applicable data protection laws in their region</li>
                                        <li>Implement appropriate security measures for customer data</li>
                                        <li>Use customer data only for legitimate artwork delivery purposes</li>
                                        <li>Delete customer data when no longer needed for fulfillment</li>
                                        <li>Maintain the authenticity and cultural integrity of their artworks</li>
                                        <li>Respect customer privacy and AfrikArtt.com community guidelines</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="privacy-section" id="contact-info">
                            <div class="section-header">
                                <h2><i class="fas fa-envelope me-3"></i>Contact Us</h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <p>If you have any questions about this Privacy Policy or our data practices at AfrikArtt.com, please contact
                                    us:</p>

                                <div class="contact-methods">
                                    <div class="contact-method">
                                        <div class="contact-icon">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="contact-details">
                                            <h5>Email</h5>
                                            <p>{{ settings::setting('site_email') }}</p>
                                        </div>
                                    </div>

                                    <div class="contact-method">
                                        <div class="contact-icon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="contact-details">
                                            <h5>Phone</h5>
                                            <p>{{ settings::setting('site_phone') }}</p>
                                        </div>
                                    </div>

                                    <div class="contact-method">
                                        <div class="contact-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="contact-details">
                                            <h5>Address</h5>
                                            <p>AfrikArtt Headquarters<br>456 Cultural Arts Avenue<br>Global Art District, NY 10001</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="response-time">
                                    <div class="alert alert-info">
                                        <i class="fas fa-clock me-2"></i>
                                        <strong>Response Time:</strong> We typically respond to privacy-related inquiries
                                        within 24-48 hours during business days.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Policy Updates -->
                        <div class="privacy-section" id="policy-updates">
                            <div class="section-header">
                                <h2><i class="fas fa-sync-alt me-3"></i>Policy Updates</h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <p>We may update this Privacy Policy from time to time to reflect changes in our practices
                                    or for other operational, legal, or regulatory reasons affecting AfrikArtt.com.</p>

                                <div class="update-notification">
                                    <h4>How We Notify You</h4>
                                    <ul class="privacy-list">
                                        <li>Email notification to all registered AfrikArtt.com users</li>
                                        <li>Prominent notice on our website homepage</li>
                                        <li>Updated "Last Modified" date at the top of this policy</li>
                                        <li>Notification to African artists about any changes affecting their data</li>
                                    </ul>
                                </div>

                                <div class="continued-use">
                                    <h4>Continued Use</h4>
                                    <p>Your continued use of AfrikArtt.com after any changes to this Privacy Policy
                                        constitutes your acceptance of the updated policy.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {!! $privacyPolicy->body !!}
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

    <!-- Privacy Policy JavaScript -->
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling for navigation links
            const navLinks = document.querySelectorAll('.privacy-nav-list a');

            navLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Update active link
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    // Smooth scroll to section
                    const targetId = this.getAttribute('href');
                    const targetSection = document.querySelector(targetId);

                    if (targetSection) {
                        targetSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Update active navigation based on scroll position
            const sections = document.querySelectorAll('.privacy-section');

            function updateActiveNav() {
                let current = '';

                sections.forEach(function(section) {
                    const sectionTop = section.offsetTop - 150;
                    const sectionHeight = section.offsetHeight;

                    if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(function(link) {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            }

            // Update active nav on scroll
            window.addEventListener('scroll', updateActiveNav);

            // Initialize active nav
            updateActiveNav();
        });
    </script> --}}
@endsection
