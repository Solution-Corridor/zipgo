<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App;
use Session;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Complaint;
use App\Models\ImportantNote;
use App\Models\MobApp;
use function Symfony\Component\Clock\now;

class Admin extends Controller
{

  public function deleteInactiveUsers()
  {
    $cutoffDate = Carbon::now()->subDays(15);
    $registrationCutoff = Carbon::now()->subDays(15);

    $users = User::where('type', 1) // 👈 only normal users
      ->whereDoesntHave('payments', function ($q) {
        $q->where('status', 'approved')
          ->where('approved_at', '<=', now())
          ->where('expires_at', '>', now());
      })
      ->where(function ($q) use ($cutoffDate, $registrationCutoff) {
        $q->whereHas('payments', function ($q2) use ($cutoffDate) {
          $q2->where('expires_at', '<', $cutoffDate);
        })
          ->orWhere(function ($q3) use ($registrationCutoff) {
            $q3->doesntHave('payments')
              ->where('created_at', '<', $registrationCutoff);
          });
      })
      ->get();

    DB::transaction(function () use ($users) {
      foreach ($users as $user) {
        $userId = $user->id;

        // Delete from all related tables manually
        DB::table('payments')->where('user_id', $userId)->delete();
        DB::table('complaints')->where('user_id', $userId)->delete();
        DB::table('kyc_verifications')->where('user_id', $userId)->delete();
        DB::table('transactions')->where('user_id', $userId)->delete();
        DB::table('withdrawals')->where('user_id', $userId)->delete();
        DB::table('user_task_logs')->where('user_id', $userId)->delete();
        DB::table('spin_histories')->where('user_id', $userId)->delete();
        DB::table('mk_orders')->where('user_id', $userId)->delete();
        DB::table('mk_product_reviews')->where('user_id', $userId)->delete();

        // Notifications (polymorphic)
        DB::table('notifications')
          ->where('notifiable_type', 'App\Models\User')
          ->where('notifiable_id', $userId)
          ->delete();

        // Delete the user
        $user->delete();
        Auth::logout($user);

        echo "Deleted User ID: {$user->id}, Username: {$user->username}<br>";
      }
    });

    return "Deleted " . $users->count() . " inactive users.";
  }

  public function importantNote(Request $request)
  {
    // Get the first (and usually only) record — or create new empty one
    $note = ImportantNote::firstOrNew(['id' => 1]); // You can also use first() + create if null

    if ($request->isMethod('post')) {
      $request->validate([
        'message' => 'nullable|string|max:65000', // text field limit
      ]);

      $note->message = $request->input('message');
      $note->save();

      return redirect()
        ->route('important_note')
        ->with('success', 'Important note has been updated.');
    }

    return view('admin.important_note', compact('note'));
  }


  public function mobileAppVersion(Request $request)
  {
    // Get the first (and usually only) record — or create new empty one
    $version = MobApp::firstOrNew(['id' => 1]); // You can also use first() + create if null

    if ($request->isMethod('post')) {
      $request->validate([
        'version' => 'required|string|max:255', // text field limit
      ]);

      $version->version = $request->input('version');
      $version->save();

      return redirect()
        ->route('mobile_app_version')
        ->with('success', 'Mobile app version has been updated.');
    }

    return view('admin.mobile_app_version', compact('version'));
  }

  public function dollarPrice(Request $request)
  {
    // Get the first (and usually only) record — or create new empty one
    $price = DollarPrice::firstOrNew(['id' => 1]); // You can also use first() + create if null

    if ($request->isMethod('post')) {
      $request->validate([
        'price' => 'required|string|max:255', // text field limit
      ]);

      $price->price = $request->input('price');
      $price->save();

      return redirect()
        ->route('dollar_price')
        ->with('success', 'Dollar price has been updated.');
    }

    return view('admin.dollar_price', compact('price'));
  }

  public function runningPackages()
  {
    $runningPackages = Payment::with(['user', 'package'])
      ->where('status', 'approved')
      ->where('expires_at', '>', now())
      ->orderBy('expires_at', 'asc')
      ->get();

    $expiredPackages = Payment::with(['user', 'package'])
      ->where('status', 'approved')
      ->where('expires_at', '<=', now())
      ->orderBy('expires_at', 'asc')
      ->get();

    return view('admin.running_packages', compact('runningPackages', 'expiredPackages'));
  }
  public function complaints()
  {
    // Pending complaints 
    $pending = Complaint::with('user')
      ->where('status', 'pending')
      ->latest()
      ->paginate(20);

    // All other complaints
    $others = Complaint::with('user')
      ->where('status', '!=', 'pending')
      ->latest()
      ->paginate(20);

    return view('admin.complaints', compact('pending', 'others'));
  }

  public function transactions()
  {
    $transactions = Transaction::with('user')
      ->get();

    return view('admin.transactions', compact('transactions'));
  }


