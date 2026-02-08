<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Skill Barter System</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="page-center">

    <div class="auth-card">

        <!-- LEFT IMAGE -->
        <div class="card-left">
            <img src="{{ asset('images/login-image.png') }}" alt="Skill Barter">
        </div>

        <!-- RIGHT FORM -->
        <div class="card-right">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <h2>Forgot Password?</h2>
                <p class="info-text">
                    Enter your email address and we will send you a password reset link.
                </p>

                <!-- Success Message -->
                @if (session('status'))
                    <p class="success">{{ session('status') }}</p>
                @endif

                <!-- Email Input -->
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>

                @error('email')
                    <small class="error">{{ $message }}</small>
                @enderror

                <button type="submit">Send Password Reset Link</button>

                <div class="links">
                    <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </form>
        </div>

    </div>

</div>

</body>
</html>
