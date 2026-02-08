<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Skill Barter System</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="page-center">

    <div class="auth-card">
        <div class="card-left">
            <img src="{{ asset('Images/login.avif') }}" alt="Skill Barter">
        </div>

        <div class="card-right">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2>Login</h2>
                <input type="email" name="email" placeholder="Email"
                       value="{{ old('email') }}" required>
                @error('email') <small class="error">{{ $message }}</small> @enderror <!-- Improved login error handling -->
                <input type="password" name="password" placeholder="Password" required>
                @error('password') <small class="error">{{ $message }}</small> @enderror
                <div class="remember">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember Me</label>
                </div>
                <button type="submit">Login</button>
                <div class="links">
                    <a href="{{ route('password.request') }}">Forgot Password?</a><br>
                    <a href="{{ route('register') }}">Create Account</a>
                </div>
            </form>
        </div>

    </div>

</div>

</body>
</html>
