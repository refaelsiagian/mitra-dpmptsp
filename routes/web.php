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
Route::get('/email/verify', function (\Illuminate\Http\Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/verify');
    }
    return view('verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/verify');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/verify', function () {
        if (auth()->user()->company()->exists()) {
            return redirect('/review');
        }
        $provinces = \App\Models\Province::orderBy('name')->get();
        $kblis = \App\Models\Kbli::orderBy('code')->get();
        return view('verify.index', compact('provinces', 'kblis'));
    })->name('verify');

    Route::post('/verify', [\App\Http\Controllers\VerificationController::class, 'store'])->name('verify.store');

    Route::get('/company/profile', [\App\Http\Controllers\CompanyProfileController::class, 'index'])->name('company.profile');
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



Route::get('/review', function () {
    return view('review');
});

Route::get('/explore', function () {
    return view('explore');
});

Route::get('/vendor-profile', function () {
    return view('vendor-profile');
});

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

