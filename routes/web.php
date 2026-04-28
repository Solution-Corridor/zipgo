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
use App\Http\Controllers\ExpertRateController;
// ────────────────────────────────────────────────
// Public / Guest Routes
// ────────────────────────────────────────────────

Route::post('contactUs', [Admin::class, 'contactUs']);

Route::get('/login', [Welcome::class, 'login'])->name('login');
// Add or modify this near your other auth routes


Route::get('/forgot-password', [ForgotPasswordController::class, 'showRequestForm'])
  ->middleware('guest')
  ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])
  ->middleware('guest')
  ->name('password.email');  // or password.otp

Route::post('/reset-password-otp', [ForgotPasswordController::class, 'resetWithOtp'])
  ->middleware('guest')
  ->name('password.update.otp');

Route::get('/register', [Welcome::class, 'register'])->name('register');
Route::post('/check-username', [Welcome::class, 'checkUsername'])->name('check.username');

Route::post('/postlogin', [Welcome::class, 'postLogin'])->name('postLogin');
Route::get('/logout', [Welcome::class, 'logout'])->name('logout');

Route::post('saveRegister', [Admin::class, 'saveRegister'])->name('saveRegister');

Route::get('/verify/{v_token}', [Welcome::class, 'verify_otp']);
Route::post('/verify_email', [Welcome::class, 'verify_email']);

Route::get('/send-email', [Welcome::class, 'sendEmail'])->name('send-email');


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

Route::get('/', [Welcome::class, 'index'])->name('welcome');

Route::get('/live-search', [Welcome::class, 'liveSearch'])->name('live.search');
Route::get('/service/{slug}', [Welcome::class, 'show'])->name('detail.show');
Route::get('/city/{slug}', [Welcome::class, 'show'])->name('detail.show');

Route::get('/privacy', fn() => view('privacy'));
Route::get('/terms', fn() => view('privacy'));
Route::get('/blogs', [Welcome::class, 'blogs'])->name('blogs');
Route::get('/blog/{slug}', [Welcome::class, 'blog_detail'])->name('blogs.show');
Route::get('/expert/{id}', [Welcome::class, 'expert_detail'])->name('expert.detail');

// ────────────────────────────────────────────────
// Authenticated User Routes
// ────────────────────────────────────────────────

