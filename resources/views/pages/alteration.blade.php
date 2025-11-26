@extends('layouts.app')
@section('content')
    <x-app.header />

    <div class="container mt-4 mb-5">
        {{-- Hero Section --}}
        <section class="alteration-hero py-5" style="background: var(--accent-color);">
            <div class="container text-center text-white">
                <h1 class="display-4 fw-bold mb-3 text-light">Custom Alteration Services</h1>
                <p class="lead mb-0">Transform your garments with our professional alteration services</p>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="alteration-form-section py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Info Card --}}
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-4 text-center">
                                        <div class="alteration-feature">
                                            <div class="feature-icon mb-3">
                                                <i class="fas fa-cut fa-3x text-primary"></i>
                                            </div>
                                            <h5 class="fw-bold">Expert Tailors</h5>
                                            <p class="text-muted small mb-0">Professional alterations by skilled craftsmen
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="alteration-feature">
                                            <div class="feature-icon mb-3">
                                                <i class="fas fa-clock fa-3x text-success"></i>
                                            </div>
                                            <h5 class="fw-bold">Quick Turnaround</h5>
                                            <p class="text-muted small mb-0">Fast and efficient service delivery</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="alteration-feature">
                                            <div class="feature-icon mb-3">
                                                <i class="fas fa-medal fa-3x text-warning"></i>
                                            </div>
                                            <h5 class="fw-bold">Quality Assured</h5>
                                            <p class="text-muted small mb-0">Guaranteed satisfaction on every piece</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Alteration Request Form --}}
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white border-0 p-4">
                                <h3 class="mb-1 fw-bold">Request Alteration Service</h3>
                                <p class="text-muted mb-0">Fill out the form below and we'll get back to you shortly</p>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('alteration.store') }}" method="POST" enctype="multipart/form-data"
                                    id="alterationForm">
                                    @csrf

                                    <div class="row g-4">
                                        {{-- Name Field --}}
                                        <div class="col-md-6">
                                            <label for="name" class="form-label fw-semibold">
                                                Full Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-user text-muted"></i>
                                                </span>
                                                <input type="text"
                                                    class="form-control border-start-0 @error('name') is-invalid @enderror"
                                                    id="name" name="name" value="{{ old('name') }}"
                                                    placeholder="Enter your full name" required>
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Email Field --}}
                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-semibold">
                                                Email Address <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-envelope text-muted"></i>
                                                </span>
                                                <input type="email"
                                                    class="form-control border-start-0 @error('email') is-invalid @enderror"
                                                    id="email" name="email" value="{{ old('email') }}"
                                                    placeholder="your.email@example.com" required>
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Phone Field --}}
                                        <div class="col-md-6 mt-3">
                                            <label for="phone" class="form-label fw-semibold">
                                                Phone Number <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-phone text-muted"></i>
                                                </span>
                                                <input type="tel"
                                                    class="form-control border-start-0 @error('phone') is-invalid @enderror"
                                                    id="phone" name="phone" value="{{ old('phone') }}"
                                                    placeholder="+1 (555) 123-4567" required>
                                            </div>
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Alteration Type --}}
                                        <div class="col-md-6 mt-3">
                                            <label for="alteration_type" class="form-label fw-semibold">
                                                Alteration Type <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-scissors text-muted"></i>
                                                </span>
                                                <input type="text"
                                                    class="form-control border-start-0 @error('type') is-invalid @enderror"
                                                    id="alteration_type" name="type" value="{{ old('type') }}"
                                                    placeholder="e.g., Hemming, Taking In" required>
                                            </div>
                                            @error('type')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Description --}}
                                        <div class="col-12 mt-3">
                                            <label for="description" class="form-label fw-semibold">
                                                Detailed Description <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                rows="5" placeholder="Please provide detailed information about your alteration request..." required>{{ old('description') }}</textarea>
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Include garment type, material, measurements, and specific alterations
                                                needed
                                            </small>
                                            @error('description')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- File Attachment --}}
                                        <div class="col-12 mt-3">
                                            <label for="attachment" class="form-label fw-semibold">
                                                Upload Images (Optional)
                                            </label>
                                            <div class="file-upload-wrapper">
                                                <input type="file"
                                                    class="form-control h-auto @error('attachment') is-invalid @enderror"
                                                    id="attachment" name="attachment" accept="image/*,application/pdf">
                                                <small class="text-muted d-block mt-2">
                                                    <i class="fas fa-paperclip me-1"></i>
                                                    Upload images of your garment (JPG, PNG, PDF - Max 5MB)
                                                </small>
                                            </div>
                                            @error('attachment')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror

                                            {{-- Image Preview --}}
                                            <div id="imagePreview" class="mt-3 d-none">
                                                <label class="form-label fw-semibold">Preview:</label>
                                                <div class="border rounded p-3 bg-light">
                                                    <img id="previewImage" src="" alt="Preview"
                                                        class="img-fluid rounded" style="max-height: 200px;">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Submit Button --}}
                                        <div class="col-12 mt-4">
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                {{-- <button type="reset" class="btn btn-outline-secondary px-4">
                                                    <i class="fas fa-undo me-2"></i>Reset
                                                </button> --}}
                                                <button type="submit" class="btn btn-primary px-5">
                                                    <i class="fas fa-paper-plane me-2"></i>Submit Request
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Additional Info --}}
                        <div class="card shadow-sm border-0 mt-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Frequently Asked Questions
                                </h5>
                                <div class="accordion" id="faqAccordion">
                                    <div class="accordion-item border-0 mb-2">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#faq1">
                                                How long does the alteration process take?
                                            </button>
                                        </h2>
                                        <div id="faq1" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Most alterations are completed within 3-7 business days. Rush services are
                                                available for urgent requests.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-0 mb-2">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#faq2">
                                                What types of garments can be altered?
                                            </button>
                                        </h2>
                                        <div id="faq2" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                We handle all types of garments including dresses, suits, pants, shirts,
                                                traditional wear, and more.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-0 mb-2">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#faq3">
                                                How will I receive the quote?
                                            </button>
                                        </h2>
                                        <div id="faq3" class="accordion-collapse collapse"
                                            data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                After reviewing your request, we'll send you a detailed quote via email
                                                within
                                                24 hours.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Custom Styles --}}
    <style>
        .alteration-hero {
            position: relative;
            overflow: hidden;
        }

        .alteration-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom center;
            background-size: cover;
            opacity: 0.5;
        }

        .alteration-form-section {
            background: #f8f9fa;
        }

        .card {
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .alteration-feature {
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .alteration-feature:hover {
            transform: scale(1.05);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            border-radius: 50%;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .alteration-feature:hover .feature-icon {
            background: var(--accent-color);
        }

        .alteration-feature:hover .feature-icon i {
            color: white !important;
        }

        .form-label {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            border: 1px solid #ced4da;
        }

        .form-control,
        .form-select {
            border: 1px solid #ced4da;
            padding: 0.625rem 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: none !important;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--accent-color);
            background-color: #fff;
        }

        .btn-primary {
            background: var(--accent-color);
            border-color: var(--accent-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            border-width: 2px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            transform: translateY(-2px);
        }

        .file-upload-wrapper {
            position: relative;
        }

        .file-upload-wrapper input[type="file"] {
            cursor: pointer;
        }

        .accordion-button {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: 600;
            border: none;
            padding: 1rem 1.25rem;
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--accent-color);
            color: white;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: transparent;
        }

        .accordion-item {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .accordion-body {
            padding: 1.25rem;
            background-color: white;
        }

        @media (max-width: 767.98px) {
            .alteration-hero h1 {
                font-size: 2rem;
            }

            .alteration-hero p {
                font-size: 1rem;
            }

            .card-body {
                padding: 1.5rem !important;
            }

            .feature-icon {
                width: 60px;
                height: 60px;
            }

            .feature-icon i {
                font-size: 2rem !important;
            }
        }

        /* Animation for form submission */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .btn-primary:active {
            animation: pulse 0.3s ease;
        }
    </style>

    {{-- JavaScript for Image Preview --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const attachmentInput = document.getElementById('attachment');
            const imagePreview = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');

            attachmentInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                    };

                    reader.readAsDataURL(file);
                } else {
                    imagePreview.classList.add('d-none');
                }
            });

            // Form validation
            const form = document.getElementById('alterationForm');
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    </script>
@endsection
