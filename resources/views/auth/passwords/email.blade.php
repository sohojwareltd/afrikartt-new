@extends('layouts.app')
@section('css')
<style>
    :root {
        /* --primary-color: #f8f9fa; */
        --primary-rgb: 248, 249, 250;
        --text-dark: #2c3e50;
        --text-muted: #7f8c8d;
        --bg-light: #e2e3e4;
        --border-color: #e9ecef;
        --success-color: #27ae60;
        --error-color: #e74c3c;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.15);
        --radius: 12px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .reset-password-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        min-height: 80vh;
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
        background: linear-gradient(45deg, rgba(248, 249, 250, 0.3) 0%, transparent 50%);
        transform: rotate(15deg);
        z-index: 1;
    }

    .reset-container {
        position: relative;
        z-index: 2;
        max-width: 500px;
        margin: 0 auto;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .reset-header {
        background: linear-gradient(135deg, #f8f9fa 0%, rgba(248, 249, 250, 0.9) 100%);
        color: var(--text-dark);
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
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
    }

    .reset-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.8);
        border: 2px solid #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
        position: relative;
        z-index: 2;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(248, 249, 250, 0.4);
    }

    .reset-title {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px;
        position: relative;
        z-index: 2;
        letter-spacing: -0.5px;
        color: var(--text-dark);
    }

    .reset-subtitle {
        font-size: 16px;
        opacity: 0.8;
        margin: 0;
        position: relative;
        z-index: 2;
        line-height: 1.5;
        color: var(--text-muted);
    }

    .reset-content {
        padding: 40px 30px;
    }

    .reset-description {
        background: #f8f9fa;
        border-left: 4px solid #f8f9fa;
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
        color: #f8f9fa;
        font-size: 18px;
        filter: brightness(0.7);
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
        border: 2px solid #f8f9fa;
        border-radius: 10px;
        font-size: 16px;
        transition: var(--transition);
        background: white;
        color: var(--text-dark);
    }

    .form-control:focus {
        border-color: #f8f9fa;
        box-shadow: 0 0 0 3px rgba(248, 249, 250, 0.3);
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
        color: #ffffff;
        border: 2px solid #f8f9fa;
        padding: 15px 20px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(248, 249, 250, 0.4);
    }

    .btn-reset:hover {
        background: var(--accent-color);
        color: #ffffff;
    }

    .btn-reset:active {
        transform: translateY(0);
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
        border-top: 1px solid #f8f9fa;
    }

    .back-link a {
        color: #f8f9fa;
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        filter: brightness(0.7);
    }

    .back-link a:hover {
        color: #f8f9fa;
        transform: translateX(-3px);
        filter: brightness(0.6);
    }

    .security-info {
        background: #f8f9fa;
        border: 1px solid #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
    }

    .security-info-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 14px;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }

    .security-info-text {
        color: var(--text-muted);
        font-size: 13px;
        margin: 0;
        line-height: 1.4;
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
        border-top: 2px solid var(--text-dark);
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resetForm');
    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');
    const emailInput = document.getElementById('email');

    // Enhanced form validation
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function showError(input, message) {
        const formGroup = input.closest('.form-group');
        let feedback = formGroup.querySelector('.invalid-feedback');
        
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

    // Real-time validation
    emailInput.addEventListener('input', function() {
        if (this.value && !validateEmail(this.value)) {
            showError(this, 'Please enter a valid email address');
        } else {
            hideError(this);
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Reset previous errors (except server errors)
        hideError(emailInput);

        // Validate email
        if (!emailInput.value) {
            showError(emailInput, 'Email address is required');
            isValid = false;
        } else if (!validateEmail(emailInput.value)) {
            showError(emailInput, 'Please enter a valid email address');
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

    // Show success message if redirected back with success
    if (window.location.search.includes('success=true')) {
        successMessage.classList.add('show');
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            successMessage.classList.remove('show');
        }, 5000);
    }

    // Enhanced visual feedback
    emailInput.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });

    emailInput.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
    });
});
</script>
@endsection
@section('content')

<x-app.header />
    <section class="reset-password-section">
    <div class="container">
        <div class="reset-container">
            <!-- Header Section -->
            <div class="reset-header">
                <div class="reset-icon">
                    🔐
                </div>
                <h1 class="reset-title">Reset Password</h1>
                <p class="reset-subtitle">We'll help you get back into your account</p>
            </div>

            <!-- Content Section -->
            <div class="reset-content">
                <!-- Description -->
                <div class="reset-description">
                    <div class="description-title">
                        <span class="description-icon">💡</span>
                        How it works
                    </div>
                    <p class="description-text">
                        Enter your email address below and we'll send you a secure link to reset your password. 
                        The link will expire in 60 minutes for your security.
                    </p>
                </div>

                <!-- Success Message (Hidden by default) -->
                <div id="successMessage" class="success-message">
                    <div class="d-flex align-items-center">
                        <span style="font-size: 20px; margin-right: 10px;">✅</span>
                        <div>
                            <strong>Email Sent Successfully!</strong>
                            <br>
                            <small>Check your inbox and follow the instructions to reset your password.</small>
                        </div>
                    </div>
                </div>

                <!-- Reset Form -->
                <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                    @csrf
                    
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
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                        >
                        @error('email')
                            <div class="invalid-feedback" data-server-error="true">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-reset" id="submitBtn">
                        <span class="btn-content">
                            <span>📧</span>
                            <span>Send Reset Link</span>
                        </span>
                    </button>
                </form>

                <!-- Security Information -->
                <div class="security-info">
                    <div class="security-info-title">
                        🛡️ Security Notice
                    </div>
                    <p class="security-info-text">
                        For your protection, the reset link will expire in 60 minutes. 
                        If you don't receive the email, check your spam folder or try again.
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
@endsection
