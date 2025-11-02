@extends('layouts.app')
@section('content')
    <x-app.header />

    <!-- Account Deletion Hero Section -->
    <div class="deletion-hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="deletion-hero-title">{{ $accountDeletion->title ?? 'Account Deletion Policy' }}</h1>
                    <p class="deletion-hero-subtitle text-dark">
                        {{ $accountDeletion->excerpt ?? 'Learn about our account deletion process and your data rights.' }}
                    </p>
                    <div class="last-updated mt-3">
                        {{-- <span class="badge bg-primary">Last Updated: {{ date('F d, Y') }}</span> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Deletion Content Section -->
    <div class="deletion-content-section">
        <div class="container">
            @if ($accountDeletion && $accountDeletion->body)
                {!! $accountDeletion->body !!}
            @else
                <!-- Default Account Deletion Content -->
                <div class="deletion-content-wrapper">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> This is a default account deletion policy template. Please create a page with
                        slug 'account-deletion' in your admin panel to customize this content.
                    </div>

                    <!-- Introduction -->
                    <div class="deletion-section" id="introduction">
                        <div class="section-header">
                            <h2>Introduction</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p class="lead">We understand that you may wish to delete your account from Royalit.com. This
                                policy outlines your rights and our process for account deletion.</p>
                            <p>You have the right to request the deletion of your personal data and account at any time. We
                                will process your request in accordance with applicable data protection laws.</p>
                        </div>
                    </div>

                    <!-- Types of Account Deletion -->
                    <div class="deletion-section" id="deletion-types">
                        <div class="section-header">
                            <h2><i class="fas fa-trash-alt me-3"></i>Types of Account Deletion</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <div class="deletion-types">
                                <div class="deletion-type">
                                    <div class="type-icon">
                                        <i class="fas fa-user-times"></i>
                                    </div>
                                    <h4>Account Deactivation</h4>
                                    <p>Temporarily disable your account while retaining your data. You can reactivate your
                                        account within 30 days.</p>
                                    <ul class="deletion-list">
                                        <li>Account becomes inaccessible immediately</li>
                                        <li>Data is retained for 30 days</li>
                                        <li>Can be reversed within the retention period</li>
                                        <li>No permanent data loss</li>
                                    </ul>
                                </div>

                                <div class="deletion-type">
                                    <div class="type-icon">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                    <h4>Permanent Deletion</h4>
                                    <p>Permanently remove your account and associated personal data from our systems.</p>
                                    <ul class="deletion-list">
                                        <li>Account and data permanently removed</li>
                                        <li>Cannot be reversed</li>
                                        <li>Some data may be retained for legal compliance</li>
                                        <li>Complete removal from our systems</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- What Gets Deleted -->
                    <div class="deletion-section" id="what-gets-deleted">
                        <div class="section-header">
                            <h2><i class="fas fa-list-check me-3"></i>What Gets Deleted</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p>When you request account deletion, the following data will be removed:</p>

                            <div class="deletion-category">
                                <h4><i class="fas fa-user me-2"></i>Personal Information</h4>
                                <ul class="deletion-list">
                                    <li>Profile information and account details</li>
                                    <li>Contact information (email, phone, address)</li>
                                    <li>Account preferences and settings</li>
                                    <li>Wishlist and saved items</li>
                                    <li>Search history and browsing data</li>
                                </ul>
                            </div>

                            <div class="deletion-category">
                                <h4><i class="fas fa-shopping-cart me-2"></i>Transaction Data</h4>
                                <ul class="deletion-list">
                                    <li>Order history (anonymized for business records)</li>
                                    <li>Payment information (securely removed)</li>
                                    <li>Shipping addresses</li>
                                    <li>Customer service communications</li>
                                </ul>
                            </div>

                            <div class="deletion-category">
                                <h4><i class="fas fa-comments me-2"></i>User Generated Content</h4>
                                <ul class="deletion-list">
                                    <li>Product reviews and ratings</li>
                                    <li>Comments and feedback</li>
                                    <li>Messages between users and vendors</li>
                                    <li>Uploaded images and content</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- What Gets Retained -->
                    <div class="deletion-section" id="what-gets-retained">
                        <div class="section-header">
                            <h2><i class="fas fa-shield-alt me-3"></i>What Gets Retained</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p>Some data may be retained for legal, regulatory, or business purposes:</p>

                            <div class="retention-notice">
                                <div class="notice-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="notice-content">
                                    <h4>Legal Compliance</h4>
                                    <p>We may retain certain information as required by law, including:</p>
                                    <ul class="deletion-list">
                                        <li>Financial records for tax and accounting purposes</li>
                                        <li>Transaction records for fraud prevention</li>
                                        <li>Communication logs for legal disputes</li>
                                        <li>Security logs and access records</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="retention-notice">
                                <div class="notice-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="notice-content">
                                    <h4>Business Analytics</h4>
                                    <p>Anonymized data may be retained for:</p>
                                    <ul class="deletion-list">
                                        <li>Business intelligence and analytics</li>
                                        <li>Platform improvement and development</li>
                                        <li>Market research and trends analysis</li>
                                        <li>Service optimization</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- How to Request Deletion -->
                    <div class="deletion-section" id="how-to-request">
                        <div class="section-header">
                            <h2><i class="fas fa-envelope-open-text me-3"></i>How to Request Deletion</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p>You can request account deletion through the following methods:</p>

                            <div class="request-methods">
                                <div class="request-method">
                                    <div class="method-icon">
                                        <i class="fas fa-user-cog"></i>
                                    </div>
                                    <div class="method-content">
                                        <h4>Account Settings</h4>
                                        <p>Log into your account and navigate to Account Settings → Privacy → Delete Account
                                        </p>
                                        <div class="method-steps">
                                            <ol>
                                                <li>Log into your Royalit.com account</li>
                                                <li>Go to Account Settings</li>
                                                <li>Select Privacy tab</li>
                                                <li>Click "Delete Account"</li>
                                                <li>Follow the confirmation prompts</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <div class="request-method">
                                    <div class="method-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="method-content">
                                        <h4>Email Request</h4>
                                        <p>Send an email to our support team with your deletion request</p>
                                        <div class="contact-info">
                                            <p><strong>Email:</strong>
                                                {{ settings::setting('site_email') ?? 'privacy@royalit.com' }}</p>
                                            <p><strong>Subject:</strong> Account Deletion Request</p>
                                            <p><strong>Include:</strong> Your account email and reason for deletion</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="request-method">
                                    <div class="method-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="method-content">
                                        <h4>Phone Support</h4>
                                        <p>Contact our customer support team directly</p>
                                        <div class="contact-info">
                                            <p><strong>Phone:</strong>
                                                {{ settings::setting('site_phone') ?? '+1 (555) 123-4567' }}</p>
                                            <p><strong>Hours:</strong> Monday - Friday, 9 AM - 6 PM EST</p>
                                            <p><strong>Note:</strong> You may need to verify your identity</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Processing Time -->
                    <div class="deletion-section" id="processing-time">
                        <div class="section-header">
                            <h2><i class="fas fa-clock me-3"></i>Processing Time</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <div class="processing-timeline">
                                <div class="timeline-item">
                                    <div class="timeline-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h4>Immediate (0-24 hours)</h4>
                                        <ul class="deletion-list">
                                            <li>Account access is disabled</li>
                                            <li>Login credentials are deactivated</li>
                                            <li>Public profile is removed</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <div class="timeline-icon">
                                        <i class="fas fa-hourglass-half"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h4>Within 7 Days</h4>
                                        <ul class="deletion-list">
                                            <li>Personal data removal from active systems</li>
                                            <li>Email communications stopped</li>
                                            <li>Marketing preferences updated</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <div class="timeline-icon">
                                        <i class="fas fa-database"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h4>Within 30 Days</h4>
                                        <ul class="deletion-list">
                                            <li>Complete data removal from backup systems</li>
                                            <li>Analytics data anonymization</li>
                                            <li>Final verification of deletion</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Considerations -->
                    <div class="deletion-section" id="considerations">
                        <div class="section-header">
                            <h2><i class="fas fa-exclamation-circle me-3"></i>Important Considerations</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <div class="warning-notice">
                                <div class="warning-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="warning-content">
                                    <h4>Before You Delete</h4>
                                    <ul class="deletion-list">
                                        <li><strong>Active Orders:</strong> Complete or cancel any pending orders</li>
                                        <li><strong>Outstanding Payments:</strong> Resolve any payment issues</li>
                                        <li><strong>Vendor Accounts:</strong> Settle any pending vendor transactions</li>
                                        <li><strong>Data Backup:</strong> Download any data you wish to keep</li>
                                        <li><strong>Subscriptions:</strong> Cancel any active subscriptions</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="warning-notice">
                                <div class="warning-icon">
                                    <i class="fas fa-ban"></i>
                                </div>
                                <div class="warning-content">
                                    <h4>Cannot Be Undone</h4>
                                    <p>Once your account is permanently deleted:</p>
                                    <ul class="deletion-list">
                                        <li>You cannot recover your account or data</li>
                                        <li>You'll need to create a new account to use our services</li>
                                        <li>Purchase history and preferences will be lost</li>
                                        <li>Vendor status and verification will be reset</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="deletion-section" id="contact-info">
                        <div class="section-header">
                            <h2><i class="fas fa-headset me-3"></i>Need Help?</h2>
                            <div class="section-divider"></div>
                        </div>
                        <div class="section-content">
                            <p>If you have questions about account deletion or need assistance, our support team is here to
                                help:</p>
                            <div class="support-methods">
                                <div class="support-method">
                                    <div class="support-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="support-details">
                                        <h5>Email Support</h5>
                                        <p>{{ settings::setting('site_email') ?? 'support@royalit.com' }}</p>
                                        <small>Response within 24 hours</small>
                                    </div>
                                </div>

                                <div class="support-method">
                                    <div class="support-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="support-details">
                                        <h5>Phone Support</h5>
                                        <p>{{ settings::setting('site_phone') ?? '+1 (555) 123-4567' }}</p>
                                        <small>Monday - Friday, 9 AM - 6 PM EST</small>
                                    </div>
                                </div>

                                <div class="support-method">
                                    <div class="support-icon">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                    <div class="support-details">
                                        <h5>Live Chat</h5>
                                        <p>Available on our website</p>
                                        <small>Monday - Friday, 9 AM - 5 PM EST</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Account Deletion Custom Styles -->
    <style>
        /* Deletion Hero Section */
        .deletion-hero-section {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .deletion-hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .deletion-hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
            opacity: 0.9;
        }

        /* Deletion Content Section */
        .deletion-content-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        /* Deletion Content Wrapper */
        .deletion-content-wrapper {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        /* Deletion Sections */
        .deletion-section {
            margin-bottom: 50px;
            scroll-margin-top: 100px;
        }

        .deletion-section:last-child {
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
            color: var(--accent-color, #ff6b6b);
        }

        .section-divider {
            height: 4px;
            background: linear-gradient(90deg, var(--accent-color, #ff6b6b) 0%, transparent 100%);
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

        /* Deletion Types */
        .deletion-types {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin: 30px 0;
        }

        .deletion-type {
            background: #f7fafc;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .deletion-type:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-color, #ff6b6b);
        }

        .type-icon {
            width: 60px;
            height: 60px;
            background: var(--accent-color, #ff6b6b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .type-icon i {
            color: white;
            font-size: 1.5rem;
        }

        .deletion-type h4 {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .deletion-type p {
            color: #718096;
            margin-bottom: 20px;
        }

        /* Deletion Lists */
        .deletion-list {
            margin: 15px 0;
            padding-left: 0;
            text-align: left;
        }

        .deletion-list li {
            margin-bottom: 8px;
            padding-left: 25px;
            position: relative;
            list-style: none;
            font-size: 0.95rem;
        }

        .deletion-list li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: var(--accent-color, #ff6b6b);
            font-weight: bold;
            font-size: 1.2rem;
        }

        /* Deletion Categories */
        .deletion-category {
            background: #f7fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 20px 0;
            border-left: 4px solid var(--accent-color, #ff6b6b);
        }

        .deletion-category h4 {
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .deletion-category h4 i {
            color: var(--accent-color, #ff6b6b);
            margin-right: 10px;
        }

        /* Retention Notices */
        .retention-notice {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .notice-icon {
            width: 40px;
            height: 40px;
            background: #feb2b2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notice-icon i {
            color: #c53030;
            font-size: 1.2rem;
        }

        .notice-content h4 {
            color: #c53030;
            margin-bottom: 10px;
        }

        /* Request Methods */
        .request-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .request-method {
            background: #f7fafc;
            border-radius: 15px;
            padding: 25px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .request-method:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-color, #ff6b6b);
        }

        .method-icon {
            width: 50px;
            height: 50px;
            background: var(--accent-color, #ff6b6b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .method-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .method-content h4 {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .method-steps ol {
            margin: 15px 0;
            padding-left: 20px;
        }

        .method-steps li {
            margin-bottom: 5px;
            color: #4a5568;
        }

        .contact-info {
            margin-top: 15px;
        }

        .contact-info p {
            margin-bottom: 5px;
            color: #4a5568;
        }

        /* Processing Timeline */
        .processing-timeline {
            margin: 30px 0;
        }

        .timeline-item {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 30px;
            padding: 20px;
            background: #f7fafc;
            border-radius: 12px;
            border-left: 4px solid var(--accent-color, #ff6b6b);
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            background: var(--accent-color, #ff6b6b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .timeline-icon i {
            color: white;
            font-size: 1rem;
        }

        .timeline-content h4 {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Warning Notices */
        .warning-notice {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .warning-icon {
            width: 40px;
            height: 40px;
            background: #feb2b2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .warning-icon i {
            color: #c53030;
            font-size: 1.2rem;
        }

        .warning-content h4 {
            color: #c53030;
            margin-bottom: 10px;
        }

        /* Support Methods */
        .support-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .support-method {
            background: #f7fafc;
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }

        .support-method:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .support-icon {
            width: 50px;
            height: 50px;
            background: var(--accent-color, #ff6b6b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .support-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .support-details h5 {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .support-details p {
            color: #4a5568;
            margin: 0;
            font-weight: 500;
        }

        .support-details small {
            color: #718096;
            font-size: 0.85rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .deletion-hero-title {
                font-size: 2.5rem;
            }

            .deletion-hero-subtitle {
                font-size: 1rem;
            }

            .deletion-content-wrapper {
                padding: 20px;
                margin: 0 15px;
            }

            .section-header h2 {
                font-size: 1.5rem;
            }

            .deletion-types {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .request-methods {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .support-methods {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .support-method {
                flex-direction: column;
                text-align: center;
            }

            .timeline-item {
                flex-direction: column;
                text-align: center;
            }

            .retention-notice,
            .warning-notice {
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
