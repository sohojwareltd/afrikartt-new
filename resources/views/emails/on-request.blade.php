<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Custom Request</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #f68b1e 0%, #ff9f42 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }

        .email-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .email-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .email-body {
            padding: 30px 20px;
        }

        .info-section {
            margin-bottom: 25px;
        }

        .info-section h2 {
            font-size: 18px;
            color: #f68b1e;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f68b1e;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: 600;
            color: #555555;
            padding: 10px 15px 10px 0;
            width: 40%;
            vertical-align: top;
        }

        .info-value {
            display: table-cell;
            color: #333333;
            padding: 10px 0;
            vertical-align: top;
        }

        .type-badge {
            display: inline-block;
            background: linear-gradient(135deg, #f68b1e 0%, #ff9f42 100%);
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .description-box {
            background-color: #fff8f0;
            border-left: 4px solid #f68b1e;
            padding: 15px;
            border-radius: 4px;
            margin-top: 10px;
            line-height: 1.6;
        }

        .attachment-notice {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px 15px;
            border-radius: 4px;
            margin-top: 15px;
            font-size: 14px;
        }

        .attachment-notice strong {
            color: #856404;
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .email-footer p {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, #f68b1e 0%, #ff9f42 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            transition: all 0.3s ease;
        }

        .action-button:hover {
            background: linear-gradient(135deg, #ff9f42 0%, #f68b1e 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
        }

        .icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 8px;
            vertical-align: middle;
        }

        .highlight-box {
            background: linear-gradient(135deg, rgba(246, 139, 30, 0.1) 0%, rgba(246, 139, 30, 0.05) 100%);
            border: 2px solid #f68b1e;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
        }

        .highlight-box strong {
            color: #f68b1e;
            display: block;
            margin-bottom: 5px;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .email-body {
                padding: 20px 15px;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .info-label,
            .info-value {
                display: block;
                width: 100%;
                padding: 5px 0;
            }

            .info-label {
                font-size: 14px;
                margin-bottom: 5px;
            }

            .info-value {
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🎨 New Custom Request</h1>
            <p>A customer has submitted a custom product/service request</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <!-- Customer Information -->
            <div class="info-section">
                <h2>👤 Customer Information</h2>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Full Name:</div>
                        <div class="info-value"><strong>{{ $request->name }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value">
                            <a href="mailto:{{ $request->email }}"
                                style="color: #f68b1e; text-decoration: none;">{{ $request->email }}</a>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Phone:</div>
                        <div class="info-value">
                            <a href="tel:{{ $request->phone }}"
                                style="color: #f68b1e; text-decoration: none;">{{ $request->phone }}</a>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Request Date:</div>
                        <div class="info-value">{{ $request->created_at->format('F d, Y \a\t h:i A') }}</div>
                    </div>
                </div>
            </div>

            <!-- Request Details -->
            <div class="info-section">
                <h2>📋 Request Details</h2>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Request Type:</div>
                        <div class="info-value">
                            <span class="type-badge">{{ str_replace('_', ' ', $request->type) }}</span>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 15px;">
                    <strong style="color: #555555; display: block; margin-bottom: 8px;">Detailed Description:</strong>
                    <div class="description-box">
                        {{ $request->description }}
                    </div>
                </div>
            </div>

            <!-- Attachment Notice -->
            @if ($request->attachment)
                <div class="attachment-notice">
                    <strong>📎 Attachment Included:</strong> This request includes an image or document attachment.
                    Please
                    check your email attachments or admin panel to view the file.
                </div>
            @endif

            <!-- Priority Notice -->
            <div class="highlight-box">
                <strong>⚡ Action Required</strong>
                <p style="margin: 0; color: #333;">Please review this custom request and respond to the customer within
                    24-48 hours with pricing and availability information.</p>
            </div>

            <!-- Action Button -->
            {{-- <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/admin/resources/alterations/' . $request->id) }}" class="action-button">
                    View Full Request in Admin Panel
                </a>
            </div> --}}
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>{{ config('app.name', 'Afrikartt') }}</strong></p>
            <p>Custom Request Management System</p>
            <p style="margin-top: 15px; font-size: 12px;">
                This is an automated notification from your custom request system.
            </p>
        </div>
    </div>
</body>

</html>
