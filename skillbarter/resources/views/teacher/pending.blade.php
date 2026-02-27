@extends('app')

@section('title', 'Awaiting Approval')

@section('content')
    <div style="max-width:600px;margin:2rem auto;text-align:center;">
        <h1>Teacher Account Pending</h1>
        <p>Your application to become a teacher has been submitted and is currently
           awaiting approval by an administrator.</p>
        <p>You'll receive an email when your account is activated. Until then you
           can continue browsing public content or update your profile.</p>
        <a href="{{ route('home') }}" class="btn primary">Return to Home</a>
    </div>
@endsection
