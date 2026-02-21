<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    DashboardController,
    UserSkillController,
    SessionRequestController,
    FeedbackController,
    RewardsController,
    PremiumController,
    SkillController,
    PageController,
    ContactController,
    RoleController,
    TeacherDashboardController,
    TeacherController,
    TeacherResourcesController,
    TeacherAnalyticsController,
    StudentDashboardController,
    StudentLearningPathController,
    StudentProgressController
};

// Public Pages (NO LOGIN REQUIRED)

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/service', [PageController::class, 'service'])->name('service');
Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Teacher directory
Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');

// Public Skill Browsing (VERY IMPORTANT)
Route::get('/find-skill', [SkillController::class, 'index'])->name('find-skill');
Route::get('/skill/{skill}', [SkillController::class, 'show'])->name('skill.show');
Route::get('/match', function() {
    if (auth()->check()) {
        return redirect()->route('requests.index');
    }
    return redirect()->route('find-skill');
})->name('match');

// Authenticated BUT NOT VERIFIED
Route::middleware('auth')->group(function () {
    // My Skills
    Route::get('/my-skills', [UserSkillController::class, 'index'])->name('my.skills');
    Route::post('/my-skills', [UserSkillController::class, 'store'])->name('my.skills.store');
    Route::delete('/my-skills/{skill}', [UserSkillController::class, 'destroy'])->name('my.skills.destroy');
});

// These NEED email verification
Route::middleware(['auth', 'verified'])->group(function () {

    // MAIN DASHBOARD (redirects based on role)
    Route::get('/dashboard', function() {
        $user = auth()->user();
        if ($user->isTeacher() && !$user->isStudent()) {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->isStudent() && !$user->isTeacher()) {
            return redirect()->route('student.dashboard');
        }
        // If both roles, show unified dashboard
        return view('dashboard.unified', ['user' => $user]);
    })->name('dashboard');

    // SHARED ROUTES (for both teacher and student)

    // Profile
    // View profile (show) at /profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    // Edit profile form at /profile/edit
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Session Requests
    Route::get('/requests', [SessionRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/new/{userSkill}', [SessionRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [SessionRequestController::class, 'store'])->name('requests.store');
    Route::post('/requests/{requestModel}/accept', [SessionRequestController::class, 'accept'])->name('requests.accept');
    Route::post('/requests/{requestModel}/decline', [SessionRequestController::class, 'decline'])->name('requests.decline');
    Route::post('/requests/{requestModel}/complete', [SessionRequestController::class, 'complete'])->name('requests.complete');
    Route::post('/requests/{requestModel}/cancel', [SessionRequestController::class, 'cancel'])->name('requests.cancel');

    // Chat for a request (real-time)
    Route::get('/chat/{requestModel}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{requestModel}/message', [\App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');

    // Feedback
    Route::resource('feedback', FeedbackController::class)->only(['index','create','store']);

    // Rewards (shared)
    Route::get('/rewards', [RewardsController::class, 'index'])->name('rewards.index');

    // Premium (shared)
    Route::get('/premium', [PremiumController::class, 'index'])->name('premium.index');
    Route::post('/premium/subscribe', [PremiumController::class, 'subscribe'])->name('premium.subscribe');
    Route::post('/premium/cancel', [PremiumController::class, 'cancel'])->name('premium.cancel');

    // ====== TEACHER-SPECIFIC ROUTES ======
    Route::middleware('teacher')->group(function () {
        // Teacher Dashboard
        Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');

        // Teacher Resources
        Route::get('/teacher/resources', [TeacherResourcesController::class, 'index'])->name('teacher.resources.index');
        Route::get('/teacher/resources/create', [TeacherResourcesController::class, 'create'])->name('teacher.resources.create');
        Route::post('/teacher/resources', [TeacherResourcesController::class, 'store'])->name('teacher.resources.store');
        Route::delete('/teacher/resources/{resource}', [TeacherResourcesController::class, 'destroy'])->name('teacher.resources.destroy');

        // Teacher Analytics
        Route::get('/teacher/analytics', [TeacherAnalyticsController::class, 'index'])->name('teacher.analytics');
    });

    // ====== STUDENT-SPECIFIC ROUTES ======
    Route::middleware('student')->group(function () {
        // Student Dashboard
        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');

        // Learning Path
        Route::get('/student/learning-path', [StudentLearningPathController::class, 'index'])->name('student.learning-path');
        Route::get('/student/skill-progress/{skill}', [StudentLearningPathController::class, 'showProgress'])->name('student.skill-progress');

        // Student Progress
        Route::get('/student/progress', [StudentProgressController::class, 'index'])->name('student.progress');
    });
});

require __DIR__.'/auth.php';

