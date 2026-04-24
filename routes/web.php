<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Welcome;
use App\Http\Controllers\MarketWelcome;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\LuckySpinController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Http\Request;
use App\Http\Controllers\MarketAdminController;
use Illuminate\Support\Facades\DB;
// ────────────────────────────────────────────────
// Public / Guest Routes
// ────────────────────────────────────────────────

Route::get('/time-test', [Welcome::class, 'time_test'])->name('time_test');
Route::get('/test-error', function () {
    abort(500);
});

Route::get('/mob/version', [Welcome::class, 'mobVersion'])->name('mob_version');

Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
})->middleware('web');

// Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');

Route::post('contactUs', [AdminController::class, 'contactUs']);

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

Route::get('/register/{code?}', [Welcome::class, 'register'])->name('register');
Route::post('/check-username', [Welcome::class, 'checkUsername'])->name('check.username');

Route::post('/postlogin', [Welcome::class, 'postLogin'])->name('postLogin');
Route::get('/logout', [Welcome::class, 'logout'])->name('logout');

Route::post('saveRegister', [AdminController::class, 'saveRegister'])->name('saveRegister');

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

// Route::get('/', [MarketWelcome::class, 'index'])->name('welcome');

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('games')
        : app(MarketWelcome::class)->index();
})->name('welcome');
Route::get('/home', [MarketWelcome::class, 'index'])->name('home');
// Static pages


Route::get('/privacy', fn() => view('privacy'));
Route::get('/terms', fn() => view('privacy'));



// ────────────────────────────────────────────────
// Authenticated User Routes
// ────────────────────────────────────────────────

