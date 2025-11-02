@extends('layouts.app')

@section('title', 'Become a Vendor on Royalit | Vendor Registration')
@section('meta_description',
    'Join Royalit as a vendor and submit your company and products to reach customers
    worldwide. Complete vendor registration and product submission form.')
@section('meta_keywords', 'vendor registration, become vendor, Royalit vendor, product submission, seller application')

@section('css')
    <style>
        /* Import centralized color system */
        @import url('{{ asset('assets/css/colors.css') }}');

        .form-section {
            background: var(--bg-secondary);
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            margin-bottom: 2rem;
            overflow: hidden;
            border: 1px solid var(--border-light);
        }

        .form-section-header {
            background: var(--bg-light);
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .form-section-header h3 {
            margin: 0;
            color: var(--text-primary);
            font-weight: 600;
        }

        .form-section-header .step-number {
            background: var(--accent-color);
            color: var(--text-light);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .form-section-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 2px solid var(--border-light);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--bg-secondary);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(222, 153, 27, 0.25);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: var(--error-color);
        }

        .invalid-feedback {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-text {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .radio-group {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input {
            /* width: 100px;
                        height: 100px; */
            border: 2px solid var(--border-medium);
        }

        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .file-upload-area {
            border: 2px dashed var(--border-medium);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            background: var(--bg-light);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: var(--accent-color);
            background: var(--cosmic-latte);
        }

        .file-upload-area.dragover {
            border-color: var(--accent-color);
            background: var(--cosmic-latte);
        }

        .product-card {
            background: var(--bg-light);
            border: 1px solid var(--border-light);
            border-radius: 8px;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .product-card-header {
            background: var(--bg-secondary);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .product-card-header h5 {
            margin: 0;
            color: var(--text-primary);
        }

        .product-card-body {
            padding: 1.5rem;
            display: none;
        }

        .product-card-body.show {
            display: block;
        }

        /* .btn-primary {
                            background: var(--accent-color);
                            border: none;
                            color: var(--text-light);
                            padding: 0.75rem 2rem;
                            border-radius: 8px;
                            font-weight: 600;
                            transition: all 0.3s ease;
                        }

                        .btn-primary:hover {
                            background: var(--btn-secondary-hover);
                            transform: translateY(-2px);
                            box-shadow: var(--shadow-medium);
                        } */

        .btn-secondary {
            background: transparent;
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* .btn-secondary:hover {
                        background: var(--accent-color);
                        color: var(--text-light);
                    } */

        .btn-outline-danger {
            border: 2px solid var(--error-color);
            color: var(--error-color);
            background: transparent;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .btn-outline-danger:hover {
            background: var(--error-color);
            border: 2px solid var(--error-color);
            color: var(--text-light);
        }

        .add-product-btn {
            background: var(--bg-light);
            border: 2px dashed var(--border-medium);
            color: var(--text-primary);
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .add-product-btn:hover {
            border-color: var(--accent-color);
            background: var(--cosmic-latte);
        }

        .policy-section {
            background: var(--bg-light);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .policy-text {
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 1rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: 6px;
            border: 1px solid var(--border-light);
        }

        .submit-section {
            background: var(--gradient-light);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            margin-top: 2rem;
        }

        .progress-bar {
            background: var(--bg-light);
            border-radius: 10px;
            height: 8px;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .progress-fill {
            background: var(--gradient-accent);
            height: 100%;
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .required {
            color: var(--error-color);
        }

        .tooltip-icon {
            color: var(--text-muted);
            cursor: help;
            margin-left: 0.25rem;
        }

        @media (max-width: 768px) {

            .form-section-body {
                padding: 1rem;
            }

            .radio-group {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        .accordion-collapse {
            transition: height 0.5s ease, opacity 0.3s ease;
        }

        .accordion-collapse.collapsing {
            opacity: 0;
        }

        .accordion-collapse.collapse.show {
            opacity: 1;
        }
    </style>
@endsection

@section('content')
    @php
        $categories = \App\Models\Prodcat::all();
    @endphp
    <x-app.header />

    <!-- Hero Section -->
    <div class="container mt-4">
        <div class="checkout-hero mb-4 position-relative">
            <h2 class="fw-bold mb-1 text-light">Become a Vendor on Royalit</h2>
            <p class="mb-0">Submit your company and products to reach customers worldwide</p>

            <div class="checkout-hero-steps d-none d-md-flex position-absolute end-0 top-0 h-100 align-items-center pe-4">
                <a href="{{ route('homepage') }}"><span class="badge bg-light text-primary me-2">Home</span></a>
                <span class="badge bg-light text-primary me-2">Vendor Registration</span>
            </div>
        </div>
    </div>

    <main class="container my-5">
        <!-- Progress Bar -->
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill" style="width: 16.67%"></div>
        </div>

        <form id="vendorRegistrationForm" method="POST" action="{{ route('vendor.registration.store') }}"
            enctype="multipart/form-data">
            @csrf

            <!-- Step 1: Company Information -->
            <div class="form-section" id="step1">
                <div class="form-section-header">
                    <div class="step-number">1</div>
                    <h3>Company Information</h3>
                </div>
                <div class="form-section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_name" class="form-label">Company/Brand Name <span
                                        class="required">*</span></label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                    id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country" class="form-label">Country of Operation <span
                                        class="required">*</span></label>
                                <select class="form-control @error('country') is-invalid @enderror" id="country"
                                    name="country" required style="border: 2px solid rgb(0 0 0 / 5%) !important;">
                                    <option value="">Select Country</option>
                                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States
                                    </option>
                                    <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>United Kingdom
                                    </option>
                                    <option value="DE" {{ old('country') == 'DE' ? 'selected' : '' }}>Germany</option>
                                    <option value="FR" {{ old('country') == 'FR' ? 'selected' : '' }}>France</option>
                                    <option value="IT" {{ old('country') == 'IT' ? 'selected' : '' }}>Italy</option>
                                    <option value="ES" {{ old('country') == 'ES' ? 'selected' : '' }}>Spain</option>
                                    <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia
                                    </option>
                                    <option value="JP" {{ old('country') == 'JP' ? 'selected' : '' }}>Japan</option>
                                    <option value="CN" {{ old('country') == 'CN' ? 'selected' : '' }}>China</option>
                                    <option value="IN" {{ old('country') == 'IN' ? 'selected' : '' }}>India</option>
                                    <option value="BR" {{ old('country') == 'BR' ? 'selected' : '' }}>Brazil</option>
                                    <option value="MX" {{ old('country') == 'MX' ? 'selected' : '' }}>Mexico</option>
                                    <option value="ZA" {{ old('country') == 'ZA' ? 'selected' : '' }}>South Africa
                                    </option>
                                    <option value="NG" {{ old('country') == 'NG' ? 'selected' : '' }}>Nigeria</option>
                                    <option value="KE" {{ old('country') == 'KE' ? 'selected' : '' }}>Kenya</option>
                                    <option value="GH" {{ old('country') == 'GH' ? 'selected' : '' }}>Ghana</option>
                                    <option value="EG" {{ old('country') == 'EG' ? 'selected' : '' }}>Egypt</option>
                                    <option value="MA" {{ old('country') == 'MA' ? 'selected' : '' }}>Morocco</option>
                                    <option value="other" {{ old('country') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="short_description" class="form-label">Short Description <span
                                class="required">*</span></label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                            name="short_description" rows="4" maxlength="200" required>{{ old('short_description') }}</textarea>
                        <div class="form-text">Maximum 200 words</div>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Legally Registered Business? <span class="required">*</span></label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" class="form-check-input" id="registered_yes" name="legally_registered"
                                    value="yes" {{ old('legally_registered') == 'yes' ? 'checked' : '' }} required>
                                <label class="form-check-label mb-0" for="registered_yes">Yes</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" class="form-check-input" id="registered_no" name="legally_registered"
                                    value="no" {{ old('legally_registered') == 'no' ? 'checked' : '' }}>
                                <label class="form-check-label mb-0" for="registered_no">No</label>
                            </div>
                        </div>
                        @error('legally_registered')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="business_registration" class="form-label">Upload Business Registration / License <span
                                class="required">*</span></label>
                        <div class="file-upload-area" onclick="document.getElementById('business_registration').click()">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <p class="mb-2">Click to upload or drag and drop</p>
                            <p class="text-muted small">PDF, JPG, PNG (Max 10MB)</p>
                        </div>
                        <input type="file" class="d-none @error('business_registration') is-invalid @enderror"
                            id="business_registration" name="business_registration" accept=".pdf,.jpg,.jpeg,.png"
                            required>
                        @error('business_registration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tax_id" class="form-label">Tax Identification Number</label>
                                <input type="text" class="form-control @error('tax_id') is-invalid @enderror"
                                    id="tax_id" name="tax_id" value="{{ old('tax_id') }}">
                                <div class="form-text">Optional</div>
                                @error('tax_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_person" class="form-label">Contact Person Name <span
                                        class="required">*</span></label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                    id="contact_person" name="contact_person" value="{{ old('contact_person') }}"
                                    required>
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact_email" class="form-label">Contact Email <span
                                class="required">*</span></label>
                        <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                            id="contact_email" name="contact_email" value="{{ old('contact_email') }}" required>
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Step 2: Product Submission -->
            <div class="form-section" id="step2">
                <div class="form-section-header">
                    <div class="step-number">2</div>
                    <h3>Product Submission</h3>
                </div>
                <div class="form-section-body">
                    <div id="products-container">
                        <!-- Product cards will be added here dynamically -->
                    </div>

                    <div class="add-product-btn" onclick="addProduct()">
                        <i class="fas fa-plus-circle fa-2x text-muted mb-2"></i>
                        <p class="mb-0">Add Another Product</p>
                    </div>
                </div>
            </div>

            <!-- Step 3: Shipping & Packaging -->
            <div class="form-section" id="step3">
                <div class="form-section-header">
                    <div class="step-number">3</div>
                    <h3>Shipping & Packaging</h3>
                </div>
                <div class="form-section-body">
                    <div class="form-group">
                        <label for="packaging_method" class="form-label">Packaging Method <span
                                class="required">*</span></label>
                        <textarea class="form-control @error('packaging_method') is-invalid @enderror" id="packaging_method"
                            name="packaging_method" rows="4" required>{{ old('packaging_method') }}</textarea>
                        <div class="form-text">Describe how you package your products for shipping</div>
                        @error('packaging_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="shipping_methods" class="form-label">Shipping Method(s) <span
                                class="required">*</span></label>
                        <input type="text" class="form-control @error('shipping_methods') is-invalid @enderror"
                            id="shipping_methods" name="shipping_methods" value="{{ old('shipping_methods') }}"
                            placeholder="e.g., DHL, FedEx, USPS, Local courier" required>
                        @error('shipping_methods')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="delivery_time" class="form-label">Estimated Delivery Time to the U.S. <span
                                        class="required">*</span></label>
                                <input type="text" class="form-control @error('delivery_time') is-invalid @enderror"
                                    id="delivery_time" name="delivery_time" value="{{ old('delivery_time') }}"
                                    placeholder="e.g., 7-14 business days" required>
                                @error('delivery_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Shipment Tracking Available? <span
                                        class="required">*</span></label>
                                <div class="radio-group mt-4">
                                    <div class="radio-item">
                                        <input type="radio" class="form-check-input" id="tracking_yes"
                                            name="tracking_available" value="yes"
                                            {{ old('tracking_available') == 'yes' ? 'checked' : '' }} required>
                                        <label for="tracking_yes" class="form-check-label mb-0">Yes</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" class="form-check-input" id="tracking_no"
                                            name="tracking_available" value="no"
                                            {{ old('tracking_available') == 'no' ? 'checked' : '' }}>
                                        <label for="tracking_no" class="form-check-label mb-0">No</label>
                                    </div>
                                </div>
                                @error('tracking_available')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Marketing & Brand Assets -->
            <div class="form-section" id="step4">
                <div class="form-section-header">
                    <div class="step-number">4</div>
                    <h3>Marketing & Brand Assets</h3>
                </div>
                <div class="form-section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="brand_logo" class="form-label">Upload Brand Logo <span
                                        class="required">*</span></label>
                                <div class="file-upload-area" onclick="document.getElementById('brand_logo').click()">
                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                    <p class="mb-2">Click to upload logo</p>
                                    <p class="text-muted small">JPG, PNG (Max 5MB)</p>
                                </div>
                                <input type="file" class="d-none @error('brand_logo') is-invalid @enderror"
                                    id="brand_logo" name="brand_logo" accept=".jpg,.jpeg,.png" required>
                                @error('brand_logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="promotional_material" class="form-label">Upload Promotional Material</label>
                                <div class="file-upload-area"
                                    onclick="document.getElementById('promotional_material').click()">
                                    <i class="fas fa-file-image fa-3x text-muted mb-3"></i>
                                    <p class="mb-2">Click to upload</p>
                                    <p class="text-muted small">JPG, PNG, PDF (Max 10MB)</p>
                                </div>
                                <input type="file" class="d-none @error('promotional_material') is-invalid @enderror"
                                    id="promotional_material" name="promotional_material" accept=".jpg,.jpeg,.png,.pdf">
                                <div class="form-text">Optional</div>
                                @error('promotional_material')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="website_url" class="form-label">Website URL</label>
                        <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                            id="website_url" name="website_url" value="{{ old('website_url') }}"
                            placeholder="https://your-website.com">
                        <div class="form-text">Optional</div>
                        @error('website_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="social_media_links" class="form-label">Social Media Links</label>
                        <textarea class="form-control @error('social_media_links') is-invalid @enderror" id="social_media_links"
                            name="social_media_links" rows="3"
                            placeholder="Facebook: https://facebook.com/yourpage&#10;Instagram: https://instagram.com/yourpage&#10;Twitter: https://twitter.com/yourpage">{{ old('social_media_links') }}</textarea>
                        <div class="form-text">Optional - List your social media profiles</div>
                        @error('social_media_links')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Step 5: Vendor Agreement & Policies -->
            <div class="form-section" id="step5">
                <div class="form-section-header mb-4">
                    <div class="step-number">5</div>
                    <h3 class="fw-bold">Vendor Agreement & Policies</h3>
                </div>

                <div class="accordion accordion-flush" id="vendorPolicyAccordion">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed fw-semibold" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                                aria-controls="collapseOne">
                                1. Vendor Responsibilities
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#vendorPolicyAccordion">
                            <div class="accordion-body">
                                <ul class="mb-0">
                                    <li>Maintain accurate product information and quality standards</li>
                                    <li>Handle customer inquiries, returns, and complaints promptly</li>
                                    <li>Comply with all applicable laws and regulations</li>
                                    <li>Ensure products meet U.S. import and safety requirements</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed fw-semibold" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">
                                2. Product Standards
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#vendorPolicyAccordion">
                            <div class="accordion-body">
                                <ul class="mb-0">
                                    <li>All products must be ethically sourced and/or handmade</li>
                                    <li>Products must comply with U.S. import regulations</li>
                                    <li>Accurate product descriptions and images required</li>
                                    <li>Quality certifications must be provided when available</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed fw-semibold" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                                3. Shipping & Fulfillment
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#vendorPolicyAccordion">
                            <div class="accordion-body">
                                <ul class="mb-0">
                                    <li>Provide accurate shipping estimates</li>
                                    <li>Offer tracking when available</li>
                                    <li>Handle returns and exchanges according to policy</li>
                                    <li>Maintain adequate inventory levels</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed fw-semibold" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                                aria-controls="collapseFour">
                                4. Payment & Fees
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#vendorPolicyAccordion">
                            <div class="accordion-body">
                                <ul class="mb-0">
                                    <li>Commission rates as agreed in vendor agreement</li>
                                    <li>Payment processing fees may apply</li>
                                    <li>Monthly payouts for approved vendors</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed fw-semibold" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false"
                                aria-controls="collapseFive">
                                5. Compliance
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                            data-bs-parent="#vendorPolicyAccordion">
                            <div class="accordion-body">
                                <ul class="mb-0">
                                    <li>Must maintain business registration and licenses</li>
                                    <li>Tax compliance in all applicable jurisdictions</li>
                                    <li>Regular quality audits may be conducted</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <div class="form-check d-flex align-items-center justify-content-start">
                    <input type="checkbox" class="form-check-input @error('terms_agreement') is-invalid @enderror"
                        id="terms_agreement" name="terms_agreement" required>
                    <label class="form-check-label mb-0 ms-2" for="terms_agreement">
                        I agree to Royalit Vendor Terms & Conditions <span class="required">*</span>
                    </label>
                </div>
                @error('terms_agreement')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Can you handle customer inquiries, returns, complaints? <span
                        class="required">*</span></label>
                <div class="radio-group">
                    <div class="radio-item">
                        <input type="radio" class="form-check-input" id="customer_service_yes" name="customer_service"
                            value="yes" {{ old('customer_service') == 'yes' ? 'checked' : '' }} required>
                        <label for="customer_service_yes" class="form-check-label mb-0">Yes</label>
                    </div>
                    <div class="radio-item">
                        <input type="radio" class="form-check-input" id="customer_service_no" name="customer_service"
                            value="no" {{ old('customer_service') == 'no' ? 'checked' : '' }}>
                        <label for="customer_service_no" class="form-check-label mb-0">No</label>
                    </div>
                </div>
                @error('customer_service')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Agree to maintain accurate product info and quality standards? <span
                        class="required">*</span></label>
                <div class="radio-group">
                    <div class="radio-item">
                        <input type="radio" class="form-check-input" id="quality_standards_yes"
                            name="quality_standards" value="yes"
                            {{ old('quality_standards') == 'yes' ? 'checked' : '' }} required>
                        <label for="quality_standards_yes" class="form-check-label mb-0">Yes</label>
                    </div>
                    <div class="radio-item">
                        <input type="radio" class="form-check-input" id="quality_standards_no"
                            name="quality_standards" value="no"
                            {{ old('quality_standards') == 'no' ? 'checked' : '' }}>
                        <label for="quality_standards_no" class="form-check-label mb-0">No</label>
                    </div>
                </div>
                @error('quality_standards')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            </div>
            </div>

            <!-- Step 6: Submit -->
            <div class="submit-section">
                <h4 class="mb-4">Ready to Submit Your Application?</h4>
                <p class="text-muted mb-4">Review all information before submitting. You can save and continue later if
                    needed.</p>

                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>Submit for Review
                    </button>
                    <button type="button" class="btn btn-secondary btn-lg" onclick="saveDraft()">
                        <i class="fas fa-save me-2"></i>Save & Continue Later
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script>
        let productCount = 0;

        // Add first product on page load
        document.addEventListener('DOMContentLoaded', function() {
            addProduct();
            updateProgress();
        });

        function addProduct() {
            productCount++;
            const container = document.getElementById('products-container');
            const productCard = createProductCard(productCount);
            container.appendChild(productCard);
            updateProgress();
        }

        function createProductCard(index) {
            const card = document.createElement('div');
            card.className = 'product-card';
            card.innerHTML = `
        <div class="product-card-header" onclick="toggleProductCard(${index})">
            <h5>Product ${index}</h5>
            <i class="fas fa-chevron-down ms-auto"></i>
        </div>
        <div class="product-card-body" id="product-${index}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_name_${index}" class="form-label">Product Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="product_name_${index}" name="products[${index}][name]" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_category_${index}" class="form-label">Product Category <span class="required">*</span></label>
                        <select class="form-control" id="product_category_${index}" name="products[${index}][category]" required>  
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="product_short_desc_${index}" class="form-label">Short Description <span class="required">*</span></label>
                <textarea class="form-control" id="product_short_desc_${index}" name="products[${index}][short_description]" rows="3" maxlength="100" required></textarea>
                <div class="form-text">Maximum 100 words</div>
            </div>

            <div class="form-group">
                <label for="product_detailed_desc_${index}" class="form-label">Detailed Description <span class="required">*</span></label>
                <textarea class="form-control" id="product_detailed_desc_${index}" name="products[${index}][detailed_description]" rows="4" maxlength="300" required></textarea>
                <div class="form-text">Maximum 300 words</div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="product_price_${index}" class="form-label">Price (USD) <span class="required">*</span></label>
                        <input type="number" class="form-control" id="product_price_${index}" name="products[${index}][price]" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="product_quantity_${index}" class="form-label">Quantity Available <span class="required">*</span></label>
                        <input type="number" class="form-control" id="product_quantity_${index}" name="products[${index}][quantity]" min="0" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Ethically Sourced / Handmade <span class="required">*</span></label>
                        <div class="radio-group mt-4">
                            <div class="radio-item">
                                <input type="radio" class="form-check-input" id="ethical_yes_${index}" name="products[${index}][ethical]" value="yes" required>
                                <label class="form-check-label mb-0" for="ethical_yes_${index}">Yes</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" class="form-check-input" id="ethical_no_${index}" name="products[${index}][ethical]" value="no">
                                <label class="form-check-label mb-0" for="ethical_no_${index}">No</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="product_images_${index}" class="form-label">Product Images <span class="required">*</span></label>
                <div class="file-upload-area" onclick="document.getElementById('product_images_${index}').click()">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <p class="mb-2">Click to upload images</p>
                    <p class="text-muted small">Minimum 3 images - JPG, PNG (Max 5MB each)</p>
                </div>
                <input type="file" class="d-none" id="product_images_${index}" name="products[${index}][images][]" accept=".jpg,.jpeg,.png" multiple required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_certifications_${index}" class="form-label">Certifications / Quality Standards</label>
                        <input type="text" class="form-control" id="product_certifications_${index}" name="products[${index}][certifications]" placeholder="e.g., Fair Trade, Organic, ISO 9001">
                        <div class="form-text">Optional</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Complies with U.S. Import & Safety Regulations <span class="required">*</span></label>
                        <div class="radio-group mt-4">
                            <div class="radio-item">
                                <input type="radio" class="form-check-input" id="compliance_yes_${index}" name="products[${index}][compliance]" value="yes" required>
                                <label class="form-check-label mb-0" for="compliance_yes_${index}">Yes</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" class="form-check-input" id="compliance_no_${index}" name="products[${index}][compliance]" value="no">
                                <label class="form-check-label mb-0" for="compliance_no_${index}">No</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="button" class="btn btn-outline-danger" onclick="removeProduct(${index})">
                    <i class="fas fa-trash me-1"></i>Remove Product
                </button>
            </div>
        </div>
    `;
            return card;
        }

        function toggleProductCard(index) {
            const body = document.getElementById(`product-${index}`);
            const icon = body.previousElementSibling.querySelector('i');

            if (body.classList.contains('show')) {
                body.classList.remove('show');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                body.classList.add('show');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        }

        function removeProduct(index) {
            if (productCount > 1) {
                const card = document.querySelector(`#product-${index}`).closest('.product-card');
                card.remove();
                productCount--;
                updateProgress();
            } else {
                alert('At least one product is required.');
            }
        }

        function updateProgress() {
            const progressFill = document.getElementById('progressFill');
            const progress = (productCount / 6) * 100; // 6 is the maximum expected products
            progressFill.style.width = Math.min(progress, 100) + '%';
        }

        function toggleFullTerms() {
            // This would typically open a modal or redirect to full terms page
            alert('Full terms and conditions would be displayed here or in a separate page.');
        }

        function saveDraft() {
            // This would save the form data as a draft
            alert('Draft saved! You can continue later.');
        }

        // File upload drag and drop functionality
        document.addEventListener('DOMContentLoaded', function() {
            const fileUploadAreas = document.querySelectorAll('.file-upload-area');

            fileUploadAreas.forEach(area => {
                area.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('dragover');
                });

                area.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                });

                area.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        const input = this.parentElement.querySelector('input[type="file"]');
                        input.files = files;
                    }
                });
            });
        });

        // Form validation
        document.getElementById('vendorRegistrationForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    </script>
@endsection
