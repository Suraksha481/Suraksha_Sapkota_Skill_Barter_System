<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Skill Barter System</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="page-center">
    <div class="auth-card">
        <div class="card-left">
            <img src="{{ asset('Images/register.webp') }}" alt="Skill Barter">
        </div>
        <div class="card-right">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h2>Create Account</h2>
                <input type="text" name="name" placeholder="Full Name"
                       value="{{ old('name') }}" required>
                @error('name') <small class="error">{{ $message }}</small> @enderror

                <input type="email" name="email" placeholder="Email"
                       value="{{ old('email') }}" required>
                @error('email') <small class="error">{{ $message }}</small> @enderror

                <input type="password" name="password" placeholder="Password" required>
                @error('password') <small class="error">{{ $message }}</small> @enderror

                <input type="password" name="password_confirmation"
                       placeholder="Confirm Password" required>

                <button type="submit">Register</button>
                <div class="links">
                    <a href="{{ route('login') }}">Already have an account?</a>
                </div>
            </form>
        </div>

    </div>

</div>

</body>
</html>
