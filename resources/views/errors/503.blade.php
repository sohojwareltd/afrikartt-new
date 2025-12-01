<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Under Construction</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            text-align: center;
            color: white;
            padding: 20px;
        }

        .container {
            max-width: 450px;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            color: #333;
        }

        h1 {
            font-size: 3.5rem;
            margin: 0 0 0.5rem 0;
            color: #e32845;
            font-weight: 700;
        }

        h2 {
            font-size: 1.6rem;
            margin: 0 0 1rem 0;
            color: #2d3748;
            font-weight: 600;
        }

        p {
            font-size: 1rem;
            color: #64748b;
            line-height: 1.5;
            margin: 0 0 1.5rem 0;
        }

        .emoji {
            font-size: 3rem;
            margin: 0 0 1rem 0;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-12px);
            }

            60% {
                transform: translateY(-6px);
            }
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #5a6fd8;
            transform: translateY(-3px);
        }

        .funny-card {
            background: #fce4ec;
            color: #e32845;
            border-radius: 12px;
            padding: 12px 20px;
            margin-bottom: 1.5rem;
            font-style: italic;
            font-weight: 500;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="emoji">🛠️🛒</div>
        <h1>503</h1>
        <h2>Our Shop is Under Construction</h2>
        <p>We are organizing products, polishing the digital shelves, and making shopping even more fun for you!</p>

       

        <a href="{{ url('/') }}" class="btn">Back to Home</a>
    </div>
</body>

</html>