Route::group(['middleware' => 'checkUserRole'], function () {
  Route::get('/recharge', [Welcome::class, 'recharge'])->name('market.recharge');
  Route::get('/pre-dashboard', [Welcome::class, 'pre_dashboard'])->name('pre_dashboard');
  Route::get('/user-dashboard', [Welcome::class, 'user_dashboard'])->name('user_dashboard');
  Route::get('/user-profile',   [Welcome::class, 'user_profile'])->name('user_profile');
  Route::post('/update-user-profile',   [Welcome::class, 'update_user_profile'])->name('user_profile.update');

  Route::prefix('experts')->name('expert.')->group(function () {
    Route::get('/rates', [ExpertRateController::class, 'index'])->name('rates');
    Route::post('/rates', [ExpertRateController::class, 'store'])->name('rates.store');
    Route::post('/update/rates/{rate}', [ExpertRateController::class, 'update'])->name('rates.update');
    Route::delete('/rates/{rate}', [ExpertRateController::class, 'destroy'])->name('rates.destroy');
  });

  Route::get('/recharge', [Welcome::class, 'recharge'])->name('market.recharge');
  Route::get('/pre-dashboard', [Welcome::class, 'pre_dashboard'])->name('pre_dashboard');
  Route::get('/user-dashboard', [Welcome::class, 'user_dashboard'])->name('user_dashboard');

  Route::get('/user-profile',   [Welcome::class, 'user_profile'])->name('user_profile');
  Route::post('/update-user-profile',   [Welcome::class, 'update_user_profile'])->name('user_profile.update');




  Route::post('/username/check', [Welcome::class, 'checkUsernameProfile'])
    ->name('user.username.check');

  Route::get('/change-password', [Welcome::class, 'change_password'])->name('password.change');
  Route::post('/change-password', [Welcome::class, 'change_password_update'])->name('password.update');



  Route::delete('/delete-account', [Welcome::class, 'delete_account'])
    ->middleware('auth')
    ->name('account.delete');



  Route::get('/my-plans',       [Welcome::class, 'my_plans'])->name('my_plans');

  Route::get('/my-tasks',       [Welcome::class, 'my_tasks2'])->name('my_tasks');
  Route::get('/my-orders',       [Welcome::class, 'my_orders'])->name('my_orders');


  Route::post('/username/check', [Welcome::class, 'checkUsernameProfile'])
    ->name('user.username.check');

  Route::get('/change-password', [Welcome::class, 'change_password'])->name('password.change');
  Route::post('/change-password', [Welcome::class, 'change_password_update'])->name('password.update');



  Route::delete('/delete-account', [Welcome::class, 'delete_account'])
    ->middleware('auth')
    ->name('account.delete');



  Route::get('/my-plans',       [Welcome::class, 'my_plans'])->name('my_plans');

  Route::get('/my-tasks',       [Welcome::class, 'my_tasks2'])->name('my_tasks');
  Route::get('/my-orders',       [Welcome::class, 'my_orders'])->name('my_orders');

  Route::post('/tasks/{id}/start', [Welcome::class, 'startTask'])->name('tasks.start');
  Route::post('/tasks/{id}/claim', [Welcome::class, 'claimTask'])->name('tasks.claim');

  Route::get('/my-complaints',  [Welcome::class, 'my_complaints'])->name('my_complaints');
  Route::post('/complaints', [Complaint::class, 'store'])->name('complaints.store');
  Route::get('/download-app', [Welcome::class, 'download_app'])->name('download_app');
  Route::get('/share-balance', [Welcome::class, 'shareBalance'])->name('share.balance');
  Route::post('/share-balance', [Welcome::class, 'transferBalance'])->name('transfer.balance');
  Route::get('/notifications', [Welcome::class, 'notifications'])->name('notifications');
  Route::post('/mark-read-all', [Welcome::class, 'markAllRead'])->name('readAll');
  Route::get('/notification-read/{id}', [Welcome::class, 'markNotificationRead'])->name('notification.read');
  // Route::get('/apply-fixed-deposit', [Welcome::class, 'applyFD'])->name('fd.apply');
  Route::get('/awards', [Welcome::class, 'awards'])->name('awards');
  Route::get('/info', [Welcome::class, 'info'])->name('info');
  Route::get('/crypto', [Welcome::class, 'crypto'])->name('crypto');
  Route::get('/my-complaints',  [Welcome::class, 'my_complaints'])->name('my_complaints');
  Route::post('/complaints', [Complaint::class, 'store'])->name('complaints.store');
  Route::get('/download-app', [Welcome::class, 'download_app'])->name('download_app');
  Route::get('/share-balance', [Welcome::class, 'shareBalance'])->name('share.balance');
  Route::post('/share-balance', [Welcome::class, 'transferBalance'])->name('transfer.balance');
  Route::get('/notifications', [Welcome::class, 'notifications'])->name('notifications');
  Route::post('/mark-read-all', [Welcome::class, 'markAllRead'])->name('readAll');
  Route::get('/notification-read/{id}', [Welcome::class, 'markNotificationRead'])->name('notification.read');
  // Route::get('/apply-fixed-deposit', [Welcome::class, 'applyFD'])->name('fd.apply');
  Route::get('/awards', [Welcome::class, 'awards'])->name('awards');
  Route::get('/info', [Welcome::class, 'info'])->name('info');
  Route::get('/crypto', [Welcome::class, 'crypto'])->name('crypto');
});

// ────────────────────────────────────────────────
// Admin Routes
// ────────────────────────────────────────────────