  public function grantWeeklyReward()
  {
    $today = Carbon::today();

    // Skip entire process if not Sunday (assuming rewards are only for Sunday)
    if (!$today->isSunday()) {
      //return "Today is not Sunday → weekly rewards are only given on Sunday.";
      return;    // silent skip
      // or: Log::info("Not Sunday → weekly rewards skipped");
    }

    // Get all active (approved & not expired) payments
    $activePayments = Payment::with([
      'user',
      'package' => function ($query) {
        $query->where('weekend_reward', '>', 0);
      }
    ])
      ->where('status', 'approved')
      ->whereHas('package', function ($query) {
        $query->where('weekend_reward', '>', 0);
      })
      ->where('approved_at', '<=', now())
      ->where('expires_at', '>', now())
      ->get();

    $grantedCount = 0;
    $totalReward  = 0;

    foreach ($activePayments as $payment) {
      $user = $payment->user;
      $package = $payment->package;

      // Skip if user is inactive or package not found
      if (!$user || $user->status != 1 || !$package) {
        continue;
      }

      // === Prevent duplicate reward today for this specific payment ===
      $alreadyRewardedToday = Transaction::where('user_id', $user->id)
        ->where('trx_type', 'weekly_reward')
        ->whereDate('created_at', $today)
        ->where('detail', 'LIKE', '%Payment ID: ' . $payment->id . '%')
        ->exists();

      if ($alreadyRewardedToday) {
        continue;
      }


      $reward = $package->weekend_reward ?? 0; // Default to 0 if not set
      $totalReward += $reward;


      // === Update user balance ===
      $user->increment('balance', $reward);

      // === Create transaction record ===
      Transaction::create([
        'user_id'    => $user->id,
        'amount'     => $reward,
        'trx_type'   => 'weekly_reward',
        'detail'     => "Weekly reward from package: {$package->name} (ID: {$package->id}), Payment ID: {$payment->id}, Amount: {$reward}",
      ]);

      // === Create notification ===
      DB::table('notifications')->insert([
        'id' => Str::uuid(),
        'type' => 'WeeklyReward',
        'notifiable_type' => 'App\\Models\\User',
        'notifiable_id' => $user->id,
        'data' => json_encode([
          'message' => "You received weekly reward of {$reward} from package {$package->name}.",
          'amount' => $reward,
          'package_id' => $package->id,
          'package_name' => $package->name,
          'payment_id' => $payment->id,
          'type' => 'weekly_reward'
        ]),
        'created_at' => now(),
        'updated_at' => now(),
      ]);


      //Log::info("Weekly reward granted to User ID: {$user->id} | Amount: {$reward} | Package: {$package->name} | Payment ID: {$payment->id}");

      $grantedCount++;
    }

    //Log::info("Weekly rewards process completed. Total rewards granted: {$grantedCount}");

    return "Weekly rewards granted successfully to {$grantedCount} active package(s). Total reward amount: {$totalReward}.";
  }

  public function grantDailyReward()
  {
    $today = Carbon::today();


    // Get all active (approved & not expired) payments
    $activePayments = Payment::with(['user', 'package']) // Make sure relations are defined
      ->where('status', 'approved')
      ->where('approved_at', '<=', now())
      ->where('expires_at', '>', now())
      ->whereHas('package', function ($query) {
        $query->where('is_daily_rewards', 1);
      })
      ->get();


    $grantedCount = 0;
    $totalReward  = 0;

    foreach ($activePayments as $payment) {
      $user = $payment->user;
      $package = $payment->package;

      // Skip if user is inactive or package not found
      if (!$user || $user->status != 1 || !$package) {
        continue;
      }

      // === Prevent duplicate reward today for this specific payment ===
      $alreadyRewardedToday = Transaction::where('user_id', $user->id)
        ->where('trx_type', 'daily_reward')
        ->whereDate('created_at', $today)
        ->where('detail', 'LIKE', '%Payment ID: ' . $payment->id . '%')
        ->exists();

      if ($alreadyRewardedToday) {
        continue;
      }

      // $package->daily_profit_min + 10 random (if you want to add some variability to daily rewards, otherwise just use daily_profit_min as fixed reward)
      $baseReward = $package->daily_profit_min ?? 0;

      // random value between 0 and +10
      $variation = rand(0, 10);

      $reward = $baseReward + $variation;
      $totalReward += $reward;


      // === Update user balance ===
      $user->increment('balance', $reward);

      // === Create transaction record ===
      Transaction::create([
        'user_id'    => $user->id,
        'amount'     => $reward,
        'trx_type'   => 'daily_reward',
        'detail'     => "Daily reward from package: {$package->name} (ID: {$package->id}), Payment ID: {$payment->id}, Amount: {$reward}",
      ]);

      // === Create notification ===
      DB::table('notifications')->insert([
        'id' => Str::uuid(),
        'type' => 'DailyReward',
        'notifiable_type' => 'App\\Models\\User',
        'notifiable_id' => $user->id,
        'data' => json_encode([
          'message' => "You received daily reward of {$reward} from package {$package->name}.",
          'amount' => $reward,
          'package_id' => $package->id,
          'package_name' => $package->name,
          'payment_id' => $payment->id,
          'type' => 'daily_reward'
        ]),
        'created_at' => now(),
        'updated_at' => now(),
      ]);


      //Log::info("Daily reward granted to User ID: {$user->id} | Amount: {$reward} | Package: {$package->name} | Payment ID: {$payment->id}");

      $grantedCount++;
    }

    //Log::info("Daily rewards process completed. Total rewards granted: {$grantedCount}");

    return "Daily rewards granted successfully to {$grantedCount} active package(s). Total reward amount: {$totalReward}.";
  }

