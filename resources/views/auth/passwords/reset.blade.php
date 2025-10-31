@extends('layouts.app')

@section('css')
<style>
    :root {
        --text-dark: #2c3e50;
        --text-muted: #7f8c8d;
        --bg-light: #f8f9fa;
        --border-color: #e9ecef;
        --success-color: #27ae60;
        --error-color: #e74c3c;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.15);
        --radius: 12px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .reset-password-section {
        background: linear-gradient(135deg, var(--accent-color) 0%, rgba(var(--accent-color-rgb), 0.8) 100%);
        min-height: 90vh;
        display: flex;
        align-items: center;
        padding: 60px 0;
        position: relative;
        overflow: hidden;
    }

    .reset-password-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 40%;
        height: 200%;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        transform: rotate(15deg);
        z-index: 1;
    }

    .reset-container {
        position: relative;
        z-index: 2;
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .reset-header {
        background: linear-gradient(135deg, var(--accent-color) 0%, rgba(var(--accent-color-rgb), 0.9) 100%);
        color: white;
        padding: 40px 30px;
        text-align: center;
        position: relative;
    }

    .reset-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    }

    .reset-icon {
        width: 70px;
        height: 70px;
        background: var(--accent-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
        position: relative;
        z-index: 2;
        backdrop-filter: blur(10px);
    }

    .reset-title {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px;
        position: relative;
        z-index: 2;
        letter-spacing: -0.5px;
    }

    .reset-subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 2;
        line-height: 1.5;
    }

    .reset-content {
        padding: 40px 30px;
    }

    .reset-description {
        background: var(--bg-light);
        border-left: 4px solid var(--accent-color);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .description-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }

    .description-icon {
        margin-right: 8px;
        color: var(--accent-color);
        font-size: 18px;
    }

    .description-text {
        color: var(--text-muted);
        font-size: 14px;
        line-height: 1.6;
        margin: 0;
    }

    .form-group {
        position: relative;
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
        font-size: 14px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 16px;
        transition: var(--transition);
        background: white;
        color: var(--text-dark);
    }

    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(var(--accent-color-rgb), 0.1);
        outline: none;
        transform: translateY(-1px);
    }

    .form-control.is-invalid {
        border-color: var(--error-color);
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
    }

    .invalid-feedback {
        color: var(--error-color);
        font-size: 14px;
        margin-top: 8px;
        display: flex;
        align-items: center;
    }

    .invalid-feedback::before {
        content: '⚠️';
        margin-right: 6px;
    }

    .btn-reset {
        width: 100%;
        background: var(--accent-color);
        color: white;
        border: none;
        padding: 15px 20px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(var(--accent-color-rgb), 0.3);
    }

    .btn-reset:hover {
        background: var(--accent-color);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(var(--accent-color-rgb), 0.4);
        filter: brightness(1.05);
    }

    .btn-reset:active {
        transform: translateY(0);
    }

    .btn-reset::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transition: all 0.4s ease;
        transform: translate(-50%, -50%);
    }

    .btn-reset:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .success-message {
        background: linear-gradient(135deg, var(--success-color) 0%, #2ecc71 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: none;
        animation: slideIn 0.3s ease;
    }

    .success-message.show {
        display: block;
    }

    .back-link {
        text-align: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    .back-link a {
        color: var(--accent-color);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .back-link a:hover {
        color: var(--accent-color);
        transform: translateX(-3px);
    }

    .security-info {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
    }

    .security-info-title {
        font-weight: 600;
        color: #856404;
        font-size: 14px;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }

    .security-info-text {
        color: #856404;
        font-size: 13px;
        margin: 0;
        line-height: 1.4;
    }

    .password-strength {
        margin-top: 10px;
    }

    .strength-meter {
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        overflow: hidden;
        margin-top: 5px;
    }

    .strength-bar {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .strength-weak .strength-bar {
        width: 25%;
        background: #e74c3c;
    }

    .strength-fair .strength-bar {
        width: 50%;
        background: #f39c12;
    }

    .strength-good .strength-bar {
        width: 75%;
        background: #f1c40f;
    }

    .strength-strong .strength-bar {
        width: 100%;
        background: #27ae60;
    }

    .strength-text {
        font-size: 12px;
        margin-top: 3px;
        font-weight: 500;
    }

    /* Loading State for Button */
    .btn-reset.loading {
        pointer-events: none;
        position: relative;
    }

    .btn-reset.loading .btn-content {
        opacity: 0.7;
    }

    .btn-reset.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .reset-password-section {
            padding: 40px 20px;
        }

        .reset-container {
            margin: 0 10px;
        }

        .reset-content {
            padding: 30px 20px;
        }

        .reset-header {
            padding: 30px 20px;
        }

        .reset-title {
            font-size: 24px;
        }

        .reset-subtitle {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')
<x-app.header />
<section class="reset-password-section">
    <div class="container">
        <div class="reset-container">
            <!-- Header Section -->
            <div class="reset-header">
                <div class="reset-icon">
                    <i class="fa-solid fa-key"></i>
                </div>
                <h1 class="reset-title">Create New Password</h1>
                <p class="reset-subtitle text-dark">Enter your new password to complete the reset process</p>
            </div>

            <!-- Content Section -->
            <div class="reset-content">
                <!-- Description -->
                <div class="reset-description">
                    <div class="description-title">
                        <span class="description-icon">🔐</span>
                        Password Requirements
                    </div>
                    <p class="description-text">
                        Your new password should be at least 8 characters long and contain a mix of uppercase, lowercase, numbers, and special characters for better security.
                    </p>
                </div>

                <!-- Reset Form -->
                <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email" class="form-label">
                            Email Address <span style="color: var(--error-color);">*</span>
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            placeholder="Enter your email address"
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email"
                            value="{{ $email ?? old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                            readonly
                        >
                        @error('email')
                            <div class="invalid-feedback" data-server-error="true">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            New Password <span style="color: var(--error-color);">*</span>
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            placeholder="Enter your new password"
                            class="form-control @error('password') is-invalid @enderror" 
                            name="password"
                            required 
                            autocomplete="new-password"
                        >
                        @error('password')
                            <div class="invalid-feedback" data-server-error="true">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        <!-- Password Strength Indicator -->
                        <div class="password-strength" id="passwordStrength" style="display: none;">
                            <div class="strength-meter">
                                <div class="strength-bar"></div>
                            </div>
                            <div class="strength-text"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="form-label">
                            Confirm New Password <span style="color: var(--error-color);">*</span>
                        </label>
                        <input 
                            id="password-confirm" 
                            type="password" 
                            placeholder="Confirm your new password"
                            class="form-control" 
                            name="password_confirmation"
                            required 
                            autocomplete="new-password"
                        >
                        <div class="invalid-feedback" id="confirmError" style="display: none;">
                            Passwords do not match
                        </div>
                    </div>

                    <button type="submit" class="btn-reset" id="submitBtn">
                        <span class="btn-content">
                            <span>🔐</span>
                            <span>Reset Password</span>
                        </span>
                    </button>
                </form>

                <!-- Security Information -->
                <div class="security-info">
                    <div class="security-info-title">
                        🛡️ Security Notice
                    </div>
                    <p class="security-info-text">
                        After resetting your password, you'll be automatically logged in. Make sure to keep your new password secure and don't share it with anyone.
                    </p>
                </div>

                <!-- Back to Login -->
                <div class="back-link">
                    <a href="{{ route('login') }}">
                        <span>←</span>
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resetForm');
    const submitBtn = document.getElementById('submitBtn');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password-confirm');
    const strengthIndicator = document.getElementById('passwordStrength');
    const confirmError = document.getElementById('confirmError');

    // Password strength checker
    function checkPasswordStrength(password) {
        let strength = 0;
        let feedback = '';

        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;

        switch (strength) {
            case 0:
            case 1:
                return { class: 'strength-weak', text: 'Weak' };
            case 2:
                return { class: 'strength-fair', text: 'Fair' };
            case 3:
            case 4:
                return { class: 'strength-good', text: 'Good' };
            case 5:
                return { class: 'strength-strong', text: 'Strong' };
        }
    }

    // Enhanced form validation
    function validatePassword(password) {
        return password.length >= 8;
    }

    function validatePasswordMatch() {
        return passwordInput.value === confirmInput.value;
    }

    function showError(input, message) {
        const formGroup = input.closest('.form-group');
        let feedback = formGroup.querySelector('.invalid-feedback:not([data-server-error])');
        
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            formGroup.appendChild(feedback);
        }
        
        feedback.textContent = message;
        input.classList.add('is-invalid');
        feedback.style.display = 'flex';
    }

    function hideError(input) {
        const formGroup = input.closest('.form-group');
        const feedback = formGroup.querySelector('.invalid-feedback:not([data-server-error])');
        
        if (feedback) {
            feedback.style.display = 'none';
        }
        input.classList.remove('is-invalid');
    }

    // Password strength indicator
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        if (password.length > 0) {
            strengthIndicator.style.display = 'block';
            const strength = checkPasswordStrength(password);
            
            strengthIndicator.className = 'password-strength ' + strength.class;
            strengthIndicator.querySelector('.strength-text').textContent = strength.text;
        } else {
            strengthIndicator.style.display = 'none';
        }

        // Validate password
        if (password && !validatePassword(password)) {
            showError(this, 'Password must be at least 8 characters long');
        } else {
            hideError(this);
        }

        // Check password match if confirm field has value
        if (confirmInput.value) {
            validatePasswordMatchField();
        }
    });

    // Confirm password validation
    function validatePasswordMatchField() {
        if (confirmInput.value && !validatePasswordMatch()) {
            confirmInput.classList.add('is-invalid');
            confirmError.style.display = 'flex';
        } else {
            confirmInput.classList.remove('is-invalid');
            confirmError.style.display = 'none';
        }
    }

    confirmInput.addEventListener('input', validatePasswordMatchField);

    // Form submission
    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Reset previous errors (except server errors)
        hideError(passwordInput);
        hideError(confirmInput);
        confirmError.style.display = 'none';
        confirmInput.classList.remove('is-invalid');

        // Validate password
        if (!passwordInput.value) {
            showError(passwordInput, 'Password is required');
            isValid = false;
        } else if (!validatePassword(passwordInput.value)) {
            showError(passwordInput, 'Password must be at least 8 characters long');
            isValid = false;
        }

        // Validate password confirmation
        if (!confirmInput.value) {
            showError(confirmInput, 'Password confirmation is required');
            isValid = false;
        } else if (!validatePasswordMatch()) {
            confirmInput.classList.add('is-invalid');
            confirmError.style.display = 'flex';
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            return;
        }

        // Show loading state
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;

        // If form is valid, let it submit naturally
        // The loading state will be cleared on page reload/redirect
    });

    // Enhanced visual feedback
    [passwordInput, confirmInput].forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
});
</script>
@endsection

