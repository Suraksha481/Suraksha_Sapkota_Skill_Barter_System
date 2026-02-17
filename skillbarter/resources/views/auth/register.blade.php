<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Skill Barter System</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .roles-selection {
            margin: 20px 0;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 8px;
        }

        .roles-selection label {
            display: flex;
            align-items: center;
            margin: 10px 0;
            cursor: pointer;
            font-weight: 500;
        }

        .roles-selection input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            cursor: pointer;
        }

        .error-text {
            color: #d32f2f;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
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

                <!-- Role Selection -->
                <div class="roles-selection">
                    <label style="font-weight: bold; margin-bottom: 10px;">Select your role(s):</label>

                    <label>
                        <input type="checkbox" name="roles[]" value="student"
                               {{ in_array('student', old('roles', [])) ? 'checked' : '' }}>
                        <span>🎓 Student - I want to learn new skills</span>
                    </label>

                    <label>
                        <input type="checkbox" name="roles[]" value="teacher"
                               {{ in_array('teacher', old('roles', [])) ? 'checked' : '' }}>
                        <span>👨‍🏫 Teacher - I want to teach skills</span>
                    </label>

                    <label>
                        <small style="color: #666; display: block; margin-top: 8px;">
                            💡 Tip: You can select both! Share your knowledge and learn new things.
                        </small>
                    </label>

                    @error('roles')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

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
