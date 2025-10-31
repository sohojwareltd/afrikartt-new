@extends('layouts.user_dashboard')

@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <!-- Header Section -->
        <div class="password-header-section mb-4">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="page-title" style="color: #ffffff">
                        <i class="fas fa-lock me-2"></i>
                        Change Password
                    </h1>
                    <p class="page-subtitle">Update your password to keep your account secure</p>
                </div>
                <div class="header-right">
                    <div class="security-stats">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Security Level</span>
                                <span class="stat-value">High</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Last Updated</span>
                                <span
                                    class="stat-value">{{ auth()->user()->updated_at ? auth()->user()->updated_at->diffForHumans() : 'Never' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Form Section -->
        <div class="password-form-section">
            <div class="form-container">
                <div class="form-header">
                    <h3 class="form-title">
                        <i class="fas fa-key me-2"></i>
                        Password Update
                    </h3>
                    <p class="form-subtitle">Enter your current password and choose a new secure password</p>
                </div>

                <form class="password-form" method="POST" action="{{ route('user.update_password') }}">
                    @csrf

                    <!-- Current Password Section -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-unlock me-2"></i>
                            Current Password
                        </h4>

                        <div class="form-group">
                            <label for="current-password" class="form-label">
                                <i class="fas fa-lock me-1"></i>
                                Current Password
                            </label>
                            <div class="password-input-group">
                                <input id="current-password" type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" required placeholder="Enter your current password">
                                <button type="button" class="password-toggle" data-target="current-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password" class="form-label">
                                <i class="fas fa-lock me-1"></i>
                                New Password
                            </label>
                            <div class="password-input-group">
                                <input id="new_password" type="password"
                                    class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                                    required placeholder="Enter your new password">
                                <button type="button" class="password-toggle" data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="input-focus-border"></div>
                            </div>
                            @error('new_password')
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirm" class="form-label">
                                <i class="fas fa-lock me-1"></i>
                                Confirm New Password
                            </label>
                            <div class="password-input-group">
                                <input id="new_password_confirm" type="password"
                                    class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                    name="new_password_confirmation" required placeholder="Confirm your new password">
                                <button type="button" class="password-toggle" data-target="new_password_confirm">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="input-focus-border"></div>
                            </div>
                            @error('new_password_confirmation')
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-edit-profile d-block btn-lg" style="padding: 0; border-radius: 0;">
                            <i class="fas fa-save me-2"></i>
                            Update Password
                        </button>
                    </div>
                    <!-- Security Tips -->
                    <div class="security-tips">
                        <h6 class="tips-title">
                            <i class="fas fa-lightbulb me-1"></i>
                            Security Tips
                        </h6>
                        <div class="tips-grid">
                            <div class="tip-item">
                                <i class="fas fa-random"></i>
                                <span>Use a unique password for each account</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Change your password regularly</span>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-user-secret"></i>
                                <span>Never share your password with anyone</span>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>

    <style>

        /* Header Section */
        .password-header-section {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-color));
            padding: 2rem;
            border-radius: 20px;
            color: white;
            box-shadow: 0 10px 30px rgba(var(--accent-color-rgb), 0.3);
            position: relative;
            overflow: hidden;
        }

        .password-header-section::before {
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

        .security-stats {
            display: flex;
            gap: 1rem;
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
        .password-form-section {
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

        /* Form Sections */
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 15px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            position: relative;
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

        .password-input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            flex: 1;
            position: relative;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(var(--accent-color-rgb), 0.25);
            outline: none;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .input-focus-border {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent-color), var(--accent-color));
            transition: width 0.3s ease;
        }

        .form-control:focus+.password-toggle+.input-focus-border {
            width: 100%;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--accent-color);
            background: rgba(var(--accent-color-rgb), 0.1);
        }

        .error-message {
            display: flex;
            align-items: center;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Password Strength */
        .password-strength {
            margin-top: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .strength-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .strength-label {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .strength-score {
            font-weight: 600;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .strength-bar {
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 4px;
            position: relative;
        }

        .strength-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            filter: blur(4px);
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        .strength-fill.weak {
            width: 25%;
            background: #dc3545;
        }

        .strength-fill.fair {
            width: 50%;
            background: #ffc107;
        }

        .strength-fill.good {
            width: 75%;
            background: #17a2b8;
        }

        .strength-fill.strong {
            width: 100%;
            background: #28a745;
        }

        .strength-text {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* Password Requirements */
        .password-requirements {
            margin-top: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .requirements-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .requirements-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.8rem;
            color: #6c757d;
            transition: all 0.3s ease;
            position: relative;
        }

        .requirement i {
            margin-right: 0.5rem;
            font-size: 0.6rem;
            color: #dee2e6;
            transition: all 0.3s ease;
        }

        .requirement-text {
            flex: 1;
        }

        .requirement-progress {
            width: 20px;
            height: 2px;
            background: #e9ecef;
            border-radius: 1px;
            overflow: hidden;
            margin-left: 0.5rem;
        }

        .requirement-progress::before {
            content: '';
            display: block;
            height: 100%;
            width: 0%;
            background: #28a745;
            transition: width 0.3s ease;
        }

        .requirement.met {
            color: #28a745;
        }

        .requirement.met i {
            color: #28a745;
        }

        .requirement.met .requirement-progress::before {
            width: 100%;
        }

        /* Password Match */
        .password-match {
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: #6c757d;
            position: relative;
        }

        .match-icon {
            margin-right: 0.5rem;
        }

        .match-icon i {
            color: #dee2e6;
            transition: all 0.3s ease;
        }

        .match-animation {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #e9ecef;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .password-match.matched {
            color: #28a745;
        }

        .password-match.matched i {
            color: #28a745;
        }

        .password-match.matched .match-animation {
            opacity: 1;
            background: #28a745;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: translateY(-50%) scale(1);
            }

            50% {
                transform: translateY(-50%) scale(1.2);
            }

            100% {
                transform: translateY(-50%) scale(1);
            }
        }

        /* Security Tips */
        .security-tips {
            margin-top: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            border: 1px solid #dee2e6;
        }

        .tips-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .tips-grid {
            display: grid;
            gap: 0.75rem;
        }

        .tip-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background: white;
            border-radius: 8px;
            font-size: 0.8rem;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .tip-item:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .tip-item i {
            margin-right: 0.75rem;
            color: var(--accent-color);
            font-size: 1rem;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .password-header-section {
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

            .security-stats {
                flex-direction: column;
                gap: 0.5rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .tips-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .password-header-section {
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

        .form-section {
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        .form-actions {
            animation: fadeInUp 0.6s ease-out 0.4s both;
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
    </style>

    <script>
        $(document).ready(function() {
            // Password toggle functionality
            $('.password-toggle').click(function() {
                const target = $(this).data('target');
                const input = $('#' + target);
                const icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Password strength checker
            $('#new_password').on('input', function() {
                const password = $(this).val();
                checkPasswordStrength(password);
                checkPasswordRequirements(password);
            });

            // Password match checker
            $('#new_password_confirm').on('input', function() {
                const password = $('#new_password').val();
                const confirmPassword = $(this).val();
                checkPasswordMatch(password, confirmPassword);
            });

            function checkPasswordStrength(password) {
                let strength = 0;
                let strengthText = 'Enter a password';
                let strengthClass = '';

                if (password.length >= 8) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[a-z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 25;

                if (strength === 0) {
                    strengthText = 'Enter a password';
                    strengthClass = '';
                } else if (strength <= 25) {
                    strengthText = 'Weak';
                    strengthClass = 'weak';
                } else if (strength <= 50) {
                    strengthText = 'Fair';
                    strengthClass = 'fair';
                } else if (strength <= 75) {
                    strengthText = 'Good';
                    strengthClass = 'good';
                } else {
                    strengthText = 'Strong';
                    strengthClass = 'strong';
                }

                $('#strength-fill').removeClass('weak fair good strong').addClass(strengthClass);
                $('#strength-score').text(strength + '%');
                $('#strength-text').text(strengthText);
            }

            function checkPasswordRequirements(password) {
                const requirements = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[^A-Za-z0-9]/.test(password)
                };

                $('.requirement').each(function() {
                    const requirement = $(this).data('requirement');
                    if (requirements[requirement]) {
                        $(this).addClass('met');
                    } else {
                        $(this).removeClass('met');
                    }
                });
            }

            function checkPasswordMatch(password, confirmPassword) {
                const matchElement = $('#password-match');
                if (confirmPassword === '') {
                    matchElement.removeClass('matched');
                    matchElement.find('.match-text').text('Passwords don\'t match');
                } else if (password === confirmPassword) {
                    matchElement.addClass('matched');
                    matchElement.find('.match-text').text('Passwords match');
                } else {
                    matchElement.removeClass('matched');
                    matchElement.find('.match-text').text('Passwords don\'t match');
                }
            }

            // Form validation feedback
            $('.form-control').on('input', function() {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid');
                    $(this).next('.error-message').hide();
                }
            });

            // Loading state for form submission
            $('.password-form').on('submit', function() {
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
                scrollTop: $('.password-form-section').offset().top - 100
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
        });
    </script>
@endsection
