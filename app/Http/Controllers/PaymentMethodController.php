<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentMethodController extends Controller
{
    public function cancelPlan($planId)
    {

        DB::table('payments')->where('user_id', Auth::id())
            ->where('id', $planId)
            ->update([
                'expires_at' => now(),
                'status' => 'cancelled',
                'admin_note' => 'Cancelled by User.'
            ]);
        return back()->with('success', 'Your plan has been cancelled successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);

        $method->update([
            'is_active' => $request->boolean('is_active'), // cleaner — converts 1/0/"1"/"0" to bool
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    public function upgradePaymentConfirm(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'plan_id' => 'required|exists:packages,id',
        ];

        $validated = $request->validate($rules);

        $plan = Package::findOrFail($validated['plan_id']);
        $planAmount = $plan->investment_amount ?? 0;

        $currentBalance = $user->balance ?? 0;
        $remaining = max(0, $planAmount - $currentBalance);
        $isFullWalletUpgrade = $remaining <= 0;

        DB::beginTransaction();

        try {
            // ── Shared: Prevent duplicate/pending upgrades ──
            $existingPending = Payment::where('user_id', $user->id)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->exists();

            if ($existingPending) {
                throw new \Exception('You already have a pending request. Please wait.');
            }

            $receiptPath = null;
            $paymentMethodId = null;
            $transactionId = null;
            $deductedFromWallet = 0;
            $status = 'pending';
            $notes = null;

            if ($isFullWalletUpgrade) {
                // ── CASE 1: Full wallet upgrade ──
                $deductedFromWallet = $planAmount;

                // Atomic wallet deduction
                $user->decrement('balance', $planAmount);

                // 1. Insert transaction record (deduction)
                DB::table('transactions')->insert([
                    'user_id'    => $user->id,
                    'amount'     => $planAmount,
                    'trx_type'   => 'plan_upgrade_deduction',
                    'detail'     => "Plan upgrade to {$plan->name} - full wallet payment",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $status = 'pending'; // Still pending for admin approval, but payment is done
                $notes  = 'Upgraded using full wallet balance';

                // 2. Insert notification record
                DB::table('notifications')->insert([
                    'id'              => (string) Str::uuid(),
                    'type'            => 'App\Notifications\PlanUpgradeSuccess',
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id'   => $user->id,
                    'data'            => json_encode([
                        'title'   => 'Plan Upgraded Successfully!',
                        'message' => "Your plan has been upgraded to {$plan->name} using your wallet balance.",
                        'amount'  => number_format($planAmount, 2),

                    ]),
                    'read_at'     => null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            } else {
                // ── CASE 2: External payment (possibly partial wallet) ──
                $request->validate([
                    'payment_method_id' => 'required|exists:payment_methods,id',
                    'transaction_id'    => 'required|string|max:255',
                    'receipt_image'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
                ]);

                $paymentMethodId = $request->payment_method_id;
                $transactionId   = $request->transaction_id;

                if ($request->hasFile('receipt_image')) {
                    $file = $request->file('receipt_image');
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('uploads/receipts');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $fileName);
                    $receiptPath = 'uploads/receipts/' . $fileName;
                }

                // Optional partial wallet deduction (uncomment if you want it)
                if ($currentBalance > 0) {
                    $user->decrement('balance', $currentBalance);
                    $deductedFromWallet = $currentBalance;

                    DB::table('transactions')->insert([
                        'user_id'    => $user->id,
                        'amount'     => $currentBalance,
                        'trx_type'   => 'plan_upgrade_partial_deduction',
                        'detail'     => "Plan upgrade to {$plan->name} - partial wallet used",
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $notes = $currentBalance > 0 ? "Partial wallet used: {$currentBalance} Rs" : null;

                // Insert notification record
                DB::table('notifications')->insert([
                    'id'              => (string) Str::uuid(),
                    'type'            => 'App\Notifications\UpgradePaymentSubmitted',
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id'   => $user->id,
                    'data'            => json_encode([
                        'title'   => 'Upgrade Request Submitted',
                        'message' => "Your payment for upgrading to {$plan->name} has been submitted. Waiting for admin approval.",
                        'amount'  => number_format($planAmount, 2),

                    ]),
                    'read_at'     => null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            // ── Create Payment record (common) ──
            Payment::create([
                'user_id'             => $user->id,
                'plan_id'             => $plan->id,
                'payment_method_id'   => $paymentMethodId ?? 100, // 100 for wallet/internal
                'transaction_id'      => $transactionId ?? 'WALLET-' . time(),
                'receipt_path'        => $receiptPath ?? null,
                'amount'              => $planAmount,
                'status'              => $status,
                'is_upgrade'          => 1,
                'deducted_from_wallet' => $deductedFromWallet,
                'notes'               => $notes,
            ]);

            DB::commit();

            $successMessage = $isFullWalletUpgrade
                ? 'Plan upgraded successfully using your wallet balance!'
                : 'Upgrade payment submitted successfully. Waiting for admin approval.';

            return back()->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage() ?: 'Failed to process upgrade. Please try again.');
        }
    }

    public function upgradePayment($planId)
    {
        $plan = Package::findOrFail($planId);
        $activeMethods = PaymentMethod::where('is_active', true)->get();

        return view('user.upgrade_payment', compact('plan', 'activeMethods'));
    }

    public function getPayment($planId)
    {
        $plan = Package::findOrFail($planId);
        $activeMethods = PaymentMethod::where('is_active', true)->get();

        return view('user.get_payment', compact('plan', 'activeMethods'));
    }


    public function confirmPayment(Request $request)
    {
        $user = Auth::user();

        // ── Common rules ──
        $rules = [
            'plan_id'           => 'required|exists:packages,id',
            'payment_method_id' => 'required',
            'is_internal'       => 'sometimes|in:0,1',
        ];

        // Extra rules only for external payments
        if (!$request->input('is_internal')) {
            $rules['transaction_id'] = ['required', 'digits_between:5,30', 'unique:payments,transaction_id'];
            $rules['receipt_image'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();

        try {
            $plan   = Package::findOrFail($validated['plan_id']);
            $amount = $plan->investment_amount;

            // ───────────────────────────────────────────────
            //  Case 1: Internal / Wallet Payment
            // ───────────────────────────────────────────────
            if ($request->input('is_internal') || $validated['payment_method_id'] === 'internal') {

                $hasPending = Payment::where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->exists();

                if ($hasPending) {
                    throw new \Exception('pending_exists');
                }

                if ($user->balance < $amount) {
                    throw new \Exception('insufficient_balance');
                }

                $user->decrement('balance', $amount);

                Payment::create([
                    'user_id'           => $user->id,
                    'plan_id'           => $plan->id,
                    'payment_method_id' => 100,
                    'transaction_id'    => 'WALLET-' . now()->timestamp . '-' . uniqid('', true), // safer
                    'receipt_path'      => null,
                    'amount'            => $amount,
                    'status'            => 'pending',
                ]);

                DB::commit();

                return back()->with('success', 'Payment completed successfully using wallet balance!');
            }

            // ───────────────────────────────────────────────
            //  Case 2: External payment (pending approval)
            // ───────────────────────────────────────────────

            $existingPending = Payment::where('user_id', $user->id)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->exists();

            if ($existingPending) {
                throw new \Exception('pending_exists');
            }

            $receiptPath = null;

            if ($request->hasFile('receipt_image')) {
                $file     = $request->file('receipt_image');
                $fileName = now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $destinationPath = public_path('uploads/receipts');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $fileName);
                $receiptPath = 'uploads/receipts/' . $fileName;
            }

            Payment::create([
                'user_id'           => $user->id,
                'plan_id'           => $plan->id,
                'payment_method_id' => $validated['payment_method_id'],
                'transaction_id'    => $validated['transaction_id'],
                'receipt_path'      => $receiptPath,
                'amount'            => $amount,
                'status'            => 'pending',
            ]);

            DB::commit();

            return back()->with('success', 'Payment confirmation submitted successfully. Waiting for admin approval.');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            // MySQL: 1062 = Duplicate entry
            // PostgreSQL: unique_violation
            if ($e->getCode() == 23000 || str_contains($e->getMessage(), 'Duplicate entry') || str_contains($e->getMessage(), 'unique constraint')) {
                return back()
                    ->withInput()
                    ->withErrors(['transaction_id' => 'This Transaction ID has already been used. Please check and try again.']);
            }

            return back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        } catch (\Exception $e) {
            DB::rollBack();

            $message = $e->getMessage();

            if ($message === 'insufficient_balance') {
                return back()->with('error', 'Your wallet balance is not enough for this plan.');
            }

            if ($message === 'pending_exists') {
                return back()->with('error', 'You already have a pending payment. Please wait for approval.');
            }

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }


    //     public function confirmPayment(Request $request)
    // {
    //     $validated = $request->validate([
    //         'plan_id'           => 'required|exists:packages,id',
    //         'payment_method_id' => 'required|exists:payment_methods,id',
    //         'transaction_id'    => 'required|string|max:255',
    //         'receipt_image'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);

    //     DB::beginTransaction();

    //     try {

    //         // 🔒 Check if user already has a pending payment
    //         $existingPending = Payment::where('user_id', Auth::id())
    //             ->where('status', 'pending')
    //             ->lockForUpdate()   // prevents race condition
    //             ->exists();

    //         if ($existingPending) {
    //             DB::rollBack();
    //             return back()->with('error', 'You already have a pending payment request. Please wait for approval.');
    //         }

    //         $plan = Package::findOrFail($validated['plan_id']);

    //         $receiptPath = null;

    //         if ($request->hasFile('receipt_image')) {
    //             $file = $request->file('receipt_image');
    //             $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    //             $destinationPath = public_path('uploads/receipts');

    //             if (!file_exists($destinationPath)) {
    //                 mkdir($destinationPath, 0755, true);
    //             }

    //             $file->move($destinationPath, $fileName);
    //             $receiptPath = 'uploads/receipts/' . $fileName;
    //         }

    //         Payment::create([
    //             'user_id'           => Auth::id(),
    //             'plan_id'           => $validated['plan_id'],
    //             'payment_method_id' => $validated['payment_method_id'],
    //             'transaction_id'    => $validated['transaction_id'],
    //             'receipt_path'      => $receiptPath,
    //             'amount'            => $plan->investment_amount,
    //             'status'            => 'pending',
    //         ]);

    //         DB::commit();

    //         return back()->with('success', 'Payment confirmation submitted successfully. Waiting for admin approval.');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->with('error', 'Something went wrong. Please try again.');
    //     }
    // }


    public function index()
    {
        $methods = PaymentMethod::latest()->get();

        return view('admin.payment_methods', compact('methods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_type'    => 'required|in:easypaisa,jazzcash,nayapay,sadapay,bank',
            'account_title'   => 'required|string|max:150',
            'account_number'  => 'nullable|string|max:50',
            'iban'            => 'nullable|string|max:50',
            'details'         => 'nullable|string',
            'receipt_sample'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'       => 'boolean',
        ]);

        if ($request->hasFile('receipt_sample')) {
            $file = $request->file('receipt_sample');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/payments'), $fileName);

            $validated['receipt_sample'] = 'uploads/payments/' . $fileName;
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        PaymentMethod::create($validated);

        return redirect()->route('payment-methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        return view('admin.payment_methods_edit', compact('paymentMethod'));
    }

    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        $validated = $request->validate([
            'account_type'    => 'required|in:easypaisa,jazzcash,nayapay,sadapay,bank,raast,binance',
            'account_title'   => 'required|string|max:150',
            'account_number'  => 'nullable|string|max:50',
            'iban'            => 'nullable|string|max:50',
            'details'         => 'nullable|string',
            'receipt_sample'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'       => 'nullable|boolean',
        ]);

        if ($request->hasFile('receipt_sample') && $request->file('receipt_sample')->isValid()) {
            $file = $request->file('receipt_sample');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $destinationPath = public_path('uploads/payments');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Delete old file if exists
            if ($paymentMethod->receipt_sample) {
                $oldPath = public_path($paymentMethod->receipt_sample);
                if (file_exists($oldPath) && is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file->move($destinationPath, $fileName);
            $validated['receipt_sample'] = 'uploads/payments/' . $fileName;
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $paymentMethod->update($validated);

        return redirect()->route('payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->is_active) {
            return redirect()->route('payment-methods.index')
                ->with('error', 'Deactivate the payment method before deleting.');
        }

        if (!empty($paymentMethod->receipt_sample) && Storage::disk('public')->exists($paymentMethod->receipt_sample)) {
            Storage::disk('public')->delete($paymentMethod->receipt_sample);
        }

        $paymentMethod->delete();

        return redirect()->route('payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}
