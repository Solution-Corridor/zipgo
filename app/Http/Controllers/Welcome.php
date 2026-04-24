<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App;
use Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\Complaint;
use App\Models\Payment;
use App\Models\Task;
use App\Models\UserTaskLog;
use App\Models\Package;
use Nette\Utils\Json;

class Welcome extends Controller
{

    protected $withdrawController;

    public function __construct(WithdrawController $withdrawController)
    {
        $this->withdrawController = $withdrawController;
    }

    public function mobVersion()
    {
        $version = App\Models\MobApp::latest()->first();
        return response()->json([
            'version' => $version ? $version->version : null,
            'download_url' => 'https://featuredesk.site/mob/FeatureDesk.apk',
        ]);
    }

    public function finishComplaints()
    {
        $peindingComplaints = Complaint::where('status', 'pending')->get();
        foreach ($peindingComplaints as $complaint) {
            $complaint->status = 'not_valid';
            $complaint->updated_at = now();
            $complaint->save();
        }

        return back()->with('success', 'All pending complaints have been marked as not valid.');
    }

    public function returnWithdraw()
    {
        $pendingWithdraws = Withdrawal::where('status', 'pending')->get();

        foreach ($pendingWithdraws as $withdraw) {

            $user = $withdraw->user;

            // calculate bonus
            $bonus = $withdraw->amount * 0.05;
            if ($bonus < 100) {
                $bonus = 100;
            }

            // update balance
            $user->balance += ($withdraw->amount + $bonus);
            $user->save();

            // update withdrawal status
            $withdraw->status = 'returned';
            $withdraw->updated_at = now();
            $withdraw->save();

            // add transaction
            Transaction::create([
                'user_id' => $withdraw->user_id,
                'amount' => $withdraw->amount + $bonus,
                'trx_type' => 'withdraw_returned',
                'detail' => "Returned amount for withdraw request ID: {$withdraw->id} (including Rs {$bonus} service fee)",
            ]);
        }

        return back()->with('success', 'All pending withdrawals have been returned.');
    }

    public function balanceShares()
    {
        $transactions = Transaction::where('trx_type', 'balance_transfer_sent')->get();

        return view('admin.balance_shares', compact('transactions'));
    }

    public function internalBalanceUsage()
    {
        $transactions = Payment::where('status', 'approved')
            ->where('transaction_id', 'like', 'WALLET-%')
            ->get();
        return view('admin.internal_balance_usage', compact('transactions'));
    }

    public function serviceFeeCollection()
    {
        $transactions = Transaction::where('trx_type', 'service_fee')->get();
        return view('admin.service_fee_collection', compact('transactions'));
    }

    public function spins()
    {
        $today = now()->startOfDay();

        $allTrx = Transaction::with('user')
            ->whereIn('trx_type', ['spin_bet', 'spin_win'])
            ->latest()
            ->get();

        $todayTrx = Transaction::with('user')
            ->whereIn('trx_type', ['spin_bet', 'spin_win'])
            ->whereDate('created_at', $today)
            ->latest()
            ->get();

        // Today's summaries
        $todaySummary = [
            'total' => [
                'count' => $todayTrx->count(),
                'amount' => $todayTrx->sum('amount')
            ],
            'wins' => [
                'count' => $todayTrx->where('trx_type', 'spin_win')->count(),
                'amount' => $todayTrx->where('trx_type', 'spin_win')->sum('amount')
            ],
            'bets' => [
                'count' => $todayTrx->where('trx_type', 'spin_bet')->count(),
                'amount' => $todayTrx->where('trx_type', 'spin_bet')->sum('amount')
            ]
        ];

        // All time summaries
        $allSummary = [
            'total' => [
                'count' => $allTrx->count(),
                'amount' => $allTrx->sum('amount')
            ],
            'wins' => [
                'count' => $allTrx->where('trx_type', 'spin_win')->count(),
                'amount' => $allTrx->where('trx_type', 'spin_win')->sum('amount')
            ],
            'bets' => [
                'count' => $allTrx->where('trx_type', 'spin_bet')->count(),
                'amount' => $allTrx->where('trx_type', 'spin_bet')->sum('amount')
            ]
        ];

        return view('admin.spins', compact('allTrx', 'todayTrx', 'todaySummary', 'allSummary'));
    }


    public function bursts()
    {
        $today = now()->startOfDay();

        $allTrx = Transaction::with('user')
            ->whereIn('trx_type', ['burst_bet', 'burst_win'])
            ->latest()
            ->get();

        $todayTrx = Transaction::with('user')
            ->whereIn('trx_type', ['burst_bet', 'burst_win'])
            ->whereDate('created_at', $today)
            ->latest()
            ->get();

        // Today's summaries
        $todaySummary = [
            'total' => [
                'count' => $todayTrx->count(),
                'amount' => $todayTrx->sum('amount')
            ],
            'wins' => [
                'count' => $todayTrx->where('trx_type', 'burst_win')->count(),
                'amount' => $todayTrx->where('trx_type', 'burst_win')->sum('amount')
            ],
            'bets' => [
                'count' => $todayTrx->where('trx_type', 'burst_bet')->count(),
                'amount' => $todayTrx->where('trx_type', 'burst_bet')->sum('amount')
            ]
        ];

        // All time summaries
        $allSummary = [
            'total' => [
                'count' => $allTrx->count(),
                'amount' => $allTrx->sum('amount')
            ],
            'wins' => [
                'count' => $allTrx->where('trx_type', 'burst_win')->count(),
                'amount' => $allTrx->where('trx_type', 'burst_win')->sum('amount')
            ],
            'bets' => [
                'count' => $allTrx->where('trx_type', 'burst_bet')->count(),
                'amount' => $allTrx->where('trx_type', 'burst_bet')->sum('amount')
            ]
        ];

        return view('admin.bursts', compact('allTrx', 'todayTrx', 'todaySummary', 'allSummary'));
    }

    public function profitBalls()
    {
        $today = now()->startOfDay();

        $allTrx = Transaction::with('user')
            ->whereIn('trx_type', ['profit_balls_bet', 'profit_balls_win'])
            ->latest()
            ->get();

        $todayTrx = Transaction::with('user')
            ->whereIn('trx_type', ['profit_balls_bet', 'profit_balls_win'])
            ->whereDate('created_at', $today)
            ->latest()
            ->get();

        // Today's summaries
        $todaySummary = [
            'total' => [
                'count' => $todayTrx->count(),
                'amount' => $todayTrx->sum('amount')
            ],
            'wins' => [
                'count' => $todayTrx->where('trx_type', 'profit_balls_win')->count(),
                'amount' => $todayTrx->where('trx_type', 'profit_balls_win')->sum('amount')
            ],
            'bets' => [
                'count' => $todayTrx->where('trx_type', 'profit_balls_bet')->count(),
                'amount' => $todayTrx->where('trx_type', 'profit_balls_bet')->sum('amount')
            ]
        ];

        // All time summaries
        $allSummary = [
            'total' => [
                'count' => $allTrx->count(),
                'amount' => $allTrx->sum('amount')
            ],
            'wins' => [
                'count' => $allTrx->where('trx_type', 'profit_balls_win')->count(),
                'amount' => $allTrx->where('trx_type', 'profit_balls_win')->sum('amount')
            ],
            'bets' => [
                'count' => $allTrx->where('trx_type', 'profit_balls_bet')->count(),
                'amount' => $allTrx->where('trx_type', 'profit_balls_bet')->sum('amount')
            ]
        ];

        return view('admin.profit_balls', compact('allTrx', 'todayTrx', 'todaySummary', 'allSummary'));
    }

    /**
     * Get plans based on user authentication status
     */
    private function getHigherPlans()
    {
        if (!auth()->check()) {
            // User is NOT logged in → Show ALL active plans
            $packages = Package::where('is_active', 1)
                ->orderBy('investment_amount', 'asc')
                ->get()
                ->groupBy('plan_type');

            return [
                'silver'  => $packages->get('silver', collect()),
                'gold'    => $packages->get('gold', collect()),
                'diamond' => $packages->get('diamond', collect()),
                'invest'  => $packages->get('invest', collect()),
            ];
        }

        // User IS logged in → Show only higher plans
        $user = auth()->user();

        // Option 1: Based on previous successful investments (Recommended for most investment platforms)
        $maxInvestment = DB::table('payments')
            ->join('packages', 'payments.plan_id', '=', 'packages.id')
            ->where('payments.user_id', $user->id)
            ->where('payments.status', 'approved')
            ->max('packages.investment_amount') ?? 0;

        // Option 2: Based on current balance (You were using this)
        // $maxInvestment = $user->balance * 0.6 ?? 0;

        // Fetch only higher active packages
        $packages = Package::where('is_active', 1)
            ->where('investment_amount', '>', $maxInvestment)
            ->orderBy('investment_amount', 'asc')
            ->get()
            ->groupBy('plan_type');

        return [
            'silver'  => $packages->get('silver', collect()),
            'gold'    => $packages->get('gold', collect()),
            'diamond' => $packages->get('diamond', collect()),
            'invest'  => $packages->get('invest', collect()),
        ];
    }

    /**
     * Show investment plans
     */
    public function plans()
    {
        $plans = $this->getHigherPlans();

        return view('plans', compact('plans'));
    }

