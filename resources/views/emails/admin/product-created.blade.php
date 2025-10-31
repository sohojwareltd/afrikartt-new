<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Product Notification</title>
    <style type="text/css">
        /* Reset styles for email compatibility */
        .ExternalClass {
            width: 100%;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table {
            border-spacing: 0;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        table td {
            border-collapse: collapse;
        }

        img {
            -ms-interpolation-mode: bicubic;
            display: block;
            outline: none;
            text-decoration: none;
        }

        a {
            text-decoration: none;
            color: #DE991B;
        }

        a:hover {
            text-decoration: underline;
        }

        @media only screen and (max-width: 480px) {
            table.table-main {
                width: 100% !important;
            }

            .mobile-hide {
                display: none !important;
            }

            .mobile-center {
                text-align: center !important;
            }

            .mobile-block {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box;
            }

            .mobile-padding {
                padding: 15px 10px !important;
            }
        }
    </style>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif; color: #333333;">

    <!-- Main email wrapper -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
        <tr>
            <td align="center" style="padding: 30px 10px;">
                <!-- Content container -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600"
                    class="table-main"
                    style="border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: linear-gradient(135deg, #DE991B 0%, #562309 100%);">
                                <tr>
                                    <td align="center" style="padding: 35px 20px; color: #ffffff; position: relative;">
                                        <div style="display: inline-block; background-color: rgb(255 255 255); border-radius: 4%;line-height: 60px; margin-bottom: 15px; text-align: center;">
                                            <span style="font-size: 28px; font-weight: bold;"><img src="{{ Settings::setting('site_logo') }}" alt="Logo" height="80px"></span>
                                        </div>
                                        <h1 style="margin: 0; font-size: 24px; text-align: center; color: #ffffff; font-weight: bold; letter-spacing: 0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                            NEW PRODUCT CREATED
                                        </h1>
                                        <p style="margin: 8px 0 0 0; font-size: 14px; text-align: center; color: #ffffff; opacity: 0.9; font-weight: 300;">
                                            Product awaiting your review and approval
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    {{-- @dd($product) --}}
                    <!-- Introduction -->
                    <tr>
                        <td style="padding: 25px 30px 20px 30px;">
                            <div style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 8px; padding: 25px; border-left: 4px solid #DE991B; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                <h3 style="margin: 0 0 12px 0; font-size: 18px; color: #562309; font-weight: 600;">
                                    👋 Hello Admin,
                                </h3>
                                <p style="margin: 0 0 8px 0; font-size: 16px; line-height: 26px; color: #374151;">
                                    A new product has been submitted to your store and is <strong style="color: #DE991B;">awaiting approval</strong>.
                                </p>
                                <p style="margin: 0; font-size: 14px; line-height: 22px; color: #6b7280; font-style: italic;">
                                    Please review the product details below and take appropriate action.
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Shop details -->
                    <tr>
                        <td style="padding: 0 30px 20px 30px;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: linear-gradient(135deg, #f8fafc 0%, #e8f4fd 100%); border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
                                <tr>
                                    <td style="padding: 25px; position: relative;">
                                        <!-- Header with icon -->
                                        <div style="display: flex; align-items: center; margin-bottom: 20px;">
                                            <div style="display: inline-block; background: linear-gradient(135deg, #DE991B 0%, #562309 100%); border-radius: 10px; padding: 8px; margin-right: 12px; box-shadow: 0 3px 8px rgba(222, 153, 27, 0.3);">
                                                <span style="color: #ffffff; font-size: 16px; font-weight: bold;">🏪</span>
                                            </div>
                                            <h2 style="margin: 0; font-size: 20px; color: #562309; font-weight: 700; letter-spacing: 0.3px;">
                                                Shop Information
                                            </h2>
                                        </div>

                                        <!-- Shop details grid -->
                                        <div style="background: rgba(255, 255, 255, 0.7); border-radius: 10px; padding: 20px; border: 1px solid rgba(222, 153, 27, 0.1); backdrop-filter: blur(5px);">
                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                                width="100%"
                                                style="border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                <tr>
                                                    <td width="140"
                                                        style="padding: 10px 0; font-weight: 600; color: #374151; font-size: 14px; vertical-align: top;">
                                                        <span style="display: inline-block; margin-right: 6px;">🏷️</span>Shop Name:
                                                    </td>
                                                    <td style="padding: 10px 0; color: #1f2937; font-size: 14px; font-weight: 500; vertical-align: top;">
                                                        {{ $product->shop->name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0; height: 1px; background: linear-gradient(90deg, transparent 0%, #e5e7eb 50%, transparent 100%);" colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td width="140"
                                                        style="padding: 10px 0; font-weight: 600; color: #374151; font-size: 14px; vertical-align: top;">
                                                        <span style="display: inline-block; margin-right: 6px;">📧</span>Email:
                                                    </td>
                                                    <td style="padding: 10px 0; vertical-align: top;">
                                                        <a href="mailto:{{ $product->shop->email }}" style="color: #DE991B; text-decoration: none; font-size: 14px; font-weight: 500; transition: color 0.3s ease;">
                                                            {{ $product->shop->email }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0; height: 1px; background: linear-gradient(90deg, transparent 0%, #e5e7eb 50%, transparent 100%);" colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td width="140"
                                                        style="padding: 10px 0; font-weight: 600; color: #374151; font-size: 14px; vertical-align: top;">
                                                        <span style="display: inline-block; margin-right: 6px;">📞</span>Phone:
                                                    </td>
                                                    <td style="padding: 10px 0; color: #1f2937; font-size: 14px; font-weight: 500; vertical-align: top;">
                                                        <a href="tel:{{ $product->shop->phone }}" style="color: #DE991B; text-decoration: none; transition: color 0.3s ease;">
                                                            {{ $product->shop->phone }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0; height: 1px; background: linear-gradient(90deg, transparent 0%, #e5e7eb 50%, transparent 100%);" colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td width="140"
                                                        style="padding: 10px 0; font-weight: 600; color: #374151; font-size: 14px; vertical-align: top;">
                                                        <span style="display: inline-block; margin-right: 6px;">⚡</span>Status:
                                                    </td>
                                                    <td style="padding: 10px 0; vertical-align: top;">
                                                        <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; letter-spacing: 0.3px; 
                                                        {{ $product->shop->status == 1 ? 'background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);' : 'background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #ffffff; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);' }}">
                                                            {{ $product->shop->status == 1 ? '✅ Active' : '❌ Inactive' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <!-- Decorative accent -->
                                        <div style="position: absolute; top: 15px; right: 15px; width: 40px; height: 40px; background: linear-gradient(135deg, #DE991B20, #56230920); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <div style="width: 6px; height: 6px; background: #DE991B; border-radius: 50%;"></div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Product details -->
                    <tr>
                        <td style="padding: 0 30px 20px 30px;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f9fafc; border-radius: 6px; border: 1px solid #e5e7eb;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h2 style="margin: 0 0 15px 0; font-size: 18px; color: #DE991B;">Product
                                            Information</h2>

                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                            width="100%"
                                            style="border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                            <tr>
                                                <td width="120"
                                                    style="padding: 5px 0; font-weight: bold; color: #6b7280;">Product
                                                    Name:</td>
                                                <td style="padding: 5px 0;">{{ $product->name }}</td>
                                            </tr>
                                            <tr>
                                                <td width="120"
                                                    style="padding: 5px 0; font-weight: bold; color: #6b7280;">Product
                                                    Type:</td>
                                                <td style="padding: 5px 0;">{{ $product->type }}</td>
                                            </tr>
                                            <tr>
                                                <td width="120"
                                                    style="padding: 5px 0; font-weight: bold; color: #6b7280;">Price:
                                                </td>
                                                <td style="padding: 5px 0;">{{ $product->vendor_price ?? '' }}</td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="120"
                                                    style="padding: 5px 0; font-weight: bold; color: #6b7280;">Quantity:
                                                </td>
                                                <td style="padding: 5px 0;">{{ $product->quantity }}</td>
                                            </tr>
                                            {{-- @dd($product) --}}
                                            <tr>
                                                <td width="120"
                                                    style="padding: 5px 0; font-weight: bold; color: #6b7280;">Created
                                                    By:</td>
                                                <td style="padding: 5px 0;">{{ $product->created_at->format('d/M/Y') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Call to action -->
                    <tr>
                        <td style="padding: 0 30px 25px 30px;">
                            <div style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 12px; padding: 25px; text-align: center; border: 1px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                                <h3 style="margin: 0 0 15px 0; font-size: 18px; color: #562309; font-weight: 600;">
                                    ⚡ Action Required
                                </h3>
                                <p style="margin: 0 0 20px 0; font-size: 14px; line-height: 22px; color: #6b7280;">
                                    Please review this product and approve or reject it from the admin panel.
                                </p>
                                
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto; border-spacing: 0;">
                                    <tr>
                                        <td style="border-radius: 8px; background: linear-gradient(135deg, #DE991B 0%, #562309 100%); box-shadow: 0 4px 12px rgba(222, 153, 27, 0.3);">
                                            <a href="{{ \Filament\Facades\Filament::getUrl() }}/products" target="_blank"
                                                style="display: inline-block; padding: 16px 32px; border-radius: 8px; color: #ffffff; font-size: 16px; font-weight: 600; text-decoration: none; letter-spacing: 0.5px; transition: all 0.3s ease;">
                                                📋 Review Product in Admin Panel
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                
                                <p style="margin: 15px 0 0 0; font-size: 12px; color: #9ca3af; font-style: italic;">
                                    Or access your admin dashboard directly to manage all pending products
                                </p>
                            </div>
                        </td>
                    </tr>


                    <!-- Footer -->
                    <tr>
                        <td style="padding: 0;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: linear-gradient(135deg, #562309 0%, #DE991B 100%); position: relative;">
                                <tr>
                                    <td style="padding: 30px 30px 25px 30px; text-align: center; position: relative;">
                                        <!-- Decorative elements -->
                                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent 0%, #DE991B 50%, transparent 100%);"></div>
                                        
                                        <!-- Main footer content -->
                                        <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                                            <div style="margin-bottom: 15px;">
                                                <span style="display: inline-block; width: 6px; height: 6px; background-color: #DE991B; border-radius: 50%; margin: 0 3px; opacity: 0.8;"></span>
                                                <span style="display: inline-block; width: 6px; height: 6px; background-color: #ffffff; border-radius: 50%; margin: 0 3px; opacity: 0.6;"></span>
                                                <span style="display: inline-block; width: 6px; height: 6px; background-color: #DE991B; border-radius: 50%; margin: 0 3px; opacity: 0.8;"></span>
                                            </div>
                                            
                                            <p style="margin: 0 0 12px 0; color: #ffffff; font-size: 13px; line-height: 20px; font-weight: 400; opacity: 0.9;">
                                                📧 This is an automated notification from your e-commerce system
                                            </p>
                                            <p style="margin: 0 0 15px 0; color: rgba(255, 255, 255, 0.7); font-size: 11px; line-height: 16px; font-style: italic;">
                                                Please do not reply to this email address
                                            </p>
                                            
                                            <!-- Divider line -->
                                            <div style="height: 1px; background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.3) 50%, transparent 100%); margin: 15px 0;"></div>
                                            
                                            <p style="margin: 0; color: #ffffff; font-size: 12px; line-height: 18px; font-weight: 500; opacity: 0.8;">
                                                &copy; {{ date('Y') }} {{ Settings::setting('site_name', 'Afrikart') }} | All rights reserved
                                            </p>
                                        </div>
                                        
                                        <!-- Bottom accent -->
                                        <div style="margin-top: 15px;">
                                            <span style="display: inline-block; width: 30px; height: 2px; background-color: #DE991B; border-radius: 1px; opacity: 0.7;"></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
