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
            width: 800px;
            max-width: 90%;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(32, 166, 138, 0.08);
            border: 1px solid var(--primary-teal-light);
            margin: 0 auto;
        }

        .verify-code-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-teal), var(--primary-teal-dark));
            padding: 50px 30px;
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
            color: var(--text-slate);
            font-size: 26px;
            font-weight: 800;
        }

        .verify-code-right .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .verify-code-right .info-text {
            background: var(--primary-teal-light);
            padding: 12px 15px;
            border-left: 4px solid var(--primary-teal);
            margin-bottom: 25px;
            border-radius: 8px;
            font-size: 13.5px;
            color: var(--text-slate);
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
            padding: 14px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 20px;
            text-align: center;
            letter-spacing: 12px;
            font-weight: bold;
            color: var(--text-slate);
            transition: all 0.3s;
        }

        .code-input-group input:focus {
            outline: none;
            border-color: var(--primary-teal);
            box-shadow: 0 0 0 4px rgba(32, 166, 138, 0.15);
        }

        .code-input-group input::placeholder {
            letter-spacing: 0;
            opacity: 0.5;
        }

        .verify-code-right button {
            width: 100%;
            padding: 14px;
            background: var(--primary-teal);
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 10px;
        }

        .verify-code-right button:hover {
            background: var(--primary-teal-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(32, 166, 138, 0.3);
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
            color: var(--primary-teal);
            border: 2px solid var(--primary-teal);
            padding: 10px 24px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 14.5px;
            font-weight: 600;
            transition: all 0.3s;
            width: auto;
            margin-top: 0;
            display: inline-block;
        }

        .resend-btn:hover {
            background: var(--primary-teal);
            color: white;
            box-shadow: 0 4px 15px rgba(32, 166, 138, 0.2);
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
            <div class="verification-header">
            <h3>Verify Your Email</h3>
            <p>We've sent a 6-digit verification code to <strong style="color: var(--text-slate);">{{ auth()->user()->email }}</strong>.</p>
        </div>

            <!-- Right Section -->
            <div class="verify-code-right">
                <h2>Enter Code</h2>
                <p class="subtitle">Check your inbox for the verification code sent to <strong>{{ $user->email }}</strong></p>

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

                    @unless(session('pending_registration'))
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                    @endunless

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
                        @unless(session('pending_registration'))
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                        @endunless
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
