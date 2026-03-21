<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – SkillSwap</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal:        #20a68a;
            --teal-dark:   #157e6a;
            --teal-darker: #0e5e4e;
            --teal-light:  #e9f7f4;
            --text-dark:   #1a2332;
            --text-muted:  #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f8fafc;
            overflow-x: hidden;
        }

        /* ====== LEFT PANEL ====== */
        .left-panel {
            width: 55%;
            position: relative;
            background: linear-gradient(145deg, var(--teal-darker) 0%, var(--teal-dark) 40%, var(--teal) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            overflow: hidden;
            padding: 50px;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(0,0,0,0.15) 0%, transparent 60%);
        }

        /* Hero image fills the panel */
        .panel-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.35;
            mix-blend-mode: luminosity;
        }

        /* Floating decorative cards */
        .float-card {
            position: absolute;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 16px;
            padding: 16px 20px;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: float 6s ease-in-out infinite;
        }
        .float-card:nth-child(2) { animation-delay: -2s; }
        .float-card:nth-child(3) { animation-delay: -4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-12px); }
        }

        .fc-1 { top: 15%;  left: 8%;  }
        .fc-2 { top: 42%;  right: 8%; }
        .fc-3 { top: 65%;  left: 12%; }

        .fc-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
        }

        /* Panel bottom text */
        .panel-footer {
            position: relative;
            z-index: 10;
            color: #fff;
        }
        .panel-footer .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 50px;
            padding: 8px 18px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 28px;
        }
        .panel-footer h2 {
            font-size: 2.8rem;
            font-weight: 900;
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 16px;
        }
        .panel-footer p {
            font-size: 1.05rem;
            opacity: 0.75;
            line-height: 1.6;
            max-width: 420px;
        }

        /* Stats row */
        .stats-row {
            display: flex;
            gap: 30px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.15);
        }
        .stat-item { color: #fff; }
        .stat-item .num { font-size: 1.8rem; font-weight: 900; display: block; }
        .stat-item .lbl { font-size: 0.8rem; opacity: 0.65; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }

        /* ====== RIGHT PANEL ====== */
        .right-panel {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            background: #fff;
        }

        .login-box { width: 100%; max-width: 400px; }

        /* Admin badge */
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--teal-light);
            color: var(--teal-dark);
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 28px;
        }
        .admin-badge::before {
            content: '';
            width: 8px; height: 8px;
            background: var(--teal);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(1.4); }
        }

        .login-box h1 {
            font-size: 2.4rem;
            font-weight: 900;
            color: var(--text-dark);
            letter-spacing: -1.5px;
            line-height: 1.2;
            margin-bottom: 10px;
        }
        .login-box .subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 45px;
        }

        /* Error alert */
        .alert-error {
            background: #fff5f5;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 28px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form field */
        .field { position: relative; margin-bottom: 22px; }
        .field label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            letter-spacing: 0.2px;
        }
        .field input {
            width: 100%;
            padding: 16px 20px;
            border-radius: 14px;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            font-size: 1rem;
            color: var(--text-dark);
            font-family: inherit;
            transition: all 0.2s;
            outline: none;
        }
        /* Hide the browser's built-in password-reveal eye (Edge / Chrome / IE) */
        .field input[type='password']::-ms-reveal,
        .field input[type='password']::-ms-clear,
        .field input[type='password']::-webkit-contacts-auto-fill-button,
        .field input[type='password']::-webkit-credentials-auto-fill-button {
            display: none !important;
            visibility: hidden;
            pointer-events: none;
        }
        /* Lighter, more subtle placeholder */
        .field input::placeholder {
            color: #b0bec5;
            font-weight: 400;
        }
        .field input:focus {
            border-color: var(--teal);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(32,166,138,0.1);
        }
        .field .field-icon {
            position: absolute;
            bottom: 16px;
            left: 17px;
            color: #94a3b8;
            font-size: 1.1rem;
            pointer-events: none;
            transition: color 0.2s;
        }
        .field input:focus + .field-icon,
        .field input:focus ~ .field-icon { color: var(--teal); }

        /* toggle password */
        .toggle-pw {
            position: absolute;
            bottom: 14px;
            right: 14px;
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            font-size: 1.15rem;
            padding: 4px;
            line-height: 1;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: var(--teal); }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 17px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal-dark) 100%);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }
        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--teal-dark) 0%, var(--teal-darker) 100%);
            opacity: 0;
            transition: opacity 0.25s;
        }
        .btn-login:hover::before { opacity: 1; }
        .btn-login span { position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(32,166,138,0.35); }
        .btn-login:active { transform: translateY(0); }

        /* Footer note */
        .login-footer-note {
            text-align: center;
            margin-top: 36px;
            font-size: 0.85rem;
            color: #94a3b8;
        }
        .login-footer-note a {
            color: var(--teal);
            font-weight: 700;
            text-decoration: none;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 28px 0;
            color: #cbd5e1;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        @media (max-width: 900px) {
            .left-panel  { display: none; }
            .right-panel { width: 100%; padding: 40px 30px; }
        }
    </style>
