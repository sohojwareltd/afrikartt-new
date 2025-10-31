<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Verification Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f7f9;
            padding: 20px;
        }

        .container {
            max-width: 21cm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        header {
            background-color: #2b6cb0 !important;
            color: white !important;
            padding: 25px;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .company-logo {
            font-size: 28px;
            color: white !important;
            background: rgba(255, 255, 255, 0.2) !important;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .report-title {
            font-size: 28px;
            margin-bottom: 5px;
            text-align: center;
            font-weight: 600;
            color: white !important;
        }

        .report-subtitle {
            font-size: 14px;
            text-align: center;
            opacity: 0.9;
            color: white !important;
        }

        .report-info {
            display: flex;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.2) !important;
            padding: 20px;
            border-radius: 12px;
            margin-top: 25px;
            color: white !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .info-item {
            text-align: center;
            flex: 1;
            padding: 0 15px;
            position: relative;
        }

        .info-item strong {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            margin-bottom: 8px;
            font-weight: 600;
            color: white !important;
        }

        .info-item span {
            font-size: 16px;
            font-weight: 700;
            color: white !important;
            display: block;
            line-height: 1.2;
        }

        .content {
            padding: 30px;
        }

        .section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 18px;
            color: #2b6cb0;
            padding-bottom: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #2b6cb0;
            font-weight: 600;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px 15px;
        }

        .form-group {
            flex: 1 0 calc(33.333% - 20px);
            margin: 0 10px 15px;
            min-width: 200px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #444;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            background: #f9fafb;
        }

        .verification-status {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            background: #f0f9ff;
            border-left: 4px solid #4caf50;
        }

        .status-icon {
            font-size: 24px;
            margin-right: 15px;
            color: #4caf50;
        }

        .status-content h3 {
            margin-bottom: 5px;
            font-size: 16px;
            color: #2e7d32;
        }

        .status-content p {
            font-size: 14px;
            margin: 0;
            color: #555;
        }

        .documents-list {
            list-style: none;
            padding: 0;
        }

        .documents-list li {
            padding: 12px;
            border: 1px solid #eaeaea;
            margin-bottom: 10px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .doc-status {
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-approved {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-pending {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-rejected {
            background: #ffebee;
            color: #c62828;
        }

        textarea {
            width: 100%;
            min-height: 100px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
            font-size: 14px;
            background: #f9fafb;
        }

        .signature-box {
            margin-top: 30px;
            padding: 20px;
            border: 1px dashed #ccc;
            border-radius: 4px;
            text-align: center;
            font-size: 14px;
            background: #f9fafb;
        }

        .signature-line {
            width: 300px;
            height: 1px;
            background: #ccc;
            margin: 40px auto 10px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #f1f5f9;
            color: #64748b;
            font-size: 12px;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 5cm;
            opacity: 0.03;
            pointer-events: none;
            z-index: -1;
            color: #000;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }

        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 1.5cm;
            }

            body {
                font-family: Arial, sans-serif;
                line-height: 1.4;
                color: #000;
                background: #fff;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
                border-radius: 0;
            }

            header {
                background: #2b6cb0 !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                border-bottom: 2px solid #2b6cb0;
                padding: 20px;
            }

            .company-logo {
                color: white !important;
                background: rgba(255, 255, 255, 0.2) !important;
            }

            .report-title {
                color: white !important;
            }

            .report-info {
                background: rgba(255, 255, 255, 0.15) !important;
                color: white !important;
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .content {
                padding: 0;
            }

            .section {
                margin-bottom: 20px;
                page-break-inside: avoid;
            }

            .section-title {
                color: #000 !important;
                border-bottom: 1px solid #ddd;
            }

            .form-control {
                background: #fff !important;
                color: #000 !important;
            }

            .verification-status {
                background: #f8f8f8 !important;
                border: 1px solid #ddd;
            }

            .documents-list li {
                border: 1px solid #ddd;
            }

            textarea {
                background: #fff !important;
                color: #000 !important;
            }

            .signature-box {
                border: 1px dashed #ccc;
                background: #fff !important;
            }

            footer {
                background: #f8f8f8 !important;
                color: #000;
                border-top: 1px solid #ddd;
            }

            .watermark {
                opacity: 0.03;
            }
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .form-group {
                flex: 1 0 calc(50% - 20px);
            }
        }

        @media (max-width: 576px) {
            .form-group {
                flex: 1 0 calc(100% - 20px);
            }

            .report-info {
                flex-direction: column;
                gap: 10px;
            }

            .info-item {
                text-align: left;
                display: flex;
                justify-content: space-between;
            }
        }
    </style>
</head>

<body>
    <div class="watermark">AFRIKART</div>
    <div class="container">
        <header style="background-color: #2b6cb0 !important; color: white !important; padding: 25px;">
            <div class="logo-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div class="company-logo" style="font-size: 28px; color: white !important; background: rgba(255, 255, 255, 0.2) !important; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <h1 class="report-title" style="font-size: 28px; margin-bottom: 5px; text-align: center; font-weight: 600; color: white !important;">Vendor Verification Report</h1>
                    <p class="report-subtitle" style="font-size: 14px; text-align: center; opacity: 0.9; color: white !important;">Quality Assurance Department</p>
                </div>
                <div class="company-logo" style="font-size: 28px; color: white !important; background: rgba(255, 255, 255, 0.2) !important; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-clipboard-check"></i>
                </div>
            </div>

            <div class="report-info" style="display: flex; justify-content: space-between; background: rgba(255, 255, 255, 0.2) !important; padding: 20px; border-radius: 12px; margin-top: 25px; color: white !important; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.3);">
                <div class="info-item" style="text-align: center; flex: 1; color: white !important; padding: 0 15px; position: relative;">
                    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 15px; height: 100%;">
                        <div style="background: rgba(255, 255, 255, 0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                            <i class="fas fa-hashtag" style="color: white; font-size: 16px;"></i>
                        </div>
                        <strong style="display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-bottom: 8px; color: white !important; font-weight: 600;">Report ID</strong>
                        <span style="font-size: 16px; font-weight: 700; color: white !important; display: block; line-height: 1.2;">VR-2023-0876</span>
                    </div>
                </div>
                <div class="info-item" style="text-align: center; flex: 1; color: white !important; padding: 0 15px; position: relative;">
                    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 15px; height: 100%;">
                        <div style="background: rgba(255, 255, 255, 0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                            <i class="fas fa-calendar-alt" style="color: white; font-size: 16px;"></i>
                        </div>
                        <strong style="display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-bottom: 8px; color: white !important; font-weight: 600;">Date of Issue</strong>
                        <span style="font-size: 16px; font-weight: 700; color: white !important; display: block; line-height: 1.2;">October 15, 2023</span>
                    </div>
                </div>
                <div class="info-item" style="text-align: center; flex: 1; color: white !important; padding: 0 15px; position: relative;">
                    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 15px; height: 100%;">
                        <div style="background: rgba(46, 204, 113, 0.9); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                            <i class="fas fa-check-circle" style="color: white; font-size: 16px;"></i>
                        </div>
                        <strong style="display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-bottom: 8px; color: white !important; font-weight: 600;">Status</strong>
                        <span style="font-size: 16px; font-weight: 700; color: #2ecc71 !important; display: block; line-height: 1.2; background: rgba(255, 255, 255, 0.9); padding: 4px 12px; border-radius: 20px; color: #27ae60 !important;">VERIFIED</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="content">
            <div class="section">
                <h2 class="section-title">Vendor Information</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="vendor-name">Vendor Name</label>
                        <input type="text" class="form-control" id="vendor-name" value="Global Tech Solutions Inc."
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="vendor-id">Vendor ID</label>
                        <input type="text" class="form-control" id="vendor-id" value="VT-9875" readonly>
                    </div>

                    <div class="form-group">
                        <label for="vendor-type">Vendor Type</label>
                        <input type="text" class="form-control" id="vendor-type" value="Technology Provider"
                            readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contact-person">Contact Person</label>
                        <input type="text" class="form-control" id="contact-person" value="Sarah Johnson" readonly>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="text" class="form-control" id="email" value="s.johnson@globaltech.com"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" value="+1 (555) 123-4567" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1 0 calc(100% - 20px);">
                        <label for="address">Business Address</label>
                        <input type="text" class="form-control" id="address"
                            value="123 Technology Drive, San Francisco, CA 94103, United States" readonly>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Verification Details</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="verification-date">Verification Date</label>
                        <input type="text" class="form-control" id="verification-date" value="October 10, 2023"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="verified-by">Verified By</label>
                        <input type="text" class="form-control" id="verified-by" value="James Wilson" readonly>
                    </div>

                    <div class="form-group">
                        <label for="verification-method">Verification Method</label>
                        <input type="text" class="form-control" id="verification-method" value="On-site Audit"
                            readonly>
                    </div>
                </div>

                <div class="verification-status">
                    <div class="status-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="status-content">
                        <h3>Vendor Verified Successfully</h3>
                        <p>This vendor has met all requirements and has been approved for partnership.</p>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Required Documents</h2>

                <ul class="documents-list">
                    <li>
                        <div>
                            <strong>Business License</strong>
                            <p>Uploaded: September 28, 2023</p>
                        </div>
                        <span class="doc-status status-approved">Approved</span>
                    </li>
                    <li>
                        <div>
                            <strong>Tax Compliance Certificate</strong>
                            <p>Uploaded: September 28, 2023</p>
                        </div>
                        <span class="doc-status status-approved">Approved</span>
                    </li>
                    <li>
                        <div>
                            <strong>Quality Management System Certification</strong>
                            <p>Uploaded: September 30, 2023</p>
                        </div>
                        <span class="doc-status status-approved">Approved</span>
                    </li>
                    <li>
                        <div>
                            <strong>Insurance Certificate</strong>
                            <p>Uploaded: October 5, 2023</p>
                        </div>
                        <span class="doc-status status-pending">Under Review</span>
                    </li>
                </ul>
            </div>

            <div class="section">
                <h2 class="section-title">Evaluation Results</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="financial-rating">Financial Stability Rating</label>
                        <input type="text" class="form-control" id="financial-rating" value="A (Excellent)"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="quality-rating">Quality Assurance Rating</label>
                        <input type="text" class="form-control" id="quality-rating" value="4.8/5" readonly>
                    </div>

                    <div class="form-group">
                        <label for="risk-level">Risk Level</label>
                        <input type="text" class="form-control" id="risk-level" value="Low" readonly>
                    </div>
                </div>

                <div>
                    <label for="evaluation-notes">Evaluation Notes</label>
                    <textarea id="evaluation-notes" class="form-control" readonly>Vendor demonstrates strong financial health and excellent quality control processes. Their delivery times have been consistent based on references from other clients. Minor follow-up required on insurance certificate documentation.</textarea>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Authorization</h2>

                <div class="signature-box">
                    <p>Verified and approved by</p>
                    <div class="signature-line"></div>
                    <p>Quality Assurance Manager</p>
                    <p style="margin-top: 10px; font-style: italic;">Signature</p>
                </div>
            </div>
        </div>

        <footer>
            <p>© 2023 Afrikart. All rights reserved. | Vendor Verification Report</p>
            <p>This document contains confidential information and is intended only for authorized personnel.</p>
        </footer>
    </div>
</body>

</html>
