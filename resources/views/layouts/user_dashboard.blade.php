@extends('layouts.app')
@section('css')
    <style>
        /* Sidebar Container */
        .sidebar-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* User Profile Section */
        .user-profile-section {
            background: var(--accent-color);
            padding: 2rem 1.5rem;
            color: white;
            text-align: center;
        }

        .profile-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .profile-avatar {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .avatar-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e9ecef;
            color: #6c757d;
            font-size: 2rem;
        }

        .status-indicator {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 16px;
            height: 16px;
            background: #28a745;
            border-radius: 50%;
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-indicator i {
            font-size: 0.5rem;
            color: white;
        }

        .profile-info {
            text-align: center;
        }

        .user-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            line-height: 1.2;
        }

        .user-role {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0.25rem 0 0 0;
        }

        /* Navigation Menu */
        .sidebar-navigation {
            padding: 1.5rem;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section:last-child {
            margin-bottom: 0;
        }

        .nav-title {
            color: #6c757d;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            text-decoration: none;
            color: #6c757d;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link:hover {
            background: rgba(var(--accent-color-rgb), 0.1);
            color: var(--accent-color);
            text-decoration: none;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--accent-color);
            color: white;
            box-shadow: 0 5px 15px rgba(59, 183, 126, 0.3);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        .nav-text {
            flex: 1;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .nav-indicator {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .nav-link.active .nav-indicator {
            opacity: 1;
        }

        /* Quick Actions */
        .quick-actions {
            padding: 1.5rem;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .actions-title {
            color: #6c757d;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-btn {
            display: flex;
            background: var(--accent-color) !important;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1rem;
            color: #ffffff;
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .action-btn:hover {
            background: var(--primary-dark) !important;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 183, 126, 0.3);
            text-decoration: none;
        }

        /* Hover Effects */
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* background: linear-gradient(135deg, #3bb77e, #2d9d6b);
                    opacity: 0; */
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .nav-link:hover::before {
            opacity: 0.1;
        }

        /* Animation Effects */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .sidebar-container {
            animation: slideInLeft 0.6s ease-out;
        }

        .nav-item {
            animation: slideInLeft 0.6s ease-out;
        }

        .nav-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .nav-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .nav-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .nav-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .nav-item:nth-child(5) {
            animation-delay: 0.5s;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar-container {
                margin-bottom: 1rem;
            }

            .user-profile-section {
                padding: 1.5rem 1rem;
            }

            .profile-avatar {
                width: 60px;
                height: 60px;
            }

            .user-name {
                font-size: 1rem;
            }

            .sidebar-navigation {
                padding: 1rem;
            }

            .quick-actions {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .user-profile-section {
                padding: 1rem;
            }

            .profile-avatar {
                width: 50px;
                height: 50px;
            }

            .user-name {
                font-size: 0.9rem;
            }

            .nav-link {
                padding: 0.6rem 0.8rem;
            }

            .nav-text {
                font-size: 0.8rem;
            }
        }

        /* Scrollbar Styling */
        /* .sidebar-container::-webkit-scrollbar {
                    width: 4px;
                }

                .sidebar-container::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 2px;
                }

                .sidebar-container::-webkit-scrollbar-thumb {
                    background: #3bb77e;
                    border-radius: 2px;
                }

                .sidebar-container::-webkit-scrollbar-thumb:hover {
                    background: #2d9d6b;
                } */
    </style>
@endsection
@section('content')
    <x-app.header />
    {{-- <x-app.breadcrumb /> --}}


    <!-- Vendor dashboard section -->
    <section class="ec-page-content ec-vendor-dashboard section-space-p">
        <div class="container">
            <div class="row">
                <!-- Sidebar Area Start -->
                <x-app.user_sidebar />
                @yield('dashboard-content')
            </div>

        </div>
    </section>
    <!-- End Vendor dashboard section -->
@endsection
@section('js')
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>


    <script>
        $(document).ready(function() {
            // Add hover effects to navigation items
            $('.nav-link').hover(
                function() {
                    $(this).find('.nav-indicator').css('opacity', '1');
                },
                function() {
                    if (!$(this).hasClass('active')) {
                        $(this).find('.nav-indicator').css('opacity', '0');
                    }
                }
            );

            // Add click feedback
            $('.nav-link').click(function() {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });

            // Add loading state to action buttons
            $('.action-btn').click(function() {
                const btn = $(this);
                const originalText = btn.html();

                btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Loading...');
                btn.prop('disabled', true);

                setTimeout(() => {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                }, 2000);
            });

            // Smooth scrolling for navigation
            $('.nav-link').click(function(e) {
                if ($(this).attr('href').startsWith('#')) {
                    e.preventDefault();
                    const target = $($(this).attr('href'));
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top - 100
                        }, 1000);
                    }
                }
            });
        });
    </script>
@endsection
