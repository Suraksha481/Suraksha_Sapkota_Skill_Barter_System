@extends('app')

@section('content')
<section class="auth-wrapper">

    <div class="auth-card single">

        <!-- LEFT IMAGE -->
        <div class="auth-left">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800&auto=format&fit=crop" class="auth-img">
        </div>

        <!-- RIGHT SECTION -->
        <div class="auth-right">

            <!-- TITLE CENTERED -->
            <div class="auth-title">
                <h1>Create Your Account</h1>
                <p>Join SkillBarter and start teaching and learning skills today!</p>
            </div>

            @if(session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert error">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORM -->
            <form class="auth-form" method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

                <div class="auth-btn-wrapper">
                    <button type="submit" class="auth-btn">Sign Up</button>
                </div>

                <p class="switch">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </form>

        </div>

    </div>

</section>
@endsection