  public function withdraw_requests()
  {
    // Get last approved withdraw date for each user
    $lastApproved = Withdrawal::select('user_id', DB::raw('MAX(approved_at) as last_approved_at'))
      ->where('status', 'approved')
      ->groupBy('user_id');

    $pending = Withdrawal::with('user')
      ->leftJoinSub($lastApproved, 'last_withdraw', function ($join) {
        $join->on('withdrawals.user_id', '=', 'last_withdraw.user_id');
      })
      ->where('withdrawals.status', 'pending')
      ->orderBy('withdrawals.id', 'asc')
      ->select('withdrawals.*', 'last_withdraw.last_approved_at')
      ->get();

    $approved = Withdrawal::with('user')
      ->where('status', 'approved')
      ->latest()
      ->get();

    $rejected = Withdrawal::with('user')
      ->where('status', 'rejected')
      ->latest()
      ->get();

    $cancelled = Withdrawal::with('user')
      ->where('status', 'cancelled')
      ->latest()
      ->get();

    return view('admin.withdraw_requests', compact('pending', 'approved', 'rejected', 'cancelled'));
  }

  public function edit_withdraw($id)
  {
    $withdrawal = Withdrawal::with('user')->findOrFail($id);
    return view('admin.edit_withdraw', compact('withdrawal'));
  }

  // Clean & readable version I recommend
  public function update_withdraw(Request $request, $id)
  {
    $withdrawal = Withdrawal::findOrFail($id);

    $validated = $request->validate([
      'method'         => 'required|string|max:30',
      'bank_name'      => 'nullable|string|max:500',
      'amount'         => 'required|numeric|min:0',
      'account_number' => 'required|string|max:100',
      'account_title'  => 'required|string|max:150',
      'status'         => 'required|in:pending,approved,rejected,cancelled,processing',
      'transaction_id' => 'nullable|string|max:255',
      'remarks'        => 'nullable|string',
      'is_refund'      => 'nullable|boolean',     // ← added
    ]);

    // Convert checkbox to proper boolean/tinyint
    $validated['is_refund'] = $request->has('is_refund') ? 1 : 0;

    $withdrawal->timestamps = false;
    $withdrawal->update($validated);

    return back()->with('success', 'Withdrawal updated successfully.');
  }

  public function approve_withdraw($id)
  {
    DB::beginTransaction();

    try {

      $withdrawal = DB::table('withdrawals')
        ->where('id', $id)
        ->lockForUpdate()
        ->first();

      if (!$withdrawal) {
        DB::rollBack();
        return back()->with('error', 'Withdrawal request not found.');
      }

      if ($withdrawal->status !== 'pending') {
        DB::rollBack();
        return back()->with('error', 'Withdrawal already processed.');
      }

      $now = now();

      // 1️⃣ Update withdrawal
      DB::table('withdrawals')
        ->where('id', $id)
        ->update([
          'status'      => 'approved',
          'approved_at' => $now,
          'updated_at' => $now,
        ]);

      // 2️⃣ Insert transaction (Debit)
      DB::table('transactions')->insert([
        'user_id'    => $withdrawal->user_id,
        'amount'     => $withdrawal->amount,
        'trx_type'   => 'withdraw',
        'detail'     => "Withdrawal approved. Request #{$withdrawal->id}, Amount: {$withdrawal->amount}, Service Charge: 100",
        'created_at' => $now,
        'updated_at' => $now,
      ]);

      // 3️⃣ Notify user
      DB::table('notifications')->insert([
        'id' => Str::uuid(),
        'type' => 'WithdrawApproved',
        'notifiable_type' => 'App\\Models\\User',
        'notifiable_id' => $withdrawal->user_id,
        'data' => json_encode([
          'message' => "Your withdrawal request #{$withdrawal->id} has been approved. Service charge of Rs 100 has been deducted.",
          'amount' => $withdrawal->amount,
          'withdrawal_id' => $withdrawal->id,
          'type' => 'withdraw_approved'
        ]),
        'created_at' => $now,
        'updated_at' => $now,
      ]);

      DB::commit();

      return back()->with('success', 'Withdrawal request approved successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Something went wrong.');
    }
  }



  public function destroy($id)
  {
    $withdraw = Withdrawal::findOrFail($id);

    // Find and delete the associated transaction using the withdrawal ID from the message
    $transaction = Transaction::where('detail', 'LIKE', '%Ref: W' . $withdraw->id . '%')->first();

    if ($transaction) {
      $transaction->delete();
    }

    $withdraw->delete();

    return redirect()->back()->with('success', 'Withdrawal request and associated transaction deleted successfully.');
  }

