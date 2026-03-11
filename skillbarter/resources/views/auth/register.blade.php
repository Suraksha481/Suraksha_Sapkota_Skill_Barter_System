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
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
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
                    <label style="font-weight: bold; margin-bottom: 10px;">Select your role:</label>

                    <label>
                        <input type="radio" name="role" value="student"
                               {{ old('role') === 'student' ? 'checked' : '' }}>
                        <span>Student - I want to learn new skills</span>
                    </label>

                    <label>
                        <input type="radio" name="role" value="teacher"
                               {{ old('role') === 'teacher' ? 'checked' : '' }}>
                        <span>Teacher - I want to teach skills</span>
                    </label>

                    

                    @error('role')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div id="teacher_fields" style="display: none; margin-bottom: 20px; padding: 15px; background: #fcfcfc; border: 1px solid #eee; border-radius: 8px;">
                    <h3 style="margin-bottom: 15px; font-size: 16px; color: #333;">Teacher Verification Documents</h3>
                    
                    <input type="text" name="bank_account" placeholder="Bank Account Number" value="{{ old('bank_account') }}">
                    @error('bank_account') <small class="error">{{ $message }}</small> @enderror

                    <div style="margin-top: 15px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 5px; color: #555;">Upload CV (PDF, DOCX)</label>
                        <input type="file" name="cv" accept=".pdf,.doc,.docx" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
                        @error('cv') <small class="error">{{ $message }}</small> @enderror
                    </div>

                    <div style="margin-top: 15px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 5px; color: #555;">Upload Certificate (PDF, Image)</label>
                        <input type="file" name="certificate" accept=".pdf,.jpg,.jpeg,.png" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
                        @error('certificate') <small class="error">{{ $message }}</small> @enderror
                    </div>

                    <div style="margin-top: 15px;">
                        <label style="display: block; font-size: 14px; margin-bottom: 5px; color: #555;">Upload Citizenship (PDF, Image)</label>
                        <input type="file" name="citizenship" accept=".pdf,.jpg,.jpeg,.png" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">
                        @error('citizenship') <small class="error">{{ $message }}</small> @enderror
                    </div>
                </div>

                <button type="submit">Register</button>
                <div class="links">
                    <a href="{{ route('login') }}">Already have an account?</a>
                </div>
            </form>
        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const studentRadio = document.querySelector('input[name="role"][value="student"]');
        const teacherRadio = document.querySelector('input[name="role"][value="teacher"]');
        const teacherFields = document.getElementById('teacher_fields');

        function toggleTeacherFields() {
            if (teacherRadio && teacherRadio.checked) {
                teacherFields.style.display = 'block';
            } else {
                teacherFields.style.display = 'none';
            }
        }

        if (studentRadio) studentRadio.addEventListener('change', toggleTeacherFields);
        if (teacherRadio) teacherRadio.addEventListener('change', toggleTeacherFields);
        
        // Initial check on load
        toggleTeacherFields();
    });
</script>

</body>
</html>
