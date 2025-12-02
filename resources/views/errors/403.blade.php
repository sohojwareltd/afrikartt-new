<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Forbidden</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .error-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            padding: 60px 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .icon-wrapper {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: #f68b1e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(246, 139, 30, 0.3);
        }

        .icon-wrapper svg {
            width: 60px;
            height: 60px;
        }

        .error-code {
            font-size: 72px;
            font-weight: 700;
            color: #f68b1e;
            margin-bottom: 15px;
            line-height: 1;
        }

        .error-title {
            font-size: 24px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 15px;
        }

        .error-message {
            font-size: 16px;
            color: #718096;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .home-button {
            display: inline-block;
            background: #f68b1e;
            color: white;
            padding: 16px 48px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26, 107, 60, 0.3);
        }

        .home-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 107, 60, 0.4);
        }

        @media (max-width: 600px) {
            .error-container {
                padding: 40px 30px;
            }

            .error-code {
                font-size: 56px;
            }

            .error-title {
                font-size: 20px;
            }

            .error-message {
                font-size: 14px;
            }

            .icon-wrapper {
                width: 100px;
                height: 100px;
            }

            .icon-wrapper svg {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="icon-wrapper">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
        </div>

        <div class="error-code">403</div>
        <h1 class="error-title">Access Forbidden</h1>
        <p class="error-message">
            You don't have permission to access this resource.
        </p>

        <a href="{{ url('/') }}" class="home-button">Go to Homepage</a>
    </div>
</body>

</html>
