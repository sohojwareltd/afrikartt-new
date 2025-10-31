<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congratulations! Your Shop Is Live</title>
    <style>
        /* Base Styles */
        :root {
            --primary: #DE991B;
            --primary-dark: #B87D15;
            --secondary: #2C3E50;
            --accent: #E67E22;
            --text: #2D3436;
            --light-bg: #FDF8F0;
            --border: #EDE5D7;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--text);
            margin: 0;
            padding: 0;
            background-color: var(--light-bg);
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border);
        }

        /* Header */
        .header {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header::after {
            content: "";
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .logo {
            max-width: 180px;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            position: relative;
            z-index: 2;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .subheader {
            font-size: 16px;
            opacity: 0.9;
            margin-top: 12px;
            position: relative;
            z-index: 2;
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        /* Content */
        .content {
            padding: 30px;
        }

        .welcome-text {
            font-size: 16px;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .highlight-card {
            background: linear-gradient(to right, rgba(222, 153, 27, 0.1), rgba(46, 134, 193, 0.1));
            border-radius: 10px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid var(--primary);
            position: relative;
            overflow: hidden;
        }

        .highlight-card::before {
            content: "✨";
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            opacity: 0.3;
        }

        .highlight-title {
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--primary-dark);
        }

        /* Shop Details */
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 25px 0;
        }

        .detail-card {
            background: var(--light-bg);
            border-radius: 8px;
            padding: 15px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            border-color: var(--primary);
        }

        .detail-label {
            font-size: 13px;
            color: #7F8C8D;
            margin-bottom: 5px;
            display: block;
        }

        .detail-value {
            font-weight: 600;
            font-size: 15px;
        }

        /* Features */
        .features-title {
            font-size: 18px;
            font-weight: 600;
            margin: 30px 0 15px;
            color: var(--secondary);
            display: flex;
            align-items: center;
        }

        .features-title::before {
            content: "";
            display: inline-block;
            width: 20px;
            height: 4px;
            background: var(--primary);
            margin-right: 10px;
            border-radius: 2px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .feature-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-color: var(--primary);
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .feature-title {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 5px;
            color: var(--secondary);
        }

        .feature-desc {
            font-size: 13px;
            color: #636E72;
            line-height: 1.5;
        }

        /* CTA */
        .cta-section {
            text-align: center;
            padding: 20px 30px 30px;
            background: var(--light-bg);
            margin-top: 20px;
            border-top: 1px dashed var(--primary);
        }

        .cta-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--secondary);
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            margin: 0 8px 10px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 15px;
            min-width: 180px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(222, 153, 27, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(222, 153, 27, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-secondary:hover {
            background: rgba(222, 153, 27, 0.05);
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            padding: 25px;
            text-align: center;
            color: #7F8C8D;
            font-size: 13px;
            line-height: 1.6;
        }

        .footer-links {
            margin: 15px 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .footer-link {
            color: var(--primary-dark);
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        .social-links {
            margin: 20px 0;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 50%;
            margin: 0 5px;
            color: var(--primary-dark);
            text-decoration: none;
            border: 1px solid var(--border);
            transition: all 0.3s;
        }

        .social-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            border-color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 600px) {

            .details-grid,
            .features-grid {
                grid-template-columns: 1fr;
            }

            .btn {
                display: block;
                margin: 10px auto;
                width: 90%;
            }

            .header {
                padding: 30px 20px;
            }

            .content,
            .cta-section {
                padding: 25px 20px;
            }

            .footer-links {
                flex-direction: column;
            }

            .footer-link {
                margin: 5px 0;
            }
        }
    </style>
</head>

<body>
    {{-- resources/views/vendor/shop-approved.blade.php --}}
    <div class="container">
        {{-- Header --}}
        <div class="header text-center mb-4">
            <img src="{{ asset(Settings::setting('site_logo')) }}" alt="Marketplace Logo" class="logo mb-3"
                style="max-height: 80px;">
            <h1>Your Shop Is Now Live!</h1>
            <div class="subheader">Welcome to our marketplace family. Start selling to thousands of customers today!
            </div>
        </div>

        {{-- Welcome Message --}}
        <div class="content">
            <p class="welcome-text">Dear <strong>{{ $shop->user->name }}</strong>,</p>

            <div class="highlight-card p-3 border rounded mb-4">
                <div class="highlight-title fw-bold mb-2">Congratulations! 🎉</div>
                <p>Your shop <strong>"{{ $shop->name }}"</strong> has been successfully approved and is now visible to
                    our
                    community of buyers. This is just the beginning of your success journey with us.</p>
            </div>

            {{-- Shop Details --}}
            <div class="details-grid row g-3">
                <div class="detail-card col-md-6">
                    <span class="detail-label fw-bold">Shop Name</span><br>
                    <span class="detail-value">{{ $shop->name }}</span>
                </div>
                <div class="detail-card col-md-6">
                    <span class="detail-label fw-bold">Shop URL</span><br>
                    <span class="detail-value">
                        <a href="{{ route('store_front', $shop->slug) }}"
                            class="text-primary">{{ route('store_front', $shop->slug) }}</a>
                    </span>
                </div>
                <div class="detail-card col-md-6">
                    <span class="detail-label fw-bold">Vendor ID</span><br>
                    <span class="detail-value">{{ $shop->user->id }}</span>
                </div>
                <div class="detail-card col-md-6">
                    <span class="detail-label fw-bold">Approval Date</span><br>
                    <span class="detail-value">{{ $shop->created_at->format('F d, Y') }}</span>
                </div>
            </div>

            {{-- Features --}}
            <h3 class="features-title mt-5">Get Started With These Features</h3>
            <div class="features-grid row g-3">
                <div class="feature-card col-md-3 text-center p-3 border rounded">
                    <div class="feature-icon fs-3">📦</div>
                    <div class="feature-title fw-bold mt-2">Add Products</div>
                    <div class="feature-desc">Upload your products with images, descriptions, and prices.</div>
                </div>
                <div class="feature-card col-md-3 text-center p-3 border rounded">
                    <div class="feature-icon fs-3">🎨</div>
                    <div class="feature-title fw-bold mt-2">Customize Shop</div>
                    <div class="feature-desc">Add your logo, banners, and brand colors.</div>
                </div>
                <div class="feature-card col-md-3 text-center p-3 border rounded">
                    <div class="feature-icon fs-3">📊</div>
                    <div class="feature-title fw-bold mt-2">Dashboard</div>
                    <div class="feature-desc">Track sales, orders, and customers.</div>
                </div>
                <div class="feature-card col-md-3 text-center p-3 border rounded">
                    <div class="feature-icon fs-3">💰</div>
                    <div class="feature-title fw-bold mt-2">Earnings</div>
                    <div class="feature-desc">Set up payouts and withdraw your balance.</div>
                </div>
            </div>
        </div>

        {{-- Call To Action --}}
        <div class="cta-section text-center mt-5">
            <div class="cta-title mb-3 fw-bold">Ready to start your selling journey?</div>
            <a href="/vendor" class="btn btn-primary me-2">Go to Vendor Dashboard</a>
            <a href="{{ route('store_front', $shop->slug) }}" class="btn btn-secondary">View Your Shop</a>
        </div>

        {{-- Footer --}}
        <div class="footer mt-5 text-center">
            <div class="footer-links mb-3">
                <a href="/vendor" class="footer-link me-3">Vendor Dashboard</a>
                <a href="{{ url('/privacy-policy') }}" class="footer-link me-3">Policies</a>
                <a href="{{ url('/contact') }}" class="footer-link me-3">Support Center</a>
                <a href="{{ url('/contact') }}" class="footer-link">Community Forum</a>
            </div>

            <p>Our vendor support team is available 24/7 to help you succeed</p>
            <p>✉️ <a href="mailto:{{ $shop->user->email }}" class="text-primary">{{ $shop->user->email }}</a>
                | 📞 {{ $shop->phone ?? '+1 (800) 123-4567' }}</p>

            {{-- Social Links --}}
            <div class="social-links mb-3">
                @if ($shop->user->facebook)
                    <a href="{{ $shop->user->facebook }}" class="social-link me-2">Facebook</a>
                @endif
                @if ($shop->user->instagram)
                    <a href="{{ $shop->user->instagram }}" class="social-link me-2">Instagram</a>
                @endif
                @if ($shop->user->twitter)
                    <a href="{{ $shop->user->twitter }}" class="social-link me-2">Twitter</a>
                @endif
                @if ($shop->user->youtube)
                    <a href="{{ $shop->user->youtube }}" class="social-link">YouTube</a>
                @endif
            </div>

            <p>© {{ date('Y') }} Afrikart. All rights reserved.<br>
                {{ $shop->user->verification->address ?? $shop->company_registration }}</p>
        </div>
    </div>
</body>

</html>
