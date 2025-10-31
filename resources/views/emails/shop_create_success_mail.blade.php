<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Online Shop is Ready!</title>
    <style>
        /* Base Styles */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #ffffff;
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid #eeeeee;
        }

        .logo {
            max-width: 180px;
            height: auto;
        }

        .content {
            padding: 30px;
        }

        h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-top: 0;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .highlight {
            background-color: #fff8e1;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }

        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .button {
            display: inline-block;
            background-color: #3498db;
            color: white !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: bold;
            margin: 10px 5px;
            text-align: center;
        }

        .button-primary {
            background-color: #2ecc71;
        }

        .button-secondary {
            background-color: #3498db;
        }

        .footer {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #777777;
        }

        .social-icons {
            margin: 15px 0;
        }

        .social-icon {
            margin: 0 8px;
            text-decoration: none;
        }

        .divider {
            height: 1px;
            background-color: #eeeeee;
            margin: 20px 0;
        }

        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100%;
            }

            .content {
                padding: 20px;
            }

            .button {
                display: block;
                margin: 10px auto;
            }
        }
    </style>
</head>

<body>
    {{-- resources/views/emails/shop-welcome.blade.php --}}

    <div class="email-container">

        {{-- Header --}}
        <div class="header" style="text-align: center; padding: 20px; background-color: #f8f8f8;">
            <img src="{{ asset(Settings::setting('site_logo')) }}" alt="{{ config('app.name') }} Logo" class="logo"
                style="max-height: 60px;">
            <h1 style="color: #333; margin-top: 15px;">Welcome to the Marketplace Family!</h1>
        </div>

        {{-- Content --}}
        <div class="content" style="padding: 20px; color: #555;">
            <p>Congratulations, <strong>{{ $shop->user->name ?? 'Valued Seller' }}</strong>!</p>

            <p>Your online shop <strong>"{{ $shop->name ?? '' }}"</strong> has been successfully created and is ready
                for business! We're thrilled to have you join our community of sellers.</p>

            <div class="highlight"
                style="background-color: #f3f8ff; padding: 15px; border-radius: 6px; margin-top: 20px;">
                <h2 style="color: #ffc107;">✨ What's Next?</h2>
                <ul style="padding-left: 20px;">
                    <li>Customize your shop design in the Seller Dashboard</li>
                    <li>Add your first products to start selling</li>
                    <li>Set up payment methods to receive payments</li>
                    <li>Explore marketing tools to promote your shop</li>
                </ul>
            </div>

            <h2 style="margin-top: 25px; color: #333;">Quick Access:</h2>

            <div class="button-container" style="margin-top: 15px;">
                <a href="{{ route('store_front', $shop->slug) }}" class="button button-primary"
                    style="background: #ffc107; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px;">Go
                    to My Shop</a>
                <a href="/vendor" class="button button-secondary"
                    style="background: #6c757d; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Seller
                    Dashboard</a>
            </div>

            <p style="margin-top: 20px;">Need help getting started? Check out our <a
                    href="/vendor" style="color: #ffc107;">Seller Guide</a>
                or contact our support team.</p>

            <p>Happy Selling!<br>
                The {{ config('app.name') }} Team</p>
        </div>

        {{-- <div class="divider" style="border-top: 1px solid #ddd; margin: 20px 0;"></div> --}}

        {{-- Footer --}}
        <div class="footer" style="text-align: center; padding: 20px; font-size: 13px; color: #777;">
            <div class="social-icons" style="margin-bottom: 10px;">
                @if ($shop->user->facebook)
                    <a href="{{ $shop->user->facebook }}" class="social-icon" style="margin: 0 5px;"><img
                            src="{{ asset('images/icons/facebook.png') }}" alt="Facebook" width="30"></a>
                @endif
                @if ($shop->user->twitter)
                    <a href="{{ $shop->user->twitter }}" class="social-icon" style="margin: 0 5px;"><img
                            src="{{ asset('images/icons/twitter.png') }}" alt="Twitter" width="30"></a>
                @endif
                @if ($shop->user->instagram)
                    <a href="{{ $shop->user->instagram }}" class="social-icon" style="margin: 0 5px;"><img
                            src="{{ asset('images/icons/instagram.png') }}" alt="Instagram" width="30"></a>
                @endif
                @if ($shop->user->linkedin)
                    <a href="{{ $shop->user->linkedin }}" class="social-icon" style="margin: 0 5px;"><img
                            src="{{ asset('images/icons/linkedin.png') }}" alt="LinkedIn" width="30"></a>
                @endif
            </div>

            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>{{ $shop->company_registration ?? '' }}<br>{{ $shop->city ?? '' }}, {{ $shop->state ?? '' }} -
                {{ $shop->post_code ?? '' }}<br>{{ $shop->country ?? '' }}</p>
            <p><a href="{{ route('privacy.policy') }}" style="color: #ffc107;">Privacy Policy</a></p>
        </div>
    </div>

</body>

</html>
