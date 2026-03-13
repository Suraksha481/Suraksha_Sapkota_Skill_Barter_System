<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    UserSkillController,
    SessionRequestController,
    FeedbackController,
    RewardsController,
    PremiumController,
    SkillController,
    PageController,
    ContactController,
    TeacherDashboardController,
    TeacherController,
    TeacherResourcesController,
    TeacherAnalyticsController,
    StudentDashboardController,
    StudentLearningPathController,
    StudentProgressController,
    AdminController
};

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/service', [PageController::class, 'service'])->name('service');
Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| PUBLIC DIRECTORY & SKILLS
|--------------------------------------------------------------------------
*/

Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');

Route::get('/find-skill', [SkillController::class, 'index'])->name('find-skill');
Route::get('/skill/{skill}', [SkillController::class, 'show'])->name('skill.show');

Route::get('/match', [\App\Http\Controllers\MatchController::class, 'index'])->name('match');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED (NOT VERIFIED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/my-skills', [UserSkillController::class, 'index'])->name('my.skills');
    Route::post('/my-skills', [UserSkillController::class, 'store'])->name('my.skills.store');
    Route::delete('/my-skills/{skill}', [UserSkillController::class, 'destroy'])->name('my.skills.destroy');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | MAIN DASHBOARD (STRICT ROLE REDIRECT)
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isTeacher()) {
            // if the teacher is still awaiting approval we display a
            // simple notice page rather than bouncing them to home. this
            // keeps them on the dashboard link and avoids confusion.
            if (! $user->is_teacher_approved) {
                return view('teacher.pending');
            }

            return redirect()->route('teacher.dashboard');
        }

        if ($user->isStudent()) {
            return redirect()->route('student.dashboard');
        }

        return redirect()->route('home');

    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | SESSION REQUESTS
    |--------------------------------------------------------------------------
    */

    Route::get('/requests', [SessionRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/new/{userSkill}', [SessionRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [SessionRequestController::class, 'store'])->name('requests.store');

    Route::get('/requests/{requestModel}', [SessionRequestController::class, 'show'])->name('requests.show');

    Route::post('/requests/{requestModel}/accept', [SessionRequestController::class, 'accept'])->name('requests.accept');
    Route::post('/requests/{requestModel}/decline', [SessionRequestController::class, 'decline'])->name('requests.decline');
    Route::post('/requests/{requestModel}/complete', [SessionRequestController::class, 'complete'])->name('requests.complete');
    Route::post('/requests/{requestModel}/cancel', [SessionRequestController::class, 'cancel'])->name('requests.cancel');

    /*
    |--------------------------------------------------------------------------
    | CHAT
    |--------------------------------------------------------------------------
    */

    Route::get('/chat/{requestModel}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{requestModel}/message', [\App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');

    /*
    |--------------------------------------------------------------------------
    | FEEDBACK
    |--------------------------------------------------------------------------
    */

    Route::resource('feedback', FeedbackController::class)
        ->only(['index', 'create', 'store']);

    /*
    |--------------------------------------------------------------------------
    | REWARDS
    |--------------------------------------------------------------------------
    */

    Route::get('/rewards', [RewardsController::class, 'index'])->name('rewards.index');

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS
    |--------------------------------------------------------------------------
    */

    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    /*
    |--------------------------------------------------------------------------
    | PREMIUM
    |--------------------------------------------------------------------------
    */

    Route::get('/premium', [PremiumController::class, 'index'])->name('premium.index');
    Route::post('/premium/subscribe', [PremiumController::class, 'subscribe'])->name('premium.subscribe');
    Route::post('/premium/cancel', [PremiumController::class, 'cancel'])->name('premium.cancel');

    Route::post('/premium/khalti/initiate', [\App\Http\Controllers\KhaltiController::class, 'initiate'])->name('khalti.initiate');
    Route::get('/premium/khalti/callback', [\App\Http\Controllers\KhaltiController::class, 'callback'])->name('khalti.callback');

    Route::post('/premium/esewa/initiate', [\App\Http\Controllers\EsewaController::class, 'initiate'])->name('esewa.initiate');
    Route::get('/premium/esewa/callback', [\App\Http\Controllers\EsewaController::class, 'callback'])->name('esewa.callback');
    Route::get('/premium/esewa/failure', [\App\Http\Controllers\EsewaController::class, 'failure'])->name('esewa.failure');

    /*
    |--------------------------------------------------------------------------
    | MESSENGER
    |--------------------------------------------------------------------------
    */
    Route::get('/messenger', [\App\Http\Controllers\MessengerController::class, 'index'])->name('messenger.index');
    Route::get('/messenger/search', [\App\Http\Controllers\MessengerController::class, 'search'])->name('messenger.search');
    Route::get('/messenger/{conversation}', [\App\Http\Controllers\MessengerController::class, 'show'])->name('messenger.show');
    Route::post('/messenger/messages', [\App\Http\Controllers\MessengerController::class, 'store'])->name('messenger.store');

    /*
    |--------------------------------------------------------------------------
    | TEACHER ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('teacher')->group(function () {

        Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');

        Route::get('/teacher/resources', [TeacherResourcesController::class, 'index'])->name('teacher.resources.index');
        Route::get('/teacher/resources/create', [TeacherResourcesController::class, 'create'])->name('teacher.resources.create');
        Route::post('/teacher/resources', [TeacherResourcesController::class, 'store'])->name('teacher.resources.store');
        Route::delete('/teacher/resources/{resource}', [TeacherResourcesController::class, 'destroy'])->name('teacher.resources.destroy');

        Route::get('/teacher/analytics', [TeacherAnalyticsController::class, 'index'])->name('teacher.analytics');
    });

    // download endpoint is accessible to students and guests; authorization enforced in controller
    Route::get('/teacher/resources/{resource}/download', [TeacherResourcesController::class, 'download'])->name('teacher.resources.download');

    /*
    |--------------------------------------------------------------------------
    | STUDENT ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('student')->group(function () {

        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');

        Route::get('/student/learning-path', [StudentLearningPathController::class, 'index'])->name('student.learning-path');
        Route::get('/student/skill-progress/{skill}', [StudentLearningPathController::class, 'showProgress'])->name('student.skill-progress');

        Route::get('/student/progress', [StudentProgressController::class, 'index'])->name('student.progress');
    });
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| DEV ROUTES
|--------------------------------------------------------------------------
*/

if (app()->environment('local')) {

    Route::get('/dev/login-as/{id}', function ($id) {
        \Illuminate\Support\Facades\Auth::loginUsingId($id);
        return redirect('/');
    })->name('dev.login-as');
}

Route::get('/session/{id}/classroom',[SessionController::class,'classroom'])->name('session.classroom');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    Route::get('login', [\App\Http\Controllers\AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [\App\Http\Controllers\AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [\App\Http\Controllers\AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('admin')->group(function () {

        Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{id}', [\App\Http\Controllers\AdminController::class, 'showUser'])->name('admin.users.show');
        Route::post('/users/{id}/toggle-active', [\App\Http\Controllers\AdminController::class, 'toggleUser'])->name('admin.users.toggle-active');
        Route::post('/users/{id}/change-role', [\App\Http\Controllers\AdminController::class, 'changeUserRole'])->name('admin.users.change-role');
        Route::delete('/users/{id}', [\App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');

        Route::get('/teachers/pending', [\App\Http\Controllers\AdminController::class, 'pendingTeachers'])->name('admin.teachers.pending');
        Route::post('/teachers/{id}/approve', [\App\Http\Controllers\AdminController::class, 'approveTeacher'])->name('admin.teachers.approve');
        Route::post('/teachers/{id}/reject', [\App\Http\Controllers\AdminController::class, 'rejectTeacher'])->name('admin.teachers.reject');

        Route::get('/skills', [\App\Http\Controllers\AdminController::class, 'skills'])->name('admin.skills');
        Route::delete('/skills/{id}', [\App\Http\Controllers\AdminController::class, 'deleteSkill'])->name('admin.skills.delete');

        Route::get('/subscriptions', [\App\Http\Controllers\AdminController::class, 'subscriptions'])->name('admin.subscriptions');
        Route::post('/subscriptions/{id}/cancel', [\App\Http\Controllers\AdminController::class, 'cancelSubscription'])->name('admin.subscriptions.cancel');

        Route::get('/feedbacks', [\App\Http\Controllers\AdminController::class, 'feedbacks'])->name('admin.feedbacks');
        Route::delete('/feedbacks/{id}', [\App\Http\Controllers\AdminController::class, 'deleteFeedback'])->name('admin.feedbacks.delete');

        Route::get('/requests', [\App\Http\Controllers\AdminController::class, 'requests'])->name('admin.requests');
        Route::post('/requests/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateRequestStatus'])->name('admin.requests.update-status');

    });
});
