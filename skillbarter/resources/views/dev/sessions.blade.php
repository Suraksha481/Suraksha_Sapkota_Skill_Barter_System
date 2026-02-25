<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dev Sessions</title>
</head>
<body>
    <h1>Developer Quick Sessions</h1>
    <p>Open each link in a different browser or private window to have separate sessions.</p>
    <ul>
        @foreach($users as $email => $user)
            <li>
                {{ $user->name }} ({{ $email }}) —
                <a href="{{ url('/dev/login-as/'.$user->id) }}" target="_blank">Open session</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
@extends('app')

@section('content')
<section class="container">
    <h1>Dev: Launch Multiple Sessions</h1>
    <p>Open each link below in a different browser, browser profile, or private window to run multiple users simultaneously.</p>

    <div style="display:flex;gap:12px;margin-top:1rem;flex-wrap:wrap">
        @php
            $admin = $users['admin@example.test'] ?? null;
            $teacher = $users['teacher@example.test'] ?? null;
            $student = $users['student@example.test'] ?? null;
        @endphp

        <div style="background:#fff;padding:16px;border-radius:8px;min-width:240px;box-shadow:0 1px 3px rgba(0,0,0,.06)">
            <h3>Admin</h3>
            <p>{{ $admin?->name ?? 'Not seeded' }}</p>
            @if($admin)
                <a href="{{ route('dev.login-as', $admin->id) }}" target="_blank" class="btn">Open as Admin (new tab)</a>
            @endif
        </div>

        <div style="background:#fff;padding:16px;border-radius:8px;min-width:240px;box-shadow:0 1px 3px rgba(0,0,0,.06)">
            <h3>Teacher</h3>
            <p>{{ $teacher?->name ?? 'Not seeded' }}</p>
            @if($teacher)
                <a href="{{ route('dev.login-as', $teacher->id) }}" target="_blank" class="btn">Open as Teacher (new tab)</a>
            @endif
        </div>

        <div style="background:#fff;padding:16px;border-radius:8px;min-width:240px;box-shadow:0 1px 3px rgba(0,0,0,.06)">
            <h3>Student</h3>
            <p>{{ $student?->name ?? 'Not seeded' }}</p>
            @if($student)
                <a href="{{ route('dev.login-as', $student->id) }}" target="_blank" class="btn">Open as Student (new tab)</a>
            @endif
        </div>
    </div>

    <hr style="margin:24px 0">
    <h4>Important</h4>
    <ul>
        <li>Browsers share cookies. To keep different authenticated users simultaneously, open each link in a different browser (Chrome, Firefox, Edge) or use separate browser profiles or private/incognito windows.</li>
        <li>If you open multiple links in the same browser profile, the last login will replace the current session.</li>
    </ul>
</section>
@endsection
