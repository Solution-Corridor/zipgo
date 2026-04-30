<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExpertMain;
use App\Http\Controllers\ExpertRateController;



Route::group(['middleware' => 'checkExpertRole'], function () {
  Route::prefix('expert')->group(function () {
    Route::get('/dashboard', [ExpertMain::class, 'expert_dashboard'])->name('expert.dashboard');
    Route::get('/jobs', [ExpertMain::class, 'jobs'])->name('expert.jobs');
    Route::get('/jobs/{id}', [ExpertMain::class, 'jobs_show'])->name('expert.jobs.show');
    Route::post('/jobs/{id}/accept', [ExpertMain::class, 'jobs_accept'])->name('expert.jobs.accept');
    Route::post('/jobs/{id}/decline', [ExpertMain::class, 'jobs_decline'])->name('expert.jobs.decline');
    Route::post('/jobs/{id}/complete', [ExpertMain::class, 'jobs_complete'])->name('expert.jobs.complete');
    Route::post('/jobs/{id}/status', [ExpertMain::class, 'updateStatus'])->name('expert.jobs.status');
    Route::get('/earnings', [ExpertMain::class, 'earnings'])->name('expert.earnings');

    Route::get('/rates', [ExpertRateController::class, 'index'])->name('expert.rates');
    Route::post('/rates', [ExpertRateController::class, 'store'])->name('expert.rates.store');
    Route::post('/update/rates/{rate}', [ExpertRateController::class, 'update'])->name('expert.rates.update');
    Route::delete('/rates/{rate}', [ExpertRateController::class, 'destroy'])->name('expert.rates.destroy');

    Route::get('/profile', [ExpertMain::class, 'expert_profile'])->name('expert.profile');
    Route::post('/update_profile', [ExpertMain::class, 'updateExpert'])->name('expert.profile.update');




    Route::get('/my-complaints',  [ExpertMain::class, 'my_complaints'])->name('expert.my_complaints');
    Route::post('/complaints', [ExpertMain::class, 'complaint_store'])->name('expert.complaints.store');

    Route::get('/expert-payment', [ExpertMain::class, 'showPaymentPage'])->name('expert.payment.page');
    Route::post('/expert-payment/process', [ExpertMain::class, 'processPayment'])->name('expert.payment.process');
  });
});