Route::group(['middleware' => 'checkAdminRole'], function () {

  Route::get('/contacts-us', [Welcome::class, 'contact_us']);

  // Dashboard
  Route::get('/dashboard', [Welcome::class, 'dashboard'])->name('dashboard');

  Route::get('/finish-complaints', [Welcome::class, 'finishComplaints'])->name('finish.complaints');

  Route::get('/balance-shares', [Welcome::class, 'balanceShares'])->name('balance.shares');




  // Users Management
  Route::get('/users',                    [Welcome::class, 'users'])->name('users');
  Route::get('/user-details/{id}',        [Welcome::class, 'userDetails'])->name('userDetails');

  Route::post('users/{id}/force-logout', [Admin::class, 'forceLogout'])->name('admin.force-logout');

  Route::delete('/delete-user/{id}',      [Admin::class, 'deleteUser'])->name('deleteUser');
  Route::get('/suspend_user/{id}',        [Admin::class, 'suspendUser'])->name('suspendUser');
  Route::get('/activate_user/{id}',       [Admin::class, 'activateUser'])->name('activateUser');
  Route::get('/edit_user/{id}',           [Admin::class, 'editUser'])->name('editUser');
  Route::post('/update_user/{id}', [Admin::class, 'update_user'])->name('user.update');

  Route::get('/all-complaints',               [Admin::class, 'complaints'])->name('all_complaints');
  Route::post('/complaint-update', [Complaint::class, 'update'])
    ->name('admin.complaints.update');
  Route::delete('/complaints/{complaint}', [Complaint::class, 'destroy'])->name('admin.complaints.destroy');

  Route::get('/my-profile', [Welcome::class, 'my_profile'])->name('my_profile');

  Route::match(['get', 'post'], '/important-note', [Admin::class, 'importantNote'])
    ->name('important_note');

  // Users Management
  Route::get('/users',                    [Welcome::class, 'users'])->name('users');
  Route::get('/user-details/{id}',        [Welcome::class, 'userDetails'])->name('userDetails');

  Route::post('users/{id}/force-logout', [Admin::class, 'forceLogout'])
    ->name('admin.force-logout');

  Route::delete('/delete-user/{id}',      [Admin::class, 'deleteUser'])->name('deleteUser');
  Route::get('/suspend_user/{id}',        [Admin::class, 'suspendUser'])->name('suspendUser');
  Route::get('/activate_user/{id}',       [Admin::class, 'activateUser'])->name('activateUser');
  Route::get('/edit_user/{id}',           [Admin::class, 'editUser'])->name('editUser');
  Route::post('/update_user/{id}', [Admin::class, 'update_user'])->name('user.update');

  Route::get('/all-complaints',               [Admin::class, 'complaints'])->name('all_complaints');
  Route::post('/complaint-update', [Complaint::class, 'update'])
    ->name('admin.complaints.update');
  Route::delete('/complaints/{complaint}', [Complaint::class, 'destroy'])->name('admin.complaints.destroy');


  Route::get('/add_blogs', [BlogController::class, 'add'])->name('blogs.add');
  Route::get('/blogs_list', [BlogController::class, 'blogs_list'])->name('blogs.list');
  Route::post('/save_blog', [BlogController::class, 'save'])->name('blogs.save');
  Route::get('/edit_blog/{blog}', [BlogController::class, 'edit'])->name('blogs.edit');
  Route::put('/update_blog/{blog}', [BlogController::class, 'update'])->name('blogs.update');
  Route::delete('/delete_blog/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
  Route::post('/toggle_commentable/{blog}', [BlogController::class, 'toggleCommentable'])->name('blogs.toggle');


  Route::match(['get', 'post'], '/important-note', [Admin::class, 'importantNote'])
    ->name('important_note');


  Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
  Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
  Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
  Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
  Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
  Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');


  Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
  Route::get('/cities/create', [CityController::class, 'create'])->name('cities.create');
  Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
  Route::get('/cities/{id}/edit', [CityController::class, 'edit'])->name('cities.edit');
  Route::put('/cities/{id}', [CityController::class, 'update'])->name('cities.update');
  Route::delete('/cities/{id}', [CityController::class, 'destroy'])->name('cities.destroy');


  Route::post('/services/{id}/toggle-active', [ServiceController::class, 'toggleActive'])->name('services.toggleActive');
  Route::post('/cities/{id}/toggle-active', [CityController::class, 'toggleActive'])->name('cities.toggleActive');


  Route::get('/experts', [Admin::class, 'experts'])->name('experts');
  Route::post('/admin/experts/verify/{id}', [Admin::class, 'verifyExpert'])->name('admin.experts.verify');
  Route::post('/admin/experts/reject/{id}', [Admin::class, 'rejectExpert'])->name('admin.experts.reject');
});

// expert routes 
Route::group(['middleware' => 'checkExpertRole'], function () {
  Route::get('/expert-dashboard', [Welcome::class, 'expert_dashboard'])->name('expert_dashboard');
  Route::post('/update-expert-profile', [Admin::class, 'updateExpert'])->name('expert_profile.update');
  Route::get('/expert-profile',   [Welcome::class, 'expert_profile'])->name('expert_profile');

  Route::get('/expert-payment', [Admin::class, 'showPaymentPage'])->name('expert.payment.page');
  Route::post('/expert-payment/process', [Admin::class, 'processPayment'])->name('expert.payment.process');
});


// ────────────────────────────────────────────────
// Shared / Profile Routes (outside middleware)
// ────────────────────────────────────────────────

Route::post('/update_profile',   [Admin::class, 'updateProfile'])->name('updateProfile');
Route::post('/change_password',  [Admin::class, 'changePassword'])->name('change.password');


//embed other routes file name market.php