  public function approve_process($id)
  {
    DB::beginTransaction();

    try {

      $withdrawal = DB::table('withdrawals')
        ->where('id', $id)
        ->lockForUpdate()
        ->first();

      if (!$withdrawal) {
        DB::rollBack();
        return back()->with('error', 'Withdrawal request not found.');
      }

      if ($withdrawal->status !== 'pending') {
        DB::rollBack();
        return back()->with('error', 'Withdrawal already processed.');
      }

      $now = now();

      // 1️⃣ Update withdrawal
      DB::table('withdrawals')
        ->where('id', $id)
        ->update([
          'status'      => 'approved + processed',
          'approved_at' => $now,
          'updated_at' => $now,
        ]);

      // 2️⃣ Insert transaction (Debit)
      DB::table('transactions')->insert([
        'user_id'    => $withdrawal->user_id,
        'amount'     => $withdrawal->amount,
        'trx_type'   => 'withdraw',
        'detail'     => "Withdrawal approved and processed. Request #{$withdrawal->id}, Amount: {$withdrawal->amount}, Service Charge: 100",
        'created_at' => $now,
        'updated_at' => $now,
      ]);

      // 3️⃣ Notify user
      DB::table('notifications')->insert([
        'id' => Str::uuid(),
        'type' => 'WithdrawApproved',
        'notifiable_type' => 'App\\Models\\User',
        'notifiable_id' => $withdrawal->user_id,
        'data' => json_encode([
          'message' => "Your withdrawal request #{$withdrawal->id} has been approved and processed. Service charge of Rs 100 has been deducted.",
          'amount' => $withdrawal->amount,
          'withdrawal_id' => $withdrawal->id,
          'type' => 'withdraw_approved'
        ]),
        'created_at' => $now,
        'updated_at' => $now,
      ]);

      DB::commit();

      return back()->with('success', 'Withdrawal request approved and processed successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Something went wrong.');
    }
  }

  public function reject_withdraw($id)
  {
    DB::beginTransaction();

    try {

      $withdrawal = DB::table('withdrawals')
        ->where('id', $id)
        ->lockForUpdate()
        ->first();

      if (!$withdrawal) {
        DB::rollBack();
        return back()->with('error', 'Withdrawal request not found.');
      }

      if ($withdrawal->status !== 'pending') {
        DB::rollBack();
        return back()->with('error', 'Withdrawal already processed.');
      }

      $now = now();
      $refund = request()->has('payment'); // checkbox check

      // 1️⃣ Update withdrawal status
      DB::table('withdrawals')
        ->where('id', $id)
        ->update([
          'status' => 'rejected',
          'is_refund' => $refund ? 1 : 0,
          'remarks' => request()->input('remarks', ''),
          'rejected_at' => $now,
          'updated_at' => $now,
        ]);

      // 2️⃣ Refund only if checkbox checked
      if ($refund) {

        DB::table('users')
          ->where('id', $withdrawal->user_id)
          ->increment('balance', $withdrawal->amount);

        $message = "Your withdrawal request #{$withdrawal->id} has been rejected and amount refunded.";
      } else {

        $message = "Your withdrawal request #{$withdrawal->id} has been rejected.";
      }

      // 3️⃣ Notify user
      DB::table('notifications')->insert([
        'id' => Str::uuid(),
        'type' => 'WithdrawRejected',
        'notifiable_type' => 'App\\Models\\User',
        'notifiable_id' => $withdrawal->user_id,
        'data' => json_encode([
          'message' => $message,
          'amount' => $withdrawal->amount,
          'withdrawal_id' => $withdrawal->id,
          'type' => 'withdraw_rejected'
        ]),
        'created_at' => $now,
        'updated_at' => $now,
      ]);

      DB::commit();

      return back()->with(
        'success',
        $refund
          ? 'Withdrawal rejected and amount refunded.'
          : 'Withdrawal rejected without refund.'
      );
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Something went wrong.');
    }
  }



