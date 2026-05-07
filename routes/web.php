<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Welcome;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;

require "expert.php";
require "user.php";
require "admin.php";


// Cache clearing (development helper)
Route::get('/clear-cache', function () {
  Artisan::call('cache:clear');
  Artisan::call('view:clear');
  // Artisan::call('log:clear');
  Artisan::call('route:clear');
  Artisan::call('config:clear');
  // session()->flush();

  return "Cache, Views, Logs, Routes, Config, and Session have been cleared!";
});

Route::get('/live-location', [Welcome::class, 'liveLocation'])->name('live.location');

Route::get('/register', [Welcome::class, 'register'])->name('register');
Route::post('saveRegister', [Welcome::class, 'saveRegister'])->name('saveRegister');

Route::get('/login', [Welcome::class, 'login'])->name('login');
Route::post('/postlogin', [Welcome::class, 'postLogin'])->name('postLogin');

Route::match(['get', 'post'], '/logout', [Welcome::class, 'logout'])->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showRequestForm'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->middleware('guest')->name('password.email');
Route::post('/reset-password-otp', [ForgotPasswordController::class, 'resetWithOtp'])->middleware('guest')->name('password.update.otp');

Route::post('/check-username', [Welcome::class, 'checkUsername'])->name('check.username');

Route::get('/verify/{v_token}', [Welcome::class, 'verify_otp']);
Route::post('/verify_email', [Welcome::class, 'verify_email']);
Route::get('/send-email', [Welcome::class, 'sendEmail'])->name('send-email');

Route::get('/', [Welcome::class, 'index'])->name('index');


// ----------------------------- EASY GO ---------------------------------
Route::get('/ride-booking', [Welcome::class, 'ride_booking'])->name('ride.booking');

// --------------------------- EASY GO END -------------------------------

// ----------------------------- QUICK SERVICES ---------------------------------
Route::get('/home-maintenance', [Welcome::class, 'homeMaintenance'])->name('home.maintenance');

// --------------------------- QUICK SERVICES END -------------------------------

Route::get('/home', [Welcome::class, 'home'])->name('welcome');
Route::get('/search', [Welcome::class, 'search'])->name('search');
Route::get('/live-search', [Welcome::class, 'liveSearch'])->name('live.search');


Route::get('/areas', [Welcome::class, 'areas'])->name('areas');
Route::get('/areas/load-more', [Welcome::class, 'loadMoreAreas'])->name('areas.load-more');
Route::get('/city/{slug}', [Welcome::class, 'show'])->name('cities.show');

Route::get('/services', [Welcome::class, 'services'])->name('services');
Route::get('/services/load-more', [Welcome::class, 'loadMoreServices'])->name('services.load-more');
Route::get('/service/{slug}', [Welcome::class, 'show_subservices'])->name('services.show');

Route::get('/blogs', [Welcome::class, 'blogs'])->name('blogs');
Route::get('/blog/{slug}', [Welcome::class, 'blog_detail'])->name('blogs.show');
Route::get('/expert/{id}', [Welcome::class, 'expert_detail'])->name('expert.detail');

