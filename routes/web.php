<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Welcome;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Complaint;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\BlogController;

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



Route::get('/register', [Welcome::class, 'register'])->name('register');
Route::post('saveRegister', [Welcome::class, 'saveRegister'])->name('saveRegister');

Route::get('/login', [Welcome::class, 'login'])->name('login');
Route::post('/postlogin', [Welcome::class, 'postLogin'])->name('postLogin');

Route::get('/logout', [Welcome::class, 'logout'])->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showRequestForm'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->middleware('guest')->name('password.email');
Route::post('/reset-password-otp', [ForgotPasswordController::class, 'resetWithOtp'])->middleware('guest')->name('password.update.otp');

Route::post('/check-username', [Welcome::class, 'checkUsername'])->name('check.username');

Route::get('/verify/{v_token}', [Welcome::class, 'verify_otp']);
Route::post('/verify_email', [Welcome::class, 'verify_email']);
Route::get('/send-email', [Welcome::class, 'sendEmail'])->name('send-email');

Route::get('/', [Welcome::class, 'index'])->name('welcome');
Route::get('/live-search', [Welcome::class, 'liveSearch'])->name('live.search');

Route::get('/service/{slug}', [Welcome::class, 'show'])->name('detail.show');
Route::get('/city/{slug}', [Welcome::class, 'show'])->name('detail.show');

Route::get('/blogs', [Welcome::class, 'blogs'])->name('blogs');
Route::get('/blog/{slug}', [Welcome::class, 'blog_detail'])->name('blogs.show');
Route::get('/expert/{id}', [Welcome::class, 'expert_detail'])->name('expert.detail');

Route::post('/update_profile',   [Admin::class, 'updateProfile'])->name('updateProfile');
Route::post('/change_password',  [Admin::class, 'changePassword'])->name('change.password');
