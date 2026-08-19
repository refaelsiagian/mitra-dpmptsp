<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification Routes
Route::get('/email/verify', [\App\Http\Controllers\EmailVerificationController::class, 'notice'])
    ->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\EmailVerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [\App\Http\Controllers\EmailVerificationController::class, 'send'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Protected Routes
Route::middleware(['auth', 'verified', 'user'])->group(function () {
    Route::get('/verify', [\App\Http\Controllers\VerificationController::class, 'index'])->name('verify');
    Route::post('/verify', [\App\Http\Controllers\VerificationController::class, 'store'])->name('verify.store');

    Route::get('/company/profile', [\App\Http\Controllers\CompanyProfileController::class, 'index'])->name('company.profile');
    Route::get('/company/profile/edit', [\App\Http\Controllers\CompanyProfileController::class, 'edit'])->name('company.profile.edit');
    Route::put('/company/profile', [\App\Http\Controllers\CompanyProfileController::class, 'update'])->name('company.profile.update');
    
    // Portfolios
    Route::get('/portfolios/create', [\App\Http\Controllers\PortfolioController::class, 'create'])->name('portfolios.create');
    Route::post('/portfolios', [\App\Http\Controllers\PortfolioController::class, 'store'])->name('portfolios.store');
    Route::get('/portfolios/{portfolio}/edit', [\App\Http\Controllers\PortfolioController::class, 'edit'])->name('portfolios.edit');
    Route::put('/portfolios/{portfolio}', [\App\Http\Controllers\PortfolioController::class, 'update'])->name('portfolios.update');
    Route::delete('/portfolios/{portfolio}', [\App\Http\Controllers\PortfolioController::class, 'destroy'])->name('portfolios.destroy');

    // Projects
    Route::get('/projects/create', [\App\Http\Controllers\ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [\App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [\App\Http\Controllers\ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [\App\Http\Controllers\ProjectController::class, 'destroy'])->name('projects.destroy');

    // Invitations
    Route::get('/notifications', [\App\Http\Controllers\InvitationController::class, 'index'])->name('notifications.index');
    Route::post('/invitations', [\App\Http\Controllers\InvitationController::class, 'store'])->name('invitations.store');
    Route::put('/invitations/{invitation}', [\App\Http\Controllers\InvitationController::class, 'update'])->name('invitations.update');

    Route::get('/review', [\App\Http\Controllers\VerificationController::class, 'review'])->name('review');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/review/{company}', [\App\Http\Controllers\AdminController::class, 'review'])->name('review');
    Route::post('/review/{company}/feedback', [\App\Http\Controllers\AdminController::class, 'storeFeedback'])->name('feedback.store');
    Route::post('/review/{company}/feedback/remove', [\App\Http\Controllers\AdminController::class, 'removeFeedback'])->name('feedback.remove');
    Route::post('/review/{company}/approve', [\App\Http\Controllers\AdminController::class, 'approve'])->name('approve');
    Route::post('/review/{company}/reject', [\App\Http\Controllers\AdminController::class, 'reject'])->name('reject');
});

// API Region Routes
Route::get('/api/regencies/{province_id}', function ($province_id) {
    return \App\Models\Regency::where('province_id', $province_id)->orderBy('name')->get();
});
Route::get('/api/districts/{regency_id}', function ($regency_id) {
    return \App\Models\District::where('regency_id', $regency_id)->orderBy('name')->get();
});
Route::get('/api/villages/{district_id}', function ($district_id) {
    return \App\Models\Village::where('district_id', $district_id)->orderBy('name')->get();
});




Route::middleware(['auth', 'verified', 'user', \App\Http\Middleware\CheckCompanyVerification::class])->group(function () {
    Route::get('/explore', [\App\Http\Controllers\ExploreController::class, 'index'])->name('explore');

    Route::get('/vendor/{company}', [\App\Http\Controllers\VendorController::class, 'show'])->name('vendor.show')->whereNumber('company');



    Route::get('/dashboard', function () {
        $company = auth()->user()->company;
        $publishedProjects = $company ? $company->projects()->where('status', 'published')->latest()->get() : collect();
        $draftProjects = $company ? $company->projects()->where('status', 'draft')->latest()->get() : collect();
        return view('company.dashboard', compact('publishedProjects', 'draftProjects'));
    })->name('dashboard');

    // Settings Routes
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/email', [\App\Http\Controllers\SettingsController::class, 'updateEmail'])->name('settings.updateEmail');
    Route::put('/settings/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
});


