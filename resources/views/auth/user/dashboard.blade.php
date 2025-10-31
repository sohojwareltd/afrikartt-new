@extends('layouts.user_dashboard')

@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <!-- Modern User Dashboard -->
        <div class="user-dashboard-modern">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <div class="welcome-icon">
                            <i class="fas fa-user-circle" style="color:var(--accent-color);"></i>
                        </div>
                        <div class="welcome-text">
                            <h1 class="text-light">Welcome back, {{ Auth::user()->name }}!</h1>
                            <p>Here's your personalized dashboard to manage your account</p>
                            <div class="welcome-stats">
                                <div class="stat-item">
                                    <i class="fas fa-shopping-bag" style="color:var(--accent-color);"></i>
                                    <span class="text-dark">{{Auth()->user()->orders->count()}}</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-map-marker-alt" style="color:var(--accent-color);"></i>
                                    <span class="text-dark">{{ Auth()->user()->addresses->count() }} Addresses</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-credit-card" style="color:var(--accent-color);"></i>
                                    <span class="text-dark">{{ auth()->user()->paymentMethods()->count() }} Cards</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Personal Information Section -->
                <div class="info-section">
                    <div class="info-card">
                        <div class="card-header">
                            <h2><i class="fas fa-user"></i> Personal Information</h2>
                            <a href="{{ route('user.update_profile') }}" class="btn-edit-profile">
                                <i class="fas fa-edit"></i>
                                Edit Profile
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user"></i>
                                        <span>Full Name</span>
                                    </div>
                                    <div class="info-value">{{ Auth::user()->name }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-envelope"></i>
                                        <span>Email Address</span>
                                    </div>
                                    <div class="info-value">{{ Auth::user()->email }}</div>
                                    <div class="verification-badge verified">
                                        <i class="fas fa-check-circle"></i> Verified
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-phone"></i>
                                        <span>Phone Number</span>
                                    </div>
                                    <div class="info-value">
                                        @if (Auth::check() && !empty(Auth::user()->phone))
                                            {{ Auth::user()->phone }}
                                            <div class="verification-badge verified">
                                                <i class="fas fa-check-circle"></i> Verified
                                            </div>
                                        @else
                                            <a href="{{ route('user.update_profile') }}" class="add-phone-link">
                                                <i class="fas fa-plus"></i> Add Phone Number
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="info-item full-width">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Account Created</span>
                                    </div>
                                    <div class="info-value">
                                        {{ Auth::user()->created_at->format('M d, Y') }}
                                        <span class="account-age">({{ Auth::user()->created_at->diffForHumans() }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Section -->
                <div class="quick-actions-section">
                    <div class="quick-actions-card">
                        <div class="card-header">
                            <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
                        </div>
                        <div class="card-body">
                            <div class="actions-grid">
                                <a href="{{route('user.ordersIndex')}}" class="action-item">
                                    <div class="action-icon">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <div class="action-text">
                                        <h3>My Orders</h3>
                                        <p>View your order history</p>
                                    </div>
                                </a>

                                <a href="{{route('wishlist.index')}}" class="action-item">
                                    <div class="action-icon">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="action-text">
                                        <h3>Wishlist</h3>
                                        <p>View saved items</p>
                                    </div>
                                </a>

                              

                                <a href="{{ route('user.change_password') }}" class="action-item">
                                    <div class="action-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div class="action-text">
                                        <h3>Change Password</h3>
                                        <p>Update your account password</p>
                                    </div>
                                </a>

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

       
         

      
        </div>
    </div>

   
@endsection

@section('css')
    <style>
        /* Modern Dashboard Styles */
        /* Import centralized color system */
        @import url('{{ asset("assets/css/colors.css") }}');

        .modern-dashboard-container {
            min-height: 100vh;
            padding-bottom: 2rem;
        }

        /* Welcome Section */
        .welcome-section {
            margin-bottom: 2rem;
        }

        .welcome-card {
            background: var(--accent-color);
            border-radius: var(--border-radius);
            padding: 3rem;
            color: var(--text-light);
            box-shadow: var(--shadow-medium);
            position: relative;
            overflow: hidden;
            border: none;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .welcome-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .welcome-icon {
            font-size: 3.5rem;
            color: var(--text-light);
            background: var(--overlay-light);
            padding: 1.5rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            flex-shrink: 0;
        }

        .welcome-text h1 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .welcome-text p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0 0 1.5rem 0;
        }

        .welcome-stats {
            display: flex;
            gap: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--overlay-light);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            backdrop-filter: blur(5px);
        }

        .stat-item i {
            font-size: 0.9rem;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* Info Sections */
        .info-section,
        .seller-section,
        .addresses-section,
        .payment-section,
        .quick-actions-section {
            margin-bottom: 2rem;
        }

        .info-card,
        .seller-card,
        .addresses-card,
        .payment-card,
        .quick-actions-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            position: relative;
            border: none;
            transition: var(--transition);
        }

        .user-dashboard-modern .info-card:hover,
        .user-dashboard-modern .seller-card:hover,
        .user-dashboard-modern .addresses-card:hover,
        .user-dashboard-modern .payment-card:hover,
        .user-dashboard-modern .quick-actions-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px var(--shadow-medium);
        }

        .user-dashboard-modern .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-dashboard-modern .card-header h2 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-dashboard-modern .card-header h2 i {
            color: var(--accent-color);
        }

        .user-dashboard-modern .card-body {
            padding: 1.5rem;
        }

        /* Info Grid - Scoped */
        .user-dashboard-modern .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.2rem;
        }

        .user-dashboard-modern .info-item {
            background: var(--bg-light);
            border-radius: 10px;
            padding: 1.2rem;
            border: 1px solid var(--border-light);
            transition: var(--transition);
            position: relative;
        }

        .user-dashboard-modern .info-item:hover {
            background: var(--bg-secondary);
            box-shadow: 0 8px 20px var(--shadow-light);
        }

        .user-dashboard-modern .info-item.full-width {
            grid-column: 1 / -1;
        }

        .user-dashboard-modern .info-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .info-label i {
            color: var(--accent-color);
            width: 18px;
            text-align: center;
        }

        .user-dashboard-modern .info-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .user-dashboard-modern .verification-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 50px;
            margin-top: 0.3rem;
        }

        .user-dashboard-modern .verification-badge.verified {
            background: var(--success-light);
            color: var(--success-color);
        }

        .user-dashboard-modern .verification-badge i {
            font-size: 0.8rem;
        }

        .user-dashboard-modern .account-age {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: normal;
            margin-left: 0.5rem;
        }

        .user-dashboard-modern .add-phone-link {
            color: #000000;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            /* transition: var(--transition); */
            font-size: 0.95rem;
        }

        /* .user-dashboard-modern .add-phone-link:hover {
            color: var(--primary-dark);
            transform: translateX(3px);
        } */

        .user-dashboard-modern .btn-edit-profile {
            background: var(--accent-light);
            color: #ffffff;
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

        .user-dashboard-modern .btn-edit-profile:hover {
            background: var(--accent-color);
            color: var(--text-light);
        }

        /* Quick Actions Section - Scoped */
        .user-dashboard-modern .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .user-dashboard-modern .action-item {
            background: var(--bg-secondary);
            border-radius: 10px;
            padding: 1.2rem;
            border: 1px solid var(--border-light);
            transition: var(--transition);
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .user-dashboard-modern .action-item:hover {
            background: var(--bg-light);
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px var(--shadow-primary);
        }

        .user-dashboard-modern .action-icon {
            width: 40px;
            height: 40px;
            background: var(--accent-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: #ffffff;
            font-size: 1.1rem;
        }

        .action-text h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0.3rem;
        }

        .action-text p {
            font-size: 0.85rem;
            color: var(--dark-gray);
            margin: 0;
        }

        /* Seller Section */
        .seller-promo {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 2rem;
            background: var(--bg-light);
            border-radius: var(--border-radius);
            border: 1px solid rgba(1, 153, 154, 0.2);
        }

        .promo-icon {
            font-size: 2.5rem;
            color: var(--accent-color);
            background: white;
            padding: 1.5rem;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(59, 183, 126, 0.2);
            flex-shrink: 0;
        }

        .promo-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .promo-content p {
            color: var(--dark-gray);
            margin-bottom: 1.5rem;
        }

        .seller-benefits {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--secondary-color);
        }

        .benefit-item i {
            color: var(--accent-color);
        }

        .btn-become-seller {
            background: var(--accent-color);
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .btn-become-seller:hover {
            background: var(--accent-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(1, 153, 154, 0.3);
        }

        .shop-status {
            display: flex;
            align-items: center;
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .status-badge.active {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .seller-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            border: 1px solid var(--medium-gray);
            text-align: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(59, 183, 126, 0.1);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            background: rgba(59, 183, 126, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .stat-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0.2rem;
        }

        .stat-content p {
            font-size: 0.85rem;
            color: var(--dark-gray);
            margin: 0;
        }

        .addresses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.2rem;
        }

        .address-card {
            background: white;
            border-radius: 10px;
            padding: 1.2rem;
            border: 1px solid var(--medium-gray);
            transition: var(--transition);
            position: relative;
        }

        .address-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            transform: translateY(-3px);
        }

        .address-card.default-address {
            border: 2px solid var(--primary-color);
            background: rgba(1, 153, 154, 0.03);
        }

        .address-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--medium-gray);
        }

        .address-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .address-number {
            font-weight: 700;
            color: var(--secondary-color);
            font-size: 0.95rem;
        }

        .default-badge {
            background: rgba(1, 153, 154, 0.1);
            color: var(--primary-color);
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 50px;
            font-weight: 600;
        }

        .address-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-set-default,
        .btn-edit,
        .btn-delete {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .btn-set-default {
            background: rgba(255, 193, 7, 0.1);
            color: var(--rating-color);
        }

        .btn-set-default:hover {
            background: var(--rating-color);
            color: white;
        }

        .btn-edit {
            background: rgba(59, 183, 126, 0.1);
            color: var(--primary-color);
        }

        .btn-edit:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-delete {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        .btn-delete:hover {
            background: var(--danger-color);
            color: white;
        }

        .address-details p {
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
            font-size: 0.9rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .address-details p i {
            color: var(--dark-gray);
            font-size: 0.8rem;
            margin-top: 0.2rem;
        }

        .address-name {
            font-size: 1rem !important;
            margin-bottom: 0.8rem !important;
        }

        .no-addresses {
            text-align: center;
            padding: 3rem 2rem;
        }

        .no-addresses-icon {
            font-size: 3rem;
            color: var(--dark-gray);
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .no-addresses h3 {
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .no-addresses p {
            color: var(--dark-gray);
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .btn-add-first-address {
            background:var(--accent-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-add-first-address:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 183, 126, 0.3);
        }

        /* Payment Section */
        .add-card-section {
            margin-bottom: 2rem;
        }

        .add-card-form {
            background: var(--light-gray);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            border: 1px solid var(--medium-gray);
        }

        .form-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-header h3 i {
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
        }

        .card-element-container {
            margin-bottom: 1.5rem;
        }

        .card-element-container label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
        }

        #card-element {
            padding: 1rem;
            border: 2px solid var(--medium-gray);
            border-radius: 8px;
            background: white;
            transition: var(--transition);
        }

        #card-element:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 183, 126, 0.1);
        }

        .existing-cards h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.2rem;
        }

        .card-item {
            background: white;
            border-radius: 10px;
            padding: 1.2rem;
            border: 1px solid var(--medium-gray);
            transition: var(--transition);
        }

        .card-item:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            transform: translateY(-3px);
        }

        .card-item.default-card {
            border: 2px solid var(--primary-color);
            background: rgba(59, 183, 126, 0.03);
        }

        .card-header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--medium-gray);
        }

        .card-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            color: var(--secondary-color);
        }

        .brand-icon {
            font-size: 1.8rem;
        }

        .fa-cc-visa {
            color: var(--text-dark);
        }

        .fa-cc-mastercard {
            color: var(--error-color);
        }

        .fa-cc-amex {
            color: var(--accent-color);
        }

        .fa-cc-discover {
            color: var(--accent-color);
        }

        .card-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-remove-card {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            cursor: pointer;
            font-size: 0.8rem;
        }

        .btn-remove-card:hover {
            background: var(--danger-color);
            color: white;
        }

        .card-body-info {
            color: var(--secondary-color);
        }

        .card-number {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-details {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--dark-gray);
        }

        .no-cards {
            text-align: center;
            padding: 3rem 2rem;
        }

        .no-cards-icon {
            font-size: 3rem;
            color: var(--dark-gray);
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .no-cards h3 {
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .no-cards p {
            color: var(--dark-gray);
            font-size: 0.95rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin-top: 1.5rem;
        }

        .btn-update,
        .btn-view-products,
        .btn-view-orders {
            background: rgba(59, 183, 126, 0.1);
            color: var(--primary-color);
            text-decoration: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
        }

        .btn-update:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-view-products {
            background: rgba(23, 162, 184, 0.1);
            color: var(--info-color);
        }

        .btn-view-products:hover {
            background: var(--info-color);
            color: white;
        }

        .btn-view-orders {
            background: rgba(108, 117, 125, 0.1);
            color: var(--dark-gray);
        }

        .btn-view-orders:hover {
            background: var(--dark-gray);
            color: white;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            color: white;
        }

        .modal-title i {
            font-size: 1.2rem;
        }

        .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-control {
            border: 2px solid var(--medium-gray);
            border-radius: 8px;
            padding: 0.65rem 1rem;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 183, 126, 0.1);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .modal-footer {
            border-top: 1px solid var(--medium-gray);
            padding: 1.2rem 1.5rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .welcome-card {
                padding: 2rem;
            }

            .welcome-text h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .seller-promo {
                flex-direction: column;
                text-align: center;
            }

            .promo-icon {
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .welcome-content {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .welcome-stats {
                justify-content: center;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .addresses-grid,
            .cards-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .welcome-text h1 {
                font-size: 1.8rem;
            }

            .welcome-stats {
                flex-direction: column;
                align-items: center;
                gap: 0.8rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .seller-stats {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-update,
            .btn-view-products,
            .btn-view-orders {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection



@section('js')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe("{{ Settings::setting('stripe_key') }}");

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                if (error?.setupIntent) {
                    document.getElementById('paymentmethod').value = error.setupIntent.payment_method
                    toastr.success('Card added');
                } else {
                    toastr.error('Something went wrong. Try again letter');
                }

            } else {
                document.getElementById('paymentmethod').value = setupIntent.payment_method
                toastr.success('Card added');
                $('#cardAddFrom').submit();
            }
        });
    </script>
@endsection
