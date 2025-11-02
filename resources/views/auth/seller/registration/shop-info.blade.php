@extends('auth.seller.registration.layout', ['current_step' => 5])

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .select2-container .select2-selection--multiple {
            box-sizing: border-box !important;
            cursor: pointer;
            display: block;
            height: 48px !important;
            user-select: none !important;
            -webkit-user-select: none;

            /* display: flex !important; */
            align-items: center !important;
        }


        .vendor-registration {
            max-width: 900px;
            margin: 0 auto;
            font-size: 0.95rem;
        }

        .form-section {
            background: white;
            border-radius: 12px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--border-color);
        }

        .section-title {
            color: var(--accent-color);
            margin-bottom: 0.75rem;
            font-size: 1.4rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            font-size: 1.2rem;
        }

        .section-subtitle {
            color: var(--text-secondary);
            margin-bottom: 2rem;
            font-size: 1rem;
            font-weight: 400;
        }

        .product-card {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            background: var(--bg-light);
            transition: all 0.3s ease;
        }

        .product-card:hover {
            border-color: var(--accent-color);
            box-shadow: 0 4px 12px rgba(45, 80, 22, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .card-header h3 {
            margin: 0;
            color: var(--accent-color);
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-remove-product {
            background: #E53E3E;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-remove-product:hover {
            background: #C53030;
            transform: translateY(-1px);
        }

        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(45, 80, 22, 0.1);
        }

        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.5rem;
            min-height: 48px;
            font-size: 0.95rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered,
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding-left: 0;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: var(--accent-color);
            border: none;
            border-radius: 6px;
            color: white;
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        }

        .radio-group,
        .checkbox-group {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .radio-label,
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-weight: 400;
            color: var(--text-primary);
        }

        .radio-label input[type="radio"],
        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
        }

        .char-count {
            text-align: right;
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
            font-weight: 400;
        }

        .image-upload-container,
        .logo-upload-container,
        .promo-upload-container {
            margin-top: 0.75rem;
        }

        .upload-boxes {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .upload-box,
        .logo-upload-box,
        .promo-upload-box {
            border: 2px dashed var(--border-color);
            border-radius: 10px;
            padding: 2rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            background: white;
        }

        .upload-box:hover,
        .logo-upload-box:hover,
        .promo-upload-box:hover {
            border-color: var(--accent-color);
            background: rgba(45, 80, 22, 0.02);
            transform: translateY(-2px);
        }

        .upload-icon {
            font-size: 2rem;
            color: var(--accent-color);
            display: block;
            margin-bottom: 0.75rem;
        }

        .upload-box span,
        .logo-upload-box span,
        .promo-upload-box span {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-hint {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            font-weight: 400;
        }

        .social-links {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .social-input-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .social-icon {
            font-size: 1.25rem;
            min-width: 40px;
            color: var(--accent-color);
            text-align: center;
        }

        .policy-card {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            background: var(--bg-light);
        }

        .policy-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .policy-header h4 {
            margin: 0;
            color: var(--accent-color);
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-toggle-policy {
            background: white;
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-toggle-policy:hover {
            background: var(--accent-color);
            color: white;
            transform: translateY(-1px);
        }

        .policy-content {
            margin-bottom: 1.5rem;
            max-height: 300px;
            overflow-y: auto;
            line-height: 1.6;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .add-product-section {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .btn-outline {
            background: white;
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
            padding: 0.875rem 2rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-outline:hover {
            background: var(--accent-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 80, 22, 0.2);
        }

        .submit-section {
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.875rem 2.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            color: white;
        }

        .btn-primary {
            background: var(--accent-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--accent-light);
            color: white;
        }

        /* Select2 custom styling */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: var(--text-secondary);
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(45, 80, 22, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-section {
                padding: 1.5rem;
            }

            .upload-boxes {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .radio-group,
            .checkbox-group {
                flex-direction: column;
                gap: 0.75rem;
            }

            .policy-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .card-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }

        /* File upload preview states */
        .file-uploaded {
            border-color: var(--accent-color);
            background: rgba(45, 80, 22, 0.05);
        }

        .file-uploaded .upload-icon {
            color: var(--accent-light);
        }
    </style>
@endsection

@section('registration-content')
    <form id="shop-info-form" method="POST" action="{{ route('vendor.registration.shop-info.store') }}"
        enctype="multipart/form-data" class="vendor-registration">
        @csrf
        <!-- Step 2: Product Submission -->

        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-box-open"></i>
                Product Submission
            </h2>
            <p class="section-subtitle">Add your products below. You can add multiple products.</p>

            <div id="product-cards-container">
                <!-- Product cards will be dynamically added here -->
                <div class="product-card" data-product-index="0">
                    <div class="card-header">
                        <h3><i class="fas fa-cube"></i>Product #1</h3>
                        <button type="button" class="btn-remove-product" style="display: none;">
                            <i class="fas fa-trash"></i>Remove Product
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_name_0"><i class="fas fa-tag"></i> Product Name </label>
                                    <input type="text" id="product_name_0" name="products[0][name]" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_category_0"><i class="fas fa-list"></i> Product Category </label>
                                    <select id="product_category_0" name="products[0][category]"
                                        class="form-control select2" required>
                                        <option value="">Select Category</option>
                                        <option value="fashion">Fashion</option>
                                        <option value="decor">Décor</option>
                                        <option value="wellness">Wellness</option>
                                        <option value="food">Food</option>
                                        <option value="jewelry">Jewelry</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="short_description_0"><i class="fas fa-align-left"></i> Short Description 
                                <small>(100 words max)</small></label>
                            <textarea id="short_description_0" name="products[0][short_description]" class="form-control" rows="3"
                                maxlength="500" required placeholder="Brief description of your product..."></textarea>
                            <div class="char-count"><span>0</span>/500 characters</div>
                        </div>

                        <div class="form-group">
                            <label for="detailed_description_0"><i class="fas fa-file-alt"></i> Detailed Description 
                                <small>(300 words max)</small></label>
                            <textarea id="detailed_description_0" name="products[0][detailed_description]" class="form-control" rows="4"
                                maxlength="1500" required placeholder="Detailed description including features, benefits, and specifications..."></textarea>
                            <div class="char-count"><span>0</span>/1500 characters</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price_0"><i class="fas fa-dollar-sign"></i> Price (USD) </label>
                                    <input type="number" id="price_0" name="products[0][price]" class="form-control"
                                        min="0" step="0.01" required placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity_0"><i class="fas fa-cubes"></i> Quantity Available </label>
                                    <input type="number" id="quantity_0" name="products[0][quantity]" class="form-control"
                                        min="0" required placeholder="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-leaf"></i> Ethically Sourced / Handmade </label>
                                    <div class="radio-group">
                                        <label class="radio-label">
                                            <input type="radio" name="products[0][ethical]" value="1" required> Yes
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="products[0][ethical]" value="0" required> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-shield-alt"></i> Complies with U.S. Import & Safety Regulations
                                        </label>
                                    <div class="radio-group">
                                        <label class="radio-label">
                                            <input type="radio" name="products[0][compliance]" value="1" required>
                                            Yes
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="products[0][compliance]" value="0" required>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="certifications_0"><i class="fas fa-award"></i> Certifications / Quality Standards
                                (Optional)</label>
                            <input type="text" id="certifications_0" name="products[0][certifications]"
                                class="form-control" placeholder="e.g., Organic, Fair Trade, ISO Certified">
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-images"></i> Product Images  <small>(Minimum 3 images
                                    required)</small></label>
                            <div class="image-upload-container">
                                <div class="upload-boxes">
                                    <div class="upload-box" data-index="1">
                                        <i class="upload-icon fas fa-cloud-upload-alt"></i>
                                        <span>Image 1</span>
                                        <input type="file" name="products[0][images][]" accept="image/*"
                                            class="file-input" required>
                                    </div>
                                    <div class="upload-box" data-index="2">
                                        <i class="upload-icon fas fa-cloud-upload-alt"></i>
                                        <span>Image 2</span>
                                        <input type="file" name="products[0][images][]" accept="image/*"
                                            class="file-input" required>
                                    </div>
                                    <div class="upload-box" data-index="3">
                                        <i class="upload-icon fas fa-cloud-upload-alt"></i>
                                        <span>Image 3</span>
                                        <input type="file" name="products[0][images][]" accept="image/*"
                                            class="file-input" required>
                                    </div>
                                </div>
                                <p class="upload-hint">Drag & drop images or click to browse. Supported formats: JPG, PNG,
                                    Max size: 5MB per image</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="add-product-section">
                <button type="button" id="add-product-btn" class="btn btn-outline">
                    <i class="fas fa-plus-circle"></i> Add Another Product
                </button>
            </div>
        </div>

        <!-- Step 3: Shipping & Packaging -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-shipping-fast"></i>
                Shipping & Packaging
            </h2>

            <div class="shipping-section">
                <div class="form-group">
                    <label for="packaging_method"><i class="fas fa-box"></i> Packaging Method </label>
                    <textarea id="packaging_method" name="shipping[packaging_method]" class="form-control" rows="3" required
                        placeholder="Describe how you package your products for shipping (materials used, protective measures, etc.)"></textarea>
                </div>

                <div class="form-group">
                    <label for="shipping_methods"><i class="fas fa-truck"></i> Shipping Method(s) </label>
                    <select id="shipping_methods" name="shipping[methods][]" class="form-control select2-multiple"
                        multiple required>
                        <option value="air_freight">Air Freight</option>
                        <option value="sea_freight">Sea Freight</option>
                        <option value="courier">Courier (DHL, FedEx, etc.)</option>
                        <option value="postal">Postal Service</option>
                        <option value="other">Other</option>
                    </select>
                    <small class="form-text text-muted">Select all that apply</small>
                </div>

                <div class="form-group">
                    <label for="delivery_time"><i class="fas fa-clock"></i> Estimated Delivery Time to the U.S. </label>
                    <input type="text" id="delivery_time" name="shipping[delivery_time]" class="form-control"
                        required placeholder="e.g., 10-15 business days">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-map-marker-alt"></i> Shipment Tracking Available? </label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="shipping[tracking]" value="1" required> Yes
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="shipping[tracking]" value="0" required> No
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Marketing & Brand Assets -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-bullhorn"></i>
                Marketing & Brand Assets
            </h2>

            <div class="marketing-section">
                <div class="form-group">
                    <label for="brand_logo"><i class="fas fa-image"></i> Upload Brand Logo </label>
                    <div class="logo-upload-container">
                        <div class="logo-upload-box">
                            <i class="upload-icon fas fa-camera"></i>
                            <span>Click to upload logo</span>
                            <input type="file" id="brand_logo" name="marketing[logo]" accept="image/*"
                                class="file-input" required>
                        </div>
                        <p class="upload-hint">Recommended: 300x300px, PNG with transparent background. Max size: 2MB</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="promotional_material"><i class="fas fa-file-video"></i> Upload Promotional Material
                        (Optional)</label>
                    <div class="promo-upload-container">
                        <div class="promo-upload-box">
                            <i class="upload-icon fas fa-folder-open"></i>
                            <span>Drag & drop promotional files or click to browse</span>
                            <input type="file" id="promotional_material" name="marketing[promotional_material][]"
                                accept=".pdf,.jpg,.jpeg,.png,.mp4" class="file-input" multiple>
                        </div>
                        <p class="upload-hint">PDF, JPG, PNG, MP4 files accepted. Max file size: 10MB each</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="website_url"><i class="fas fa-globe"></i> Website URL (Optional)</label>
                    <input type="url" id="website_url" name="marketing[website_url]" class="form-control"
                        placeholder="https://yourwebsite.com">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-share-alt"></i> Social Media Links (Optional)</label>
                    <div class="social-links">
                        <div class="social-input-group">
                            <span class="social-icon fab fa-facebook"></span>
                            <input type="url" name="marketing[social_media][facebook]" class="form-control"
                                placeholder="Facebook URL">
                        </div>
                        <div class="social-input-group">
                            <span class="social-icon fab fa-instagram"></span>
                            <input type="url" name="marketing[social_media][instagram]" class="form-control"
                                placeholder="Instagram URL">
                        </div>
                        <div class="social-input-group">
                            <span class="social-icon fab fa-twitter"></span>
                            <input type="url" name="marketing[social_media][twitter]" class="form-control"
                                placeholder="Twitter URL">
                        </div>
                        <div class="social-input-group">
                            <span class="social-icon fab fa-linkedin"></span>
                            <input type="url" name="marketing[social_media][linkedin]" class="form-control"
                                placeholder="LinkedIn URL">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5: Vendor Agreement & Policies -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-file-contract"></i>
                Vendor Agreement & Policies
            </h2>

            <div class="agreement-section">
                {{-- <div class="policy-card">
                    <div class="policy-header">
                        <h4><i class="fas fa-gavel"></i> Royalit Vendor Terms & Conditions</h4>
                        <button type="button" class="btn-toggle-policy">
                            <i class="fas fa-chevron-down"></i>Read Full Terms
                        </button>
                    </div>
                    <section class="policy-content">
                        <h2>Terms & Conditions</h2>
                        <p>
                            Please read our
                            <a href="/terms-and-conditions" target="_blank" rel="noopener noreferrer">
                                Terms and Conditions
                            </a>
                            carefully before using the Royalit platform.
                        </p>
                        <p>
                            This includes the complete vendor agreement, terms of service, privacy policy,
                            and all legal requirements for selling on Royalit.
                        </p>
                    </section>


                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="agreement[terms]" value="1" required>
                            <span>I have read and agree to Royalit Vendor Terms & Conditions *</span>
                        </label>
                    </div>
                </div> --}}

                <div class="form-group">
                    <label><i class="fas fa-headset"></i> Can you handle customer inquiries, returns, complaints? </label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="agreement[customer_support]" value="1" required> Yes, we
                            have dedicated customer support
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="agreement[customer_support]" value="0" required> No, we
                            cannot provide customer support
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-star"></i> Agree to maintain accurate product info and quality standards?
                        </label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="agreement[quality_standards]" value="1" required> Yes, we
                            commit to maintaining accurate information and high quality standards
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="agreement[quality_standards]" value="0" required> No
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 6: Submit -->
        <div class="form-section submit-section">
            <div class="action-buttons">
                <button type="button" id="save-draft-btn" class="btn btn-secondary">
                    <i class="fas fa-save"></i> Save & Continue Later
                </button>
                <button type="submit" id="submit-btn" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Submit for Review
                </button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productCount = 1;

            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select a category",
                allowClear: true,
                width: '100%'
            });

            $('.select2-multiple').select2({
                placeholder: "Select shipping methods",
                allowClear: true,
                width: '100%'
            });

            // Hide remove button if only one product card exists
            if (document.querySelectorAll('.product-card').length === 1) {
                document.querySelector('.btn-remove-product').style.display = 'none';
            }

            // Add product functionality
            document.getElementById('add-product-btn').addEventListener('click', function() {
                productCount++;
                const newProductCard = createProductCard(productCount);
                document.getElementById('product-cards-container').appendChild(newProductCard);

                // Initialize Select2 only for the new card
                $(newProductCard).find('.select2').select2({
                    placeholder: "Select a category",
                    allowClear: true,
                    width: '100%'
                });

                $(newProductCard).find('.select2-multiple').select2({
                    placeholder: "Select shipping methods",
                    allowClear: true,
                    width: '100%'
                });

                // Show remove buttons when there are multiple products
                document.querySelectorAll('.btn-remove-product').forEach(btn => {
                    btn.style.display = 'flex';
                });
            });

            // Remove product functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove-product') || e.target.closest(
                        '.btn-remove-product')) {
                    const btn = e.target.classList.contains('btn-remove-product') ? e.target : e.target
                        .closest('.btn-remove-product');
                    const productCard = btn.closest('.product-card');
                    productCard.remove();

                    // Hide remove button if only one product remains
                    if (document.querySelectorAll('.product-card').length === 1) {
                        document.querySelector('.btn-remove-product').style.display = 'none';
                    }
                }
            });

            // Character count for textareas
            document.addEventListener('input', function(e) {
                if (e.target.tagName === 'TEXTAREA') {
                    const charCount = e.target.nextElementSibling?.querySelector('span');
                    if (charCount) {
                        charCount.textContent = e.target.value.length;
                    }
                }
            });

            // Toggle policy content
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-toggle-policy') || e.target.closest(
                        '.btn-toggle-policy')) {
                    const btn = e.target.classList.contains('btn-toggle-policy') ? e.target : e.target
                        .closest('.btn-toggle-policy');
                    const policyCard = btn.closest('.policy-card');
                    const policyContent = policyCard.querySelector('.policy-content');

                    if (policyContent.style.display === 'none') {
                        policyContent.style.display = 'block';
                        btn.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Terms';
                    } else {
                        policyContent.style.display = 'none';
                        btn.innerHTML = '<i class="fas fa-chevron-down"></i> Read Full Terms';
                    }
                }
            });

            // File upload visual feedback
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('file-input')) {
                    const uploadBox = e.target.closest('.upload-box, .logo-upload-box, .promo-upload-box');
                    if (uploadBox && e.target.files.length > 0) {
                        uploadBox.classList.add('file-uploaded');
                        const text = uploadBox.querySelector('span');

                        if (e.target.files.length === 1) {
                            text.textContent = e.target.files[0].name;
                        } else {
                            text.textContent = `${e.target.files.length} files selected`;
                        }
                    }
                }
            });

            // Drag and drop functionality
            document.addEventListener('dragover', function(e) {
                if (e.target.classList.contains('upload-box') ||
                    e.target.classList.contains('logo-upload-box') ||
                    e.target.classList.contains('promo-upload-box')) {
                    e.preventDefault();
                    e.target.style.borderColor = 'var(--accent-color)';
                    e.target.style.backgroundColor = 'rgba(45, 80, 22, 0.1)';
                }
            });

            document.addEventListener('dragleave', function(e) {
                if (e.target.classList.contains('upload-box') ||
                    e.target.classList.contains('logo-upload-box') ||
                    e.target.classList.contains('promo-upload-box')) {
                    e.target.style.borderColor = '';
                    e.target.style.backgroundColor = '';
                }
            });

            document.addEventListener('drop', function(e) {
                if (e.target.classList.contains('upload-box') ||
                    e.target.classList.contains('logo-upload-box') ||
                    e.target.classList.contains('promo-upload-box')) {
                    e.preventDefault();
                    e.target.style.borderColor = '';
                    e.target.style.backgroundColor = '';
                }
            });

            function createProductCard(index) {
                const card = document.createElement('div');
                card.className = 'product-card';
                card.setAttribute('data-product-index', index);
                card.innerHTML = `
                <div class="card-header">
                    <h3><i class="fas fa-cube"></i> Product #${index}</h3>
                    <button type="button" class="btn-remove-product">
                        <i class="fas fa-trash"></i> Remove Product
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_name_${index}"><i class="fas fa-tag"></i> Product Name </label>
                                <input type="text" id="product_name_${index}" name="products[${index}][name]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_category_${index}"><i class="fas fa-list"></i> Product Category </label>
                                <select id="product_category_${index}" name="products[${index}][category]" class="form-control select2" required>
                                    <option value="">Select Category</option>
                                    <option value="fashion">Fashion</option>
                                    <option value="decor">Décor</option>
                                    <option value="wellness">Wellness</option>
                                    <option value="food">Food</option>
                                    <option value="jewelry">Jewelry</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="short_description_${index}"><i class="fas fa-align-left"></i> Short Description  <small>(100 words max)</small></label>
                        <textarea id="short_description_${index}" name="products[${index}][short_description]" class="form-control" rows="3" maxlength="500" required placeholder="Brief description of your product..."></textarea>
                        <div class="char-count"><span>0</span>/500 characters</div>
                    </div>
                    <div class="form-group">
                        <label for="detailed_description_${index}"><i class="fas fa-file-alt"></i> Detailed Description  <small>(300 words max)</small></label>
                        <textarea id="detailed_description_${index}" name="products[${index}][detailed_description]" class="form-control" rows="4" maxlength="1500" required placeholder="Detailed description including features, benefits, and specifications..."></textarea>
                        <div class="char-count"><span>0</span>/1500 characters</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="price_${index}"><i class="fas fa-dollar-sign"></i> Price (USD) </label>
                                <input type="number" id="price_${index}" name="products[${index}][price]" class="form-control" min="0" step="0.01" required placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="quantity_${index}"><i class="fas fa-cubes"></i> Quantity Available </label>
                                <input type="number" id="quantity_${index}" name="products[${index}][quantity]" class="form-control" min="0" required placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-leaf"></i> Ethically Sourced / Handmade </label>
                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="products[${index}][ethical]" value="1" required> Yes
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="products[${index}][ethical]" value="0" required> No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-shield-alt"></i> Complies with U.S. Import & Safety Regulations </label>
                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="products[${index}][compliance]" value="1" required> Yes
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="products[${index}][compliance]" value="0" required> No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="certifications_${index}"><i class="fas fa-award"></i> Certifications / Quality Standards (Optional)</label>
                        <input type="text" id="certifications_${index}" name="products[${index}][certifications]" class="form-control" placeholder="e.g., Organic, Fair Trade, ISO Certified">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-images"></i> Product Images  <small>(Minimum 3 images required)</small></label>
                        <div class="image-upload-container">
                            <div class="upload-boxes">
                                <div class="upload-box" data-index="1">
                                    <i class="upload-icon fas fa-cloud-upload-alt"></i>
                                    <span>Image 1</span>
                                    <input type="file" name="products[${index}][images][]" accept="image/*" class="file-input" required>
                                </div>
                                <div class="upload-box" data-index="2">
                                    <i class="upload-icon fas fa-cloud-upload-alt"></i>
                                    <span>Image 2</span>
                                    <input type="file" name="products[${index}][images][]" accept="image/*" class="file-input" required>
                                </div>
                                <div class="upload-box" data-index="3">
                                    <i class="upload-icon fas fa-cloud-upload-alt"></i>
                                    <span>Image 3</span>
                                    <input type="file" name="products[${index}][images][]" accept="image/*" class="file-input" required>
                                </div>
                            </div>
                            <p class="upload-hint">Drag & drop images or click to browse. Supported formats: JPG, PNG, Max size: 5MB per image</p>
                        </div>
                    </div>
                </div>
            `;
                return card;
            }

            // Draft and submit handlers
            const draftUrl = '{{ route('vendor.registration.shop-info.draft') }}';
            const csrfToken = '{{ csrf_token() }}';
            const form = document.getElementById('shop-info-form');
            const saveBtn = document.getElementById('save-draft-btn');
            const submitBtn = document.getElementById('submit-btn');

            if (saveBtn) {
                saveBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    saveBtn.disabled = true;
                    const originalHtml = saveBtn.innerHTML;
                    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

                    const formData = new FormData(form);

                    fetch(draftUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData,
                        credentials: 'same-origin'
                    }).then(async res => {
                        let data;
                        try {
                            data = await res.json();
                        } catch (err) {
                            data = null;
                        }
                        if (res.ok && data && data.success) {
                            alert(data.message || 'Draft saved successfully.');
                        } else {
                            const msg = (data && data.message) ? data.message :
                                'Failed to save draft.';
                            alert(msg);
                        }
                    }).catch(err => {
                        console.error(err);
                        alert('Failed to save draft.');
                    }).finally(() => {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = originalHtml;
                    });
                });
            }

            // Prevent multiple submits and show loading state
            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                });
            }

        });
    </script>
@endsection
