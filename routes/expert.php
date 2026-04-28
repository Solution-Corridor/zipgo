<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Welcome;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Complaint;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ExpertRateController;



Route::group(['middleware' => 'checkExpertRole'], function () {
  Route::prefix('experts')->group(function () {

    Route::get('/expert-dashboard', [Welcome::class, 'expert_dashboard'])->name('expert_dashboard');
    Route::post('/update-expert-profile', [Admin::class, 'updateExpert'])->name('expert_profile.update');
    Route::get('/expert-profile',   [Welcome::class, 'expert_profile'])->name('expert_profile');

    Route::get('/expert-payment', [Admin::class, 'showPaymentPage'])->name('expert.payment.page');
    Route::post('/expert-payment/process', [Admin::class, 'processPayment'])->name('expert.payment.process');

    Route::get('/rates', [ExpertRateController::class, 'index'])->name('expert.rates');
    Route::post('/rates', [ExpertRateController::class, 'store'])->name('expert.rates.store');
    Route::post('/update/rates/{rate}', [ExpertRateController::class, 'update'])->name('expert.rates.update');
    Route::delete('/rates/{rate}', [ExpertRateController::class, 'destroy'])->name('expert.rates.destroy');

  });
});