  public function approve_package($id)
  {
    $payment = Payment::findOrFail($id);

    if ($payment->status !== 'pending') {
      return redirect()->back()->with('error', 'This payment has already been processed.');
    }

    $package = DB::table('packages')
      ->where('id', $payment->plan_id)
      ->first();

    if (!$package) {
      return redirect()->back()->with('error', 'Associated package not found.');
    }

    try {
      DB::beginTransaction();

      $now      = now();
      $days     = (int) $package->duration_days - 1; // Subtract 1 day to make it inclusive of the start day
      $investment = $package->investment_amount;

      if ($days <= 0) {
        throw new \Exception("Invalid package duration: {$days} days");
      }

      $expires = Carbon::parse($now)->addDays($days);

      // 1. Update payment status
      $payment->update([
        'status'      => 'approved',
        'approved_at' => $now,
        'expires_at'  => $expires,
        'admin_note'  => request()->input('note', 'Payment Verified'),
      ]);

      // 2. Notify the investor
      DB::table('notifications')->insert([
        'id'              => Str::uuid(),
        'type'            => 'PackageApproved',
        'notifiable_type' => 'App\\Models\\User',
        'notifiable_id'   => $payment->user_id,
        'data'            => json_encode([
          'message'    => "Your package purchase has been approved.",
          'package_id' => $package->id,
          'expires_at' => $expires,
          'type'       => 'package_approved'
        ]),
        'created_at'      => $now,
        'updated_at'      => $now,
      ]);

      // if upgrade or internal transfer, approve payment and skip referral bonuses

      if ($payment->payment_method_id == 100 || $payment->is_upgrade == 1) {
        DB::commit();
        return redirect()->back()->with('success', "Payment #{$payment->id} approved successfully. No referral bonuses processed (upgrade or internal transfer).");
      }

      // 3. Process referral bonuses (only if referrer has at least 1 active plan)
      $investor = DB::table('users')
        ->where('id', $payment->user_id)
        ->first();

      if (!$investor) {
        throw new \Exception("Investor user not found");
      }

      $current_user_id = $investor->id;
      $level = 1;
      $max_levels = 3;

      // Array to store usernames of those who actually receive a bonus
      $beneficiaryUsernames = [];

      while ($level <= $max_levels && $current_user_id) {
        $referrer = DB::table('users')
          ->where('id', $current_user_id)
          ->where('status', 1)
          ->first();

        if (!$referrer || !$referrer->referred_by) {
          break;
        }

        $referrer_id = $referrer->referred_by;

        // ─── Check if referrer has at least 1 active package ───
        $hasActivePlan = Payment::where('user_id', $referrer_id)
          ->where('status', 'approved')
          ->where('approved_at', '<=', now())
          ->where('expires_at', '>', now())
          ->exists();

        if (!$hasActivePlan) {
          // Skip this level (upline not active)
          $current_user_id = $referrer->referred_by;
          $level++;
          continue;
        }

        $bonus_percent_column = "referral_bonus_level{$level}";

        if (!property_exists($package, $bonus_percent_column) || $package->$bonus_percent_column <= 0) {
          $level++;
          $current_user_id = $referrer->referred_by;
          continue;
        }

        $bonus_amount = $investment * ($package->$bonus_percent_column / 100);

        // --- Get the username of the upline who will receive the bonus ---
        $referrerName = DB::table('users')->where('id', $referrer_id)->value('username');
        if ($referrerName) {
          $beneficiaryUsernames[] = $referrerName;
        }

        // Credit referrer
        DB::table('users')
          ->where('id', $referrer_id)
          ->increment('balance', $bonus_amount);

        // Record transaction
        DB::table('transactions')->insert([
          'user_id'    => $referrer_id,
          'amount'     => $bonus_amount,
          'trx_type'   => 'referral_bonus',
          'detail'     => "Level {$level} referral bonus from user #{$investor->id} ({$investor->username}) - Package #{$package->id}",
          'created_at' => $now,
          'updated_at' => $now,
        ]);

        // Notify referrer
        DB::table('notifications')->insert([
          'id'              => Str::uuid(),
          'type'            => 'ReferralBonus',
          'notifiable_type' => 'App\\Models\\User',
          'notifiable_id'   => $referrer_id,
          'data'            => json_encode([
            'message'     => "You received Level {$level} referral bonus of {$bonus_amount} from {$investor->username}.",
            'amount'      => $bonus_amount,
            'level'       => $level,
            'from_user_id' => $investor->id,
            'package_id'  => $package->id,
            'type'        => 'referral_bonus'
          ]),
          'created_at'      => $now,
          'updated_at'      => $now,
        ]);

        // Move up
        $current_user_id = $referrer->referred_by;
        $level++;
      }

      DB::commit();

      // Build the success message with the list of beneficiaries
      $usernamesList = empty($beneficiaryUsernames)
        ? 'No referral bonuses were given (no eligible upline).'
        : implode(', ', $beneficiaryUsernames);

      return redirect()->back()->with('success', "Payment #{$payment->id} approved successfully. Referral bonuses processed (up to level {$max_levels}): {$usernamesList}");
    } catch (\Exception $e) {
      DB::rollBack();

      Log::error('Payment approval + referral processing failed', [
        'payment_id' => $id,
        'error'      => $e->getMessage(),
        'trace'      => $e->getTraceAsString(),
      ]);

      return redirect()->back()->with('error', 'Approval failed: ' . $e->getMessage());
    }
  }


  public function reject_package(Request $request, $id)
  {
    $payment = Payment::findOrFail($id);

    // if ($payment->status !== 'pending') {
    //     return redirect()
    //         ->back()
    //         ->with('error', 'This payment has already been processed.');
    // }

    try {
      DB::beginTransaction();

      $now = now();
      $note = $request->admin_note ?? 'Payment not Verified';

      // 1️⃣ Update payment status
      $payment->update([
        'status'      => 'rejected',
        'admin_note'  => $note,
        'rejected_at' => $now,
      ]);

      // 2️⃣ Notify package owner
      DB::table('notifications')->insert([
        'id' => Str::uuid(),
        'type' => 'PackageRejected',
        'notifiable_type' => 'App\\Models\\User',
        'notifiable_id' => $payment->user_id,
        'data' => json_encode([
          'message' => "Your package payment #{$payment->id} has been rejected.",
          'payment_id' => $payment->id,
          'reason' => $note,
          'type' => 'package_rejected'
        ]),
        'created_at' => $now,
        'updated_at' => $now,
      ]);

      DB::commit();

      return redirect()
        ->back()
        ->with('success', 'Payment #' . $payment->id . ' has been rejected.');
    } catch (\Exception $e) {

      DB::rollBack();

      \Log::error('Payment rejection failed', [
        'payment_id' => $id,
        'error'      => $e->getMessage()
      ]);

      return redirect()
        ->back()
        ->with('error', 'Failed to reject payment. Please try again.');
    }
  }


