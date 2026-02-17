<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verified | SkillXchange</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .success-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .success-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            padding: 60px 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            background: #1a1a1a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: white;
        }

        .success-card h1 {
            color: #1a1a1a;
            margin: 0 0 15px 0;
            font-size: 28px;
        }

        .success-card p {
            color: #666;
            margin: 0 0 30px 0;
            font-size: 16px;
            line-height: 1.6;
        }

        .success-card a {
            display: inline-block;
            background: #1a1a1a;
            color: white;
            padding: 12px 40px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: 1.5px solid #d4d4db;
        }

        .success-card a:hover {
            background: #0d0d99;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(21, 21, 230, 0.3);
        }

        .checkmark {
            animation: checkmark-animation 0.8s ease-in-out;
        }

        @keyframes checkmark-animation {
            0% { transform: scale(0) rotate(-45deg); opacity: 0; }
            50% { transform: scale(1.2) rotate(0deg); }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <div class="success-icon checkmark">✓</div>
            <h1>Email Verified!</h1>
            <p>Congratulations! Your email has been verified successfully. You can now login to your SkillXchange account and start exchanging skills with others.</p>
            <a href="{{ route('login') }}">Go to Login</a>
        </div>
    </div>
</body>
</html>
