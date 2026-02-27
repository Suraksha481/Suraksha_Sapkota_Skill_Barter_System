<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body style="display:flex;justify-content:center;align-items:center;height:100vh;">

<div class="card-dark" style="width:350px;">
    <h2 class="section-heading">Admin Login</h2>

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button class="btn-primary-dark" style="width:100%;">
            Login
        </button>
    </form>
</div>

</body>
</html>
