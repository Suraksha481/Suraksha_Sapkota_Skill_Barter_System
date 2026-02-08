<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\{
    ProfileController,
    DashboardController,
    UserSkillController,
    MatchController,
    SessionRequestController,
    FeedbackController,
    RewardsController,
    PremiumController,
    SkillController,
    PageController,
    ContactController,
    RoleController
};

/*

| Public Pages (NO LOGIN REQUIRED) */


Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about']);
Route::get('/service', [PageController::class, 'service']);
Route::get('/blogs', [PageController::class, 'blogs']);
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/* Public Skill Browsing (VERY IMPORTANT)
Users can SEARCH & VIEW skills WITHOUT login
*/

Route::get('/find-skill', [SkillController::class, 'index'])->name('find-skill');
Route::get('/skill/{skill}', [SkillController::class, 'show'])->name('skill.show');
Route::get('/match', function() {
    if (auth()->check()) {
        return redirect()->route('requests.index');
    }
    return redirect()->route('find-skill');
})->name('match');

/*Auth Pages (Guest Only)
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Authenticated BUT NOT VERIFIED
|--------------------------------------------------------------------------
| Logged-in users, email may be unverified
*/

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // My Skills (force login but NOT verification)
    Route::get('/my-skills', [UserSkillController::class, 'index'])->name('my.skills');
    Route::post('/my-skills', [UserSkillController::class, 'store'])->name('my.skills.store');
    Route::delete('/my-skills/{skill}', [UserSkillController::class, 'destroy'])->name('my.skills.destroy');

    // Choose role
    Route::get('/choose-role', [RoleController::class, 'show'])->name('role.choose');
    Route::post('/choose-role', [RoleController::class, 'store'])->name('role.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated + VERIFIED ONLY (STRICT)
|--------------------------------------------------------------------------
| These NEED email verification
*/



Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
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

    // Feedback
    Route::resource('feedback', FeedbackController::class)->only(['index','create','store']);

    // Rewards
    Route::get('/rewards', [RewardsController::class, 'index'])->name('rewards.index');

    // Premium
    Route::get('/premium', [PremiumController::class, 'index'])->name('premium.index');
    Route::post('/premium/subscribe', [PremiumController::class, 'subscribe'])->name('premium.subscribe');
    Route::post('/premium/cancel', [PremiumController::class, 'cancel'])->name('premium.cancel');
});



require __DIR__.'/auth.php';
