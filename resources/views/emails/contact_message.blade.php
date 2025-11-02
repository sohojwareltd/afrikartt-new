<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message - Royalit</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8f9fa;
            padding: 20px 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Header Styles */
        .email-header {
            background: linear-gradient(135deg, #DE991B 0%, rgba(222, 153, 27, 0.9) 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .logo-section {
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 123px;
            height: 55px;
            background: #ffffff;
            border-radius: 5%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .header-subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin: 5px 0 0;
        }

        .notification-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            margin-top: 15px;
            backdrop-filter: blur(10px);
        }

        /* Content Styles */
        .email-content {
            padding: 40px 30px;
        }

        .message-intro {
            background: #f8f9fa;
            border-left: 4px solid #DE991B;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .intro-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .intro-text {
            color: #000000;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Contact Details Section */
        .contact-details {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .details-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
        }

        .details-icon {
            width: 40px;
            height: 40px;
            background: #DE991B;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 16px;
        }

        .details-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .detail-row {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .detail-label {
            font-weight: 600;
            color: #000000;
            width: 120px;
            flex-shrink: 0;
            font-size: 14px;
        }

        .detail-value {
            color: #000000;
            flex: 1;
            font-size: 14px;
            word-break: break-word;
        }

        /* Message Content */
        .message-content {
            background: #f8f9fa !important;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .message-header {
            font-size: 16px;
            font-weight: 600;
            color: #000000;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .message-icon {
            margin-right: 8px;
            color: #DE991B;
        }

        .message-text {
            background: white;
            padding: 20px;
            border-radius: 6px;
            color: #000000;
            line-height: 1.8;
            font-size: 14px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* Action Section */
        .action-section {
            text-align: center;
            padding: 30px 20px;
            background: #f8f9fa;
        }

        .action-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .action-subtitle {
            color: #000000;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .btn-primary {
            background: #DE991B;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(222, 153, 27, 0.3);
        }

        .btn-primary:hover {
            background: #c8891a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(222, 153, 27, 0.4);
        }

        /* Footer */
        .email-footer {
            background: #2c3e50;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .footer-content {
            max-width: 500px;
            margin: 0 auto;
        }

        .footer-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .footer-text {
            font-size: 14px;
            opacity: 0.8;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .footer-links {
            margin-bottom: 20px;
        }

        .footer-link {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
            opacity: 0.8;
        }

        .footer-link:hover {
            opacity: 1;
            text-decoration: underline;
        }

        .footer-bottom {
            padding-top: 20px;
            font-size: 12px;
            opacity: 0.6;
        }

        /* Priority Badge */
        .priority-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .priority-high {
            background: #DE991B;
            color: white;
        }

        .priority-normal {
            background: #95a5a6;
            color: white;
        }

        /* Responsive Design */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }

            .email-content {
                padding: 25px 20px;
            }

            .contact-details {
                padding: 20px;
            }

            .detail-row {
                flex-direction: column;
                margin-bottom: 12px;
            }

            .detail-label {
                width: auto;
                margin-bottom: 4px;
            }

            .company-name {
                font-size: 24px;
            }

            .action-section {
                padding: 25px 15px;
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            .email-container {
                background-color: #ffffff;
            }

            .email-content {
                background-color: #ffffff;
                color: #000000;
            }

            .contact-details {
                background-color: #f8f9fa;
            }

            .message-content {
                background-color: #ffffff;
            }

            .message-text {
                background-color: #ffffff;
                color: #000000;
            }

            .intro-title,
            .details-title,
            .action-title {
                color: #000000;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo-icon">
                        <img src="{{ Settings::setting('site_logo') }}" alt="Royalit Logo" height="40">
                    </div>
                    <h1 class="company-name">Royalit</h1>
                    <p class="header-subtitle">African Art Marketplace</p>
                </div>
                <div class="notification-badge">
                    📧 New Contact Message Received
                </div>
            </div>
        </div>
        <!-- Content -->
        <div class="email-content">
            <!-- Intro Section -->
            <div class="message-intro">
                <h2 style="color: #585353">🔔 New Contact Form Submission</h2>
                <p class="intro-text">
                    A new message has been submitted through the Royalit contact form.
                    Please review the details below and respond promptly to maintain our excellent customer service
                    standards.
                </p>
            </div>

            <!-- Contact Details -->
            <div class="contact-details">
                <div class="details-header">
                    <div class="details-icon">
                        <!-- User Icon SVG -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" aria-label="User Icon">
                            <circle cx="12" cy="8" r="4" fill="#fff" opacity="0.9" />
                            <path d="M4 19c0-3.3137 3.134-6 8-6s8 2.6863 8 6v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-1z"
                                fill="#fff" opacity="0.7" />
                        </svg>
                    </div>
                    <h3 class="details-title">Contact Information</h3>
                </div>

                <div class="detail-row">
                    <span class="detail-label text-light">Full Name:</span>
                    <span class="text-light">{{ $contactData['first_name'] ?? 'N/A' }}
                        {{ $contactData['last_name'] ?? '' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label  text-light">Email Address:</span>
                    <span class="text-light">{{ $contactData['email'] ?? 'N/A' }}</span>
                </div>

                @if (!empty($contactData['phone']))
                    <div class="detail-row">
                        <span class="detail-label  text-light">Phone Number:</span>
                        <span class="text-light">{{ $contactData['phone'] }}</span>
                    </div>
                @endif

                @if (!empty($contactData['order_number']))
                    <div class="detail-row">
                        <span class="detail-label  text-light">Order Number:</span>
                        <span class="text-light">{{ $contactData['order_number'] }}</span>
                    </div>
                @endif

                <div class="detail-row">
                    <span class="detail-label  text-light">Submitted:</span>
                    <span class="text-light">{{ now()->format('F j, Y \a\t g:i A T') }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label  text-light">Priority:</span>
                    <span class="detail-value">
                        @if (!empty($contactData['order_number']))
                            <span class="priority-badge priority-high">High Priority</span>
                        @else
                            <span class="priority-badge priority-normal">Normal</span>
                        @endif
                    </span>
                </div>
            </div>

            <!-- Message Content -->
            <div class="message-content">
                <div class="message-header">
                    <span class="message-icon">
                        <!-- Message Bubble SVG Icon -->
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-label="Message Icon"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="3" width="16" height="12" rx="4" fill="#DE991B"
                                opacity="0.15" />
                            <rect x="2" y="3" width="16" height="12" rx="4" stroke="#DE991B"
                                stroke-width="1.5" />
                            <path
                                d="M6 15v2a1 1 0 0 0 1.447.894l3.106-1.553A2 2 0 0 1 12 16h2a4 4 0 0 0 4-4V7a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v5a4 4 0 0 0 4 4h0z"
                                fill="none" />
                            <circle cx="7" cy="9" r="1" fill="#DE991B" />
                            <circle cx="10" cy="9" r="1" fill="#DE991B" />
                            <circle cx="13" cy="9" r="1" fill="#DE991B" />
                        </svg>
                    </span>
                    Customer Message
                </div>
                <div class="message-text">{{ $contactData['message'] ?? 'No message provided.' }}</div>
            </div>
        </div>

        <!-- Action Section -->
        <div class="action-section">
            <h3 class="action-title">⚡ Quick Response</h3>
            <p class="action-subtitle">Click below to respond directly to this customer inquiry</p>
            <a href="mailto:{{ $contactData['email'] ?? '' }}?subject=Re: Your Royalit Inquiry{{ !empty($contactData['order_number']) ? ' - Order ' . $contactData['order_number'] : '' }}&body=Dear {{ $contactData['first_name'] ?? 'Valued Customer' }},%0D%0A%0D%0AThank you for contacting Royalit. We have received your message and will be happy to assist you.%0D%0A%0D%0ABest regards,%0D%0ARoyalit Support Team"
                class="btn-primary">
                <!-- Email Icon SVG -->
                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" aria-label="Email Icon"
                    xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle; margin-right:6px;">
                    <rect x="2" y="4" width="16" height="12" rx="3" fill="#ffffff" opacity="0.15" />
                    <rect x="2" y="4" width="16" height="12" rx="3" stroke="#ffffff"
                        stroke-width="1.5" />
                    <path d="M4 6l6 5 6-5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Reply to Customer
            </a>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-content">
                <h4 class="footer-title">Royalit Support Team</h4>
                <p class="footer-text">
                    This email was automatically generated from the Royalit contact form.
                    Please respond to customer inquiries within 2 hours to maintain our service standards.
                </p>

                <div class="footer-links">
                    <a href="{{ route('homepage') }}" class="footer-link">Visit Website</a>
                    <a href="{{ route('faqs') }}" class="footer-link">Support Center</a>
                    <a href="mailto:support@royalit.com" class="footer-link">Contact Admin</a>
                </div>

                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} Royalit. All rights reserved.</p>
                    <p>African Art Marketplace - Connecting Artists with the World</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