  public function package_requests()
  {
    $statuses = ['pending', 'approved', 'rejected'];
    $requests = [];

    $baseQuery = DB::table('payments')
      ->join('users', 'payments.user_id', '=', 'users.id')
      ->join('packages', 'payments.plan_id', '=', 'packages.id')
      ->leftJoin('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
      ->select(
        'payments.*',
        'users.username',
        'users.phone',
        'packages.name as plan_name',
        'packages.id as package_id',
        'payment_methods.account_type as payment_method_name',
        'payment_methods.account_title as payment_method_title'
      );

    foreach ($statuses as $status) {
      $requests[$status . 'Requests'] = (clone $baseQuery)
        ->where('payments.status', $status)
        ->get();
    }

    return view('admin.package_requests', $requests);
  }



  public function storePending(Request $request)
  {
    $request->validate([
      'service_id'     => 'nullable|exists:services,id',
      'nic_number'     => 'nullable|string|max:50',
      'nic_expiry'     => 'nullable|date',
      'nic_front'      => 'nullable|image|max:2048',
      'nic_back'       => 'nullable|image|max:2048',
      'selfie'         => 'nullable|image|max:2048',
    ]);

    $userId = auth()->id();
    if (!$userId) {
      return redirect()->back()->with('error', 'You must be logged in.');
    }

    $saveFile = function ($file) {
      $destinationPath = public_path('expert/images');
      if (!File::exists($destinationPath)) {
        File::makeDirectory($destinationPath, 0755, true);
      }
      $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
      $file->move($destinationPath, $fileName);
      return 'expert/images/' . $fileName;
    };
        $data = [
            'service_id'     => $request->service_id,
            'nic_number'     => $request->nic_number,
            'nic_expiry'     => $request->nic_expiry,
            'payment_status' => $request->payment_status ?? 'Pending',
            'profile_status' => 0,
            'updated_at'     => now(),
        ];

        // Helper function to save file directly to public folder
        $saveFile = function ($file, $subFolder = '') {
            $destinationPath = public_path('expert/images' . ($subFolder ? '/' . $subFolder : ''));
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            return 'expert/images' . ($subFolder ? '/' . $subFolder : '') . '/' . $fileName;
        };

    $data = [
      'user_id'        => $userId,
      'service_id'     => $request->service_id,
      'nic_number'     => $request->nic_number,
      'nic_expiry'     => $request->nic_expiry,
      'payment_status' => 0,   // pending
      'created_at'     => now(),
      'updated_at'     => now(),
    ];

    if ($request->hasFile('nic_front')) {
      $data['nic_front_image'] = $saveFile($request->file('nic_front'));
    }
    if ($request->hasFile('nic_back')) {
      $data['nic_back_image'] = $saveFile($request->file('nic_back'));
    }
    if ($request->hasFile('selfie')) {
      $data['selfie_image'] = $saveFile($request->file('selfie'));
    }

    $recordId = DB::table('expert_details')->insertGetId($data);

    // Store the record ID in session to use on payment page
    session(['pending_expert_id' => $recordId]);

    // Get price from service
    $price = DB::table('services')->where('id', $request->service_id)->value('price') ?? 0;

    return redirect()->route('expert.payment.page')->with('amount', $price);
  }

  public function showPaymentPage()
  {
    $amount = session('amount', 0);
    if (!$amount) {
      return redirect()->route('user_profile')->with('error', 'Invalid payment request.');
    }
    return view('expert.payment', compact('amount'));
  }

  public function processPayment(Request $request)
  {
    $request->validate([
      'card_number'   => 'required|string|size:16',
      'expiry_month'  => 'required|string|size:2',
      'expiry_year'   => 'required|string|size:2',
      'cvc'           => 'required|string|size:3',
    ]);

    // Validate card (Luhn, expiry) as before
    if (!$this->validateLuhn($request->card_number)) {
      return redirect()->back()->with('error', 'Invalid card number.');
    }
    // ... expiry validation

    $expertId = session('pending_expert_id');
    if (!$expertId) {
      return redirect()->route('user_profile')->with('error', 'Session expired. Please start over.');
    }

    // Update payment status to 1 (paid)
    DB::table('expert_details')
      ->where('id', $expertId)
      ->where('user_id', auth()->id())
      ->update(['payment_status' => 1, 'updated_at' => now()]);

    session()->forget(['pending_expert_id', 'amount']);

    return redirect()->route('user_profile')->with('success', 'Payment successful! You are now an expert.');
  }

  private function validateLuhn($number)
  {
    $number = preg_replace('/\D/', '', $number);
    $sum = 0;
    $alt = false;
    for ($i = strlen($number) - 1; $i >= 0; $i--) {
      $n = $number[$i];
      if ($alt) {
        $n *= 2;
        if ($n > 9) $n -= 9;
      }
      $sum += $n;
      $alt = !$alt;
    }
    return ($sum % 10) == 0;
  }

  public function sendEmail(Request $request)
  {
    $recipients = $request->input('recipients');
    $subject = $request->input('subject');
    $messageContent = $request->input('message');

    // Check if the "sendAll" checkbox is checked
    if ($request->has('sendAll')) {
      // Send email to all email addresses from the users table
      $allEmails = DB::table('users')->pluck('email')->toArray();

      foreach ($allEmails as $recipient) {
        Mail::send([], [], function ($message) use ($recipient, $subject, $messageContent) {
          $message->from('secure@botaex.com', 'BotaEx');
          $message->to($recipient);
          $message->subject($subject);
          $message->html($messageContent); // Set email body as HTML
        });
      }
    } elseif (!empty($recipients)) {
      // Send email to selected recipients
      foreach ($recipients as $recipient) {
        Mail::send([], [], function ($message) use ($recipient, $subject, $messageContent) {
          $message->from('secure@botaex.com', 'BotaEx');
          $message->to($recipient);
          $message->subject($subject);
          $message->html($messageContent); // Set email body as HTML
        });
      }
    }

    return redirect('/email_system')->with('success', 'Email(s) sent successfully');
  }



  public function emailSystem()
  {
    $users = DB::table('users')->where('level', 1)->get();

    return view('/admin.email_system', [
      'users' => $users
    ]);
  }


  public function editUser($id)
  {
    $user = User::findOrFail($id);
    return view('admin.edit_user', compact('user'));
  }

  public function update_user(Request $request, $id)
  {
    $user = User::findOrFail($id);

    $validated = $request->validate([
      'username'     => ['required', 'string', 'max:100', Rule::unique('users')->ignore($user->id)],
      'name'         => 'nullable|string|max:100',
      'phone'        => 'required|string|max:100',
      'whatsapp'     => 'required|string|max:100',
      'email'        => 'nullable|email|max:100',
      'referred_by'  => 'nullable|integer|exists:users,id',
      'balance'      => 'required|numeric',
      'type'         => 'required|in:0,1',
      'status'       => 'required|in:0,1',
      'pic'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
      'password'     => 'nullable|min:6',
      'is_fd'        => 'required|in:0,1',
    ]);

    // ────────────────────────────────────────────────
    //    Handle profile picture
    // ────────────────────────────────────────────────
    if ($request->hasFile('pic')) {
      if ($user->pic && file_exists(public_path('uploads/user/' . $user->pic))) {
        @unlink(public_path('uploads/user/' . $user->pic));
      }

      $file = $request->file('pic');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('uploads/user'), $filename);
      $validated['pic'] = $filename;
    }

    // ────────────────────────────────────────────────
    //    Handle password separately – never mass-assign
    // ────────────────────────────────────────────────
    if ($request->filled('password')) {           // or !empty($validated['password'])
      $validated['password'] = bcrypt($validated['password']);
      // or Hash::make($validated['password']);
    } else {
      // Important: do NOT send password = null / '' to update()
      unset($validated['password']);
    }

    $user->update($validated);

    return redirect()->route('users')->with('success', 'User updated successfully');
  }





