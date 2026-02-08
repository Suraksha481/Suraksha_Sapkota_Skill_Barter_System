<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | SkillXchange</title>
    <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}">
</head>
<body>

<div class="reset-wrapper">
    <div class="reset-card">
        <h2>Reset Password</h2>
        <p>Create a new password for your account</p>

        <form method="POST" action="{{ url('reset-password') }}">
            @csrf
            @method('PUT')

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    readonly
                >
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <!-- New Password -->
            <div class="form-group">
                <label>New Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    minlength="8"
                >
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label>Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                >
            </div>

            <button type="submit" class="btn-reset">
                Reset Password
            </button>
        </form>
    </div>
</div>

</body>
</html>
