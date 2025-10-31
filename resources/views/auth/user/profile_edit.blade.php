@extends('layouts.user_dashboard')

@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <!-- Header Section -->
        <div class="profile-header-section mb-4">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="page-title text-light" style="color: #ffffff">
                        <i class="fas fa-user-edit me-2"></i>
                        Edit Profile
                    </h1>
                    <p class="page-subtitle">Update your personal information and profile picture</p>
                </div>
                <div class="header-right">
                    <div class="profile-stats">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Member Since</span>
                                <span
                                    class="stat-value">{{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Last Updated</span>
                                <span
                                    class="stat-value">{{ Auth::user()->updated_at ? Auth::user()->updated_at->diffForHumans() : 'Never' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form Section -->
        <div class="profile-form-section">
            <div class="form-container">
                <div class="form-header">
                    <h3 class="form-title">
                        <i class="fas fa-user-cog me-2"></i>
                        Profile Information
                    </h3>
                    <p class="form-subtitle">Keep your profile information up to date</p>
                </div>

                <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data"
                    class="profile-form">
                    @csrf

                    <!-- Avatar Section -->
                    <div class="avatar-section">
                        <div class="avatar-container">
                            <div class="avatar-preview">
                                <img id="avatar-preview"
                                    src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('public/assets/img/account/user.jpg') }}"
                                    alt="Profile Avatar" class="avatar-image">
                                <div class="avatar-overlay">
                                    {{-- <i class="fas fa-camera"></i>
                                    <span>Change Photo</span> --}}
                                </div>
                            </div>
                            <div class="avatar-info">
                                <h5>Profile Picture</h5>
                                <p>Upload a new profile picture to personalize your account</p>
                                <div class="file-input-wrapper">
                                    <input type="file" id="avatar" name="avatar" class="file-input" accept="image/*">
                                    <label for="avatar" class="file-label">
                                        <i class="fas fa-upload me-2"></i>
                                        Choose File
                                    </label>
                                </div>
                                @error('avatar')
                                    <span class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-user me-2"></i>
                            Personal Information
                        </h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">
                                        <i class="fas fa-user me-1"></i>
                                        First Name
                                    </label>
                                    <input id="first_name" type="text" name="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        value="{{ Auth::user()->name }}" placeholder="Enter your first name">
                                    @error('first_name')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="form-label">
                                        <i class="fas fa-user me-1"></i>
                                        Last Name
                                    </label>
                                    <input id="last_name" type="text" name="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        value="{{ Auth::user()->l_name }}" placeholder="Enter your last name">
                                    @error('last_name')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>
                                        Email Address
                                    </label>
                                    <input class="form-control @error('email') is-invalid @enderror" name="email"
                                        id="email" value="{{ Auth::user()->email }}"
                                        placeholder="Enter your email address">
                                    @error('email')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_number" class="form-label">
                                        <i class="fas fa-phone me-1"></i>
                                        Contact Number
                                    </label>
                                    <input class="form-control @error('meta') is-invalid @enderror" name="meta[phone]"
                                        id="contact_number" value="{{ Auth::user()->phone }}"
                                        placeholder="Enter your phone number">
                                    @error('phone')
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-edit-profile border">
                                <i class="fas fa-save me-2"></i>
                                Update Profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Header Section */
        .profile-header-section {
            background: var(--accent-color);
            padding: 2rem;
            border-radius: 20px;
            color: white;
            box-shadow: 0 10px 30px rgba(59, 183, 126, 0.3);
            position: relative;
            overflow: hidden;
        }

        .profile-header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-subtitle {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }

        .profile-stats {
            display: flex;
            gap: 1rem;
        }

        .btn-edit-profile {
            background: rgba(var(--accent-color-rgb), 0.1);
            color: var(--primary-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            font-size: 0.85rem;
        }

        .btn-edit-profile:hover {
            background: var(--primary-color);
            color: white;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem 1.5rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.25);
        }

        .stat-icon {
            font-size: 1.5rem;
            opacity: 0.9;
        }

        .stat-info {
            text-align: center;
        }

        .stat-label {
            display: block;
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .stat-value {
            display: block;
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Form Section */
        .profile-form-section {
            margin-bottom: 2rem;
        }

        .form-container {
            background: white;
            padding: 2rem;
            /* border-radius: 20px; */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        @keyframes gradient-shift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f8f9fa;
        }

        .form-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: #6c757d;
            margin: 0;
        }

        /* Avatar Section */
        .avatar-section {
            margin-bottom: 2rem;
            padding: 2rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            border: 1px solid #dee2e6;
        }

        .avatar-container {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .avatar-preview {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .avatar-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .avatar-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(var(--accent-color-rgb), 0.1) !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .avatar-preview:hover .avatar-overlay {
            opacity: 1;
        }

        .avatar-overlay i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .avatar-overlay span {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .avatar-info {
            flex: 1;
        }

        .avatar-info h5 {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .avatar-info p {
            color: #6c757d;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .file-label {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: rgba(var(--accent-color-rgb), 0.1);
            color: var(--primary-color);
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .file-label:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 15px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: #3bb77e;
            box-shadow: 0 0 0 0.2rem rgba(59, 183, 126, 0.25);
            outline: none;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .error-message {
            display: flex;
            align-items: center;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #f8f9fa;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3bb77e, #2d9d6b);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 183, 126, 0.3);
            color: white;
        }

        .btn-outline-secondary {
            background: white;
            color: #6c757d;
            border: 2px solid #6c757d;
        }

        .btn-outline-secondary:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-header-section {
                padding: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .profile-stats {
                flex-direction: column;
                gap: 0.5rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .avatar-container {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .profile-header-section {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.25rem;
            }

            .form-container {
                padding: 1rem;
            }

            .form-section {
                padding: 1rem;
            }

            .avatar-section {
                padding: 1rem;
            }
        }

        /* Animation Effects */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container {
            animation: fadeInUp 0.6s ease-out;
        }

        .avatar-section {
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        .form-section {
            animation: fadeInUp 0.6s ease-out 0.4s both;
        }

        .form-actions {
            animation: fadeInUp 0.6s ease-out 0.6s both;
        }

        /* Loading Animation */
        @keyframes shimmer {
            0% {
                background-position: -200px 0;
            }

            100% {
                background-position: calc(200px + 100%) 0;
            }
        }

        .btn.loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200px 100%;
            animation: shimmer 1.5s infinite;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Avatar preview functionality
            $('#avatar').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#avatar-preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Avatar click to trigger file input
            $('.avatar-preview').click(function() {
                $('#avatar').click();
            });

            // Form validation feedback
            $('.form-control').on('input', function() {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid');
                    $(this).next('.error-message').hide();
                }
            });

            // Loading state for form submission
            $('.profile-form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true);
                submitBtn.addClass('loading');
                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');

                // Re-enable after 5 seconds (fallback)
                setTimeout(() => {
                    submitBtn.prop('disabled', false);
                    submitBtn.removeClass('loading');
                    submitBtn.html(originalText);
                }, 5000);
            });

            // Smooth scrolling for form sections
            $('html, body').animate({
                scrollTop: $('.profile-form-section').offset().top - 100
            }, 1000);

            // Add hover effects to form sections
            $('.form-section').hover(
                function() {
                    $(this).css('transform', 'translateY(-2px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );

            // File input styling
            $('.file-input').on('change', function() {
                const fileName = this.files[0]?.name || 'No file chosen';
                $(this).next('.file-label').text(fileName);
            });
        });
    </script>
@endsection