  public function activateUser($id)
  {
    $affectedRows = DB::table('users')
      ->where('id', $id)
      ->update(['status' => 1]);

    if ($affectedRows > 0) {
      return redirect()->back()->with('success', 'User activated successfully.');
    }

    return redirect()->back()->with('error', 'User not found or could not be activated.');
  }

  public function suspendUser($id)
  {
    $affectedRows = DB::table('users')
      ->where('id', $id)
      ->update(['status' => 2]);

    if ($affectedRows > 0) {
      return redirect()->back()->with('success', 'User suspended successfully.');
    }

    return redirect()->back()->with('error', 'User not found or could not be suspended.');
  }



  public function changePassword(Request $request)
  {
    $request->validate([
      'old_password'         => 'required',
      'new_password'         => 'required|min:8|confirmed', // ← increased min length to 8 (common recommendation)
      'new_password_confirmation' => 'required',
    ], [
      'new_password.min' => 'The new password must be at least 8 characters.',
      'new_password.confirmed' => 'The new password confirmation does not match.',
    ]);

    $user = Auth::user();

    if (! Hash::check($request->old_password, $user->password)) {
      return redirect()->back()
        ->withInput($request->only('old_password')) // keep old_password visible
        ->withErrors(['old_password' => 'The current password is incorrect.']);
    }

    $user->update([
      'password' => Hash::make($request->new_password),
    ]);

    // Optional: force logout other devices (good security practice)
    Auth::logoutOtherDevices($request->new_password);

    return redirect()->back()->with('success', 'Password changed successfully.');
  }

  public function updateProfile(Request $request)
  {
    // Validation
    $request->validate([
      'id'       => 'required|exists:users,id',
      'name'     => 'required|string|max:255',
      'email'    => 'required|email|max:255|unique:users,email,' . $request->id,
      'phone'    => 'nullable|string|max:20',
      'whatsapp' => 'nullable|string|max:20',
      'pic'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB max
    ]);

    $id = $request->input('id');

    // Get current user data (for old image)
    $user = DB::table('users')->where('id', $id)->first();

    $updateData = [
      'name'     => $request->input('name'),
      'email'    => $request->input('email'),
      'phone'    => $request->input('phone'),
      'whatsapp' => $request->input('whatsapp'),
    ];

    // Handle profile picture
    if ($request->hasFile('pic')) {
      $image = $request->file('pic');

      // Generate unique filename
      $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

      // Full relative path you want to save in DB
      $imagePath = 'uploads/user/' . $imageName;

      $destinationPath = public_path('uploads/user/');

      // Create folder if not exists
      if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
      }

      // Delete old image if exists
      if ($user->pic && file_exists(public_path($user->pic))) {
        unlink(public_path($user->pic));
      }

      // Move the uploaded file
      $image->move($destinationPath, $imageName);

      // Save FULL PATH in database
      $updateData['pic'] = $imagePath;
    }

