<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;

class PackageController extends Controller
{

    // show package details to admin
    public function show($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.package_show', compact('package'));
    }
    
    public function planUpdate(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $data = $request->validate([
            'status'            => 'nullable|in:pending,approved,rejected,expired',
            'admin_note'        => 'nullable|string',
            'approved_at'       => 'nullable|date',
            'rejected_at'       => 'nullable|date',
            'expires_at'        => 'nullable|date',
        ]);

        // Convert empty datetime strings to null
        foreach (['approved_at', 'rejected_at', 'expires_at'] as $field) {
            if (empty($data[$field])) {
                $data[$field] = null;
            }
        }

        $payment->update($data);

        return redirect()->route('running_packages')
            ->with('success', 'Payment updated successfully.');
    }
    public function planEdit($id)
    {
        $payment = Payment::with('user', 'package')->findOrFail($id);
        return view('admin.payment_edit', compact('payment'));
    }
    public function expire($id)
    {
        $payment = Payment::findOrFail($id);

        // Set expiry to current moment
        $payment->expires_at = now();
        $payment->save();

        return redirect()->back()->with('success', 'Package has been expired successfully.');
    }

    public function index()
    {
        $packages = Package::latest()->get();

        return view('admin.manage_packages', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:100|unique:packages,name',
            'investment_amount'     => 'required|numeric|min:1',
            'daily_profit_min'      => 'required|numeric|min:0',
            'daily_profit_max'      => 'required|numeric|gte:daily_profit_min',
            'duration_days'         => 'required|integer|min:1',
            'referral_bonus_level1' => 'required|numeric|between:0,100',
            'referral_bonus_level2' => 'required|numeric|between:0,100',
            'daily_tasks'           => 'required|integer|min:0',
            'daily_task_price'      => 'required|numeric|min:0',
            'free_spins'           => 'required|integer|min:0',
            'free_spin_price'      => 'required|numeric|min:0',
            'weekend_reward'       => 'required|numeric|min:0',
            'plan_type'            => 'required|in:silver,gold,diamond,invest',
            'is_active'             => 'boolean',
            'is_daily_rewards'     => 'boolean',
        ]);

        Package::create($validated);

        return redirect()
            ->route('packages.index') // we'll define named route below
            ->with('success', 'Package created successfully!');
    }

    // Optional: for future edit/delete
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.package_edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $validated = $request->validate([
            'name'                  => 'required|string|max:100|unique:packages,name,' . $id,
            'investment_amount'     => 'required|numeric|min:1',
            'daily_profit_min'      => 'required|numeric|min:0',
            'daily_profit_max'      => 'required|numeric|gte:daily_profit_min',
            'duration_days'         => 'required|integer|min:1',
            'referral_bonus_level1' => 'required|numeric|between:0,100',
            'referral_bonus_level2' => 'required|numeric|between:0,100',
            'daily_tasks'           => 'required|integer|min:0',
            'daily_task_price'      => 'required|numeric|min:0',
            'free_spins'           => 'required|integer|min:0',
            'free_spin_price'      => 'required|numeric|min:0',
            'weekend_reward'       => 'required|numeric|min:0',
            'plan_type'            => 'required|in:silver,gold,diamond,invest',
            'is_active'             => 'boolean',
            'is_daily_rewards'     => 'boolean',
        ]);

        $package->update($validated);

        return redirect()
            ->route('packages.index')
            ->with('success', 'Package updated successfully!');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()
            ->route('packages.index')
            ->with('success', 'Package deleted successfully!');
    }
}
