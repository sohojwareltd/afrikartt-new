@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .profile-card {
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
        }

        .tab-button {
            position: relative;
        }

        .tab-button::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: currentColor;
            transform: scaleX(0);
            transition: transform 0.2s ease;
        }

        .tab-button.active::after {
            transform: scaleX(1);
        }

        .form-section {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .avatar-upload:hover img {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        .avatar-upload img {
            transition: transform 0.3s ease;
        }

        .avatar-banner-upload {
            position: relative;
            overflow: hidden;
        }

        .avatar-banner-upload:hover img,
        .avatar-banner-upload:hover video {
            transform: scale(1.02);
        }

        .avatar-banner-upload img,
        .avatar-banner-upload video {
            transition: transform 0.3s ease;
        }

        .profile-completion-ring {
            transform: rotate(-90deg);
        }

        .progress-ring-circle {
            transition: stroke-dasharray 0.35s;
            transform-origin: 50% 50%;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .status-indicator {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }
    </style>
@endpush
