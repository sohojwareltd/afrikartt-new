@section('title', 'Bank Transfer Payment | ' . config('app.name'))

@extends('layouts.app')

@section('css')
    <style>
        @import url('{{ asset('assets/css/colors.css') }}');

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .payment-container {
            max-width: 800px;
            margin: 60px auto;
            padding: 20px;
        }

        .payment-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
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

        .payment-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .payment-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .payment-header .order-id {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .payment-body {
            padding: 40px 30px;
        }

        .bank-details-section {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 2px solid #3b82f6;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .bank-details-section h2 {
            color: #1e40af;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 25px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .bank-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .bank-info-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .bank-info-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .bank-info-value {
            font-size: 1.25rem;
            color: #1e40af;
            font-weight: 700;
            word-break: break-all;
        }

        .bank-info-value.monospace {
            font-family: 'Courier New', monospace;
        }

        .instructions-section {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .instructions-section h3 {
            color: #92400e;
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .instructions-section p {
            color: #78350f;
            margin: 0;
            line-height: 1.6;
        }

        .upload-section {
            background: #f9fafb;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .upload-section:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .upload-section h3 {
            color: #111827;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0 0 15px 0;
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
            margin: 20px 0;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-button {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 15px 40px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .file-input-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .file-info {
            margin-top: 15px;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .selected-file {
            margin-top: 15px;
            padding: 15px;
            background: #d1fae5;
            border-radius: 8px;
            color: #065f46;
            font-weight: 600;
            display: none;
        }

        .submit-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 18px 50px;
            border: none;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .submit-button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .submit-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .order-summary {
            background: #f9fafb;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .order-summary h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 15px 0;
        }

        .order-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .order-summary-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
            color: #10b981;
        }

        @media (max-width: 768px) {
            .payment-container {
                margin: 20px auto;
                padding: 10px;
            }

            .payment-header {
                padding: 30px 20px;
            }

            .payment-header h1 {
                font-size: 1.5rem;
            }

            .payment-body {
                padding: 25px 20px;
            }

            .bank-info-grid {
                grid-template-columns: 1fr;
            }

            .bank-info-value {
                font-size: 1.1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="payment-container">
        <div class="payment-card">
            <!-- Header -->
            <div class="payment-header">
                <div style="font-size: 3rem; margin-bottom: 15px;">🏦</div>
                <h1 class="text-light">Complete Your Bank Transfer</h1>
                <div class="order-id">Order #{{ $order->id }}</div>
            </div>

            <!-- Body -->
            <div class="payment-body">
                <!-- Order Summary -->
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div class="order-summary-row">
                        <span>Subtotal:</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if ($order->shipping_total)
                        <div class="order-summary-row">
                            <span>Shipping:</span>
                            <span>${{ number_format($order->shipping_total, 2) }}</span>
                        </div>
                    @endif
                    @if ($order->state_tax)
                        <div class="order-summary-row">
                            <span>Tax:</span>
                            <span>${{ number_format($order->state_tax, 2) }}</span>
                        </div>
                    @endif
                    @if ($order->discount)
                        <div class="order-summary-row">
                            <span>Discount:</span>
                            <span style="color: #10b981;">-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="order-summary-row">
                        <span>Total Amount:</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <!-- Bank Details -->
                <div class="bank-details-section">
                    <h2>
                        <svg style="width: 28px; height: 28px;" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.496 2.132a1 1 0 00-.992 0l-7 4A1 1 0 003 8v7a1 1 0 100 2h14a1 1 0 100-2V8a1 1 0 00.496-1.868l-7-4zM6 9a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1zm3 1a1 1 0 012 0v3a1 1 0 11-2 0v-3zm5-1a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1z" />
                        </svg>
                        Bank Account Details
                    </h2>
                    <p style="color: #6b7280; margin-bottom: 20px;">Transfer the exact amount to the following bank account:
                    </p>

                    <div class="bank-info-grid">
                        <div class="bank-info-item">
                            <div class="bank-info-label">Bank Name</div>
                            <div class="bank-info-value">{{ $settings->bank_name }}</div>
                        </div>
                        <div class="bank-info-item">
                            <div class="bank-info-label">Account Holder</div>
                            <div class="bank-info-value">{{ $settings->account_holder }}</div>
                        </div>
                        <div class="bank-info-item">
                            <div class="bank-info-label">Account Number</div>
                            <div class="bank-info-value monospace">{{ $settings->account_number }}</div>
                        </div>
                        <div class="bank-info-item">
                            <div class="bank-info-label">Routing Number</div>
                            <div class="bank-info-value monospace">{{ $settings->routing_number }}</div>
                        </div>
                        <div class="bank-info-item">
                            <div class="bank-info-label">Account Type</div>
                            <div class="bank-info-value">{{ ucfirst($settings->account_type) }}</div>
                        </div>
                        <div class="bank-info-item">
                            <div class="bank-info-label">Amount to Transfer</div>
                            <div class="bank-info-value" style="color: #10b981;">${{ number_format($order->total, 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                @if ($settings->instructions)
                    <div class="instructions-section">
                        <h3><i class="fas fa-info-circle"></i> Important Instructions</h3>
                        <p>{{ $settings->instructions }}</p>
                    </div>
                @endif

                <!-- Upload Section -->
                <form action="{{ route('payment.bank-transfer.submit', ['order' => $order->id]) }}" method="POST"
                    enctype="multipart/form-data" id="receiptForm">
                    @csrf

                    <div class="upload-section">
                        <h3>📤 Upload Payment Receipt</h3>
                        <p style="color: #6b7280; margin-bottom: 10px;">After completing the transfer, upload your payment
                            receipt or screenshot.</p>

                        <div class="file-input-wrapper">
                            <input type="file" name="bank_receipt" id="receiptInput"
                                accept="image/jpeg,image/jpg,image/png,application/pdf" required>
                            <div class="file-input-button">
                                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Choose File
                            </div>
                        </div>

                        <div id="selectedFileName" class="selected-file"></div>

                        <div class="file-info">
                            <i class="fas fa-check-circle" style="color: #10b981;"></i>
                            Accepted formats: JPG, PNG, PDF | Max size:
                            {{ number_format($settings->max_file_size / 1024, 1) }}MB
                        </div>

                        @error('bank_receipt')
                            <div style="color: #dc2626; margin-top: 10px; font-weight: 600;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="submit-button" id="submitButton" disabled>
                        <span id="buttonText">Select a file to continue</span>
                    </button>
                </form>

                <!-- Help Text -->
                <div style="text-align: center; margin-top: 30px; color: #6b7280;">
                    <p><strong>Need help?</strong> Contact us at <a href="mailto:{{ config('mail.from.address') }}"
                            style="color: #3b82f6;">{{ config('mail.from.address') }}</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const receiptInput = document.getElementById('receiptInput');
            const selectedFileName = document.getElementById('selectedFileName');
            const submitButton = document.getElementById('submitButton');
            const buttonText = document.getElementById('buttonText');
            const maxFileSize = {{ $settings->max_file_size }} * 1024; // KB to bytes

            receiptInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (!file) {
                    selectedFileName.style.display = 'none';
                    submitButton.disabled = true;
                    buttonText.textContent = 'Select a file to continue';
                    return;
                }

                // Validate file size
                if (file.size > maxFileSize) {
                    alert(
                        'File size exceeds the maximum allowed size of {{ number_format($settings->max_file_size / 1024, 1) }}MB. Please upload a smaller file.'
                        );
                    receiptInput.value = '';
                    selectedFileName.style.display = 'none';
                    submitButton.disabled = true;
                    buttonText.textContent = 'Select a file to continue';
                    return;
                }

                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                if (!validTypes.includes(file.type)) {
                    alert('Invalid file type. Please upload a JPG, PNG, or PDF file.');
                    receiptInput.value = '';
                    selectedFileName.style.display = 'none';
                    submitButton.disabled = true;
                    buttonText.textContent = 'Select a file to continue';
                    return;
                }

                // Show selected file name
                selectedFileName.textContent = '✓ Selected: ' + file.name + ' (' + (file.size / 1024 / 1024)
                    .toFixed(2) + ' MB)';
                selectedFileName.style.display = 'block';

                // Enable submit button
                submitButton.disabled = false;
                buttonText.textContent = 'Submit Payment Proof';
            });

            // Form submission
            document.getElementById('receiptForm').addEventListener('submit', function() {
                submitButton.disabled = true;
                buttonText.textContent = 'Uploading...';
            });
        });
    </script>
@endsection
