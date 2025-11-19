<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Customized Product Request</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #f68b1e 0%, #ff9f42 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .email-header p {
            margin: 10px 0 0;
            font-size: 14px;
            opacity: 0.95;
        }

        .email-body {
            padding: 30px 25px;
        }

        .info-section {
            margin-bottom: 25px;
        }

        .info-section h2 {
            color: #f68b1e;
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f68b1e;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .info-table td:first-child {
            font-weight: 600;
            color: #555;
            width: 40%;
        }

        .info-table td:last-child {
            color: #333;
        }

        .product-type-badge {
            display: inline-block;
            background: linear-gradient(135deg, #f68b1e 0%, #ff9f42 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .quantity-badge {
            display: inline-block;
            background: #17a2b8;
            color: white;
            padding: 6px 14px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 13px;
            margin-left: 10px;
        }

        .description-box {
            background-color: #fff8f0;
            border-left: 4px solid #f68b1e;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }

        .description-box p {
            margin: 0;
            color: #555;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .priority-box {
            background: linear-gradient(135deg, #fff3cd 0%, #ffe8a1 100%);
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }

        .priority-box strong {
            color: #856404;
            font-size: 16px;
            display: block;
            margin-bottom: 5px;
        }

        .priority-box p {
            color: #856404;
            margin: 0;
            font-size: 14px;
        }

        .attachment-notice {
            background-color: #e7f3ff;
            border: 1px solid #2196F3;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }

        .attachment-notice p {
            margin: 0;
            color: #0d47a1;
            font-weight: 600;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #f68b1e 0%, #ff9f42 100%);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 25px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(246, 139, 30, 0.3);
        }

        .cta-button:hover {
            background: linear-gradient(135deg, #ff9f42 0%, #f68b1e 100%);
            box-shadow: 0 6px 20px rgba(246, 139, 30, 0.4);
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            border-top: 1px solid #eee;
        }

        .email-footer p {
            margin: 5px 0;
        }

        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }

            .email-header {
                padding: 20px 15px;
            }

            .email-header h1 {
                font-size: 22px;
            }

            .email-body {
                padding: 20px 15px;
            }

            .info-table td {
                display: block;
                width: 100% !important;
                padding: 8px 5px;
            }

            .info-table td:first-child {
                border-bottom: none;
                padding-bottom: 2px;
            }

            .cta-button {
                display: block;
                padding: 12px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        {{-- Header --}}
        <div class="email-header">
            <h1>🎨 New Customized Product Request</h1>
            <p>A new custom design request has been submitted</p>
        </div>

        {{-- Body --}}
        <div class="email-body">
            {{-- Priority Action Box --}}
            <div class="priority-box">
                <strong>⚡ Creative Opportunity</strong>
                <p>Review this custom design request and respond within 24 hours</p>
            </div>

            {{-- Customer Information --}}
            <div class="info-section">
                <h2>Customer Information</h2>
                <table class="info-table">
                    <tr>
                        <td>Name:</td>
                        <td><strong>{{ $customized->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><a href="mailto:{{ $customized->email }}"
                                style="color: #f68b1e; text-decoration: none;">{{ $customized->email }}</a></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><a href="tel:{{ $customized->phone }}"
                                style="color: #f68b1e; text-decoration: none;">{{ $customized->phone }}</a></td>
                    </tr>
                </table>
            </div>

            {{-- Product Details --}}
            <div class="info-section">
                <h2>Product Details</h2>
                <table class="info-table">
                    <tr>
                        <td>Product Type:</td>
                        <td>
                            <span
                                class="product-type-badge">{{ ucfirst(str_replace('_', ' ', $customized->type)) }}</span>
                        </td>
                    </tr>
                    {{-- <tr>
                        <td>Quantity:</td>
                        <td>
                            <span class="quantity-badge">{{ number_format($customized->quantity) }} {{ $customized->quantity > 1 ? 'pieces' : 'piece' }}</span>
                        </td>
                    </tr> --}}
                    <tr>
                        <td>Submitted:</td>
                        <td>{{ $customized->created_at->format('F j, Y \a\t g:i A') }}</td>
                    </tr>
                </table>
            </div>

            {{-- Design Details --}}
            <div class="info-section">
                <h2>Design Details</h2>
                <div class="description-box">
                    <p>{{ $customized->description }}</p>
                </div>
            </div>

            {{-- Attachment Notice --}}
            @if ($customized->attachment)
                <div class="attachment-notice">
                    <p>📎 This request includes design inspiration attachments</p>
                </div>
            @endif

            {{-- Call to Action --}}
            {{-- <div style="text-align: center;">
                <a href="{{ config('app.url') }}/admin" class="cta-button">
                    View in Admin Panel
                </a>
            </div> --}}
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <p><strong>Customized Product Request Notification</strong></p>
            <p>This is an automated notification from {{ config('app.name') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
