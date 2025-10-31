<!DOCTYPE html>
<html>
<head>
    <style>
        :root {
            --primary: #DE991B;
            --primary-light: #FDF4E6;
            --primary-dark: #C58517;
            --text: #333333;
            --text-light: #666666;
            --background: #F9F9F9;
            --border: #E0E0E0;
        }
        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: var(--text);
            background-color: var(--background);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, #FDF4E6 0%, #FFFFFF 100%);
            border-bottom: 1px solid var(--border);
        }
        .logo {
            max-height: 50px;
            margin-bottom: 15px;
        }
        .alert-icon {
            width: 60px;
            height: 60px;
            background-color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        .alert-icon svg {
            width: 30px;
            height: 30px;
            fill: white;
        }
        .content {
            padding: 30px;
        }
        .alert-banner {
            background: var(--primary-light);
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            border-left: 4px solid var(--primary);
        }
        .btn {
            display: inline-block;
            background: var(--primary);
            color: white !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(222, 153, 27, 0.2);
        }
        .details-card {
            background: white;
            border-radius: 8px;
            border: 1px solid var(--border);
            margin: 25px 0;
            overflow: hidden;
        }
        .detail-row {
            display: flex;
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: var(--text-light);
            width: 40%;
            flex-shrink: 0;
        }
        .detail-value {
            color: var(--text);
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: var(--text-light);
            border-top: 1px solid var(--border);
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .detail-row {
                flex-direction: column;
            }
            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{Settings::setting('site.logo')}}" alt="Company Logo" class="logo">
            <div class="alert-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
            </div>
            <h1 style="color: var(--primary); margin: 0 0 5px;">New Vendor Registration</h1>
            <p style="color: var(--text-light); margin: 0;">Requires administrative review</p>
        </div>
        
        <div class="content">
            <div class="alert-banner">
                <h2 style="margin-top: 0; color: var(--primary);">New Seller: {{ $user->name . ' ' . $user->l_name }}</h2>
                <p>A new vendor has registered on {{ config('app.name') }} and requires your approval.</p>
            </div>

            <div class="details-card">
                <div class="detail-row">
                    <div class="detail-label">Contact Person:</div>
                    <div class="detail-value">{{ $user->name . ' ' . $user->l_name }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email Address:</div>
                    <div class="detail-value">{{ $user->email }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Phone Number:</div>
                    <div class="detail-value">{{ $verification->phone ?? 'Not provided' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Registered On:</div>
                    <div class="detail-value">{{ $verification->created_at->format('F j, Y \a\t g:i a') }}</div>
                </div>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="/admin" class="btn">Admin Panel</a>
            </div>

            <p style="text-align: center; font-size: 14px; color: var(--text-light);">
                This is an automated notification. Please review this registration within 48 hours.
            </p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>You're receiving this email because you're an administrator.</p>
        </div>
    </div>
</body>
</html>