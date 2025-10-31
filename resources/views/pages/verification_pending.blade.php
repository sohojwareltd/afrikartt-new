@extends('layouts.app')

@section('title', 'Verification Pending - Afrikart E-commerce')

@section('css')
    <style>
        .verification-container {
            width: 100%;
            max-width: 900px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }

        .verification-header {
            background: linear-gradient(135deg, #DE991B 0%, #b87d15 100%);
            padding: 35px;
            text-align: center;
            color: white;
            position: relative;
        }

        .logo {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .logo span {
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .status-badge {
            display: inline-block;
            padding: 10px 25px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            font-weight: 600;
            margin-top: 15px;
            backdrop-filter: blur(5px);
            animation: glow 2s infinite alternate;
            font-size: 17px;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(255, 204, 128, 0.6);
            }

            to {
                box-shadow: 0 0 20px rgba(255, 204, 128, 0.9);
            }
        }

        .verification-body {
            padding: 45px;
        }

        .verification-icon {
            text-align: center;
            margin-bottom: 35px;
        }

        .icon-container {
            width: 130px;
            height: 130px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(222, 153, 27, 0.12) 0%, rgba(222, 153, 27, 0.08) 100%);
            border-radius: 50%;
            position: relative;
        }

        .icon-container i {
            font-size: 55px;
            color: #DE991B;
        }

        .icon-container::after {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 3px solid rgba(222, 153, 27, 0.2);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                opacity: 0.7;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.3;
            }

            100% {
                transform: scale(0.95);
                opacity: 0.7;
            }
        }

        .verification-title {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #DE991B;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .verification-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 35px;
            font-size: 18px;
            line-height: 1.6;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .progress-container {
            margin: 40px 0;
            background: #f9f9f9;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-weight: 600;
            color: #555;
        }

        .progress-bar {
            height: 12px;
            background: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 60%;
            background: linear-gradient(90deg, #DE991B, #e8ae48);
            border-radius: 10px;
            animation: progressAnimation 1.5s infinite alternate;
            box-shadow: 0 0 10px rgba(222, 153, 27, 0.4);
        }

        @keyframes progressAnimation {
            0% {
                width: 60%;
            }

            100% {
                width: 65%;
            }
        }

        .verification-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin: 45px 0;
        }

        .step {
            background: #fff;
            border-radius: 15px;
            padding: 30px 25px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #f0f0f0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .step:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .step-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, rgba(222, 153, 27, 0.1) 0%, rgba(222, 153, 27, 0.05) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .step:hover .step-icon {
            transform: scale(1.1);
        }

        .step-icon i {
            font-size: 28px;
            color: #DE991B;
        }

        .step-title {
            font-weight: 700;
            margin-bottom: 12px;
            color: #333;
            font-size: 18px;
        }

        .step-desc {
            color: #666;
            font-size: 15px;
            line-height: 1.5;
        }

        .verification-timeline {
            margin: 45px 0;
            position: relative;
            padding-left: 35px;
        }

        .timeline-title {
            font-weight: 700;
            margin-bottom: 25px;
            color: #333;
            font-size: 22px;
            text-align: center;
            color: #DE991B;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 35px;
            padding-left: 35px;
            border-left: 2px solid #DE991B;
        }

        .timeline-item:last-child {
            border-left: 2px solid #e0e0e0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -11px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #DE991B;
            border: 4px solid white;
            box-shadow: 0 0 0 2px #DE991B;
        }

        .timeline-item.pending::before {
            background: #f0f0f0;
            box-shadow: 0 0 0 2px #b0b0b0;
        }

        .timeline-content {
            background: #fff9f0;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .timeline-content:hover {
            transform: translateX(5px);
        }

        .timeline-content h4 {
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        .timeline-content p {
            color: #666;
            font-size: 14px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 45px;
            flex-wrap: wrap;
        }

        .btn_verification_pending {
            padding: 16px 35px;
            border-radius: 35px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
            min-width: 180px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #DE991B 0%, #c58514 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(222, 153, 27, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(222, 153, 27, 0.5);
            background: linear-gradient(135deg, #c58514 0%, #DE991B 100%);
        }

        .btn-outline {
            background: transparent;
            color: #DE991B;
            border: 2px solid #DE991B;
        }

        .btn-outline:hover {
            background: #DE991B;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(222, 153, 27, 0.3);
        }

        .verification-footer {
            text-align: center;
            padding: 25px;
            background: #fff9f0;
            color: #666;
            font-size: 15px;
            border-top: 1px solid #f0e6d9;
        }

        .contact-info {
            margin-top: 12px;
        }

        .contact-info a {
            color: #DE991B;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .time-estimate {
            background: #fff9f0;
            border-radius: 15px;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
            border: 1px dashed #DE991B;
        }

        .time-estimate i {
            color: #DE991B;
            font-size: 22px;
            margin-right: 10px;
        }

        .time-estimate strong {
            color: #DE991B;
        }

        @media (max-width: 768px) {
            .verification-body {
                padding: 30px 20px;
            }

            .verification-header {
                padding: 25px 20px;
            }

            .verification-steps {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn_verification_pending {
                width: 100%;
            }

            .verification-title {
                font-size: 26px;
            }

            .logo {
                font-size: 26px;
            }
        }
    </style>
@endsection

@section('content')
    <x-app.header />
    <div class="container d-flex justify-content-center align-items-center">
        <div class="verification-container my-5">
            <div class="verification-header">
                <div class="logo"><span>Afrikart</span> E-commerce</div>
                <h1>Account Verification</h1>
                <div class="status-badge">
                    <i class="fas fa-hourglass-half"></i>
                    Verification In Progress
                </div>
            </div>

            <div class="verification-body">
                <div class="verification-icon">
                    <div class="icon-container">
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>

                <h2 class="verification-title">Your Account is Under Review</h2>
                <p class="verification-subtitle">
                    Thank you for submitting your verification documents. Our team is currently reviewing your information
                    to
                    ensure everything meets our security standards.
                </p>

                <div class="time-estimate">
                    <i class="fas fa-clock"></i>
                    <strong>Estimated Processing Time:</strong> 24-48 hours (excluding weekends)
                </div>

                <div class="progress-container">
                    <div class="progress-info">
                        <span>Verification Progress</span>
                        <span>60%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                </div>

                <div class="verification-steps">
                    <div class="step">
                        <div class="step-icon">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <h3 class="step-title">Document Submission</h3>
                        <p class="step-desc">You've successfully submitted your ID and payment verification documents.</p>
                    </div>

                    <div class="step">
                        <div class="step-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="step-title">Review Process</h3>
                        <p class="step-desc">Our security team is carefully reviewing your submitted information.</p>
                    </div>

                    <div class="step">
                        <div class="step-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="step-title">Approval</h3>
                        <p class="step-desc">Once verified, you'll get full access to your seller dashboard.</p>
                    </div>
                </div>

                <div class="verification-timeline">
                    <h3 class="timeline-title">Verification Timeline</h3>

                    <div class="timeline-item">
                        <div class="timeline-content">
                            <h4>Registration Completed</h4>
                            <p>Your account was successfully created.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-content">
                            <h4>Documents Submitted</h4>
                            <p>ID and payment information received.</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-content">
                            <h4>Under Review</h4>
                            <p>Our team is verifying your information.</p>
                        </div>
                    </div>

                    <div class="timeline-item pending">
                        <div class="timeline-content">
                            <h4>Verification Complete</h4>
                            <p>Account will be activated shortly.</p>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ url('/') }}" class="btn_verification_pending btn-primary">
                        <i class="fas fa-home me-2"></i>
                        Back to Homepage
                    </a>

                    <a href="{{ url('/contact') }}" class="btn_verification_pending btn-outline">
                        <i class="fas fa-envelope me-2"></i>
                        Contact Support
                    </a>

                    <button class="btn_verification_pending btn-outline" id="refresh-btn">
                        <i class="fas fa-sync-alt me-2"></i>
                        Refresh Status
                    </button>
                </div>
            </div>

            <div class="verification-footer">
                <p>© 2023 Afrikart E-commerce. All rights reserved.</p>
                <div class="contact-info">
                    Need help? Contact us at <a
                        href="mailto:{{ Settings::setting('admin_email') }}">{{ Settings::setting('admin_email') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to the progress bar
            const progressFill = document.querySelector('.progress-fill');
            let progressWidth = 60;

            setInterval(() => {
                progressWidth = progressWidth === 60 ? 65 : 60;
                progressFill.style.width = progressWidth + '%';
            }, 1500);

            // Refresh button functionality
            const refreshBtn = document.getElementById('refresh-btn');
            refreshBtn.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Checking...';
                this.disabled = true;

                // Make AJAX request to check shop status
                fetch('/check-shop-status', {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Shop status response:', data); // Debug log

                        this.innerHTML = originalText;
                        this.disabled = false;

                        // Convert status to integer for comparison
                        const shopStatus = parseInt(data.status);

                        if (shopStatus === 1) {
                            // Shop is approved, redirect to vendor dashboard
                            const notification = document.createElement('div');
                            notification.style.position = 'fixed';
                            notification.style.bottom = '20px';
                            notification.style.right = '20px';
                            notification.style.padding = '15px 20px';
                            notification.style.background = '#28a745';
                            notification.style.color = 'white';
                            notification.style.borderRadius = '8px';
                            notification.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.15)';
                            notification.style.zIndex = '1000';
                            notification.innerHTML =
                                '<i class="fas fa-check-circle me-2"></i> Congratulations! Your account has been approved. Redirecting to vendor dashboard...';

                            document.body.appendChild(notification);

                            setTimeout(() => {
                                window.location.href = '/vendor';
                            }, 2000);
                        } else {
                            // Shop is still pending (status = 0 or any other value)
                            const notification = document.createElement('div');
                            notification.style.position = 'fixed';
                            notification.style.bottom = '20px';
                            notification.style.right = '20px';
                            notification.style.padding = '15px 20px';
                            notification.style.background = '#DE991B';
                            notification.style.color = 'white';
                            notification.style.borderRadius = '8px';
                            notification.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.15)';
                            notification.style.zIndex = '1000';
                            notification.innerHTML =
                                '<i class="fas fa-hourglass-half me-2"></i> Please wait. You will get vendor access after admin approval.';

                            document.body.appendChild(notification);

                            // Remove notification after 4 seconds
                            setTimeout(() => {
                                notification.style.opacity = '0';
                                notification.style.transition = 'opacity 0.5s ease';
                                setTimeout(() => {
                                    if (document.body.contains(notification)) {
                                        document.body.removeChild(notification);
                                    }
                                }, 500);
                            }, 4000);
                        }
                    })
                    .catch(error => {
                        console.error('Error checking shop status:', error); // Debug log

                        this.innerHTML = originalText;
                        this.disabled = false;

                        // Show error message
                        const notification = document.createElement('div');
                        notification.style.position = 'fixed';
                        notification.style.bottom = '20px';
                        notification.style.right = '20px';
                        notification.style.padding = '15px 20px';
                        notification.style.background = '#dc3545';
                        notification.style.color = 'white';
                        notification.style.borderRadius = '8px';
                        notification.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.15)';
                        notification.style.zIndex = '1000';
                        notification.innerHTML =
                            '<i class="fas fa-exclamation-triangle me-2"></i> An error occurred. Please try again.';

                        document.body.appendChild(notification);

                        setTimeout(() => {
                            notification.style.opacity = '0';
                            notification.style.transition = 'opacity 0.5s ease';
                            setTimeout(() => {
                                if (document.body.contains(notification)) {
                                    document.body.removeChild(notification);
                                }
                            }, 500);
                        }, 3000);
                    });
            });

            // Add hover effects to timeline items
            const timelineItems = document.querySelectorAll('.timeline-content');
            timelineItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.1)';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
                });
            });
        });
    </script>
@endsection
