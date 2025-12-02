@section('title', 'Payment Submitted Successfully | ' . config('app.name'))

@extends('layouts.app')

@section('css')
    <style>
        @import url('{{ asset('assets/css/colors.css') }}');

        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            min-height: 100vh;
        }

        .success-container {
            max-width: 700px;
            margin: 80px auto;
            padding: 20px;
        }

        .success-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 50px 30px;
            text-align: center;
            color: white;
        }

        .checkmark-circle {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease-out 0.2s both;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        .checkmark {
            font-size: 60px;
        }

        .success-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .success-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            margin: 0;
        }

        .success-body {
            padding: 40px 30px;
        }

        .info-box {
            background: #dbeafe;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .info-box.success {
            background: #d1fae5;
            border-color: #10b981;
        }

        .info-box h3 {
            color: #1e40af;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .info-box.success h3 {
            color: #065f46;
        }

        .info-box p {
            color: #1e3a8a;
            margin: 0;
            line-height: 1.6;
        }

        .info-box.success p {
            color: #047857;
        }

        .timeline {
            margin: 30px 0;
        }

        .timeline-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: start;
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 700;
        }

        .timeline-icon.pending {
            background: #f59e0b;
        }

        .timeline-content h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 5px 0;
        }

        .timeline-content p {
            color: #6b7280;
            margin: 0;
            line-height: 1.5;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .btn-primary {
            flex: 1;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .btn-secondary {
            flex: 1;
            background: white;
            color: #3b82f6;
            padding: 15px 30px;
            border: 2px solid #3b82f6;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #eff6ff;
            color: #2563eb;
        }

        .highlight-box {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }

        .highlight-box .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .highlight-box h3 {
            color: #92400e;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .highlight-box p {
            color: #78350f;
            margin: 0;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .success-container {
                margin: 30px auto;
                padding: 10px;
            }

            .success-header {
                padding: 40px 20px;
            }

            .success-header h1 {
                font-size: 1.7rem;
            }

            .success-body {
                padding: 25px 20px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="success-container">
        <div class="success-card">
            <!-- Header -->
            <div class="success-header">
                <div class="checkmark-circle">
                    <div class="checkmark">✓</div>
                </div>
                <h1>Payment Proof Submitted!</h1>
                <p>Thank you for your order</p>
            </div>

            <!-- Body -->
            <div class="success-body">
                @if (session('success'))
                    <div class="info-box success">
                        <h3>✅ Success!</h3>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('info'))
                    <div class="info-box">
                        <h3>ℹ️ Information</h3>
                        <p>{{ session('info') }}</p>
                    </div>
                @endif

                <!-- Cart Cleared Notice -->
                <div class="highlight-box">
                    <div class="icon">🛒</div>
                    <h3>Your Cart Has Been Cleared</h3>
                    <p>Your shopping cart has been automatically cleared. You can continue shopping for more items.</p>
                </div>

                <div class="info-box">
                    <h3>📋 What Happens Next?</h3>
                    <p>Your payment receipt has been submitted successfully. Our team will review it within <strong>12-24
                            hours</strong>
                        and update your order status. You will receive an email notification once the payment is verified.
                    </p>
                </div>

                <!-- Timeline -->
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon">✓</div>
                        <div class="timeline-content">
                            <h4>Order Placed</h4>
                            <p>Your order has been created successfully</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon">✓</div>
                        <div class="timeline-content">
                            <h4>Payment Proof Submitted</h4>
                            <p>We received your bank transfer receipt</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon pending">⏳</div>
                        <div class="timeline-content">
                            <h4>Awaiting Verification</h4>
                            <p>Our team is reviewing your payment (12-24 hours)</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon pending">📦</div>
                        <div class="timeline-content">
                            <h4>Order Processing</h4>
                            <p>Once verified, your order will be prepared for shipment</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('homepage') }}" class="btn-primary">
                        Continue Shopping
                    </a>
                    @auth
                        <a href="{{ url('/user') }}" class="btn-secondary">
                            View My Orders
                        </a>
                    @endauth
                </div>

                <!-- Help Text -->
                <div style="text-align: center; margin-top: 30px; padding: 20px; background: #f9fafb; border-radius: 10px;">
                    <p style="color: #6b7280; margin: 0;">
                        <strong>Questions about your order?</strong><br>
                        Contact us at <a href="mailto:{{ config('mail.from.address') }}"
                            style="color: #3b82f6;">{{ config('mail.from.address') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
