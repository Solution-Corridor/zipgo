<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubServiceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ExpertRateController;




Route::group(['middleware' => 'checkAdminRole'], function () {
  Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [Admin::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/experts', [Admin::class, 'experts'])->name('admin.experts');
    Route::post('/experts/verify/{id}', [Admin::class, 'verifyExpert'])->name('admin.experts.verify');
    Route::post('/experts/reject/{id}', [Admin::class, 'rejectExpert'])->name('admin.experts.reject');

    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::post('/services/{id}/toggle-active', [ServiceController::class, 'toggleActive'])->name('services.toggleActive');



    Route::resource('sub-services', SubServiceController::class)->names([
      'index'   => 'sub-services.index',
      'create'  => 'sub-services.create',
      'store'   => 'sub-services.store',
      'edit'    => 'sub-services.edit',
      'update'  => 'sub-services.update',
      'destroy' => 'sub-services.destroy',
    ]);
    Route::post('/sub-services/toggle-priority', [SubServiceController::class, 'togglePriority'])
      ->name('sub-services.togglePriority');

    Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
    Route::get('/cities/create', [CityController::class, 'create'])->name('cities.create');
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('/cities/{id}/edit', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('/cities/{id}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('/cities/{id}', [CityController::class, 'destroy'])->name('cities.destroy');
    Route::post('/cities/{id}/toggle-active', [CityController::class, 'toggleActive'])->name('cities.toggleActive');


    Route::get('/all-complaints', [ComplaintController::class, 'complaints'])->name('all_complaints');
    Route::post('/complaint-update', [ComplaintController::class, 'update'])
      ->name('admin.complaints.update');
    Route::delete('/complaints/{complaint}', [ComplaintController::class, 'destroy'])->name('admin.complaints.destroy');
    Route::get('/finish-complaints', [ComplaintController::class, 'finishComplaints'])->name('finish.complaints');

    // Users Management
    Route::get('/users', [Admin::class, 'users'])->name('admin.users');
    Route::get('/user-details/{id}', [Admin::class, 'userDetails'])->name('userDetails');

    Route::post('users/{id}/force-logout', [Admin::class, 'forceLogout'])->name('admin.force-logout');
    Route::delete('/delete-user/{id}', [Admin::class, 'deleteUser'])->name('deleteUser');
    Route::get('/suspend_user/{id}', [Admin::class, 'suspendUser'])->name('suspendUser');
    Route::get('/activate_user/{id}', [Admin::class, 'activateUser'])->name('activateUser');
    Route::get('/edit_user/{id}', [Admin::class, 'editUser'])->name('editUser');
    Route::post('/update_user/{id}', [Admin::class, 'update_user'])->name('user.update');

    Route::match(['get', 'post'], '/important-note', [Admin::class, 'importantNote'])->name('important_note');

    Route::get('/add_blogs', [BlogController::class, 'add'])->name('blogs.add');
    Route::get('/blogs_list', [BlogController::class, 'blogs_list'])->name('blogs.list');
    Route::post('/save_blog', [BlogController::class, 'save'])->name('blogs.save');
    Route::get('/edit_blog/{blog}', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/update_blog/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/delete_blog/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    Route::post('/toggle_commentable/{blog}', [BlogController::class, 'toggleCommentable'])->name('blogs.toggle');

    Route::get('/my-profile', [Admin::class, 'my_profile'])->name('my_profile');
    Route::post('/update_profile',   [Admin::class, 'updateProfile'])->name('updateProfile');
    Route::post('/change_password',  [Admin::class, 'changePassword'])->name('change.password');
  });
});
