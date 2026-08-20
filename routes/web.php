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

    // Password Reset Routes
    Route::get('/forgot-password', [\App\Http\Controllers\PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\NewPasswordController::class, 'store'])->name('password.update');
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

    // Proposals
    Route::get('/projects/{project}/proposals/create', [\App\Http\Controllers\ProposalController::class, 'create'])->name('proposals.create');
    Route::post('/projects/{project}/proposals', [\App\Http\Controllers\ProposalController::class, 'store'])->name('proposals.store');
    Route::get('/proposals/{proposal}', [\App\Http\Controllers\ProposalController::class, 'show'])->name('proposals.show');
    Route::put('/proposals/{proposal}/status', [\App\Http\Controllers\ProposalController::class, 'updateStatus'])->name('proposals.updateStatus');

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
        $publishedProjects = $company ? $company->projects()
            ->withCount('proposals')
            ->withCount(['proposals as accepted_proposals_count' => function($q) {
                $q->where('status', 'accepted');
            }])
            ->where('status', 'published')->latest()->get() : collect();
        $draftProjects = $company ? $company->projects()->where('status', 'draft')->latest()->get() : collect();
        $closedProjects = $company ? $company->projects()
            ->withCount('proposals')
            ->withCount(['proposals as accepted_proposals_count' => function($q) {
                $q->where('status', 'accepted');
            }])
            ->where('status', 'closed')->latest()->get() : collect();
        $sentProposals = $company ? $company->proposals()->with('project.company')->latest()->get() : collect();
        $receivedProposals = $company ? \App\Models\Proposal::whereHas('project', function($q) use ($company) {
            $q->where('company_id', $company->id);
        })->with(['project', 'company'])->latest()->get() : collect();
        return view('company.dashboard', compact('publishedProjects', 'draftProjects', 'closedProjects', 'sentProposals', 'receivedProposals'));
    })->name('dashboard');

    Route::put('/projects/{project}/close', function (\App\Models\Project $project) {
        if (!auth()->check() || !auth()->user()->company || auth()->user()->company->id !== $project->company_id) {
            abort(403);
        }
        $project->update(['status' => 'closed']);
        return back()->with('success', 'Proyek berhasil ditutup dan dipindahkan ke Riwayat Anda.');
    })->name('projects.close');

    Route::put('/projects/{project}/toggle-visibility', function (\App\Models\Project $project) {
        if ($project->company_id !== auth()->user()->company->id) {
            abort(403);
        }
        $project->update(['is_public' => !$project->is_public]);
        
        $status = $project->is_public ? 'publik' : 'tersembunyi';
        return back()->with('success', "Proyek berhasil diubah menjadi {$status}.");
    })->name('projects.toggle-visibility');

    // Settings Routes
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/email', [\App\Http\Controllers\SettingsController::class, 'updateEmail'])->name('settings.updateEmail');
    Route::put('/settings/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
});


