<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email | SkillBarter</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <style>
        :root {
            --primary-teal: #20a68a;
            --primary-teal-dark: #17826a;
            --primary-teal-light: #e6f5f2;
            --text-slate: #1e293b;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .premium-verify-card {
            display: flex;
            width: 1000px;
            max-width: 95%;
            min-height: 640px;
            height: auto;
            background: #fff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(32, 166, 138, 0.12);
            border: 1px solid rgba(32, 166, 138, 0.1);
            margin: 20px;
        }

        /* Branding Side */
        .verify-visual {
            flex: 0 0 45%;
            background: linear-gradient(135deg, var(--primary-teal), var(--primary-teal-dark));
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .verify-visual::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 86c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm66 3c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm-46-45c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm40 24c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd' /%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .icon-box {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .verify-visual h1 {
            font-size: 32px;
            margin: 0 0 15px 0;
            font-weight: 800;
        }

        .verify-visual p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
            max-width: 300px;
        }

        /* Form Side */
        .verify-form-area {
            flex: 1;
            padding: 60px 60px 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-header h2 {
            font-size: 28px;
            color: var(--text-slate);
            margin: 0 0 10px 0;
            font-weight: 800;
        }

        .form-header p {
            color: #64748b;
            font-size: 15px;
            line-height: 1.5;
        }

        .code-display {
            background: var(--primary-teal-light);
            padding: 12px 20px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--primary-teal-dark);
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .code-grid {
            margin-bottom: 30px;
        }

        .code-grid label {
            display: block;
            margin-bottom: 12px;
            font-weight: 700;
            color: var(--text-slate);
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .code-input-wrapper {
            position: relative;
         color: #373636ff;
        }

        .main-code-input {
            width: 100%;
            height: 60px;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            text-align: center;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 15px;
            color: var(--text-slate);
            transition: all 0.3s;
            background: #fdfdfd;
        }

        .main-code-input:focus {
            outline: none;
            border-color: var(--primary-teal);
            box-shadow: 0 0 0 5px rgba(61, 67, 66, 0.1);
            background: #fff;
        }

        .btn-verify {
            width: 100%;
            padding: 16px;
            background: var(--primary-teal);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(32, 166, 138, 0.25);
        }

        .resend-box {
            margin-top: 30px;
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid #f1f5f9;
        }

        .resend-box p {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 15px;
        }

        .btn-resend {
            background: white;
            color: var(--primary-teal);
            border: 2px solid var(--primary-teal);
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }

        .main-code-input::placeholder {
            font-size: 18px;
            color: #cbd5e1;
            letter-spacing: 2px;
            font-weight: 400;
        }

    

        .error-toast {
            background: #fff1f2;
            color: #e11d48;
            padding: 12px 16px;
            border-radius: 12px;
            border-left: 4px solid #e11d48;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .success-toast {
            background: #f0fdf4;
            color: #16a34a;
            padding: 12px 16px;
            border-radius: 12px;
            border-left: 4px solid #16a34a;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (max-width: 900px) {
            .premium-verify-card {
                flex-direction: column;
                height: auto;
                width: 500px;
            }
            .verify-visual {
                padding: 40px;
            }
            .verify-form-area {
                padding: 40px;
            }
            .icon-box {
                width: 80px; height: 80px; font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <div class="premium-verify-card">
        <!-- Visual Brand Side -->
        <div class="verify-visual">
            <div class="icon-box">
                <i class="fas fa-shield-halved"></i>
            </div>
            <h1>Secure Your Access</h1>
            <p>One final step to join the SkillBarter community. Verify your identity to protect your account and start trading skills.</p>
        </div>

        <!-- Form Side -->
        <div class="verify-form-area">
            <div class="form-header">
                <h2>Verify Email</h2>
                <p>We've sent a unique 6-digit code to your inbox to ensure your account security.</p>
                <div style="margin-top: 10px; font-size: 13px; color: #ef4444; font-weight: 600;">
                    <i class="fas fa-clock"></i> Code expires in 2 minutes
                </div>
            </div>

            <div class="code-display">
                <i class="fas fa-envelope"></i>
                <span>{{ $user->email }}</span>
            </div>

            @if ($errors->any())
                <div class="error-toast">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="success-toast">
                    <i class="fas fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('verify-email-code.verify') }}">
                @csrf
                @unless(session('pending_registration'))
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                @endunless

                <div class="code-grid">
                    <label for="code">Enter 6-Digit Code</label>
                    <div class="code-input-wrapper">
                        <input
                            type="text"
                            id="code"
                            name="code"
                            class="main-code-input"
                            placeholder="000000"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            required
                            autocomplete="off"
                            value="{{ old('code') }}"
                            autofocus
                        >
                    </div>
                </div>

                <button type="submit" class="btn-verify">Complete Verification</button>
            </form>

            <div class="resend-box">
                <p>Didn't receive a code? Please check your spam folder or request a new one.</p>
                <form method="POST" action="{{ route('verify-email-code.resend') }}">
                    @csrf
                    @unless(session('pending_registration'))
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                    @endunless
                    <button type="submit" class="btn-resend">Resend New Code</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
