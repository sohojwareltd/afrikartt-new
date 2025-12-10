@extends('layouts.app')

@section('content')
    <style>
        .error-404-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f0e8 100%);
            padding: 2rem 1rem;
        }

        .error-404-container {
            max-width: 600px;
            width: 100%;
        }

        .error-404-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(26, 107, 60, 0.08);
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .error-404-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            /* background: #f68b1e; */
            pointer-events: none;
        }

        .error-number {
            font-size: 120px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 1rem;
            background: #f68b1e;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            text-shadow: 0 10px 30px rgba(26, 107, 60, 0.1);
        }

        .error-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            position: relative;
        }

        .error-icon svg {
            width: 100%;
            height: 100%;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .error-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2e2e2e;
            margin-bottom: 1rem;
        }

        .error-description {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }

        .error-search-form {
            margin-bottom: 2rem;
            max-width: 450px;
            margin-left: auto;
            margin-right: auto;
        }

        .error-search-input {
            display: flex;
            gap: 0.5rem;
            border: 2px solid #e0e6d9;
            border-radius: 50px;
            padding: 0.5rem;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .error-search-input:focus-within {
            border-color: #f68b1e;
            background: white;
            box-shadow: 0 4px 12px rgba(26, 107, 60, 0.1);
        }

        .error-search-input input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            outline: none;
        }

        .error-search-btn {
            background: #f68b1e;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .error-search-btn:hover {
            background: #f68b1e;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(246, 139, 30, 0.3);
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .error-btn {
            padding: 0.875rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .error-btn-primary {
            background: #f68b1e;
            color: white;
            border: 2px solid #f68b1e;
        }

        .error-btn-primary:hover {
            background: #f68b1e;
            border-color: #f68b1e;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(246, 139, 30, 0.3);
            color: white;
        }

        .error-btn-secondary {
            background: white;
            color: #f68b1e;
            border: 2px solid #f68b1e;
        }

        .error-btn-secondary:hover {
            background: #f68b1e;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(246, 139, 30, 0.2);
        }

        .error-help-links {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid #e0e6d9;
        }

        .error-help-title {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .error-help-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
        }

        .error-help-link {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            text-decoration: none;
            color: #2e2e2e;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .error-help-link:hover {
            background: #f68b1e;
            color: white;
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(246, 139, 30, 0.2);
        }

        .error-help-link svg {
            width: 28px;
            height: 28px;
        }

        .error-help-link span {
            font-size: 0.875rem;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .error-number {
                font-size: 80px;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .error-description {
                font-size: 1rem;
            }

            .error-404-card {
                padding: 2rem 1.5rem;
            }

            .error-actions {
                flex-direction: column;
            }

            .error-btn {
                width: 100%;
                justify-content: center;
            }

            .error-search-input {
                flex-direction: column;
            }

            .error-search-btn {
                justify-content: center;
            }
        }
    </style>

    <div class="error-404-wrapper">
        <div class="error-404-container">
            <div class="error-404-card">
                <div class="error-icon">
                    <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="80" fill="#f0f4ee" stroke="#1a6b3c" stroke-width="4" />
                        <path d="M70 80C70 80 75 70 85 70C95 70 100 80 100 80" stroke="#1a6b3c" stroke-width="4"
                            stroke-linecap="round" />
                        <path d="M100 80C100 80 105 70 115 70C125 70 130 80 130 80" stroke="#1a6b3c" stroke-width="4"
                            stroke-linecap="round" />
                        <circle cx="85" cy="85" r="4" fill="#1a6b3c" />
                        <circle cx="115" cy="85" r="4" fill="#1a6b3c" />
                        <path d="M70 120C70 120 80 110 100 110C120 110 130 120 130 120" stroke="#1a6b3c" stroke-width="4"
                            stroke-linecap="round" />
                    </svg>
                </div>

                <div class="error-number">404</div>
                <h1 class="error-title">Oops! Page Not Found</h1>
                <p class="error-description">
                    The page you're looking for seems to have wandered off. Let's help you find what you need.
                </p>

                <form action="{{ route('shops') }}" method="GET" class="error-search-form">
                    <div class="error-search-input">
                        <input type="text" name="search" placeholder="Search for products..." autocomplete="off" />
                        <button type="submit" class="error-search-btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <path d="M21 21l-4.35-4.35" />
                            </svg>
                            Search
                        </button>
                    </div>
                </form>

                <div class="error-actions">
                    <a href="{{ url('/') }}" class="error-btn error-btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            <path d="M9 22V12h6v10" />
                        </svg>
                        Back to Home
                    </a>
                    <button onclick="history.back()" class="error-btn error-btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7" />
                        </svg>
                        Go Back
                    </button>
                </div>

                <div class="error-help-links">
                    <div class="error-help-title">Quick Links</div>
                    <div class="error-help-grid">
                        <a href="{{ route('shops') }}" class="error-help-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                            <span>Products</span>
                        </a>
                        <a href="{{ route('vendors') }}" class="error-help-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                <path d="M9 22V12h6v10" />
                            </svg>
                            <span>Shops</span>
                        </a>
                        
                        <a href="{{ route('contact') }}" class="error-help-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                            </svg>
                            <span>Contact</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
