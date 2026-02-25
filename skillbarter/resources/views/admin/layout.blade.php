<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>

<div class="admin-wrapper">

    {{-- Sidebar --}}
    @include('admin.sidebar')

    {{-- Main Content --}}
    <div class="admin-main">

        <div class="admin-topbar">
            <h2>@yield('title')</h2>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn-danger">Logout</button>
            </form>
        </div>

        <div class="admin-content">
            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>

    </div>
</div>

</body>
</html>
