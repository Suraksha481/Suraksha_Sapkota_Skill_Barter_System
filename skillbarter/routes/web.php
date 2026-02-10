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
    RoleController
};

/*

| Public Pages (NO LOGIN REQUIRED) */


Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/service', [PageController::class, 'service'])->name('service');
Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs');
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

/*
|--------------------------------------------------------------------------
| Auth Pages are handled by routes/auth.php (included at bottom)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Authenticated BUT NOT VERIFIED
|--------------------------------------------------------------------------
| Logged-in users, email may be unverified
*/

Route::middleware('auth')->group(function () {
    // My Skills
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

Route::middleware(['auth', 'verified'])->group(function () {
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