Route::group(['middleware' => 'CheckUserRole'], function () {
    Route::get('/recharge', [MarketWelcome::class, 'recharge'])->name('market.recharge');
    Route::get('/pre-dashboard', [Welcome::class, 'pre_dashboard'])->name('pre_dashboard');
    Route::get('/user-dashboard', [Welcome::class, 'user_dashboard'])->name('user_dashboard');
    Route::get('/user-profile',   [Welcome::class, 'user_profile'])->name('user_profile');
    Route::post('/update-user-profile',   [Welcome::class, 'update_user_profile'])->name('user_profile.update');

    Route::get('/plan', [Welcome::class, 'plans'])->name('plan');
    Route::get('/upgrade-plan', [Welcome::class, 'upgrade_plans'])->name('upgrade_plan');

    // In routes/web.php
    Route::post('/update-whatsapp', function (Illuminate\Http\Request $request) {
        $request->validate([
            'whatsapp' => [
                'required',
                'string',
                'min:10',
                'max:20',
                'regex:/^\+\d{8,15}$/',
                'unique:users,whatsapp'        // prevents duplicate
            ],
        ], [
            'whatsapp.unique' => 'This WhatsApp number is already used by another account.',
            'whatsapp.regex'  => 'WhatsApp number must start with + followed by digits only.',
        ]);

        auth()->user()->update(['whatsapp' => $request->whatsapp]);

        return response()->json(['success' => true]);
    })->middleware('auth');

    Route::post('/username/check', [Welcome::class, 'checkUsernameProfile'])
        ->name('user.username.check');

    Route::get('/change-password', [Welcome::class, 'change_password'])->name('password.change');
    Route::post('/change-password', [Welcome::class, 'change_password_update'])->name('password.update');

    Route::get('/kyc',           [KycController::class, 'index'])->name('kyc.index');
    Route::get('/kyc/create',    [KycController::class, 'create'])->name('kyc.create');
    Route::post('/kyc/submit',   [KycController::class, 'store'])->name('kyc.store');
    Route::get('/kyc/status',    [KycController::class, 'status'])->name('kyc.status');

    Route::delete('/delete-account', [Welcome::class, 'delete_account'])
        ->middleware('auth')
        ->name('account.delete');


    Route::get('/invite',         [Welcome::class, 'invite'])->name('invite');
    Route::get('/invite/level1/load-more', [Welcome::class, 'loadMoreLevel1'])->name('invite.level1.load-more');
    Route::get('/invite/level2/load-more', [Welcome::class, 'loadMoreLevel2'])->name('invite.level2.load-more');

    Route::get('/my-plans',       [Welcome::class, 'my_plans'])->name('my_plans');
    Route::post('/plan/{id}/cancel', [PaymentMethodController::class, 'cancelPlan'])->name('plan.cancel');
    Route::get('/my-investments', [Welcome::class, 'my_investments'])->name('my_investments');

    Route::get('/deposit-history',  [Welcome::class, 'deposit_history'])->name('deposit_history');
    Route::get('/all-transactions', [Welcome::class, 'all_transactions'])->name('all_transactions');

    // Payment
    Route::get('/payment/{id}',       [PaymentMethodController::class, 'getPayment'])->name('getPayment');
    Route::post('/payment/confirm',   [PaymentMethodController::class, 'confirmPayment'])->name('user.payment.confirm');

    Route::get('/upgrade/{plan}', [PaymentMethodController::class, 'upgradePayment'])
        ->name('upgrade.plan');

    Route::post('/upgrade/confirm',   [PaymentMethodController::class, 'upgradePaymentConfirm'])->name('user.upgrade.confirm');

    // Withdraw
    Route::get('/withdraw',           [WithdrawController::class, 'create'])->name('withdraw');
    Route::post('/withdraw',          [WithdrawController::class, 'store'])->name('withdraw.store');
    Route::get('/withdraw-history',   [Welcome::class, 'withdraw_history'])->name('withdraw_history');
    Route::post('/cancel-withdraw/{id}', [WithdrawController::class, 'cancelWithdraw'])->name('withdraw.cancel');

    //Route::get('/my-tasks',       [Welcome::class, 'my_tasks'])->name('my_tasks');
    //Route::get('/my-tasks',       [Welcome::class, 'my_tasks_new'])->name('my_tasks');
    Route::get('/my-tasks',       [Welcome::class, 'my_tasks2'])->name('my_tasks');
    Route::get('/my-orders',       [Welcome::class, 'my_orders'])->name('my_orders');

    Route::post('/tasks/{id}/start', [Welcome::class, 'startTask'])->name('tasks.start');
    Route::post('/tasks/{id}/claim', [Welcome::class, 'claimTask'])->name('tasks.claim');

    Route::get('/my-complaints',  [Welcome::class, 'my_complaints'])->name('my_complaints');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
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
    Route::get('/games/lucky-spin', [LuckySpinController::class, 'luckySpin'])->name('games.lucky-spin');
    Route::post('/lucky-spin', [LuckySpinController::class, 'spin']);
    Route::get('/lucky-spin/history', [LuckySpinController::class, 'history']);

    Route::get('/games', [LuckySpinController::class, 'index'])->name('games');
    Route::get('/games/burst-numbers', [LuckySpinController::class, 'burstNumbers'])->name('games.burst-numbers');

    Route::post('/games/burst-record', [LuckySpinController::class, 'burstRecord'])->name('games.burst_record');

    Route::get('/games/profit-ball', [LuckySpinController::class, 'profitBall'])->name('games.profit-ball');


    Route::post('/games/profit-balls/start', [LuckySpinController::class, 'profitBallsStart'])->name('profit-balls.start');
    Route::post('/games/profit-balls/finish', [LuckySpinController::class, 'profitBallsFinish'])->name('profit-balls.finish');
});

// ────────────────────────────────────────────────
// Admin Routes
// ────────────────────────────────────────────────

