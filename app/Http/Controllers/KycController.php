<?php

namespace App\Http\Controllers;

use App\Models\KycVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class KycController extends Controller
{
    // Route::post('/kyc/{id}/approve', [KycController::class, 'approve'])->name('admin.kyc.approve');
    // Route::post('/kyc/{id}/reject',  [KycController::class, 'reject'])->name('admin.kyc.reject');
    
    public function approve($id)
    {
        $kyc = KycVerification::findOrFail($id);
        $kyc->status = 'approved';
        $kyc->reviewed_at = now();
        $kyc->save();

        return back()->with('success', 'KYC verification approved successfully.');
    }

    public function reject(Request $request,$id)
    {
        $request->validate([
        'admin_note' => 'nullable|string|max:1000',
    ]);
        $kyc = KycVerification::findOrFail($id);
        $kyc->status = 'rejected';
        $kyc->admin_note = $request->admin_note;
        $kyc->reviewed_at = now();
        $kyc->save();

        return back()->with('success', 'KYC verification rejected successfully.');
    }
    
public function kycVerification()
    {
        $pendingReview = KycVerification::with('user')
            ->whereIn('status', ['pending', 'submitted'])
            ->latest('submitted_at')
            ->get();

        $approved = KycVerification::with('user')
            ->where('status', 'approved')
            ->latest('reviewed_at')
            ->get();
        
        $rejected = KycVerification::with('user')
            ->where('status', 'rejected')
            ->latest('reviewed_at')
            ->get();

        return view('admin.kyc', compact(
            'pendingReview',
            'approved',
            'rejected'
        ));
    }

public function index()
{
    $user = Auth::user();
    // get latest single KYC record for this user
    $kyc = KycVerification::where('user_id', $user->id)
        ->latest('submitted_at')
        ->first();

    $kycHistory = KycVerification::where('user_id', $user->id)
        ->latest()
        ->get();

    return view('user.kyc', compact('kyc', 'kycHistory'));
}

    public function create()
    {
        $kyc = Auth::user()->kycVerification;

        if ($kyc && $kyc->isApproved()) {
            return redirect()->route('kyc.index')
                ->with('info', 'Your KYC is already verified.');
        }

        if ($kyc && $kyc->isSubmitted()) {
            return redirect()->route('kyc.status')
                ->with('info', 'Your KYC is under review.');
        }

        return view('user.kyc_create');
    }



    public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:120',
        'city'      => 'required|string|max:100',
        'gender'    => 'required|in:male,female,other',
        'phone'     => [
            'required',
            'string',
            'max:20',
            Rule::unique('kyc_verifications', 'phone')
                ->ignore(Auth::id(), 'user_id'),
        ],
        'whatsapp'  => [
            'required',
            'string',
            'max:20',
        ],
    ]);

    $user = Auth::user();

    // Prevent resubmission if already submitted or approved
    if (
        $user->kycVerification?->status === 'submitted' ||
        $user->kycVerification?->status === 'approved'
    ) {
        return redirect()->route('kyc.index');
    }

    

    

    // Save/Update KYC Record
    KycVerification::updateOrCreate(
        ['user_id' => $user->id],
        [
            'full_name'    => $request->full_name,
            'city'         => $request->city,
            'gender'       => $request->gender,
            'phone'        => $request->phone,
            'whatsapp'     => $request->whatsapp,
            'status'       => 'submitted',
            'submitted_at' => now(),
        ]
    );

    return redirect()->route('kyc.index')
        ->with('success', 'KYC documents submitted successfully. We will review them shortly.');
}

    public function status()
    {
        $kyc = Auth::user()->kycVerification;
        return view('user.kyc.status', compact('kyc'));
    }
}
