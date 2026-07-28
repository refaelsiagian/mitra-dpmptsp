<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/verify', function () {
    return view('verify');
});

Route::get('/review', function () {
    return view('review');
});

Route::get('/verify-email', function () {
    return view('verify-email');
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

