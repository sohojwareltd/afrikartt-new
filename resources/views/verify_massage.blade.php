@extends('auth.seller.registration.layout', ['current_step' => 2])

@section('registration-content')
    <div class="d-flex align-items-center justify-content-center" style="min-height: 80vh; background: #fafdff;">
        <div class="card shadow-sm border-0 p-4"
            style="max-width: 400px; width: 100%; border-radius: 0; border-left: 6px solid var(--accent-color);">
            <div class="text-center mb-3">
                <i class="fas fa-envelope-open-text" style="font-size: 3rem; color: var(--accent-color);"></i>
            </div>
            <h2 class="text-center fw-bold mb-2" style="color: var(--accent-color);">Verify your email</h2>
            <p class="text-center text-secondary mb-2" style="font-size: 1.08rem;">We’ve sent a confirmation link to your
                email.</p>
            <p class="text-center text-muted mb-4" style="font-size: 0.98rem;">Didn’t get it? Check your spam or click
                below.</p>
            <a href="{{ route('again.verify.token') }}"
                class="btn d-flex align-items-center justify-content-center w-100 mb-3"
                style="background:var(--accent-color);color:#fff;font-weight:600;font-size:1.08rem; border-radius:0;">
                <i class="fas fa-paper-plane me-2"></i> Resend email
            </a>
            <div class="text-center text-secondary small mt-2">
                Need help? <a href="mailto:support@royalit.com"
                    style="color:var(--accent-color);text-decoration:underline;">Contact
                    support</a>
            </div>
        </div>
    </div>
@endsection