</head>
<body>

    <!-- ===== LEFT DECORATIVE PANEL ===== -->
    <div class="left-panel">
        <img src="{{ asset('images/admin/login_hero.png') }}" alt="Admin Panel" class="panel-image">

        <!-- Floating cards -->
        <div class="float-card fc-1">
            <div class="fc-icon">👥</div>
            <div>
                <div style="font-size:1.1rem; font-weight:800;">2,400+</div>
                <div style="opacity:0.75; font-size:0.75rem;">Active Users</div>
            </div>
        </div>
        <div class="float-card fc-2">
            <div class="fc-icon">📚</div>
            <div>
                <div style="font-size:1.1rem; font-weight:800;">180+</div>
                <div style="opacity:0.75; font-size:0.75rem;">Skills Listed</div>
            </div>
        </div>
        <div class="float-card fc-3">
            <div class="fc-icon">✅</div>
            <div>
                <div style="font-size:1.1rem; font-weight:800;">98%</div>
                <div style="opacity:0.75; font-size:0.75rem;">Session Success</div>
            </div>
        </div>

        <!-- Footer text -->
        <div class="panel-footer">
            <div class="brand">
                🛡️ &nbsp;SkillBarter Admin Portal
            </div>
            <h2>Control.<br>Manage.<br>Empower.</h2>
            <p>Access the full suite of administrative tools to manage users, skills, sessions, and platform growth.</p>

            <div class="stats-row">
                <div class="stat-item"><span class="num">50+</span><span class="lbl">Skills</span></div>
                <div class="stat-item"><span class="num">1.2k</span><span class="lbl">Sessions</span></div>
                <div class="stat-item"><span class="num">340+</span><span class="lbl">Teachers</span></div>
            </div>
        </div>
    </div>

    <!-- ===== RIGHT LOGIN PANEL ===== -->
    <div class="right-panel">
        <div class="login-box">
            <div class="admin-badge">Admin Access</div>
            <h1>Welcome<br>Back, Admin.</h1>
            <p class="subtitle">Sign in to access the management dashboard.</p>

            @if($errors->any())
            <div class="alert-error">
                <span>⚠️</span>
                {{ $errors->first() }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert-error">
                <span>⚠️</span>
                {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                <div class="field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="Enter Your Email"
                           required autocomplete="email">

                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="Enter your password"
                           required autocomplete="current-password">

                    <button type="button" class="toggle-pw" onclick="togglePw()" title="Show/hide password">👁</button>
                </div>

                <button type="submit" class="btn-login">
                    <span>
                        Sign In to Dashboard
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></svg>
                    </span>
                </button>
            </form>

            <div class="divider">Secure access only</div>


        </div>
    </div>

   
</body>
</html>
