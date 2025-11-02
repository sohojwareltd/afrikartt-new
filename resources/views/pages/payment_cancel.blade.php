@extends('layouts.app')

@section('title', 'Payment Cancelled | Royalit E-commerce')
@section('meta_description',
    'Your payment was cancelled. You can try again or continue shopping on Royalit
    E-commerce.')
@section('meta_keywords', 'payment cancelled, payment failed, checkout, ecommerce, Royalit')
@section('canonical_url', route('payment.cancel'))

@section('meta_og')
    <meta property="og:title" content="Payment Cancelled | Royalit E-commerce">
    <meta property="og:description"
        content="Your payment was cancelled. You can try again or continue shopping on Royalit E-commerce.">
    <meta property="og:image" content="{{ Settings::setting('site_logo') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection

@section('meta_twitter')
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Payment Cancelled | Royalit E-commerce">
    <meta name="twitter:description"
        content="Your payment was cancelled. You can try again or continue shopping on Royalit E-commerce.">
    <meta name="twitter:image" content="{{ Settings::setting('site_logo') }}">
@endsection

@section('css')
    <style>
        .payment-cancel-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 40px 0;
        }

        .cancel-card {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
            margin: 0 20px;
            position: relative;
            overflow: hidden;
        }

        .cancel-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .cancel-icon svg {
            width: 60px;
            height: 60px;
            color: #ef4444;
        }

        .cancel-title {
            font-size: 32px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cancel-subtitle {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 40px;
            line-height: 1.6;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .btn-secondary-custom {
            background: var(--accent-color);
            border: 2px solid #e5e7eb;
            color: #ffffff;
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            border-color: #3b82f6;
            background: #f8fafc;
            color: #3b82f6;
            transform: translateY(-2px);
        }

        .help-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
            border: 1px solid #e5e7eb;
        }

        .help-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .help-links {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .help-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .help-link:hover {
            background: #dbeafe;
            color: #2563eb;
        }

        .security-note {
            margin-top: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-radius: 12px;
            border-left: 4px solid #0ea5e9;
        }

        .security-note-title {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .security-note-text {
            font-size: 14px;
            color: #475569;
            line-height: 1.5;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .cancel-card {
                padding: 40px 30px;
                margin: 0 15px;
            }

            .cancel-title {
                font-size: 28px;
            }

            .cancel-subtitle {
                font-size: 16px;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-primary-custom,
            .btn-secondary-custom {
                width: 100%;
                max-width: 280px;
            }

            .help-links {
                flex-direction: column;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cancel-card {
            animation: fadeInUp 0.6s ease;
        }

        .cancel-icon {
            animation: fadeInUp 0.8s ease;
        }
    </style>
@endsection

@section('content')
    <x-app.header />

    <div class="payment-cancel-container">
        <div class="cancel-card">
            <!-- Cancel Icon -->
            <div class="cancel-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <!-- Main Content -->
            <h1 class="cancel-title">Payment Cancelled</h1>
            <p class="cancel-subtitle">
                Your payment was cancelled or failed to process. Don't worry, no charges were made to your account. You can
                try again or continue shopping.
            </p>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('homepage') }}" class="btn-secondary-custom">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px;">
                        <path fill-rule="evenodd"
                            d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                    </svg>
                    Continue Shopping
                </a>
            </div>

            <!-- Help Section -->
            <div class="help-section">
                <h3 class="help-title">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                    </svg>
                    Need Help?
                </h3>
                <div class="help-links">
                    <a href="{{ route('contact') }}" class="help-link">Contact Support</a>
                    <a href="{{ route('faqs') }}" class="help-link">Payment FAQ</a>
                    <a href="{{ route('cart') }}" class="help-link">Cart</a>
                </div>
            </div>

            <!-- Security Note -->
            <div class="security-note">
                <div class="security-note-title">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                    </svg>
                    Your Security is Protected
                </div>
                <p class="security-note-text">
                    No payment information was processed. Your financial details remain secure and no charges were made to
                    your account.
                </p>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
