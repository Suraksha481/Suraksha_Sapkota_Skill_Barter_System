@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl">Admin Login</h1>
    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div>
            <label>Email</label>
            <input type="email" name="email" required />
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required />
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</div>
@endsection
