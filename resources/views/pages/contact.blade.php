@extends('layouts.app')
@section('content')
    <x-app.header />
    <div class="contact-content-section">
        <div class="container">
            <div class="checkout-hero mb-4 position-relative">
                <h2 class="fw-bold mb-1 text-light">Contact Our Team</h2>
                <p class="mb-0">Contact our support team for quick help or questions. We're here to assist you.</p>

                <div
                    class="checkout-hero-steps d-none d-md-flex position-absolute end-0 top-0 h-100 align-items-center pe-4">
                    <a href="{{ route('homepage') }}"><span class="badge bg-light text-primary me-2">Home</span></a>
                    <span class="badge bg-light text-primary me-2">Contact Our Team</span>
                </div>
            </div>
            <div class="row">
                <!-- Contact Form -->
                <div class="col-lg-8 mb-5">
                    <div class="contact-form-wrapper">
                        <div class="form-header mb-4">
                            <div class="form-icon mb-3" style="background: var(--contact-primary);">
                                <i class="fas fa-paper-plane" style="color: #ffffff;"></i>
                            </div>
                            <h2 class="form-title">Send us a Message</h2>
                            <p class="form-subtitle">Whether you're an artist looking to join our platform or an art lover
                                seeking support, we're here to help. Fill out the form below and we'll get back to you
                                promptly.</p>
                        </div>

                        <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-user me-2"></i>Personal Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="first_name" class="form-label">First Name <span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                required>
                                            <div class="form-focus-line"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="last_name" class="form-label">Last Name <span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                required>
                                            <div class="form-focus-line"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email Address <span
                                                    class="required">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                            <div class="form-focus-line"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" id="phone" name="phone">
                                            <div class="form-focus-line"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-info-circle me-2"></i>Inquiry Details
                                </h5>

                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="order_number" class="form-label">Order Number <small
                                                class="text-muted">(if applicable)</small></label>
                                        <input type="text" class="form-control" id="order_number" name="order_number"
                                            placeholder="e.g., #AFR-12345">
                                        <div class="form-focus-line"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="message" class="form-label">Your Message <span
                                                class="required">*</span></label>
                                        <textarea class="form-control" id="message" name="message" rows="6"
                                            placeholder="Please describe your inquiry in detail. If you're an artist, tell us about your work and background..."
                                            required></textarea>
                                        <div class="form-focus-line"></div>
                                        <div class="character-count">
                                            <small class="text-muted">0 / 1000 characters</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-footer">
                                <div class="form-check mb-4 d-flex justify-content-center align-items-center">
                                    <input class="form-check-input" type="checkbox" id="privacy_agree" name="privacy_agree"
                                        required>
                                    <label class="form-check-label ms-2" for="privacy_agree">
                                        I agree to Afrikart's <a href="{{ route('privacy.policy') }}" target="_blank"
                                            class="policy-link">Privacy Policy</a> and consent to the processing of my
                                        personal data for the purpose of this inquiry. <span class="required">*</span>
                                    </label>
                                </div>

                                <div class="submit-section">
                                    <button type="submit" class="btn btn-primary btn-submit">
                                        <span class="btn-text">
                                            <i class="fas fa-paper-plane me-2"></i>Send Message
                                        </span>
                                        <span class="btn-loading d-none">
                                            <i class="fas fa-spinner fa-spin me-2"></i>Sending...
                                        </span>
                                    </button>
                                    <p class="submit-note">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        Your information is secure and will only be used to respond to your inquiry.
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Information Sidebar -->
                <div class="col-lg-4">
                    <div class="contact-info-sidebar">
                        <!-- Quick Contact Card -->
                        <div class="quick-contact-card mb-4">
                            <div class="quick-contact-header">
                                <div class="contact-avatar">
                                    <i class="fas fa-headset" style="color: var(--contact-primary)"></i>
                                </div>
                                <div class="contact-info">
                                    <h5>Need Immediate Help?</h5>
                                    <p class="text-dark">Our support team is standing by</p>
                                </div>
                            </div>
                            <div class="quick-contact-actions">
                                <a href="tel:{{ Settings::setting('site_phone') }}" class="quick-action-btn phone">
                                    <i class="fas fa-phone"></i>
                                    <span>Call Now</span>
                                </a>
                                <a href="mailto:{{ Settings::setting('site_email') }}" class="quick-action-btn email">
                                    <i class="fas fa-envelope"></i>
                                    <span>Email Us</span>
                                </a>
                            </div>
                        </div>

                        <!-- Contact Methods -->
                        <div class="contact-info-card mb-4">
                            <div class="card-header">
                                <i class="fas fa-comments card-icon"></i>
                                <h4>Get in Touch</h4>
                            </div>
                            <div class="contact-methods">
                                <div class="contact-method">
                                    <div class="method-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="method-content">
                                        <h6>Customer Support</h6>
                                        <p>{{ Settings::setting('site_phone') }}</p>
                                        <small>Mon-Fri: 8AM-8PM EST</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email Support -->
                        <div class="contact-info-card mb-4">
                            <div class="card-header">
                                <i class="fas fa-envelope-open card-icon"></i>
                                <h4>Email Departments</h4>
                            </div>
                            <div class="email-departments">
                                <div class="email-item">
                                    <div class="email-icon">
                                        <i class="fas fa-life-ring"></i>
                                    </div>
                                    <div class="email-content">
                                        <strong>Customer Support</strong>
                                        <a
                                            href="mailto:{{ Settings::setting('site_email') }}">{{ Settings::setting('site_email') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Office Information -->
                        {{-- <div class="contact-info-card mb-4">
                            <div class="card-header">
                                <i class="fas fa-building card-icon"></i>
                                <h4>Our Offices</h4>
                            </div>
                            <div class="office-locations">
                                <div class="office-item">
                                    <div class="office-flag">
                                        🇺🇸
                                    </div>
                                    <div class="office-details">
                                        <h6>North America HQ</h6>
                                        <p>
                                            Afrikart Inc.<br>
                                            123 Art District<br>
                                            New York, NY 10001<br>
                                            United States
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Social Media & Community -->
                        <div class="contact-info-card">
                            <div class="card-header">
                                <i class="fas fa-users card-icon"></i>
                                <h4>Join Our Community</h4>
                            </div>
                            <div class="social-community">
                                <p class="community-description">Connect with artists and art lovers worldwide. Follow us
                                    for daily inspiration and updates.</p>
                                <div class="social-grid">
                                    <a href="{{ Settings::setting('social_fb_link') }}" class="social-item facebook">
                                        <i class="fab fa-facebook-f"></i>
                                        <span>Facebook</span>
                                        <small>15K followers</small>
                                    </a>
                                    <a href="{{ Settings::setting('social_inst_link') }}" class="social-item instagram">
                                        <i class="fab fa-instagram"></i>
                                        <span>Instagram</span>
                                        <small>25K followers</small>
                                    </a>
                                    <a href="{{ Settings::setting('social_twitter_link') }}" class="social-item twitter">
                                        <i class="fab fa-twitter"></i>
                                        <span>Twitter</span>
                                        <small>8K followers</small>
                                    </a>
                                    <a href="{{ Settings::setting('social_linkedin_link') }}"
                                        class="social-item linkedin">
                                        <i class="fab fa-linkedin-in"></i>
                                        <span>LinkedIn</span>
                                        <small>5K followers</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Resources -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="help-resources-section">
                        <div class="section-header text-center mb-5">
                            <div class="section-icon mb-3" style="background: var(--contact-primary)">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h3>Helpful Resources</h3>
                            <p class="section-subtitle">Quick access to common topics and self-service options</p>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="resource-card">
                                    <div class="resource-icon">
                                        <i class="fas fa-paint-brush"></i>
                                    </div>
                                    <h5>Artist Guidelines</h5>
                                    <p>Learn about our submission process, quality standards, and artist requirements.</p>
                                    <a href="{{ route('faqs') }}#artist-guidelines" class="resource-link">
                                        View Guidelines <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="resource-card">
                                    <div class="resource-icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <h5>Buying Guide</h5>
                                    <p>Step-by-step instructions for purchasing artwork, payment options, and delivery.</p>
                                    <a href="{{ route('faqs') }}#buying-guide" class="resource-link">
                                        Learn More <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="resource-card">
                                    <div class="resource-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <h5>Authenticity</h5>
                                    <p>Understand our verification process and certificate of authenticity program.</p>
                                    <a href="{{ route('faqs') }}#authenticity" class="resource-link">
                                        Read More <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="resource-card">
                                    <div class="resource-icon">
                                        <i class="fas fa-globe-africa"></i>
                                    </div>
                                    <h5>International Shipping</h5>
                                    <p>Information about worldwide delivery, customs, and international payment methods.</p>
                                    <a href="{{ route('faqs') }}#international" class="resource-link">
                                        View Details <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Professional Styles -->
    <style>
        :root {
            --contact-primary: var(--accent-color);
            --contact-primary-rgb: var(--accent-color-rgb);
            --contact-dark: #1a202c;
            --contact-text: #2d3748;
            --contact-muted: #718096;
            --contact-light: #f7fafc;
            --contact-border: #e2e8f0;
            --contact-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --contact-shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --contact-radius: 12px;
            --contact-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Hero Section */
        .contact-hero-section {
            background: linear-gradient(135deg, var(--contact-primary) 0%, rgba(var(--contact-primary-rgb), 0.8) 100%);
            color: white;
            padding: 120px 0 100px;
            position: relative;
            overflow: hidden;
        }

        .contact-hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><defs><pattern id="hero-pattern" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse"><circle cx="30" cy="30" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="0" cy="0" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="60" cy="60" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23hero-pattern)"/></svg>');
            opacity: 0.3;
        }

        .hero-pattern {
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(100px);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-block;
        }

        .badge-text {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .contact-hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            margin: 1.5rem 0 1rem;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .contact-hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .contact-stats {
            margin-top: 3rem;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.15);
            border-radius: var(--contact-radius);
            padding: 2rem 1.5rem;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--contact-transition);
            height: 100%;
        }

        .stat-item:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .stat-content {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }

        .stat-label {
            font-size: 0.95rem;
            opacity: 0.9;
            font-weight: 500;
        }

        /* Contact Content Section */
        .contact-content-section {
            padding: 100px 0;
            background: var(--contact-light);
        }

        /* Contact Form */
        .contact-form-wrapper {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--contact-shadow-lg);
            border: 1px solid var(--contact-border);
            position: relative;
            overflow: hidden;
        }

        .contact-form-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--contact-primary) 0%, rgba(var(--contact-primary-rgb), 0.6) 100%);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .form-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--contact-primary) 0%, rgba(var(--contact-primary-rgb), 0.8) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 8px 25px rgba(var(--contact-primary-rgb), 0.3);
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--contact-dark);
            margin: 1.5rem 0 0.5rem;
        }

        .form-subtitle {
            color: var(--contact-muted);
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 500px;
            margin: 0 auto;
        }

        .form-section {
            margin-bottom: 2.5rem;
            padding: 1.5rem;
            background: #fafbfc;
            border-radius: var(--contact-radius);
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--contact-text);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            color: var(--contact-primary);
        }

        .form-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--contact-text);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .required {
            color: #e53e3e;
            font-weight: 700;
        }

        .form-control,
        .form-select {
            border: 2px solid var(--contact-border);
            border-radius: 10px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: var(--contact-transition);
            background: white;
            position: relative;
            z-index: 1;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--contact-primary);
            box-shadow: 0 0 0 0.2rem rgba(var(--contact-primary-rgb), 0.25);
            outline: none;
        }

        .form-focus-line {
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--contact-primary);
            transition: var(--contact-transition);
            transform: translateX(-50%);
        }

        .form-control:focus+.form-focus-line,
        .form-select:focus+.form-focus-line {
            width: 100%;
        }

        .character-count {
            text-align: right;
            margin-top: 0.5rem;
        }

        .form-footer {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--contact-border);
        }

        .policy-link {
            color: var(--contact-primary);
            text-decoration: none;
            font-weight: 500;
        }

        .policy-link:hover {
            text-decoration: underline;
        }

        .submit-section {
            text-align: center;
            margin-top: 1.5rem;
        }

        .btn-submit {
            background: var(--contact-primary);
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            transition: var(--contact-transition);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(var(--contact-primary-rgb), 0.3);
            min-width: 200px;
        }

        .btn-submit:hover {
            background: var(--contact-primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(var(--contact-primary-rgb), 0.4);
            filter: brightness(1.1);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .submit-note {
            margin-top: 1rem;
            color: var(--contact-muted);
            font-size: 0.9rem;
        }

        /* Sidebar Styles */
        .contact-info-sidebar {
            position: sticky;
            top: 2rem;
        }

        .quick-contact-card {
            background: linear-gradient(135deg, var(--contact-primary) 0%, rgba(var(--contact-primary-rgb), 0.9) 100%);
            color: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--contact-shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .quick-contact-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        .quick-contact-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .contact-avatar {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .quick-contact-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .quick-contact-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .quick-contact-actions {
            display: flex;
            gap: 1rem;
            position: relative;
            z-index: 2;
        }

        .quick-action-btn {
            flex: 1;
            background: var(--contact-primary);
            color: white;
            text-decoration: none;
            padding: 0.875rem 1rem;
            border-radius: 12px;
            text-align: center;
            transition: var(--contact-transition);
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        .quick-action-btn:hover {
            background: var(--contact-primary);
            color: white;
            transform: translateY(-2px);
        }

        .contact-info-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--contact-shadow);
            border: 1px solid var(--contact-border);
            transition: var(--contact-transition);
        }

        .contact-info-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--contact-shadow-lg);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--contact-border);
        }

        .card-icon {
            color: var(--contact-primary);
            font-size: 1.3rem;
        }

        .card-header h4 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--contact-dark);
        }

        .contact-methods .contact-method,
        .email-departments .email-item,
        .office-locations .office-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: var(--contact-light);
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: var(--contact-transition);
        }

        .contact-method:hover,
        .email-item:hover,
        .office-item:hover {
            background: #f1f5f9;
            transform: translateX(5px);
        }

        .method-icon,
        .email-icon {
            width: 45px;
            height: 45px;
            background: var(--contact-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }

        .method-content h6,
        .email-content strong {
            color: var(--contact-text);
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-size: 1rem;
        }

        .method-content p {
            color: var(--contact-primary);
            font-weight: 500;
            margin: 0;
            font-size: 1rem;
        }

        .method-content small {
            color: var(--contact-muted);
            font-size: 0.85rem;
        }

        .email-content a {
            color: var(--contact-primary);
            text-decoration: none;
            font-weight: 500;
        }

        .email-content a:hover {
            text-decoration: underline;
        }

        .office-flag {
            font-size: 2rem;
            line-height: 1;
        }

        .office-details h6 {
            color: var(--contact-text);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .office-details p {
            color: var(--contact-muted);
            margin: 0;
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .office-hours {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--contact-border);
        }

        .office-hours h6 {
            color: var(--contact-text);
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .hours-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            font-size: 0.9rem;
        }

        .hours-item span:first-child {
            color: var(--contact-text);
            font-weight: 500;
        }

        .hours-item span:last-child {
            color: var(--contact-muted);
        }

        .social-community {
            text-align: center;
        }

        .community-description {
            color: var(--contact-muted);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .social-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .social-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            padding: 1.5rem 1rem;
            background: var(--contact-light);
            border-radius: 12px;
            text-decoration: none;
            color: var(--contact-text);
            transition: var(--contact-transition);
            position: relative;
            overflow: hidden;
        }

        .social-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--contact-primary);
            transform: translateY(100%);
            transition: var(--contact-transition);
            z-index: 0;
        }

        .social-item:hover::before {
            transform: translateY(0);
        }

        .social-item:hover {
            color: white;
            transform: translateY(-3px);
        }

        .social-item i,
        .social-item span,
        .social-item small {
            position: relative;
            z-index: 1;
        }

        .social-item i {
            font-size: 1.5rem;
        }

        .social-item span {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .social-item small {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        /* Help Resources */
        .help-resources-section {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--contact-shadow);
            border: 1px solid var(--contact-border);
        }

        .section-header {
            margin-bottom: 3rem;
        }

        .section-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--contact-primary) 0%, rgba(var(--contact-primary-rgb), 0.8) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 8px 25px rgba(var(--contact-primary-rgb), 0.3);
        }

        .section-header h3 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--contact-dark);
            margin: 1.5rem 0 0.5rem;
        }

        .section-subtitle {
            color: var(--contact-muted);
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .resource-card {
            background: var(--contact-light);
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            transition: var(--contact-transition);
            border: 1px solid var(--contact-border);
            position: relative;
            overflow: hidden;
        }

        .resource-card:hover {
            background: white;
            transform: translateY(-5px);
            box-shadow: var(--contact-shadow-lg);
        }

        .resource-icon {
            width: 60px;
            height: 60px;
            background: var(--contact-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(var(--contact-primary-rgb), 0.3);
        }

        .resource-card h5 {
            color: var(--contact-dark);
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .resource-card p {
            color: var(--contact-muted);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .resource-link {
            color: var(--contact-primary);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: var(--contact-transition);
        }

        .resource-link:hover {
            color: var(--contact-primary);
            transform: translateX(5px);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .contact-info-sidebar {
                position: static;
                margin-top: 3rem;
            }
        }

        @media (max-width: 768px) {
            .contact-hero-section {
                padding: 80px 0 60px;
            }

            .contact-content-section {
                padding: 60px 0;
            }

            .contact-form-wrapper {
                padding: 2rem 1.5rem;
            }

            .form-section {
                padding: 1rem;
            }

            .contact-info-card {
                padding: 1.5rem;
            }

            .help-resources-section {
                padding: 2rem 1.5rem;
            }

            .quick-contact-actions {
                flex-direction: column;
            }

            .stat-group {
                gap: 1rem;
            }

            .social-grid {
                grid-template-columns: 1fr;
            }

            .office-locations .office-item {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .contact-hero-title {
                font-size: 2rem;
            }

            .contact-hero-subtitle {
                font-size: 1rem;
            }

            .form-title {
                font-size: 1.5rem;
            }

            .section-header h3 {
                font-size: 1.5rem;
            }

            .commitment-content h4 {
                font-size: 1.4rem;
            }
        }

        /* Form Validation States */
        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #e53e3e;
        }

        .form-control.is-valid,
        .form-select.is-valid {
            border-color: #38a169;
        }

        .form-control.is-invalid:focus,
        .form-select.is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(229, 62, 62, 0.25);
        }

        .form-control.is-valid:focus,
        .form-select.is-valid:focus {
            box-shadow: 0 0 0 0.2rem rgba(56, 161, 105, 0.25);
        }

        /* Loading State */
        .btn-submit.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-submit.loading .btn-text {
            display: none;
        }

        .btn-submit.loading .btn-loading {
            display: inline-block !important;
        }

        /* Success Message */
        .form-success {
            background: #f0fff4;
            border: 1px solid #9ae6b4;
            color: #276749;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 1rem;
        }

        /* Print Styles */
        @media print {

            .contact-hero-section,
            .quick-contact-card,
            .social-community {
                display: none;
            }

            .contact-form-wrapper,
            .contact-info-card {
                box-shadow: none;
                border: 1px solid #ccc;
            }
        }
    </style>
@endsection