    // Update user record
    DB::table('users')
      ->where('id', $id)
      ->update($updateData);

    return back()->with('success', 'Profile updated successfully');
  }

  public function deleteUser($id)
  {
    // Delete the account with the given ID
    DB::table('users')->where('id', $id)->delete();
    return back()->with('success', 'User deleted successfully');
  }

  public function deleteUserSelf($id)
  {
    // Delete the account with the given ID
    DB::table('users')->where('id', $id)->delete();
    return redirect('/login')->with('success', 'User deleted successfully');
  }

  public function forceLogout($id)
  {
    $user = User::findOrFail($id);

    if ($user->id === auth()->id()) {
      return back()->with('error', 'You cannot force logout yourself this way.');
    }

    // Delete ALL sessions that belong to this user
    DB::table('sessions')
      ->where('user_id', $user->id)
      ->delete();

    // Optional: also clear remember me token (affects "remember me" logins)
    $user->update(['remember_token' => null]);

    return back()->with('success', "All sessions of {$user->username} have been terminated.");
  }


  public function saveRegister(Request $request)
  {
    $validated = $request->validate([
      'username'    => 'required|string|min:3|max:30',
      'phone'       => [
        'required',
        'regex:/^[0-9]{11,11}$/',
      ],
      'password'    => 'required|min:6',
      'referred_by' => 'nullable|integer|exists:users,id',
    ]);

    // Look for existing user by BOTH username AND phone
    $user = User::where('username', $validated['username'])
      ->where('phone', $validated['phone'])
      ->first();

    if ($user) {
      // ─── Existing user ─── attempt login

      if (!Hash::check($validated['password'], $user->password)) {
        // Password incorrect
        if ($user->is_sensitive) {
          $attemptKey = 'login_attempts_sensitive_' . md5($validated['phone']);
          $attempts   = session($attemptKey, 0) + 1;
          session([$attemptKey => $attempts]);

          if ($attempts >= 3) {
            $user->update(['status' => 0]);
            session()->forget($attemptKey);

            return redirect('/login')
              ->with('error', 'Too many failed attempts. Account has been deactivated.');
          }

          $remaining = 3 - $attempts;

          return back()
            ->withInput($request->only('username', 'phone', 'referred_by'))
            ->withErrors(['password' => 'Incorrect password.'])
            ->with('attempts_left', $remaining);
        }

        // Normal (non-sensitive) failure
        return back()
          ->withInput($request->only('username', 'phone', 'referred_by'))
          ->withErrors(['password' => 'The password you entered is incorrect.']);
      }

      // ─── Password correct ─── apply security checks

      // Status checks
      if ($user->status == 0) {
        return redirect('/login')
          ->with('error', 'Account is inactive.');
      }

      if ($user->status == 2) {
        return redirect('/login')
          ->with('error', 'Account is suspended.');
      }

      // Single-device logout for non-admins
      if ($user->type != 0) {
        Auth::logoutOtherDevices($validated['password']);
      }

      // Success → reset sensitive attempts if applicable
      if ($user->is_sensitive) {
        $attemptKey = 'login_attempts_sensitive_' . md5($validated['phone']);
        session()->forget($attemptKey);
      }

      // Log in the user
      Auth::login($user);
      $request->session()->regenerate();


      return redirect()
        ->route('user_dashboard')
        ->with('success', 'Welcome back!');
    }

    // ─── New user ─── enforce uniqueness and create

    $request->validate([
      'username' => 'unique:users,username',
      'phone'    => 'unique:users,phone',
    ]);

    $user = User::create([
      'username'    => $validated['username'],
      'phone'       => $validated['phone'],
      'password'    => Hash::make($validated['password']),
      'status'      => 1,
      'type'        => 1,
      'referred_by' => $validated['referred_by'] ?? null,
      'balance'     => 300, // welcome bonus
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()
      ->route('user_dashboard')
      ->with('success', 'Registration successful! Welcome on board.');
  }


  public function contactUs(Request $req)
  {

    $validation = $req->validate([
      'name' => 'required',
      'email' => 'required|email',
      'subject' => 'required',
      'message' => 'required',
    ]);

    if (!$validation) {
      return back()->withInput()->withErrors($validation);
    }

    $data = array(
      "name" => $req->get('name'),
      "email" => $req->get('email'),
      "subject" => $req->get('subject'),
      "message" => $req->get('message')
    );

    $insert = DB::table('contact')->insert($data);

    if ($insert) {
      return back()->with('success', 'Message sent successfully');
    } else {
      return back()->withInput()->with('error', 'Message not saved, technical error');
    }
  }
}
