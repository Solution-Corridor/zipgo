<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;     // ← create this model
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Validation\Rule;
use App\Models\Payment;

class WithdrawController extends Controller
{

    public function cancelWithdraw($id)
    {

        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Only pending withdrawals can be cancelled.');
        }

        $withdrawal->update([
            'status'   => 'cancelled',
            'remarks'  => ($withdrawal->remarks ? $withdrawal->remarks . "\n" : '')
                . 'Cancelled by user on ' . now()->format('d M Y h:i A'),
            'cancelled_at' => now(),
            'updated_at' => now(),
        ]);

        // Important: Refund the amount back to user balance 
        $user = Auth::user();
        $user->increment('balance', $withdrawal->amount - 100);  // Refund the amount minus service charge

        // Optional: dispatch event, send notification, log action...

        return back()->with('success', 'Withdrawal request cancelled successfully. Amount has been refunded to your balance.');
    }

    public function create()
{
    $user = Auth::user();

    if ($user->is_withdraw_allowed == 0) {
        return redirect()->back()->with('error', 'You are not allowed to get withdraw.');
    }

    if ($user->is_fd) {
        $msg = 'Withdrawals are not available while you have an active Fixed Deposit.';
    } elseif ($user->withdraw_timer != 0 && $this->isUserInCooldown($user)) {
        // cooldown only applies if withdraw_timer is NOT 0
        $msg = 'Withdrawals are on cooldown. Please try again later.';
    } else {
        return view('user.withdraw', compact('user'));
    }

    return redirect()->route('user_dashboard')->with('error', $msg);
}


    public function isUserInCooldown($user): bool
    {
        $days = (int) config('app.withdraw_cool_down_days', 0);
        if ($days === 0) return false;

        $last = Withdrawal::where('user_id', $user->id)
            ->latest('updated_at')
            ->value('updated_at');

        if (!$last) return false;

        return now()->lt(Carbon::parse($last)->addDays($days));
    }

    public function store(Request $request)
{
    $user = Auth::user();

    // ── Existing checks ────────────────────────────────────────────────
    $pending = Withdrawal::where('user_id', $user->id)
        ->where('status', 'pending')
        ->exists();

    if ($pending) {
        return back()->withErrors([
            'pending' => 'You already have a pending withdrawal request. Please wait until it is processed.'
        ]);
    }

    // Duplicate account check
    $duplicatAccount = Withdrawal::where('account_number', $request->input('account_number'))
        ->where('status', 'pending')
        ->exists();

    if ($duplicatAccount) {
        return back()->withErrors([
            'pending' => 'Duplicate account number detected. Another user has already requested a withdrawal to this account and it is pending.'
        ]);
    }

    // ==================== COOLDOWN CHECK (Using your existing function) ====================
    if ($user->withdraw_timer == 1) {
        // Only apply cooldown if user has withdraw_timer = 1
        if ($this->isUserInCooldown($user)) {
            // You can calculate remaining time here if you want to show exact message
            $last = Withdrawal::where('user_id', $user->id)
                ->latest('updated_at')
                ->value('updated_at');

            $coolDownDays = (int) config('app.withdraw_cool_down_days', 0);
            $nextAllowedTime = Carbon::parse($last)->addDays($coolDownDays);

            $remainingSeconds = now()->diffInSeconds($nextAllowedTime);

            $days    = floor($remainingSeconds / 86400);
            $hours   = floor(($remainingSeconds % 86400) / 3600);
            $minutes = floor(($remainingSeconds % 3600) / 60);

            return back()->withErrors([
                'pending' => "You can request a new withdrawal after {$days}d {$hours}h {$minutes}m."
            ]);
        }
    }
    // If $user->withdraw_timer == 0 → completely bypass cooldown (no check)

    //echo $user->withdraw_without_package; die;
if ($user->withdraw_without_package==0) {
    // Check active package
    $hasActivePlan = Payment::where('user_id', $user->id)
        ->where('status', 'approved')
        ->where('approved_at', '<=', now())
        ->where('expires_at', '>', now())
        ->exists();

    if (!$hasActivePlan) {
        return back()->withErrors([
            'pending' => 'You must have an active package to request a withdrawal.'
        ]);
    }
}

    // ── Validation ─────────────────────────────────────────────────────
    $validated = $request->validate([
        'method'         => 'required|in:easypaisa,jazzcash,nayapay,sadapay,bank',
        'bank_name'      => [
            'nullable',
            'string',
            'max:100',
            Rule::requiredIf(fn() => $request->input('method') === 'bank'),
        ],
        'amount'         => 'required|numeric|min:270',
        'account_number' => 'required|string|max:100',
        'account_title'  => 'required|string|max:150|regex:/^[A-Za-z\s]+$/',
    ]);

    if ($validated['amount'] > $user->balance) {
        return back()->withErrors(['amount' => 'Insufficient balance']);
    }

    $amountRequested = $validated['amount'];
    $serviceFee = max($amountRequested * 0.05, 100);
    $netAmount = $amountRequested - $serviceFee;

    // ── Main logic inside transaction ─────────────────────────────────
    DB::transaction(function () use ($validated, $user, $amountRequested, $serviceFee, $netAmount) {

        $withdrawal = Withdrawal::create([
            'user_id'        => $user->id,
            'method'         => $validated['method'],
            'bank_name'      => $validated['bank_name'] ?? null,
            'amount'         => $netAmount,
            'account_number' => $validated['account_number'],
            'account_title'  => $validated['account_title'],
            'status'         => 'pending',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        Transaction::create([
            'user_id'   => $user->id,
            'amount'    => $serviceFee,
            'trx_type'  => 'service_fee',
            'detail'    => "Service fee for withdrawal • Amounted {$amountRequested} Rs • Ref: W{$withdrawal->id}",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user->decrement('balance', $amountRequested);
    });

    return redirect()
        ->route('user_dashboard')
        ->with('success', 'Withdrawal request submitted successfully! It will be processed soon.');
}
}
