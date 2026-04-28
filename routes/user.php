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


Route::group(['middleware' => 'checkUserRole'], function () {
  Route::get('/recharge', [Welcome::class, 'recharge'])->name('market.recharge');
  Route::get('/pre-dashboard', [Welcome::class, 'pre_dashboard'])->name('pre_dashboard');
  Route::get('/user-dashboard', [Welcome::class, 'user_dashboard'])->name('user_dashboard');
  Route::get('/user-profile',   [Welcome::class, 'user_profile'])->name('user_profile');
  Route::post('/update-user-profile',   [Welcome::class, 'update_user_profile'])->name('user_profile.update');



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
