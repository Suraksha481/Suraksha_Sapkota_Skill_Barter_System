<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email | SkillXchange</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .verify-code-card {
            display: flex;
            width: 700px;
            max-width: 90%;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            margin: 0 auto;
        }

        .verify-code-left {
            flex: 1;
            background: linear-gradient(135deg, #1a1a1a, #333333);
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .verify-code-left h1 {
            margin: 0 0 15px 0;
            font-size: 28px;
        }

        .verify-code-left p {
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
            opacity: 0.95;
        }

        .code-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 20px;
        }

        .verify-code-right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .verify-code-right h2 {
            text-align: center;
            margin: 0 0 10px 0;
            color: #1a1a1a;
            font-size: 24px;
        }

        .verify-code-right .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .verify-code-right .info-text {
            background: #f0f4ff;
            padding: 12px 15px;
            border-left: 4px solid #1a1a1a;
            margin-bottom: 25px;
            border-radius: 4px;
            font-size: 13px;
            color: #333;
        }

        .code-input-group {
            margin-bottom: 25px;
        }

        .code-input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .code-input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 18px;
            text-align: center;
            letter-spacing: 8px;
            font-weight: bold;
            transition: border-color 0.3s;
        }

        .code-input-group input:focus {
            outline: none;
            border-color: #1a1a1a;
        }

        .code-input-group input::placeholder {
            letter-spacing: 0;
            opacity: 0.5;
        }

        .verify-code-right button {
            width: 100%;
            padding: 12px;
            background: #1a1a1a;
            border: 2px solid #1a1a1a;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .verify-code-right button:hover {
            background: #0d0d99;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(21, 21, 230, 0.3);
        }

        .resend-section {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0;
        }

        .resend-text {
            color: #666;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .resend-btn {
            background: transparent;
            color: #1a1a1a;
            border: 2px solid #1a1a1a;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            width: auto;
            margin-top: 0;
        }

        .resend-btn:hover {
            background: #1a1a1a;
            color: white;
        }

        .error-message {
            background: #fee;
            color: #c00;
            padding: 12px 15px;
            border-left: 4px solid #c00;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .success-message {
            background: #efe;
            color: #0a0;
            padding: 12px 15px;
            border-left: 4px solid #0a0;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .timer {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .verify-code-card {
                flex-direction: column;
                width: 100%;
            }

            .verify-code-left {
                padding: 30px 20px;
                min-height: 200px;
            }

            .verify-code-right {
                padding: 30px 20px;
            }

            .code-input-group input {
                letter-spacing: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="page-center">
        <div class="verify-code-card">
            <!-- Left Section -->
            <div class="verify-code-left">
                <div class="code-icon">📧</div>
                <h1>Verify Email</h1>
                <p>We've sent a 6-digit code to your email address. Please enter it below to complete your registration.</p>
            </div>

            <!-- Right Section -->
            <div class="verify-code-right">
                <h2>Enter Code</h2>
                <p class="subtitle">Check your inbox for the verification code</p>

                @if ($errors->any())
                    <div class="error-message">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verify-email-code.verify') }}">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="code-input-group">
                        <label for="code">Verification Code</label>
                        <input
                            type="text"
                            id="code"
                            name="code"
                            placeholder="000000"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            required
                            autocomplete="off"
                            value="{{ old('code') }}"
                        >
                    </div>

                    <button type="submit">Verify Email</button>
                </form>

                <div class="resend-section">
                    <p class="resend-text">Didn't receive the code?</p>
                    <form method="POST" action="{{ route('verify-email-code.resend') }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button type="submit" class="resend-btn">Resend Code</button>
                    </form>
                </div>

                <div class="timer">
                    ⏱️ Code expires in 10 minutes
                </div>
            </div>
        </div>
    </div>
</body>
</html>
