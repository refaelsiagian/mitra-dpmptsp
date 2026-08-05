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
Route::middleware(['auth', 'verified'])->group(function () {
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




Route::middleware(['auth', 'verified', \App\Http\Middleware\CheckCompanyVerification::class])->group(function () {
    Route::get('/explore', function () {
        return view('explore');
    });

    Route::get('/vendor/{company}', [\App\Http\Controllers\VendorController::class, 'show'])->name('vendor.show')->whereNumber('company');

    Route::get('/project/tender', function () {
        return view('project-tender');
    });

    Route::get('/project/subcon', function () {
        return view('project-subcon');
    });

    Route::get('/project/kso', function () {
        return view('project-kso');
    });

    Route::get('/project/kso/2', function () {
        return view('project-kso-2');
    });

    Route::get('/project/kso/3', function () {
        return view('project-kso-3');
    });

    Route::get('/vendor/inovasi-properti', function () {
        return view('vendor-inovasi');
    });

    Route::get('/vendor/waskita', function () {
        return view('vendor-waskita');
    });

    Route::get('/vendor/nusantara-wisata', function () {
        return view('vendor-wisata');
    });

    Route::get('/vendor/agro-kopi', function () {
        return view('vendor-agro');
    });

    Route::get('/vendor/logistik-maritim', function () {
        return view('vendor-logistik');
    });

    // UMKM Vendors (Usaha Kecil & Mikro)
    Route::get('/vendor/tani-jaya', function () {
        return view('vendor-tani');
    });
    Route::get('/vendor/rekayasa-digital', function () {
        return view('vendor-digital');
    });
    Route::get('/vendor/kuliner-nusantara', function () {
        return view('vendor-kuliner');
    });
    Route::get('/vendor/kreatif-kemasan', function () {
        return view('vendor-kemasan');
    });
    Route::get('/vendor/daur-ulang', function () {
        return view('vendor-daurulang');
    });

    // UMKM Projects (KSO Suplai & Kolaborasi)
    Route::get('/project/kso/tani', function () {
        return view('project-kso-tani');
    });
    Route::get('/project/kso/digital', function () {
        return view('project-kso-digital');
    });
    Route::get('/project/kso/kuliner', function () {
        return view('project-kso-kuliner');
    });
    Route::get('/project/kso/kemasan', function () {
        return view('project-kso-kemasan');
    });
    Route::get('/project/kso/daurulang', function () {
        return view('project-kso-daurulang');
    });

    Route::get('/rfp-saya', function () {
        return view('rfp-saya');
    });
});


