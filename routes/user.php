<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainUser;


Route::group(['middleware' => 'checkUserRole'], function () {
  Route::prefix('user')->group(function () {

    Route::get('/dashboard', [MainUser::class, 'user_dashboard'])->name('user.dashboard');

    Route::get('/explore', [MainUser::class, 'explore'])->name('user.explore');

    // Search / Find professionals
    Route::get('/search', [MainUser::class, 'search'])->name('user.search');
    Route::get('/search/results', [MainUser::class, 'search_results'])->name('user.search.results');

    // Bookings (my service requests)
    Route::get('/bookings', [MainUser::class, 'bookings'])->name('user.bookings');
    Route::get('/bookings/{id}', [MainUser::class, 'booking_show'])->name('bookings.show');
    Route::post('/bookings', [MainUser::class, 'booking_store'])->name('bookings.store');

    Route::get('/user-profile',   [MainUser::class, 'user_profile'])->name('user.profile');
    Route::post('/update-user-profile',   [MainUser::class, 'update_user_profile'])->name('user_profile.update');


    Route::delete('/delete-account', [MainUser::class, 'delete_account'])->middleware('auth')->name('user.delete_account');

    Route::get('/change-password', [MainUser::class, 'change_password'])->name('user.change_password');
    Route::post('/change-password', [MainUser::class, 'change_password_update'])->name('password.update');
















    Route::get('/awards', [MainUser::class, 'awards'])->name('awards');
    Route::get('/info', [MainUser::class, 'info'])->name('info');
    Route::get('/share-balance', [MainUser::class, 'shareBalance'])->name('share.balance');
    Route::post('/share-balance', [MainUser::class, 'transferBalance'])->name('transfer.balance');
    Route::get('/crypto', [MainUser::class, 'crypto'])->name('crypto');
    Route::get('/plan', [MainUser::class, 'sample'])->name('user.plans');
    Route::get('/upgrade_plan', [MainUser::class, 'sample'])->name('user.upgrade_plan');
    Route::get('/my-plans', [MainUser::class, 'sample'])->name('user.my_plans');
    Route::get('/my-team', [MainUser::class, 'sample'])->name('user.my_team');
    Route::get('/my-tasks', [MainUser::class, 'sample'])->name('user.my_tasks');
    Route::get('/my-orders', [MainUser::class, 'sample'])->name('user.my_orders');
    Route::get('/withdraw-history', [MainUser::class, 'sample'])->name('user.withdraw_history');
    Route::get('/my-complaints',  [MainUser::class, 'my_complaints'])->name('user.my_complaints');
    Route::post('/complaints', [MainUser::class, 'complaint_store'])->name('user.complaints.store');
    Route::get('/all-transactions', [MainUser::class, 'sample'])->name('user.all_transactions');
    Route::get('/download-app', [MainUser::class, 'download_app'])->name('download_app');




    Route::get('/pre-dashboard', [MainUser::class, 'pre_dashboard'])->name('pre_dashboard');

    Route::post('/username/check', [MainUser::class, 'checkUsernameProfile'])->name('user.username.check');
    Route::get('/notifications', [MainUser::class, 'notifications'])->name('notifications');
    Route::post('/mark-read-all', [MainUser::class, 'markAllRead'])->name('readAll');
    Route::get('/notification-read/{id}', [MainUser::class, 'markNotificationRead'])->name('notification.read');
  });
});