    /**
     * Show upgrade plans (same logic, different view)
     */
    public function upgrade_plans()
    {
        $plans = $this->getHigherPlans();

        return view('upgrade_plans', compact('plans'));
    }

    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }

    public function time_test(Request $request)
    {
        echo "Current Server Time: " . now()->toDateTimeString() . "<br>";
        echo "Current Server Time (UTC): " . now()->utc()->toDateTimeString() . "<br>";
        echo "Current Server Time (Asia/Kolkata): " . now()->timezone('Asia/Kolkata')->toDateTimeString() . "<br>";
    }

    public function checkUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:4|max:30|regex:/^[A-Za-z0-9_.-]+$/'
        ]);

        $username = $request->input('username');

        $exists = User::where('username', $username)->exists();

        if ($exists) {
            return response()->json([
                'available' => false,
                'message'   => 'This username is already taken'
            ]);
        }

        return response()->json([
            'available' => true
        ]);
    }

    public function awards()
    {
        $user = auth()->user();

        // Level 1
        $level1_ids = User::where('referred_by', $user->id)
            ->where('status', 1)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->pluck('id');

        $level1_count    = $level1_ids->count();

        $level1_business = Payment::whereIn('user_id', $level1_ids)
            ->where('status', 'approved')
            ->whereMonth('approved_at', now()->month)
            ->whereYear('approved_at', now()->year)
            ->sum('amount');

        // Level 2
        $level2_ids = User::whereIn('referred_by', $level1_ids)
            ->where('status', 1)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->pluck('id');

        $level2_count    = $level2_ids->count();
        $level2_business = Payment::whereIn('user_id', $level2_ids)
            ->where('status', 'approved')
            ->whereMonth('approved_at', now()->month)
            ->whereYear('approved_at', now()->year)
            ->sum('amount');

        // Team Stats
        $team_size   = $level1_count + $level2_count;
        $team_invest = $level1_business + $level2_business;
        return view('user.awards', compact('team_size', 'team_invest', 'level1_count', 'level1_business', 'level2_count', 'level2_business'));
    }

    public function pre_dashboard()
    {
        return view('user.pre_dashboard');
    }

    public function info()
    {
        return view('user.info');
    }

    public function crypto()
    {
        return view('user.crypto');
    }

    public function applyFD()
    {
        $user = Auth::user();

        $user->update([
            'is_fd' => 1,
        ]);
        return back()->with('success', 'Your Fixed Deposit application has been successfully submitted. Your funds are now locked for the selected term, and withdrawal options are temporarily disabled until maturity.');
    }

    public function notifications()
    {
        $user = Auth::user();

        $notifications = DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->latest()
            ->paginate(20);

        return view('user.notifications', compact('notifications'));
    }

    public function markAllRead()
    {
        $user = Auth::user();

        // Mark all unread notifications as read
        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    public function markNotificationRead($id)
    {
        $user = Auth::user();

        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }

        // Redirect to the URL stored in notification (if exists) or back
        $url = $notification->data['url'] ?? back()->getTargetUrl();

        return redirect($url);
    }

    public function shareBalance()
    {
        $user = Auth::user();
        if ($user->is_fd) {
            $msg = 'Withdrawals are not available while you have an active Fixed Deposit.';
        } elseif ($this->withdrawController->isUserInCooldown($user)) {
            $msg = 'Withdrawals are on cooldown. Please try again later.';
        } else {
            return view('user.share_balance', compact('user'));
        }

        return redirect()->route('user_dashboard')->with('error', $msg);
    }


    public function transferBalance(Request $request)
    {
        $request->validate([
            'receiver_username' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\User::where('username', $value)
                        ->orWhere('phone', $value)
                        ->exists();

                    if (!$exists) {
                        $fail('The selected receiver is invalid.');
                    }
                },
            ],
            'amount' => 'required|numeric|min:1100|max:' . auth()->user()->balance,
        ]);

        $sender = auth()->user();

        //check user has active package or not, for withdrawal user must have active package
        $hasActivePlan = Payment::where('user_id', $sender->id)
            ->where('status', 'approved')
            ->where('approved_at', '<=', now())
            ->where('expires_at', '>', now())
            ->exists();

        if (!$hasActivePlan) {
            return back()->withErrors([
                'error' => 'You must have an active package to share balance.'
            ]);
        }

        // check if user already shared balance in last 24 hours, if yes then restrict sharing balance
        $lastShare = DB::table('transactions')
            ->where('user_id', $sender->id)
            ->where('trx_type', 'balance_transfer_sent')
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if ($lastShare) {
            return back()->with('error', 'You can only share balance once in 24 hours.');
        }

        $receiver = User::where('username', $request->receiver_username)
            ->orWhere('phone', $request->receiver_username)
            ->first();

        if ($receiver->id === $sender->id) {
            return back()->with('error', 'You cannot transfer to yourself!');
        }

        $sentAmount = (float) $request->amount;

        // 5% fee but minimum Rs 100
        $fee = max(round($sentAmount * 0.05, 2), 100);

        // Total amount deducted from sender
        $totalDeducted = $sentAmount + $fee;

        // Balance safety check
        if ($sender->balance < $totalDeducted) {
            return back()->with('error', 'Insufficient balance (including service fee).');
        }

        DB::transaction(function () use ($sender, $receiver, $sentAmount, $fee, $totalDeducted) {

            // 1. Update balances
            $sender->decrement('balance', $totalDeducted);
            $receiver->increment('balance', $sentAmount);

            // 2. Sender transaction
            DB::table('transactions')->insert([
                'user_id'    => $sender->id,
                'amount'     => $totalDeducted,
                'trx_type'   => 'balance_transfer_sent',
                'detail'     => "Sent Rs {$sentAmount} to {$receiver->username} (incl. Rs {$fee} fee)",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3. Receiver transaction
            DB::table('transactions')->insert([
                'user_id'    => $receiver->id,
                'amount'     => $sentAmount,
                'trx_type'   => 'balance_transfer_received',
                'detail'     => "Received Rs {$sentAmount} from {$sender->username}",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4. Fee record
            DB::table('transactions')->insert([
                'user_id'    => $sender->id,
                'amount'     => $fee,
                'trx_type'   => 'service_fee',
                'detail'     => "Service fee for transfer to {$receiver->username}",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 5. Sender notification
            DB::table('notifications')->insert([
                'id'             => Str::uuid(),
                'type'           => 'BalanceTransfer',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id'  => $sender->id,
                'data'           => json_encode([
                    'message' => "You sent Rs {$sentAmount} to {$receiver->username} (Rs {$fee} fee charged)",
                    'amount'  => $sentAmount,
                    'fee'     => $fee,
                    'total'   => $totalDeducted,
                    'type'    => 'debit'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 6. Receiver notification
            DB::table('notifications')->insert([
                'id'             => Str::uuid(),
                'type'           => 'BalanceTransfer',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id'  => $receiver->id,
                'data'           => json_encode([
                    'message' => "You received Rs {$sentAmount} from {$sender->username}",
                    'amount'  => $sentAmount,
                    'type'    => 'credit'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            "Rs {$sentAmount} transferred successfully! (Rs {$fee} service charge applied)"
        );
    }


    public function download_app()
    {
        return view('user.download_app');
    }

    public function my_orders()
    {
        $user = Auth::user();
        $orders = DB::table('mk_orders')
            ->join('mk_products', 'mk_orders.product_id', '=', 'mk_products.product_id')
            ->select('mk_orders.*', 'mk_products.name as product_name', 'mk_products.pic as product_image')
            ->where('mk_orders.user_id', $user->id)
            ->latest()
            ->paginate(20);

        return view('user.my_orders', compact('orders'));
    }

    public function my_tasks2()
    {
        $user = Auth::user();

        // if user not allowed tasks or is suspended, show empty tasks with message
        if ($user->is_tasks_allowed == 0 || $user->status == 2) {
            return view('user.my_tasks2', [
                'activePayments'     => collect(),
                'planSummaries'      => collect(),
                'allTasks'           => collect(),
                'totalDailyTasks'    => 0,
                'cooldownSeconds'    => 0,
                'lastClaimTime'      => null,
                'nextAvailableAt'    => null,
                'timeLeftToNext'     => 0,
                'canClaimNow'        => false,
                'timeAllowed'        => 0,
                'nextOpeningTime'    => null,
                'todayClaimedCount'  => 0,
                'todayClaimedAmount' => 0
            ]);
        }

        $now   = now();
        $today = Carbon::today();

        // $timeAllowed = 1 * 60 * 60; // 1 hour total time window
        $timeAllowed = 0; // no hard limit, cooldown will be dynamic based on user's plan
        $allTasks        = collect();
        $planSummaries   = collect();
        $totalDailyTasks = 0;

        // ───────────────────────────────────────────────
        // 1. Get active paid plans
        // ───────────────────────────────────────────────
        $activePayments = Payment::with('package')
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('approved_at', '<=', $now)
            ->where('expires_at', '>', $now)
            ->get();

        foreach ($activePayments as $payment) {
            $package = $payment->package;

            $planId     = $package->id;
            $planName   = $package->name;
            $dailyTasks = $package->daily_tasks ?? 0;
            $taskPrice = rand($package->daily_task_price ?? 0, ($package->daily_task_price ?? 0) + 7);

            $totalDailyTasks += $dailyTasks;

            // Tasks already claimed today for THIS plan
            $claimedThisPlanToday = DB::table('user_task_logs')
                ->where('user_id', $user->id)
                ->where('status', 'claimed')
                //->where('reward', $taskPrice)
                ->where('package_id', $planId)
                ->where('payment_id', $payment->id)
                ->whereDate('claimed_at', $today)
                ->count();

            $remainingThisPlan = max(0, $dailyTasks - $claimedThisPlanToday);

            // Fetch random tasks
            $tasksForThisPlan = Task::orderByRaw('RAND(?)', [mt_rand()])
                ->limit($remainingThisPlan)
                ->get();

            // Attach plan data to tasks
            foreach ($tasksForThisPlan as $task) {
                $task->task_price = $taskPrice;
                $task->package_id = $planId;
                $task->payment_id = $payment->id;
            }

            $allTasks = $allTasks->merge($tasksForThisPlan);

            // Plan summary for UI
            $planSummaries->push([
                'plan_id'            => $planId,
                'plan_name'          => $planName,
                'daily_tasks'        => $dailyTasks,
                'task_price'         => $taskPrice,
                'claimed_today'      => $claimedThisPlanToday,
                'remaining_today'    => $remainingThisPlan,
                'tasks_count_picked' => $tasksForThisPlan->count(),
            ]);
        }
        // ================ free area ==================
        // ───────────────────────────────────────────────
        // 2. No active plans → give free daily tasks (once per day)
        // ───────────────────────────────────────────────
        if ($activePayments->isEmpty()) {

            $freeTasksCountWanted = 10;

            $totalDailyTasks = $freeTasksCountWanted;

            // Check if user already received free tasks today
            $alreadyGotFreeTodayCount = DB::table('user_task_logs')
                ->where('user_id', $user->id)
                ->where('package_id', 'free')
                ->where('payment_id', 'free')
                ->whereDate('claimed_at', $today)
                ->count();

            $remainingFreeTasks = max(0, $freeTasksCountWanted - $alreadyGotFreeTodayCount);

            if ($remainingFreeTasks > 0) {

                // Get random tasks (up to 10)
                $randomFreeTasks = Task::orderByRaw('RAND(?)', [mt_rand()])
                    ->limit($remainingFreeTasks)
                    ->get();



                foreach ($randomFreeTasks as $task) {
                    $task->task_price = rand(3, 5);
                    $task->package_id = 'free';
                    $task->payment_id = 'free';
                    // optional: $task->source = 'free_daily';
                }

                $allTasks = $allTasks->merge($randomFreeTasks);

                // Fake summary row for frontend
                $planSummaries->push([
                    'plan_id'            => 'free',
                    'plan_name'          => 'Daily Free Tasks',
                    'daily_tasks'        => $freeTasksCountWanted,
                    'task_price'         => '3–5',           // keep string if blade expects it
                    'claimed_today'      => $alreadyGotFreeTodayCount,
                    'remaining_today'    => $remainingFreeTasks,
                    'tasks_count_picked' => $randomFreeTasks->count(),

                ]);

                // echo '<pre>';
                // print_r($planSummaries);
                // die();

            }
            // If already got today → $allTasks stays empty → user sees no tasks
        }

        //=============== free area end ==========================

        // ───────────────────────────────────────────────
        // Shuffle tasks 
        // ───────────────────────────────────────────────
        $allTasks = $allTasks->shuffle();

        // ───────────────────────────────────────────────
        // Cooldown logic
        // ───────────────────────────────────────────────
        $cooldownSeconds = 0;

        if ($totalDailyTasks > 0) {
            $cooldownSeconds = (int) floor($timeAllowed / $totalDailyTasks);
        }

        // Last claimed task (any type)
        $lastClaim = DB::table('user_task_logs')
            ->where('user_id', $user->id)
            ->where('status', 'claimed')
            ->orderByDesc('claimed_at')
            ->first();

        $lastClaimTime   = $lastClaim ? Carbon::parse($lastClaim->claimed_at) : null;
        $nextAvailableAt = null;
        $timeLeftToNext  = 0;
        $canClaimNow     = true;

        if ($lastClaimTime) {
            $nextAvailableAt = $lastClaimTime->copy()->addSeconds($cooldownSeconds);

            if ($now->lessThan($nextAvailableAt)) {
                $canClaimNow    = false;
                $timeLeftToNext = $now->diffInSeconds($nextAvailableAt);
            }
        }

        $nextOpeningTime = $timeLeftToNext > 0 ? $now->copy()->addSeconds($timeLeftToNext) : null;

        // Today stats (all tasks - paid + free)
        $todayTasks = DB::table('user_task_logs')
            ->where('user_id', $user->id)
            ->whereDate('claimed_at', $today);

        $todayClaimedCount  = $todayTasks->count();
        $todayClaimedAmount = $todayTasks->sum('reward');

        // echo '<pre>';
        // print_r([
        //     //'activePayments'   => $activePayments->toArray(),
        //     //'planSummaries'    => $planSummaries->toArray(),
        //     //'allTasks'         => $allTasks->toArray(),
        //     'totalDailyTasks'  => $totalDailyTasks,
        //     'cooldownSeconds'  => $cooldownSeconds,
        //     'lastClaimTime'    => $lastClaimTime,
        //     'nextAvailableAt'  => $nextAvailableAt,
        //     'timeLeftToNext'   => $timeLeftToNext,
        //     'canClaimNow'      => $canClaimNow,
        //     'timeAllowed'      => $timeAllowed,
        //     'nextOpeningTime'  => $nextOpeningTime,
        //     'todayClaimedCount'=> $todayClaimedCount,
        //     'todayClaimedAmount'=> $todayClaimedAmount
        // ]);
        // die();

        return view('user.my_tasks2', compact(
            'activePayments',
            'planSummaries',
            'allTasks',
            'totalDailyTasks',
            'cooldownSeconds',
            'lastClaimTime',
            'nextAvailableAt',
            'timeLeftToNext',
            'canClaimNow',
            'timeAllowed',
            'nextOpeningTime',
            'todayClaimedCount',
            'todayClaimedAmount'
        ));
    }

    public function my_tasks_new()
    {
        $user = Auth::user();
        $now  = now();



        $activePayments = Payment::with('package')
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('approved_at', '<=', $now)
            ->where('expires_at', '>', $now)
            ->join('packages as pkg', 'payments.plan_id', '=', 'pkg.id') // Alias to avoid conflict
            ->orderBy('pkg.daily_task_price', 'asc')
            ->select('payments.*')
            ->get();

        if ($activePayments->isEmpty()) {
            return view('user.my_tasks_new', [
                'tasks'               => collect(),
                'remainingTasks'      => 0,
                'tasksNum'            => 0,
                'earnedToday'         => 0,
                'earnedAll'           => 0,
                'tasksCompletedToday' => 0,
                'tasksCompletedAll'   => 0,
                'perTaskPrice'        => 0,
                'shouldRefresh'       => false,
                'timeLeftToNext'      => 0,
                'cooldownMinutes'     => 0,
            ]);
        }

        // ── Aggregate total limits & max price ──────────────────────────────────────
        $totalDailyTasks = 0;
        $maxTaskPrice    = 0;

        foreach ($activePayments as $payment) {
            $package = $payment->package;
            $totalDailyTasks += (int) ($package->daily_tasks ?? 0);
            $maxTaskPrice = max($maxTaskPrice, (float) ($package->daily_task_price ?? 0));
        }

        $tasksNum     = $totalDailyTasks;
        $perTaskPrice = $maxTaskPrice;

        if ($tasksNum <= 0) {
            $tasksNum     = 0;
            $perTaskPrice = 0;
        }

        // ── Dynamic cooldown: aim for 6 hours total engagement ─────────────────────
        $targetEngagementMinutes = 6 * 60; // 360 minutes

        $cooldownMinutes = 0;
        if ($tasksNum > 0) {
            $cooldownMinutes = (int) floor($targetEngagementMinutes / $tasksNum);
            // You can also try: round() or ceil() depending on preference
        }

        $cooldownSeconds = $cooldownMinutes * 60;

        // ── Last successful claim ───────────────────────────────────────────────────
        $lastClaim = DB::table('user_task_logs')
            ->where('user_id', $user->id)
            ->whereIn('status', ['claimed', 'completed'])
            ->orderByDesc('claimed_at')
            ->first();

        $lastClaimTime = $lastClaim ? Carbon::parse($lastClaim->claimed_at) : null;

        // Race condition safety
        if (!$lastClaimTime || $now->diffInSeconds($lastClaimTime) < 60) {
            $freshClaim = DB::table('user_task_logs')
                ->where('user_id', $user->id)
                ->where('status', 'claimed')
                ->orderByDesc('claimed_at')
                ->first();

            if ($freshClaim) {
                $lastClaimTime = Carbon::parse($freshClaim->claimed_at);
            }
        }

        // Fallback: today's most recent claim
        if (is_null($lastClaimTime)) {
            $lastClaimToday = DB::table('user_task_logs')
                ->where('user_id', $user->id)
                ->where('status', 'claimed')
                ->whereDate('claimed_at', now()->startOfDay()->toDateString())
                ->max('claimed_at');

            if ($lastClaimToday) {
                $lastClaimTime = Carbon::parse($lastClaimToday);
            }
        }

        // ── Cooldown check ──────────────────────────────────────────────────────────
        $canActivate    = true;
        $timeLeftToNext = 0;

        if ($lastClaimTime) {
            $nextAvailableAt = $lastClaimTime->copy()->addSeconds($cooldownSeconds);

            if ($now->lessThan($nextAvailableAt)) {
                $canActivate = false;
                $timeLeftToNext = $now->diffInSeconds($nextAvailableAt, false);
            }
        }

        $shouldRefresh = $canActivate;

        // ── Total claimed today (global limit) ──────────────────────────────────────
        $tasksClaimedToday = DB::table('user_task_logs')
            ->where('user_id', $user->id)
            ->whereDate('claimed_at', now()->startOfDay()->toDateString())
            ->where('status', 'claimed')
            ->count();

        $remainingTasks = max(0, $tasksNum - $tasksClaimedToday);




        // ── Exclude recently attempted ──────────────────────────────────────────────
        $excludedTaskIds = DB::table('user_task_logs')
            ->where('user_id', $user->id)
            ->where(function ($q) {
                $q->whereDate('created_at', now()->startOfDay()->toDateString())
                    ->orWhereDate('claimed_at', now()->startOfDay()->toDateString());
            })
            ->pluck('task_id')
            ->unique()
            ->toArray();


        // ── Load tasks PER PLAN respecting each plan's remaining quota ─────────────
        $tasks = collect();
        $globalTasksLoaded = 0;

        if ($remainingTasks > 0) {
            foreach ($activePayments as $payment) {
                if ($globalTasksLoaded >= $remainingTasks) {
                    break;
                }

                $package      = $payment->package;
                $planPrice    = (float) ($package->daily_task_price ?? 0);
                $planMaxTasks = (int) ($package->daily_tasks ?? 0);

                if ($planMaxTasks <= 0 || $planPrice <= 0) {
                    continue;
                }

                // Count how many were already claimed TODAY from THIS plan's price
                $claimedThisPlanToday = DB::table('user_task_logs')
                    ->where('user_id', $user->id)
                    ->whereDate('claimed_at', now()->startOfDay()->toDateString())
                    ->where('status', 'claimed')
                    ->where('reward', $planPrice)           // ← this must be reliable
                    ->count();

                $planRemaining = max(0, $planMaxTasks - $claimedThisPlanToday);

                if ($planRemaining <= 0) {
                    continue;
                }

                // How many more we can still take (global cap)
                $canTake = min($planRemaining, $remainingTasks - $globalTasksLoaded);

                if ($canTake <= 0) {
                    continue;
                }

                // Load fresh tasks
                $planTasks = Task::whereNotIn('id', $excludedTaskIds)
                    ->inRandomOrder()
                    ->take($canTake)
                    ->get();

                foreach ($planTasks as $t) {
                    $t->task_price = $planPrice;
                }

                $tasks = $tasks->merge($planTasks);
                $globalTasksLoaded += $planTasks->count();
            }
        }

        // If still under global limit and want fallback behavior (optional / legacy)
        if ($tasks->count() < $remainingTasks && $shouldRefresh) {
            $stillNeeded = $remainingTasks - $tasks->count();

            $extraTasks = Task::whereNotIn('id', $excludedTaskIds)
                ->whereNotIn('id', $tasks->pluck('id')) // avoid duplicates
                ->inRandomOrder()
                ->take($stillNeeded)
                ->get();

            foreach ($extraTasks as $t) {
                $t->task_price = $perTaskPrice;
            }

            $tasks = $tasks->merge($extraTasks);
        }

        // ── Claimed today IDs for status marking ────────────────────────────────────
        $claimedTodayIds = DB::table('user_task_logs')
            ->where('user_id', $user->id)
            ->whereDate('claimed_at', now()->startOfDay()->toDateString())  // still safe
            ->where('status', 'claimed')
            ->pluck('task_id')
            ->toArray();




        // ── Assign statuses ─────────────────────────────────────────────────────────
        if ($tasks->isNotEmpty()) {
            if ($canActivate) {
                if (!in_array($tasks[0]->id, $claimedTodayIds)) {
                    $tasks[0]->status = 'active';
                } else {
                    $tasks[0]->status = 'claimed_today';
                }
            } else {
                $tasks[0]->status = 'locked';
            }

            foreach ($tasks->skip(1) as $task) {
                $task->status = 'locked';
            }
        }

        // Safety: mark any already-claimed-today tasks
        foreach ($tasks as $task) {
            if (in_array($task->id, $claimedTodayIds)) {
                $task->status = 'claimed_today';
            }
        }

        // ── Stats ───────────────────────────────────────────────────────────────────
        $logs = DB::table('user_task_logs')
            ->where('user_id', $user->id)
            ->where('status', 'claimed')
            ->get();

        $earnedAll = $logs->sum('reward') ?? 0;

        $todayLogs = $logs->filter(fn($log) => $log->claimed_at && Carbon::parse($log->claimed_at)->isToday());

        $earnedToday         = $todayLogs->sum('reward') ?? 0;
        $tasksCompletedToday = $todayLogs->count();
        $tasksCompletedAll   = $logs->count();

        // ── Return ──────────────────────────────────────────────────────────────────
        return view('user.my_tasks_new', compact(
            'tasks',
            'remainingTasks',
            'tasksNum',
            'earnedToday',
            'earnedAll',
            'tasksCompletedToday',
            'tasksCompletedAll',
            'perTaskPrice',
            'shouldRefresh',
            'timeLeftToNext',
            'cooldownMinutes'
        ));
    }


    public function my_tasks()
    {
        $user = Auth::user();
        $now  = now();
        $last24 = $now->copy()->subHours(24);

        $maxTasksPerDay = 7;
        $cooldownMinutes = 205; // 205 minutes cooldown

        // check if user has active payment plan 

        $hasActive = false;

        // $hasActive = Payment::where('user_id', $user->id)
        //     ->where('status', 'approved')
        //     ->whereNotNull('approved_at')
        //     ->whereNotNull('expires_at')
        //     ->where('expires_at', '>', now())
        //     ->exists();

        if (!$hasActive) {
            return view('user.my_tasks', [
                'tasks' => collect(), // empty collection
                'earnedToday' => 0,
                'totalEarned' => 0,
                'tasksCompletedToday' => 0,
                'tasksCompletedAll' => 0,
                'earnedAll' => 0
            ]);
        }

        // ── Stats for last 24 hours ─────────────────────────────
        $todayStats = UserTaskLog::where('user_id', $user->id)
            ->where('claimed_at', '>=', $last24)
            ->where('status', 'claimed')
            ->selectRaw('COUNT(*) as count, SUM(reward) as total_reward')
            ->first();

        $tasksCompletedToday = $todayStats->count ?? 0;
        $earnedToday         = $todayStats->total_reward ?? 0.00;

        // ── Lifetime Stats ───────────────────────────────────────────
        $allTimeStats = UserTaskLog::where('user_id', $user->id)
            ->where('status', 'claimed')
            ->selectRaw('COUNT(*) as count, SUM(reward) as total_reward')
            ->first();

        $tasksCompletedAll = $allTimeStats->count ?? 0;
        $earnedAll         = $allTimeStats->total_reward ?? 0.00;


        $totalEarned = UserTaskLog::where('user_id', $user->id)
            ->whereNotNull('claimed_at')
            ->sum('reward') ?? 0.00;

        // ── Last claimed task ────────────────────────────────────
        $lastClaim = UserTaskLog::where('user_id', $user->id)
            ->whereNotNull('claimed_at')
            ->latest('claimed_at')
            ->first();

        $canShowTask = true;

        // ── Daily limit check ────────────────────────────────────
        if ($tasksCompletedToday >= $maxTasksPerDay) {
            $canShowTask = false;
        }

        // ── Fixed 144-minute cooldown check ─────────────────────
        if ($lastClaim && $canShowTask) {

            $nextUnlockTime = Carbon::parse($lastClaim->claimed_at)
                ->addMinutes($cooldownMinutes);

            if ($now->lt($nextUnlockTime)) {
                $canShowTask = false;
            }
        }

        // ── Load next random task if allowed ─────────────────────
        $tasks = collect();

        if ($canShowTask) {

            $claimedIds = UserTaskLog::where('user_id', $user->id)
                ->where('claimed_at', '>=', $last24)
                ->pluck('task_id');

            $tasks = Task::whereNotIn('id', $claimedIds)
                ->orderByRaw('RAND(?)', [now()->getTimestamp()])
                ->take(1)
                ->get();
        }

        return view('user.my_tasks', compact(
            'tasks',
            'earnedToday',
            'totalEarned',
            'tasksCompletedToday',
            'tasksCompletedAll',
            'earnedAll'
        ));
    }


    public function startTask(Request $request, $id)
    {
        $user = Auth::user();
        // Validate price
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'package_id' => 'nullable',
            'payment_id' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $log = UserTaskLog::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'package_id' => $validated['package_id'] ?? 'free',
                    'payment_id' => $validated['payment_id'] ?? 'free',
                    'task_id' => $id,
                    'status'  => 'started',
                    'claimed_at' => null
                ],
                [
                    'started_at' => now(),
                    'viewed_at' => now(),
                    'assigned_price' => $validated['price']
                ]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Failed to start task', [
                'user_id' => $user->id,
                'task_id' => $id,
                'error'   => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to start task'
            ], 500);
        }



        return response()->json([
            'success'        => true,
            'message'        => 'Task session continued',
        ]);
    }

    public function claimTask(Request $request, $id)
    {
        $user = Auth::user();

        $task = Task::findOrFail($id);

        $log = UserTaskLog::where('user_id', $user->id)
            ->where('task_id', $id)
            ->whereNull('claimed_at')
            ->first();

        if (!$log || !$log->started_at) {
            return response()->json([
                'success' => false,
                'message' => 'Task not started'
            ]);
        }

        // Timer validation
        $startedAt = Carbon::parse($log->started_at);
        $elapsed = $startedAt->diffInSeconds(now());

        if ($elapsed < $task->duration) {
            return response()->json([
                'success' => false,
                'message' => 'Watch the full task first'
            ]);
        }

        try {
            DB::beginTransaction();

            $now = now();

            // Use the price that was stored when task was started
            $reward = (float) ($log->assigned_price ?? 0);

            if ($reward <= 0) {
                throw new \Exception('Invalid reward amount');
            }

            // Lock user row
            $lockedUser = DB::table('users')
                ->where('id', $user->id)
                ->lockForUpdate()
                ->first();

            if (!$lockedUser) {
                throw new \Exception('User not found');
            }

            // Update balance
            DB::table('users')
                ->where('id', $user->id)
                ->increment('balance', $reward);

            // Transaction record
            DB::table('transactions')->insert([
                'user_id'    => $user->id,
                'amount'     => $reward,
                'trx_type'   => 'task_reward',
                'detail'     => "Reward for completing task #{$task->id} ({$task->name})",
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Notification
            DB::table('notifications')->insert([
                'id'              => Str::uuid(),
                'type'            => 'TaskReward',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id'   => $user->id,
                'data'            => json_encode([
                    'message'  => "You earned Rs {$reward} for completing '{$task->name}'",
                    'amount'   => $reward,
                    'task_id'  => $task->id,
                    'type'     => 'task_reward'
                ]),
                'created_at'      => $now,
                'updated_at'      => $now,
            ]);

            // Update log
            $log->update([
                'claimed_at' => $now,
                'reward'     => $reward,
                'status'     => 'claimed'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reward claimed successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Task claim failed', [
                'user_id' => $user->id,
                'task_id' => $id,
                'error'   => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }



    public function my_complaints()
    {
        if (auth()->user()->is_complaint_allowed == 0) {
            return redirect()->back()->with('error', 'You are not allowed to view complaints.');
        }

        $complaints = Complaint::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);   // or ->get() if you prefer no pagination

        return view('user.my_complaints', compact('complaints'));
    }

    public function contact_us()
    {

        $msgs = DB::select('SELECT * FROM contact');
        return view('admin.contact', [
            'msgs' => $msgs
        ]);
    }

    public function manage_packages()
    {
        return view('admin.manage_packages', []);
    }

    public function add_services()
    {
        if (Auth::check()) {

            $services = DB::select('SELECT * FROM services');
            return view('admin.add_services', [
                'services' => $services
            ]);
        } else {
            return redirect('login')->with('error', 'you are not allowed to access');
        }
    }

    public function add_product()
    {

        $products = DB::select('SELECT * FROM products');
        $categories = DB::select('SELECT * FROM categories');
        return view('admin.add_product', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function add_category()
    {

        $categories = DB::select('SELECT * FROM categories');
        return view('admin.add_category', [
            'categories' => $categories
        ]);
    }


    public function service()
    {
        $service = DB::select('SELECT * FROM services');
        return view('service', [
            'service' => $service
        ]);
    }

    public function products()
    {
        $products = DB::select('SELECT * FROM products');
        return view('products', [
            'products' => $products
        ]);
    }

    public function badges()
    {
        $products = DB::select('SELECT * FROM products WHERE category = "badge"');
        return view('badges', [
            'products' => $products
        ]);
    }

    public function delete_blogs($blog_id)
    {
        $delete = DB::delete('DELETE FROM blog WHERE blog_id = ?', [$blog_id]);
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Data Not Deleted, Technical Error');
        }
    }

    public function delete_service($service_id)
    {
        $delete = DB::delete('DELETE FROM services WHERE service_id  = ?', [$service_id]);
        if ($delete or $delete2) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Data Not Deleted, Technical Error');
        }
    }

    // Edit Product
    public function edit_product($id)
    {
        // Retrieve the product by ID using Query Builder
        $product = DB::table('products')->where('id', $id)->first();
        $categories = DB::table('categories')->get();

        // Check if the product exists
        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        // Load the edit product page with the product data
        return view('admin.edit_product', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function edit_category($id)
    {
        // Retrieve the category by ID using Query Builder
        $category = DB::table('categories')->where('id', $id)->first();

        // Check if the category exists
        if (!$category) {
            return back()->with('error', 'Category not found.');
        }

        // Load the edit category page with the category data
        return view('admin.edit_category', ['category' => $category]);
    }

    //edit blog
    public function edit_blogs($blog_id)
    {
        $blogs = DB::table('blog')
            ->where('blog_id', '=', $blog_id)
            ->get();
        $blogs = json_decode($blogs, true);
        return view('admin.edit_blogs', ['blogs' => $blogs]);
    }

    public function edit_service($service_id)
    {
        $services = DB::table('services')
            ->where('service_id', '=', $service_id)
            ->get();
        $services = json_decode($services, true);
        return view('admin.edit_service', ['services' => $services]);
    }


    public function blogs_detail($slug)
    {
        $blog = DB::table('blog')
            ->where('slug', '=', $slug)
            ->get();

        // Define $recent_blogs instead of $blogs
        $recent_blogs = DB::select('SELECT * FROM blog ORDER BY blog_id DESC LIMIT 10');

        return view('/blog_details', [
            'blog' => $blog,
            'blogs' => $recent_blogs // Pass $recent_blogs here
        ]);
    }

    public function services_detail($slug)
    {
        $service = DB::table('services')
            ->where('slug', '=', $slug)
            ->get();


        $services = DB::select('SELECT * FROM services ORDER BY service_id DESC LIMIT 10');


        return view('/services_detail', [
            'service' => $service,
            'services' => $services
        ]);
    }

    public function product_detail($slug)
    {
        $product = DB::table('products')
            ->where('slug', '=', $slug)
            ->get();


        $products = DB::select('SELECT * FROM products ORDER BY id DESC LIMIT 10');


        return view('/product_detail', [
            'product' => $product,
            'products' => $products
        ]);
    }




    public function reset_password(string $token)
    {
        //$token = Request::segment(2);

        $user_record = DB::select('SELECT email FROM password_reset WHERE token = "' . $token . '" ORDER BY created_at DESC LIMIT 1');

        if (empty($user_record)) {
            return redirect()->to('login')->with('error', 'Link Expired or Time Out');
        }

        $email = $user_record[0]->email;
        return view('auth.reset_password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    // public function reset_password(){
    //  return view('auth.reset_password');
    // }

    public function reset_password_change(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $updatePassword = DB::table('password_reset')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid Security Key or Time Out!');
        }

        $user = DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('success', 'Your password has been changed!');
    }


    public function sendResetLink(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        $user = DB::table('users')->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        } else {

            DB::table('password_reset')->where('email', $email)->delete();
            $token = Str::random(64);
            DB::table('password_reset')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('emails.reset_password_link', ['token' => $token], function ($message) use ($request) {
                $message->from('secure@botaex.com', 'BotaEx');
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return back()->with('success', 'We have e-mailed your password reset link!');
        }
    }

    public function forgot_password()
    {
        return view('auth.forgot_password');
    }

    public function user_profile()
    {
        $user = DB::table('users')->where('id', auth()->user()->id)->first();

        if (!$user) {
            // Handle the case where the user with the given ID is not found
            return redirect()->back()->with('error', 'User not found');
        }

        return view('user.profile', [
            'user' => $user
        ]);
    }

    public function checkUsernameProfile(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:30|regex:/^[A-Za-z0-9_.-]+$/'
        ]);

        $username = $request->username;
        $currentUserId = auth()->id();

        $exists = User::where('username', $username)
            ->where('id', '!=', $currentUserId)
            ->exists();

        return response()->json([
            'available' => !$exists,
            'message'   => $exists ? 'This username is already taken' : null
        ]);
    }

    public function update_user_profile(Request $request)
    {
        $request->validate([
            'name'    => 'nullable|string|max:255',
            'username' => 'required|string|min:3|max:30|regex:/^[A-Za-z0-9_.-]+$/|unique:users,username,' . auth()->id(),
            'phone'   => 'required|string|max:20|unique:users,phone,' . auth()->id(),
            'whatsapp' => 'nullable|string|max:20|unique:users,whatsapp,' . auth()->id(),
            'email'   => 'nullable|email|max:255|unique:users,email,' . auth()->id(),
            'pic'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB
        ]);

        $user = auth()->user();

        // Handle avatar upload
        if ($request->hasFile('pic')) {
            // Delete old avatar if it exists
            if ($user->pic) {
                $oldPath = public_path('uploads/user/' . $user->pic);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Store the new file and get the path
            $file = $request->file('pic');

            // Option 1: Simple filename (recommended for most cases)
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->move(public_path('uploads/user'), $filename);
            // → then $path would be full server path → you usually want relative path

            // Most common & clean approach (using storage):
            $user->pic = 'uploads/user/' . $filename;
        }

        // Update other fields (only if provided)
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }
        if ($request->filled('whatsapp')) {
            $user->whatsapp = $request->whatsapp;
        }
        if ($request->filled('username')) {
            $user->username = $request->username;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function my_profile()
    {
        $user = DB::table('users')->where('id', auth()->user()->id)->first();

        if (!$user) {
            // Handle the case where the user with the given ID is not found
            return redirect()->back()->with('error', 'User not found');
        }

        return view('admin.user_profile', [
            'user' => $user
        ]);
    }

    public function delete_account(Request $request)
    {
        $user = $request->user();

        // 1️⃣ Validate password confirmation
        $request->validate([
            'password' => ['required'],
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'The provided password is incorrect.'
            ]);
        }

        if ($user->balance < 0) {
            return back()->withErrors([
                'error' => 'Cannot delete account: Your balance is negative. Please settle your dues first.'
            ])->withInput();
        }

        // 2️⃣ Logout before deleting
        Auth::logout();

        // 3️⃣ Delete user (Soft delete recommended)
        $user->delete();

        // 4️⃣ Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Your account has been deleted successfully.');
    }


    public function invite()
    {
        $user = auth()->user();

        // ---------- Level 1 ----------
        // Get all Level 1 user IDs (for totals, not display)
        $level1_ids = User::where('referred_by', $user->id)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->pluck('id');

        $level1_count = $level1_ids->count();

        // Total business (sum of approved payments)
        $level1_business = Payment::whereIn('user_id', $level1_ids)
            ->where('status', 'approved')
            ->sum('amount');

        // Total commission for Level 1
        $level1_commission = Payment::whereIn('user_id', $level1_ids)
            ->where('status', 'approved')
            ->join('packages', 'payments.plan_id', '=', 'packages.id')
            ->selectRaw('SUM(payments.amount * (packages.referral_bonus_level1 / 100)) as total')
            ->value('total') ?? 0;

        // Paginated Level 1 users for display (first 5)
        $level1_users = User::whereIn('id', $level1_ids)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['id', 'name', 'username', 'created_at']);

        // Add invested amount to each user in the current page
        foreach ($level1_users as $u) {
            $u->total_invested = Payment::where('user_id', $u->id)
                ->where('status', 'approved')
                ->sum('amount');
        }

        // ---------- Level 2 ----------
        // Get all Level 2 user IDs (using a subquery for efficiency)
        $level2_ids = User::whereIn('referred_by', function ($query) use ($user) {
            $query->select('id')
                ->from('users')
                ->where('referred_by', $user->id)
                ->where('status', 1);
        })->where('status', 1)->pluck('id');

        $level2_count = $level2_ids->count();

        $level2_business = Payment::whereIn('user_id', $level2_ids)
            ->where('status', 'approved')
            ->sum('amount');

        $level2_commission = Payment::whereIn('user_id', $level2_ids)
            ->where('status', 'approved')
            ->join('packages', 'payments.plan_id', '=', 'packages.id')
            ->selectRaw('SUM(payments.amount * (packages.referral_bonus_level2 / 100)) as total')
            ->value('total') ?? 0;

        // Paginated Level 2 users for display
        $level2_users = User::whereIn('id', $level2_ids)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['id', 'name', 'username', 'created_at']);

        foreach ($level2_users as $u) {
            $u->total_invested = Payment::where('user_id', $u->id)
                ->where('status', 'approved')
                ->sum('amount');
        }

        // ---------- Totals ----------
        $total_team_business   = $level1_business + $level2_business;
        $total_team_commission = $level1_commission + $level2_commission;

        // User package (unchanged)
        $user_package_id = Payment::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('approved_at', '<=', now())
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'desc')
            ->value('plan_id');

        $user_package = DB::table('packages')->where('id', $user_package_id)->first();

        return view('user.invite', compact(
            'level1_count',
            'level1_business',
            'level1_commission',
            'level1_users',
            'level2_count',
            'level2_business',
            'level2_commission',
            'level2_users',
            'total_team_business',
            'total_team_commission',
            'user_package'
        ));
    }

    /**
     * AJAX: Load more Level 1 members.
     */
    public function loadMoreLevel1(Request $request)
    {
        $user = auth()->user();
        $page = $request->get('page', 1);

        $users = User::where('referred_by', $user->id)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['id', 'name', 'username', 'created_at'], 'page', $page);

        foreach ($users as $u) {
            $u->total_invested = Payment::where('user_id', $u->id)
                ->where('status', 'approved')
                ->sum('amount');
        }

        $html = view('user.partials.user_list_items', ['users' => $users])->render();

        return response()->json([
            'html'          => $html,
            'hasMorePages'  => $users->hasMorePages(),
            'nextPage'      => $users->currentPage() + 1,
        ]);
    }

    /**
     * AJAX: Load more Level 2 members.
     */
    public function loadMoreLevel2(Request $request)
    {
        $user = auth()->user();
        $page = $request->get('page', 1);

        $users = User::whereIn('referred_by', function ($query) use ($user) {
            $query->select('id')
                ->from('users')
                ->where('referred_by', $user->id)
                ->where('status', 1);
        })->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['id', 'name', 'username', 'created_at'], 'page', $page);

        foreach ($users as $u) {
            $u->total_invested = Payment::where('user_id', $u->id)
                ->where('status', 'approved')
                ->sum('amount');
        }

        $html = view('user.partials.user_list_items', ['users' => $users])->render();

        return response()->json([
            'html'          => $html,
            'hasMorePages'  => $users->hasMorePages(),
            'nextPage'      => $users->currentPage() + 1,
        ]);
    }
    private function calculateReferralCommission($users, $level)
    {
        $total = 0;

        foreach ($users as $downline) {
            $payments = Payment::where('user_id', $downline->id)
                ->where('status', 'approved')
                ->with('package')           // assuming relation: belongsTo(Package::class, 'plan_id')
                ->get();

            foreach ($payments as $payment) {
                if (!$payment->package) continue;

                $percent = $level === 1
                    ? $payment->package->referral_bonus_level1
                    : $payment->package->referral_bonus_level2;

                $commission = $payment->amount * ($percent / 100);
                $total += $commission;
            }
        }

        return round($total, 2);
    }

    public function my_plans()
    {
        $user = auth()->user();

        $baseQuery = DB::table('payments')
            ->join('packages', 'payments.plan_id', '=', 'packages.id')
            ->leftJoin('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
            ->where('payments.user_id', $user->id)
            ->select(
                'payments.*',
                'payments.id as payment_id',
                'packages.name as package_name',
                'packages.daily_profit_min',
                'packages.daily_profit_max',
                'packages.duration_days',
                'packages.daily_tasks',
                'packages.daily_task_price',
                'packages.free_spins',
                'packages.free_spin_price',
                'packages.referral_bonus_level1',
                'packages.referral_bonus_level2',
                'packages.weekend_reward',
                'payment_methods.account_type as method_type',
                'payment_methods.account_title as method_title'
            )
            ->orderByDesc('payments.created_at');

        $allPayments = (clone $baseQuery)->get();

        $now = now();

        $processed = $allPayments->map(function ($payment) use ($now) {

            if ($payment->status !== 'approved' || !$payment->approved_at) {
                $payment->expires_at     = null;
                $payment->is_active      = false;
                $payment->days_remaining = 0;
            } else if (!$payment->expires_at) {
                // Edge case: approved but never got expires_at saved → fallback (or log error)
                $approvedAt  = Carbon::parse($payment->approved_at);
                $duration    = (int) ($payment->duration_days ?? 0);

                if ($duration > 0) {
                    $payment->expires_at = $approvedAt->addDays($duration)->toDateTimeString();
                } else {
                    $payment->expires_at = null;
                }
            }
            // ─── Main case: we trust the DB value ───
            else {
                $expiresAt = Carbon::parse($payment->expires_at);

                $rawDiff = $now->diffInDays($expiresAt, false);
                $daysLeft = max(0, (int) ceil($rawDiff));

                $payment->expires_at     = $expiresAt;           // already Carbon or string — keep consistent
                $payment->days_remaining = $daysLeft;
                $payment->is_active      = $now->lt($expiresAt);
            }

            // Daily profit display (unchanged)
            if ($payment->daily_profit_min == $payment->daily_profit_max) {
                $payment->daily_profit_display = number_format($payment->daily_profit_min, 0);
            } else {
                $payment->daily_profit_display = number_format($payment->daily_profit_min, 0)
                    . ' – ' . number_format($payment->daily_profit_max, 0);
            }

            return $payment;
        });

        // Grouping (unchanged)
        $active   = $processed->filter(fn($p) => $p->is_active)->values();
        $pending  = $processed->where('status', 'pending')->values();
        $rejected = $processed->where('status', 'rejected')->values();
        $cancelled = $processed->where('status', 'cancelled')->values();
        $expired  = $processed->filter(fn($p) => $p->status === 'approved' && !$p->is_active)->values();

        $activeCount = $active->count();

        // For debugging — remove in production
        // echo '<pre>'; print_r($active->toArray()); echo '</pre>'; die();

        return view('user.my_plans', compact(
            'active',
            'pending',
            'rejected',
            'cancelled',
            'expired',            
            'activeCount'
        ));
    }

    public function my_investments()
    {
        return view('user.my_investments');
    }

    public function deposit_history()
    {
        return view('user.deposit_history');
    }

    public function all_transactions(Request $request)
    {
        $perPage = 4;

        $query = Transaction::with('user')
            ->where('user_id', auth()->id())
            ->latest();

        $transactions = $query->paginate($perPage);

        if ($request->ajax()) {
            // Return **only** the items – no layout
            return view('user.partials.transactions-list', compact('transactions'))->render();
        }

        return view('user.all_transactions', compact('transactions'));
    }



    public function withdraw_history()
    {
        $user = auth()->user();

        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);  // or ->get() if you prefer no pagination

        return view('user.withdraw_history', compact('withdrawals'));
    }

    public function userDetails($id)
    {
        $user = User::with('referrer')->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        return view('admin.user_details', [
            'user' => $user,
        ]);
    }

    public function toggleSensitive(Request $request, $id)
    {
        $request->validate([
            'is_sensitive' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);

        $user->is_sensitive = $request->is_sensitive;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Sensitivity updated successfully',
            'is_sensitive' => $user->is_sensitive,
        ]);
    }

    public function toggleTasksAllowed(Request $request, $id)
    {
        $request->validate([
            'is_tasks_allowed' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);

        $user->is_tasks_allowed = $request->is_tasks_allowed;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Tasks allowed updated successfully',
            'is_tasks_allowed' => $user->is_tasks_allowed,
        ]);
    }

    public function toggleBalanceSharing(Request $request, $id)
    {
        $request->validate([
            'is_balance_sharing_allowed' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);

        $user->is_balance_sharing_allowed = $request->is_balance_sharing_allowed;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Balance sharing allowed updated successfully',
            'is_balance_sharing_allowed' => $user->is_balance_sharing_allowed,
        ]);
    }


    public function toggleWithdraw(Request $request, $id)
    {
        $request->validate([
            'is_withdraw_allowed' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);

        $user->is_withdraw_allowed = $request->is_withdraw_allowed;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Withdraw allowed updated successfully',
            'is_withdraw_allowed' => $user->is_withdraw_allowed,
        ]);
    }

    public function toggleWithdrawTimer(Request $request, $id)
    {
        $request->validate([
            'withdraw_timer' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);

        $user->withdraw_timer = $request->withdraw_timer;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Withdraw timer updated successfully',
            'withdraw_timer' => $user->withdraw_timer,
        ]);
    }

    public function toggleWithdrawWithoutPackage(Request $request, $id)
    {
        $request->validate([
            'withdraw_without_package' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);

        $user->withdraw_without_package = $request->withdraw_without_package;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Withdraw without package allowed updated successfully',
            'withdraw_without_package' => $user->withdraw_without_package,
        ]);
    }

    public function toggleComplaint(Request $request, $id)
    {
        $request->validate([
            'is_complaint_allowed' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);

        $user->is_complaint_allowed = $request->is_complaint_allowed;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Complaint allowed updated successfully',
            'is_complaint_allowed' => $user->is_complaint_allowed,
        ]);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }

    public function users()
    {
        $users = User::with('referrer')
            ->withCount(['payments as active_plans_count' => function ($q) {
                $q->where('status', 'approved');
                $q->where('expires_at', '>=', now());   // if needed
            }])
            ->get();

        return view('admin.users', compact('users'));
    }


    public function dashboard()
    {
        $now = now();
        // 1. Total users (type = 1)
        $total_users = User::where('type', 1)->count();

        // 2. Users with ZERO payments ever
        $users_never_had_plan = User::where('type', 1)
            ->whereDoesntHave('payments')           // assumes you have payments() relationship
            ->count();

        // Alternative without relationship (safer if you haven't defined it yet):
        $users_never_had_plan = User::where('type', 1)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('payments')
                    ->whereColumn('payments.user_id', 'users.id');
            })
            ->count();

        // 3. Users who have at least one payment, but NO currently active payment
        $users_with_expired_or_no_active_plan = User::where('type', 1)
            ->whereExists(function ($q) {                   // has at least one payment
                $q->select(DB::raw(1))
                    ->from('payments')
                    ->whereColumn('payments.user_id', 'users.id');
            })
            ->whereDoesntHave('payments', function ($q) use ($now) {   // but none active now
                $q->where('status', 'approved')
                    ->whereNotNull('approved_at')
                    ->whereNotNull('expires_at')
                    ->where('expires_at', '>', $now);
            })
            ->count();

        // Alternative version without relationship (using subqueries only):
        $users_with_expired_or_no_active_plan = User::where('type', 1)
            ->whereExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('payments')
                    ->whereColumn('payments.user_id', 'users.id');
            })
            ->whereNotExists(function ($q) use ($now) {
                $q->select(DB::raw(1))
                    ->from('payments')
                    ->whereColumn('payments.user_id', 'users.id')
                    ->where('status', 'approved')
                    ->whereNotNull('approved_at')
                    ->whereNotNull('expires_at')
                    ->where('expires_at', '>', $now);
            })
            ->count();
        // Existing sums
        $total_deposits = Payment::where('status', 'approved')->where('payment_method_id', '!=', 100)->sum('amount');
        $total_withdrawals = Withdrawal::where('status', 'approved')->sum('amount');

        $todays_deposits = Payment::where('status', 'approved')
            ->whereDate('approved_at', now())->sum('amount');
        $todaysPendingDeposits = Payment::where('status', 'pending')
            ->whereDate('created_at', now())->sum('amount');

        $todayswithdrawals = Withdrawal::where('status', 'approved')
            ->whereDate('approved_at', now())->sum('amount');
        $todayspendingWithdrawals = Withdrawal::where('status', 'pending')
            ->whereDate('created_at', now())->sum('amount');

        // Tasks rewards sums
        $tasksRewardToday = DB::table('user_task_logs')
            ->whereDate('claimed_at', now())->sum('reward');
        $tasksRewardTotal = DB::table('user_task_logs')->sum('reward');

        // Tasks count (total tasks available)
        $totaltasks = DB::table('tasks')->count();

        // Total balance of all users
        $allUsersCurrentBalance = DB::table('users')->sum('balance');

        // Service fee sum and count (already present)
        $serviceFee = DB::table('transactions')
            ->where('trx_type', 'service_fee')
            ->selectRaw('SUM(amount) as total_amount, COUNT(*) as total_count')
            ->first();
        $serviceFeeSum = $serviceFee->total_amount;
        $serviceFeeCount = $serviceFee->total_count;

        // ========== NEW COUNT VARIABLES ==========
        // Counts for deposits
        $total_deposits_count = Payment::where('status', 'approved')->count();
        $total_withdrawals_count = Withdrawal::where('status', 'approved')->count();

        // Today's approved deposits count
        $todays_deposits_count = Payment::where('status', 'approved')
            ->whereDate('approved_at', now())->count();

        // Today's pending deposits count
        $todaysPendingDeposits_count = Payment::where('status', 'pending')
            ->whereDate('created_at', now())->count();

        // Today's approved withdrawals count
        $todayswithdrawals_count = Withdrawal::where('status', 'approved')
            ->whereDate('approved_at', now())->count();

        // Today's pending withdrawals count
        $todayspendingWithdrawals_count = Withdrawal::where('status', 'pending')
            ->whereDate('created_at', now())->count();

        // Tasks claimed counts (number of times tasks were claimed)
        $tasksClaimedToday_count = DB::table('user_task_logs')
            ->whereDate('claimed_at', now())->count();
        $tasksClaimedTotal_count = DB::table('user_task_logs')->count();

        // All-time totals
        $allTimeSpins = DB::table('transactions')
            ->selectRaw("
        COUNT(*) as total_spins,
        SUM(amount) as total_spins_amount,
        
        SUM(CASE WHEN trx_type = 'spin_win' THEN 1 ELSE 0 END) as total_wins,
        SUM(CASE WHEN trx_type = 'spin_win' THEN amount ELSE 0 END) as total_wins_amount,
        
        SUM(CASE WHEN trx_type = 'spin_bet' THEN 1 ELSE 0 END) as total_bets,
        SUM(CASE WHEN trx_type = 'spin_bet' THEN amount ELSE 0 END) as total_bets_amount
    ")
            ->whereIn('trx_type', ['spin_win', 'spin_bet'])
            ->first();

        // Today's stats (only wins + bets)
        $todaySpins = DB::table('transactions')
            ->selectRaw("
        SUM(CASE WHEN trx_type = 'spin_win' THEN 1 ELSE 0 END) as today_wins,
        SUM(CASE WHEN trx_type = 'spin_win' THEN amount ELSE 0 END) as today_wins_amount,
        
        SUM(CASE WHEN trx_type = 'spin_bet' THEN 1 ELSE 0 END) as today_bets,
        SUM(CASE WHEN trx_type = 'spin_bet' THEN amount ELSE 0 END) as today_bets_amount
    ")
            ->whereIn('trx_type', ['spin_win', 'spin_bet'])
            ->whereDate('created_at', now()->toDateString())
            ->first();



        // Burst Numbers All-time totals
        $allTimeBursts = DB::table('transactions')
            ->selectRaw("
        COUNT(*) as total_bursts,
        SUM(amount) as total_bursts_amount,
        
        SUM(CASE WHEN trx_type = 'burst_win' THEN 1 ELSE 0 END) as total_burst_wins,
        SUM(CASE WHEN trx_type = 'burst_win' THEN amount ELSE 0 END) as total_burst_wins_amount,
        
        SUM(CASE WHEN trx_type = 'burst_bet' THEN 1 ELSE 0 END) as total_burst_bets,
        SUM(CASE WHEN trx_type = 'burst_bet' THEN amount ELSE 0 END) as total_burst_bets_amount
    ")
            ->whereIn('trx_type', ['burst_win', 'burst_bet'])
            ->first();

        // Burst Numbers Today's stats (only wins + bets)
        $todayBursts = DB::table('transactions')
            ->selectRaw("
        SUM(CASE WHEN trx_type = 'burst_win' THEN 1 ELSE 0 END) as today_wins,
        SUM(CASE WHEN trx_type = 'burst_win' THEN amount ELSE 0 END) as today_wins_amount,
        
        SUM(CASE WHEN trx_type = 'burst_bet' THEN 1 ELSE 0 END) as today_bets,
        SUM(CASE WHEN trx_type = 'burst_bet' THEN amount ELSE 0 END) as today_bets_amount
    ")
            ->whereIn('trx_type', ['burst_win', 'burst_bet'])
            ->whereDate('created_at', now()->toDateString())
            ->first();



        // Profit Balls All-time totals
        $allTimeProfitBalls = DB::table('transactions')
            ->selectRaw("
        COUNT(*) as total_profit_balls,
        SUM(amount) as total_profit_balls_amount,
        
        SUM(CASE WHEN trx_type = 'profit_balls_win' THEN 1 ELSE 0 END) as total_profit_balls_wins,
        SUM(CASE WHEN trx_type = 'profit_balls_win' THEN amount ELSE 0 END) as total_profit_balls_wins_amount,
        
        SUM(CASE WHEN trx_type = 'profit_balls_bet' THEN 1 ELSE 0 END) as total_profit_balls_bets,
        SUM(CASE WHEN trx_type = 'profit_balls_bet' THEN amount ELSE 0 END) as total_profit_balls_bets_amount
    ")
            ->whereIn('trx_type', ['profit_balls_win', 'profit_balls_bet'])
            ->first();

        // Profit Balls Today's stats (only wins + bets)
        $todayProfitBalls = DB::table('transactions')
            ->selectRaw("
        SUM(CASE WHEN trx_type = 'profit_balls_win' THEN 1 ELSE 0 END) as today_wins,
        SUM(CASE WHEN trx_type = 'profit_balls_win' THEN amount ELSE 0 END) as today_wins_amount,
        
        SUM(CASE WHEN trx_type = 'profit_balls_bet' THEN 1 ELSE 0 END) as today_bets,
        SUM(CASE WHEN trx_type = 'profit_balls_bet' THEN amount ELSE 0 END) as today_bets_amount
    ")
            ->whereIn('trx_type', ['profit_balls_win', 'profit_balls_bet'])
            ->whereDate('created_at', now()->toDateString())
            ->first();

        $internalBalanceUsage = Payment::where('status', 'approved')
            ->where(function ($query) {
                $query->where('payment_method_id', 100)
                    ->orWhere('is_upgrade', 1);
            });

        $internalBalanceUsageCount = $internalBalanceUsage->count();
        $internalBalanceUsageAmount   = $internalBalanceUsage->sum('amount');

        $balanceShare = Transaction::where('trx_type', 'balance_transfer_sent')
            ->selectRaw('SUM(amount) as total_amount, COUNT(*) as total_count')
            ->first();
        $balanceShareAmount = $balanceShare->total_amount;
        $balanceShareCount = $balanceShare->total_count;

        // <!-- Top 5 Investors -->
        $topDepositors = User::query()
            ->select(
                'users.id',
                'users.username',
                'users.name',
                'users.phone',
                'users.email',
                'users.balance',
                DB::raw('COUNT(payments.id) as deposit_count'),
                DB::raw('COALESCE(SUM(payments.amount), 0) as total_deposited')
            )
            ->leftJoin('payments', function ($join) {
                $join->on('users.id', '=', 'payments.user_id')
                    ->where('payments.status', '=', 'approved');
            })
            ->groupBy('users.id', 'users.username', 'users.name', 'users.phone', 'users.email', 'users.balance')
            ->havingRaw('total_deposited > 0')
            ->orderByDesc('total_deposited')
            ->limit(5)
            ->get();
        //Top 5 Withdrawers
        $topWithdrawers = User::query()
            ->select(
                'users.id',
                'users.username',
                'users.name',
                'users.phone',
                'users.email',
                'users.balance',
                DB::raw('COUNT(withdrawals.id) as withdrawal_count'),
                DB::raw('COALESCE(SUM(withdrawals.amount), 0) as total_withdrawn')
            )
            ->leftJoin('withdrawals', function ($join) {
                $join->on('users.id', '=', 'withdrawals.user_id')
                    ->where('withdrawals.status', '=', 'approved');
            })
            ->groupBy('users.id', 'users.username', 'users.name', 'users.phone', 'users.email', 'users.balance')
            ->havingRaw('total_withdrawn > 0')
            ->orderByDesc('total_withdrawn')
            ->limit(5)
            ->get();

        $topTaskUsersByCount = User::query()
            ->select(
                'users.id',
                'users.username',
                'users.name',
                'users.phone',
                'users.email',
                'users.balance',
                DB::raw('COUNT(user_task_logs.id) as task_count'),
                DB::raw('COALESCE(SUM(user_task_logs.reward), 0) as total_task_reward')
            )
            ->join('user_task_logs', 'users.id', '=', 'user_task_logs.user_id')
            ->whereIn('user_task_logs.status', ['claimed', 'completed'])  // adjust if only 'claimed' counts
            ->groupBy(
                'users.id',
                'users.username',
                'users.name',
                'users.phone',
                'users.email',
                'users.balance'
            )
            ->having('task_count', '>', 0)
            ->orderByDesc('task_count')
            ->limit(5)
            ->get();


        $topSpinBetUsers = \App\Models\User::query()
            ->select(
                'users.id',
                'users.username',
                'users.name',
                'users.phone',
                'users.email',
                'users.balance',
                \DB::raw('COUNT(transactions.id) as bet_count'),
                \DB::raw('COALESCE(SUM(transactions.amount), 0) as total_bet_amount')
            )
            ->join('transactions', 'users.id', '=', 'transactions.user_id')
            ->where('transactions.trx_type', 'spin_bet')
            ->groupBy(
                'users.id',
                'users.username',
                'users.name',
                'users.phone',
                'users.email',
                'users.balance'
            )
            ->having('total_bet_amount', '>', 0)
            ->orderByDesc('total_bet_amount')
            ->limit(5)
            ->get();

        $topSpinWinUsers = \App\Models\User::query()
            ->select(
                'users.id',
                'users.username',
                'users.name',
                'users.phone',
                'users.email',
                'users.balance',
                \DB::raw('COUNT(transactions.id) as win_count'),
                \DB::raw('COALESCE(SUM(transactions.amount), 0) as total_win_amount')
            )
            ->join('transactions', 'users.id', '=', 'transactions.user_id')
            ->where('transactions.trx_type', 'spin_win')
            ->groupBy(
                'users.id',
                'users.username',
                'users.name',
                'users.phone',
                'users.email',
                'users.balance'
            )
            ->having('total_win_amount', '>', 0)
            ->orderByDesc('total_win_amount')
            ->limit(5)
            ->get();

        // top 5 users having heighest balance (excluding admins)
        $topBalances = User::where('type', 1) // only regular users
            ->orderByDesc('balance')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'total_users',
            'users_never_had_plan',
            'users_with_expired_or_no_active_plan',
            'total_deposits',
            'total_withdrawals',
            'todays_deposits',
            'todaysPendingDeposits',
            'todayswithdrawals',
            'todayspendingWithdrawals',
            'totaltasks',
            'tasksRewardToday',
            'tasksRewardTotal',
            'allUsersCurrentBalance',
            'serviceFeeSum',
            'serviceFeeCount',
            // New count variables
            'total_deposits_count',
            'total_withdrawals_count',
            'todays_deposits_count',
            'todaysPendingDeposits_count',
            'todayswithdrawals_count',
            'todayspendingWithdrawals_count',
            'tasksClaimedToday_count',
            'tasksClaimedTotal_count',
            'allTimeSpins',
            'todaySpins',
            'allTimeBursts',
            'todayBursts',
            'allTimeProfitBalls',
            'todayProfitBalls',
            'internalBalanceUsageCount',
            'internalBalanceUsageAmount',
            'balanceShareAmount',
            'balanceShareCount',
            'topDepositors',
            'topWithdrawers',
            'topTaskUsersByCount',
            'topSpinBetUsers',
            'topSpinWinUsers',
            'topBalances'
        ));
    }

    public function user_dashboard()
    {
        $user = auth()->user();
        // echo $user->withdraw_timer; die;

        // Level 1
        $level1_ids = User::where('referred_by', $user->id)
            ->where('status', 1)
            ->pluck('id');

        $level1_count    = $level1_ids->count();
        $level1_business = Payment::whereIn('user_id', $level1_ids)
            ->where('status', 'approved')
            ->sum('amount');

        // Level 2
        $level2_ids = User::whereIn('referred_by', $level1_ids)
            ->where('status', 1)
            ->pluck('id');

        $level2_count    = $level2_ids->count();
        $level2_business = Payment::whereIn('user_id', $level2_ids)
            ->where('status', 'approved')
            ->sum('amount');

        // Team Stats
        $team_size   = $level1_count + $level2_count;
        $team_invest = $level1_business + $level2_business;

        // User's own deposit
        $total_deposit = Payment::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');

        // Total Withdraw (approved)
        $total_withdraw = Withdrawal::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');

        // Total Withdraw (pending)
        $total_withdraw_pending = Withdrawal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');

        $refer_bonus = Transaction::where('user_id', $user->id)
            ->where('trx_type', 'referral_bonus')
            ->sum('amount');

        $dailyProfit = Transaction::where('user_id', $user->id)
            ->where('trx_type', 'daily_reward')
            ->sum('amount');

        // Count tasks started today
        $myTasksToday = DB::table('user_task_logs')
            ->where('user_id', $user->id)
            ->where('started_at', '>=', now()->startOfDay())
            ->count();

        // Count all tasks for the user (total ever)
        $myTasksTotal = DB::table('user_task_logs')
            ->where('user_id', $user->id)
            ->count();


        $coolDownDays = (int) config('app.withdraw_cool_down_days', 0);

        $lastWithdrawalTime = Withdrawal::where('user_id', $user->id)
            ->latest('updated_at')
            ->value('updated_at');

        $nextWithdrawTime = null;
        $isCooldownActive = false;

        if ($lastWithdrawalTime && $coolDownDays > 0) {
            $nextWithdrawTime = Carbon::parse($lastWithdrawalTime)
                ->addDays($coolDownDays);

            $isCooldownActive = now()->lt($nextWithdrawTime);
        }

        $balanceTransfer = Transaction::where('user_id', $user->id)
            ->where('trx_type', 'balance_transfer_sent')
            ->sum('amount');

        $tasksReward = Transaction::where('user_id', $user->id)
            ->where('trx_type', 'task_reward')
            ->sum('amount');

        return view('user.user_dashboard', compact(
            'user',
            'team_size',
            'team_invest',
            'total_deposit',
            'total_withdraw',
            'total_withdraw_pending',
            'refer_bonus',
            'dailyProfit',
            'myTasksToday',
            'myTasksTotal',
            'isCooldownActive',
            'nextWithdrawTime',
            'balanceTransfer',
            'tasksReward'
        ));
    }


    public function updateContent()
    {
        $user = Auth::user();
        $user_id = $user['id'];
        $check = DB::select('SELECT * FROM mining WHERE status=0 AND user_id = "' . $user_id . '"');
        $wallet = DB::select('SELECT amount FROM mining_wallet WHERE user_id = "' . $user_id . '"');

        date_default_timezone_set('Asia/Karachi');

        $bonus = 0;
        $percentage = 0;

        if (isset($check[0]->start_time, $check[0]->end_time) && strtotime($check[0]->end_time) > strtotime(now())) {
            $startTime = strtotime($check[0]->start_time);
            $endTime = strtotime($check[0]->end_time);
            $currentTime = strtotime(now());

            // Calculate the absolute time difference in minutes
            $timeDifference = abs($currentTime - $startTime) / 60;

            // Calculate the percentage of time difference from 8 hours
            $totalMinutes = abs($endTime - $startTime) / 60;
            $percentage = ($timeDifference / $totalMinutes) * 100;

            // Calculate the bonus as 0.0167 of the amount per minute
            $amount = $wallet[0]->amount ?? 0;
            $bonusPerMinute = $timeDifference * 0.0167;
            $bonus = $bonusPerMinute;
        }

        $actual = isset($amount) ? $amount + $bonus : 0;

        // Render the partial view as a string
        $htmlContent = view('user.partial_view', compact('actual', 'percentage', 'check', 'wallet'))->render();

        // Return the HTML content as a JSON response
        return response()->json(['html' => $htmlContent]);
    }





    public function verify_email(Request $req)
    {
        $validation = $req->validate([
            'v_token' => 'required',
            'otp' => 'required'
        ]);

        if ($validation) {
            $token = $req->get('v_token');
            $otp = $req->get('otp');

            // Retrieve user by verification token and verify OTP
            $user = DB::table('users')->where('verification_token', $token)->first();

            // echo $user->otp;
            // die();

            if ($user && $user->otp == $otp) {
                // OTP matched, update user status
                $update = DB::table('users')->where('verification_token', $token)->update([
                    "status" => 1,
                    "verification_token" => 'verified',
                    "otp" => 1
                ]);

                if ($update) {
                    return redirect('/login')->with('success', 'OTP Verified Successfully');
                } else {
                    return back()->withInput()->with('error', 'Technical Error');
                }
            } else {
                return back()->withInput()->with('error', 'Incorrect OTP');
            }
        } else {
            return back()->withInput()->withErrors($validation);
        }
    }

    public function verify_otp($v_token)
    {
        // echo 'salman';
        // die();

        return view('auth.verify_otp', ['v_token' => $v_token]);
    }



    public function sendEmail(Request $request)
    {
        $email = $request->get('email');

        Mail::send('emails.test_mail', ['email' => $email], function ($message) {
            $message->from('secure@botaex.com', 'BotaEx');
            $message->to('salmanbhatti2010@gmail.com'); // Set your static email here
            $message->subject('Test Email');
        });
        echo 'Email sent successfully!';
    }

    //========login......
    public function postLogin(Request $request)
    {
        $validated = $request->validate([
            'login'     => 'required|string|min:3|max:30',
            'password'  => 'required|string|min:6',
        ]);

        $loginInput = $request->input('login');
        $fieldType  = is_numeric($loginInput) ? 'phone' : 'username';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->password,
        ];

        // Try to find the user first (without authenticating yet)
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        $isSensitive = $user && $user->is_sensitive;

        // Session key unique per login identifier (username/phone)
        $attemptKey = 'login_attempts_sensitive_' . md5($loginInput);

        $attempts = 0;
        $maxAttempts = 5;

        if ($isSensitive) {
            $attempts = session($attemptKey, 0);
        }

        // ────────────────────────────────────────────────
        // Try to log in
        // ────────────────────────────────────────────────
        if (! Auth::attempt($credentials)) {
            // Failed attempt

            if ($isSensitive) {
                $attempts++;
                session([$attemptKey => $attempts]);

                $message = 'Incorrect username/mobile or password.';

                if ($attempts >= $maxAttempts) {
                    // Deactivate the account
                    $user->status = 0;
                    $user->save();  // or $user->update(['status' => 0]);

                    // Optional: clear sensitive session data
                    session()->forget($attemptKey);

                    $message = 'Too many failed login attempts. Your account has been deactivated for security reasons. Please contact support.';
                } else {
                    $remaining = $maxAttempts - $attempts;
                    return back()
                        ->withInput($request->only('login'))
                        ->withErrors(['login' => $message])
                        ->with('attempts_left', $remaining);
                }
            }

            return back()
                ->withInput($request->only('login'))
                ->withErrors(['login' => $message ?? 'Incorrect username/mobile or password.']);
        }

        // ────────────────────────────────────────────────
        // SUCCESSFUL LOGIN
        // ────────────────────────────────────────────────
        if ($isSensitive) {
            // Reset counter on success
            session()->forget($attemptKey);
        }

        $request->session()->regenerate();

        $user = Auth::user();  // Now authenticated

        // Status checks (important: sensitive user might have been deactivated elsewhere)
        if ($user->status == 0) {
            Auth::logout();
            return redirect('/login')->with('error', 'Account is inactive.');
        }

        if ($user->status == 2) {
            Auth::logout();
            return redirect('/login')->with('error', 'Account is suspended.');
        }

        // Single-device logout for non-admins
        if ($user->type != 0) {
            Auth::logoutOtherDevices($request->password);
        }

        // Role-based redirect
        return in_array($user->type, [0, 2])
            ? redirect('dashboard')
            : redirect('pre-dashboard');
    }




    public function change_password()
    {
        return view('auth.change_password');
    }

    public function change_password_update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (! Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => 'required|string|min:6|confirmed', // confirmed = checks password_confirmation field
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        // Optional: force logout other devices (good security practice)
        Auth::logoutOtherDevices($validated['password']);

        return back()->with('success', 'Password changed successfully!');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register(Request $request, $code = null)
    {
        if (!empty($code)) {

            // Remove first 2 digits (26)
            $realId = substr($code, 2);

            // Validate it's numeric
            if (is_numeric($realId)) {

                $ref = DB::table('users')->where('id', $realId)->first();

                if ($ref) {
                    return view('auth.register', ['ref' => $ref]);
                }
            }
        }

        return view('auth.register');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Logged out successfully');
    }
}
