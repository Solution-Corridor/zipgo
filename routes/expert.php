<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExpertMain;
use App\Http\Controllers\ExpertRateController;



Route::group(['middleware' => 'checkExpertRole'], function () {
  Route::prefix('experts')->group(function () {

    Route::get('/dashboard', [ExpertMain::class, 'expert_dashboard'])->name('expert.dashboard');
    Route::get('/expert-profile',   [ExpertMain::class, 'expert_profile'])->name('expert_profile');
    Route::post('/update-expert-profile', [ExpertMain::class, 'updateExpert'])->name('expert_profile.update');

    Route::get('/expert-payment', [ExpertMain::class, 'showPaymentPage'])->name('expert.payment.page');
    Route::post('/expert-payment/process', [ExpertMain::class, 'processPayment'])->name('expert.payment.process');

    Route::get('/rates', [ExpertRateController::class, 'index'])->name('expert.rates');
    Route::post('/rates', [ExpertRateController::class, 'store'])->name('expert.rates.store');
    Route::post('/update/rates/{rate}', [ExpertRateController::class, 'update'])->name('expert.rates.update');
    Route::delete('/rates/{rate}', [ExpertRateController::class, 'destroy'])->name('expert.rates.destroy');

  });
});
