<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email | SkillXchange</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        .verification-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            padding: 40px;
            text-align: center;
        }
        .verification-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }
        h1 {
            color: #333;
            margin: 20px 0 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 20px;
            font-size: 16px;
            line-height: 1.6;
        }
        .email-highlight {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 600;
            color: #667eea;
        }
        .instructions {
            background: #f9f9f9;
            padding: 20px;
            border-left: 4px solid #667eea;
            margin: 20px 0;
            text-align: left;
            border-radius: 5px;
        }
        .instructions h3 {
            margin-top: 0;
            color: #333;
        }
        .instructions ol {
            padding-left: 20px;
            color: #555;
        }
        .instructions li {
            margin-bottom: 10px;
        }
        .action-buttons {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #ddd;
            color: #333;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn-secondary:hover {
            background: #ccc;
        }
        .resend-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .resend-text {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .spam-note {
            color: #999;
            font-size: 12px;
            margin-top: 15px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <div class="verification-icon">✉️</div>
        <h1>Verify Your Email</h1>
        <p class="subtitle">Thank you for signing up! Your registration is almost complete.</p>

        <div class="email-highlight">
            We've sent a verification link to your email
        </div>

        <div class="instructions">
            <h3>What's Next?</h3>
            <ol>
                <li>Check your email inbox for a message from SkillXchange</li>
                <li>Click the verification link in the email</li>
                <li>Return here and log in with your credentials</li>
            </ol>
        </div>

        <p class="spam-note">💡 Tip: If you don't see the email, check your spam or junk folder.</p>

        <div class="action-buttons">
            <a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>
        </div>

        <div class="resend-section">
            <p class="resend-text">Didn't receive the email?</p>
            <a href="{{ route('password.request') }}" class="btn btn-secondary">Request a New Link</a>
        </div>
    </div>
</body>
</html>