Route::group(['middleware' => 'checkAdminRole'], function () {

    Route::get('/contacts-us', [Welcome::class, 'contact_us']);

    // Dashboard
    Route::get('/dashboard', [Welcome::class, 'dashboard'])->name('dashboard');

    Route::get('/return-withdraw', [Welcome::class, 'returnWithdraw'])->name('return.withdraw');
    Route::get('/finish-complaints', [Welcome::class, 'finishComplaints'])->name('finish.complaints');

    Route::get('/balance-shares', [Welcome::class, 'balanceShares'])->name('balance.shares');
    Route::get('/internal-balance-usage', [Welcome::class, 'internalBalanceUsage'])->name('internal.balance.usage');
    Route::get('/service-fee-collection', [Welcome::class, 'serviceFeeCollection'])->name('service.fee.collection');

    Route::get('/spins', [Welcome::class, 'spins'])->name('spins');
    Route::get('/bursts', [Welcome::class, 'bursts'])->name('bursts');
    Route::get('/profit-balls', [Welcome::class, 'profitBalls'])->name('profit.balls');

    // Packages CRUD
    Route::get('/packages',             [PackageController::class, 'index'])->name('packages.index');
    Route::post('/packages',            [PackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{id}/edit',   [PackageController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{id}',        [PackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{id}',     [PackageController::class, 'destroy'])->name('packages.destroy');
    Route::get('/packages/{id}',        [PackageController::class, 'show'])->name('packages.show');

    // Payment Methods CRUD
    Route::get('/payment-methods',          [PaymentMethodController::class, 'index'])->name('payment-methods.index');
    Route::post('/payment-methods',         [PaymentMethodController::class, 'store'])->name('payment-methods.store');
    Route::get('/payment-methods/{id}/edit', [PaymentMethodController::class, 'edit'])->name('payment-methods.edit');
    Route::put('/payment-methods/{id}',     [PaymentMethodController::class, 'update'])->name('payment-methods.update');
    Route::delete('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy'])
        ->name('payment-methods.destroy');
    Route::post('payment-methods/{id}/toggle-status', [PaymentMethodController::class, 'toggleStatus'])
        ->name('payment-methods.toggle-status');

    // Package Payment Requests
    Route::get('/package-requests',         [AdminController::class, 'package_requests'])->name('package_requests');
    Route::get('/approve-package/{id}',     [AdminController::class, 'approve_package'])->name('approve_package');
    Route::post('/reject-package/{id}',     [AdminController::class, 'reject_package'])->name('reject_package');

    // Withdraw Requests
    Route::get('/withdraw-requests',        [AdminController::class, 'withdraw_requests'])->name('withdraw_requests');
    Route::get('/approve-withdraw/{id}',    [AdminController::class, 'approve_withdraw'])->name('approve_withdraw');
    Route::get('/approve-process/{id}',    [AdminController::class, 'approve_process'])->name('approve_process');
    Route::post('/reject-withdraw/{id}',     [AdminController::class, 'reject_withdraw'])->name('reject_withdraw');
    Route::get('/edit-withdraw/{id}', [AdminController::class, 'edit_withdraw'])->name('edit_withdraw');
    Route::post('/update-withdraw/{id}', [AdminController::class, 'update_withdraw'])->name('update_withdraw');
    Route::delete('withdraw/{withdraw}', [AdminController::class, 'destroy'])->name('admin.withdraw.destroy');

    // Users Management
    Route::get('/users',                    [Welcome::class, 'users'])->name('users');
    Route::get('/user-details/{id}',        [Welcome::class, 'userDetails'])->name('userDetails');
    Route::post('/users/{id}/toggle-sensitive', [Welcome::class, 'toggleSensitive'])->name('users.toggle-sensitive');
    Route::post('/users/{id}/toggle-tasks-allowed', [Welcome::class, 'toggleTasksAllowed'])->name('users.toggle-tasks-allowed');
    Route::post('/users/{id}/toggle-balance-sharing', [Welcome::class, 'toggleBalanceSharing'])->name('users.toggle-balance-sharing');

    Route::post('/users/{id}/toggle-withdraw', [Welcome::class, 'toggleWithdraw'])->name('users.toggle-withdraw');
    Route::post('/users/{id}/toggle-withdraw-timer', [Welcome::class, 'toggleWithdrawTimer'])->name('users.toggle-withdraw-timer');
    Route::post('/users/{id}/toggle-withdraw-without-package', [Welcome::class, 'toggleWithdrawWithoutPackage'])->name('users.toggle-withdraw-without-package');
    Route::post('/users/{id}/toggle-complaint', [Welcome::class, 'toggleComplaint'])->name('users.toggle-complaint');


    Route::post('users/{id}/force-logout', [AdminController::class, 'forceLogout'])
        ->name('admin.force-logout');

    Route::delete('/delete-user/{id}',      [AdminController::class, 'deleteUser'])->name('deleteUser');
    Route::get('/suspend_user/{id}',        [AdminController::class, 'suspendUser'])->name('suspendUser');
    Route::get('/activate_user/{id}',       [AdminController::class, 'activateUser'])->name('activateUser');
    Route::get('/edit_user/{id}',           [AdminController::class, 'editUser'])->name('editUser');
    Route::post('/update_user/{id}', [AdminController::class, 'update_user'])->name('user.update');
    Route::get('/transactions',              [AdminController::class, 'transactions'])->name('transactions');
    Route::get('/all-complaints',               [AdminController::class, 'complaints'])->name('all_complaints');
    Route::post('/complaint-update', [ComplaintController::class, 'update'])
        ->name('admin.complaints.update');
    Route::delete('/complaints/{complaint}', [ComplaintController::class, 'destroy'])->name('admin.complaints.destroy');

    Route::get('/tasks', [TasksController::class, 'tasks'])->name('tasks');
    Route::post('/tasks', [TasksController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TasksController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TasksController::class, 'destroy'])->name('tasks.destroy');

    Route::get('/my-profile', [Welcome::class, 'my_profile'])->name('my_profile');

    Route::get('/running-packages', [AdminController::class, 'runningPackages'])->name('running_packages');

    Route::get('/plan/{id}/edit', [PackageController::class, 'planEdit'])
        ->name('plan.edit');
    Route::put('/plan/{id}', [PackageController::class, 'planUpdate'])->name('plan.update');

    Route::put('/plan/{id}/expire', [PackageController::class, 'expire'])
        ->name('plan.expire');

    Route::get('/kyc-verification', [KycController::class, 'kycVerification'])->name('kyc_verification');
    Route::post('/kyc/{id}/approve', [KycController::class, 'approve'])->name('admin.kyc.approve');
    Route::post('/kyc/{id}/reject',  [KycController::class, 'reject'])->name('admin.kyc.reject');
    Route::match(['get', 'post'], '/important-note', [AdminController::class, 'importantNote'])
        ->name('important_note');
    Route::match(['get', 'post'], '/mob-app-version', [AdminController::class, 'mobileAppVersion'])->name('mobile_app_version');

        Route::match(['get', 'post'], '/dollar-price', [AdminController::class, 'dollarPrice'])->name('dollar_price');

});

// ────────────────────────────────────────────────
// Shared / Profile Routes (outside middleware)
// ────────────────────────────────────────────────

Route::post('/update_profile',   [AdminController::class, 'updateProfile'])->name('updateProfile');
Route::post('/change_password',  [AdminController::class, 'changePassword'])->name('change.password');


//cron jobs
Route::get('/grant-daily-reward', [AdminController::class, 'grantDailyReward'])->name('grantDailyReward');

Route::get('/grant-weekly-reward', [AdminController::class, 'grantWeeklyReward'])->name('grantWeeklyReward');

Route::get('/delete-inactive-users', [AdminController::class, 'deleteInactiveUsers'])->name('deleteInactiveUsers');

//embed other routes file name market.php


//FeatureDesk routes
Route::get('/about', [MarketWelcome::class, 'about'])->name('about');
Route::get('/blogs', [MarketWelcome::class, 'blogs'])->name('blogs');
Route::get('/blog/{slug}', [MarketWelcome::class, 'blog_detail'])->name('blog.detail');
Route::post('/blog/comment', [MarketWelcome::class, 'store_comment'])
    ->name('blog.comment.store');

Route::get('/fill-data', [MarketWelcome::class, 'fill_data'])->name('fill.data');

Route::get('/sitemap.xml', [SitemapController::class, 'sale_bazar_generate']);
Route::get('/sitemap', [SitemapController::class, 'sitemap_html']);


Route::get('/products', [MarketWelcome::class, 'products'])->name('market.products');
Route::get('/products/load-more', [MarketWelcome::class, 'loadMoreProducts'])
    ->name('products.loadMore');

Route::get('/quick-selling', [MarketWelcome::class, 'best_selling'])->name('market.best_selling');
Route::get('/high-rated', [MarketWelcome::class, 'five_stars'])->name('market.five_stars');
Route::get('/new-products', [MarketWelcome::class, 'new_products'])->name('market.new_products');

Route::get('/categories', [MarketWelcome::class, 'categories'])->name('market.categories');

Route::post('/market_contactU', [MarketAdminController::class, 'contactUs'])->name('market.contactUs');

Route::get('/product/{slug}', [MarketWelcome::class, 'product_detail'])->name('market.product.detail');
Route::get('/product/{slug}/reviews', [MarketWelcome::class, 'product_reviews'])->name('market.product.reviews');

Route::post('/market/submit-review', [MarketWelcome::class, 'submitReview'])->name('market.submit.review');



Route::get('/buy-now/{id}', [MarketWelcome::class, 'buynow'])->name('market.buynow');
Route::post('/order-now', [MarketWelcome::class, 'orderNow'])->name('market.ordernow');

Route::get('/add-to-cart/{id}', [MarketWelcome::class, 'addtoCart'])->name('market.addtocart');





Route::get('/help-center', [MarketWelcome::class, 'help_center'])->name('market.help_center');
Route::get('/contact-us', [MarketWelcome::class, 'contact'])->name('market.contact_us');
Route::get('/shipping-info', [MarketWelcome::class, 'shopping_info'])->name('market.shopping_info');
Route::get('/returns-refunds', [MarketWelcome::class, 'returns_refunds'])->name('market.returns_refunds');
Route::get('/faqs', [MarketWelcome::class, 'faqs'])->name('market.faqs');
Route::get('/track-order', [MarketWelcome::class, 'track_order'])->name('market.track_order');
Route::post('/track-order/search', [MarketWelcome::class, 'trackOrder'])->name('track.order.search');
Route::get('/careers', [MarketWelcome::class, 'careers'])->name('market.careers');
Route::get('/privacy-policy', [MarketWelcome::class, 'privacy_policy'])->name('market.privacy_policy');
Route::get('/terms-of-service', [MarketWelcome::class, 'term_of_services'])->name('market.term_of_services');
Route::get('/cookie-policy', [MarketWelcome::class, 'cookie_policy'])->name('market.cookie_policy');


Route::group(['middleware' => 'MarketRoutes'], function () {

    Route::prefix('market')->group(function () {

        Route::get('/dashboard', [MarketWelcome::class, 'dashboard'])->name('market.dashboard');


        Route::get('/add_blogs', [MarketWelcome::class, 'add_blogs'])->name('market.add_blogs');
        Route::post('/save_blogs', [MarketAdminController::class, 'save_blogs'])->name('market.save_blogs');
        // Recommended Route Definitions
        Route::get('/edit_blog/{blog_id}', [MarketWelcome::class, 'edit_blog'])->name('market.edit_blog');
        Route::get('/delete_blog/{blog_id}', [MarketWelcome::class, 'delete_blog'])->name('market.delete_blog');   // Note: delete_blogs → delete_blog
        Route::post('/update_blogs', [MarketAdminController::class, 'update_blogs'])->name('market.update_blogs');

        Route::get('/blogs_list', [MarketWelcome::class, 'blogs_list'])->name('market.blogs_list');



        Route::get('/add_product', [MarketWelcome::class, 'add_product'])->name('market.add_products');
        Route::get('/all_products', [MarketWelcome::class, 'all_products'])->name('market.all_products');
        Route::post('/save_product', [MarketAdminController::class, 'save_product'])->name('market.save_product');
        Route::get('/edit_product/{id}', [MarketWelcome::class, 'edit_product'])->name('market.edit_product');
        Route::put('/update_product/{id}', [MarketAdminController::class, 'update_product'])->name('market.update_product');
        Route::delete('/delete_product/{id}', [MarketAdminController::class, 'delete_product'])->name('market.delete_product');



        Route::get('/add_category', [MarketWelcome::class, 'add_category'])->name('market.add_category');
        Route::post('save_category', [MarketAdminController::class, 'save_category'])->name('market.save_category');
        Route::get('/edit_category/{category}', [MarketWelcome::class, 'edit_category'])->name('market.edit_category');
        Route::put('/update_category/{category}', [MarketAdminController::class, 'update_category'])->name('market.update_category');
        Route::delete('/delete_category/{category}', [MarketAdminController::class, 'delete_category'])->name('market.delete_category');



        Route::get('/add_sub_category', [MarketWelcome::class, 'add_sub_category'])->name('market.add_sub_category');
        Route::post('/save_sub_category', [MarketAdminController::class, 'save_sub_category'])->name('market.save_sub_category');
        Route::get('/edit_sub_category/{sub_cat_id}', [MarketWelcome::class, 'edit_sub_category'])->name('market.edit_sub_category');
        Route::put('/update_sub_category/{sub_cat_id}', [MarketAdminController::class, 'update_sub_category'])->name('market.update_sub_category');
        Route::delete('/delete_sub_category/{sub_cat_id}', [MarketAdminController::class, 'delete_sub_category'])->name('market.delete_sub_category');

        Route::get('/orders', [MarketWelcome::class, 'orders'])->name('market.orders');
        Route::get('/contact-us', [MarketWelcome::class, 'contact_us'])->name('market.contact_us');
    });
});

Route::get('/get-sub-categories/{cat_id}', [MarketWelcome::class, 'getSubCategories'])->name('get.subcategories');

Route::put('/orders/status/{id}', [MarketWelcome::class, 'updateStatus'])
    ->name('orders.updateStatus');

Route::get('/search', [MarketWelcome::class, 'search'])->name('market.search');
Route::get('/{category}', [MarketWelcome::class, 'category'])->name('market.category.show');
Route::get('/{category}/{sub_category}', [MarketWelcome::class, 'subCategory'])->name('market.sub_category.show');
// Route::get('/{category}/{sub_category}/{quality}', [MarketWelcome::class, 'quality'])->name('market.quality.show');



