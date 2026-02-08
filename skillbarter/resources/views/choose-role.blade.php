<section class="role-wrapper">
    <div class="role-card-container">
        <h1>Choose Your Role</h1>
        <p class="role-subtitle">
            You can learn, teach, or do both. Choose how you want to use SkillBarter.
        </p>

        <form method="POST" action="{{ route('role.store') }}">
            @csrf

            <div class="role-options">

                <label class="role-option">
                    <input type="checkbox" name="role[]" value="student">
                    <div class="role-box">
                        <span class="role-icon">🎓</span>
                        <h3>Student</h3>
                        <p>Learn new skills from peers and mentors</p>
                    </div>
                </label>

                <label class="role-option">
                    <input type="checkbox" name="role[]" value="teacher">
                    <div class="role-box">
                        <span class="role-icon">👨‍🏫</span>
                        <h3>Teacher</h3>
                        <p>Teach your skills and earn points & badges</p>
                    </div>
                </label>

            </div>

            <button type="submit" class="btn primary role-btn">
                Continue
            </button>
        </form>
    </div>
</section>
