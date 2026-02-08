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

            <!-- FORM (RIGHT ALIGNED) -->
            <form class="auth-form">
                <input type="text" placeholder="Full Name" required>
                <input type="email" placeholder="Email" required>
                <input type="password" placeholder="Password" required>
                <input type="password" placeholder="Confirm Password" required>

                <div class="auth-btn-wrapper">
                    <button type="submit" class="auth-btn">Sign Up</button>
                </div>

                <p class="switch">Already have an account? <a href="/login">Login</a></p>
            </form>

        </div>

    </div>

</section>
@endsection