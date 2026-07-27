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
