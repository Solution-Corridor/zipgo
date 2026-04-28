<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\City;
use App\Models\Service;
use App\Models\ExpertDetail;
use App\Models\Blog;


class ExpertMain extends Controller
{

  public function expert_dashboard()
  {
    $user = auth()->user();

    return view('expert.dashboard', compact(
      'user'
    ));
  }

  public function updateExpert(Request $request)
  {

    // 1. Validate inputs – on failure, redirects back with old input automatically
    $validated = $request->validate([
      'service_id'     => 'required|exists:services,id',
      'nic_number'     => 'required|string|max:50',
      'nic_expiry'     => 'required|date',
      'nic_front'      => 'required|image|max:2048',
      'nic_back'       => 'required|image|max:2048',
      'selfie'         => 'required|image|max:2048',
    ]);

    $userId = Auth::id();
    if (!$userId) {
      return redirect()->back()->with('error', 'You must be logged in.');
    }

    // 2. Helper to save uploaded file and return public path
    $saveFile = function ($file) {
      $destinationPath = public_path('expert/images');
      if (!File::exists($destinationPath)) {
        File::makeDirectory($destinationPath, 0755, true);
      }
      $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
      $file->move($destinationPath, $fileName);
      return 'expert/images/' . $fileName;
    };

    // 3. Prepare data array (match fillable fields in ExpertDetail model)
    $data = [
      'user_id'        => $userId,
      'service_id'     => $request->service_id,
      'nic_number'     => $request->nic_number,
      'nic_expiry'     => $request->nic_expiry,
      'payment_status' => 'Pending',   // ENUM value
      'profile_status' => 0,
    ];

    // 4. Add file paths if uploaded
    if ($request->hasFile('nic_front')) {
      $data['nic_front_image'] = $saveFile($request->file('nic_front'));
    }
    if ($request->hasFile('nic_back')) {
      $data['nic_back_image'] = $saveFile($request->file('nic_back'));
    }
    if ($request->hasFile('selfie')) {
      $data['selfie_image'] = $saveFile($request->file('selfie'));
    }

    // 5. Create record using Eloquent model
    $expertDetail = ExpertDetail::updateOrCreate(
      ['user_id' => $userId],
      $data
    );

    $recordId = $expertDetail->id;

    session(['pending_expert_id' => $recordId]);

    // 7. Get service price
    $price = $expertDetail->service->price ?? 0; // using relation

    // 8. Redirect to payment page with success message
    return redirect()->route('expert.payment.page')
      ->with('amount', $price)
      ->with('success', 'Expert details saved. Please complete payment.');
  }


  public function expert_profile()
  {
    $user = DB::table('users')->where('id', auth()->id())->first();

    if (!$user) {
      return redirect()->back()->with('error', 'User not found');
    }

    // Fetch expert details for the current user
    $expertData = DB::table('expert_details')
      ->where('user_id', auth()->id())
      ->first();

    $services = DB::table('services')
      ->where('is_active', 1)
      ->orderBy('name')
      ->get();

    return view('expert.profile', [
      'user'       => $user,
      'services'   => $services,
      'expertData' => $expertData,   // now defined in view
    ]);
  }

  public function showPaymentPage()
  {
    $amount = session('amount', 0);
    if (!$amount) {
      return redirect()->back()->with('error', 'Invalid payment request.');
    }
    return view('expert.payment', compact('amount'));
  }

  public function processPayment(Request $request)
  {
    $request->merge([
      'card_number' => preg_replace('/\s+/', '', $request->card_number),
    ]);

    $request->validate([
      'card_number'  => 'required|digits:16',
      'expiry_month' => 'required|string|size:2',
      'expiry_year'  => 'required|string|size:2',
      'cvc'          => 'required|string|size:3',
    ]);

    // Validate card (Luhn, expiry) as before
    if (!$this->validateLuhn($request->card_number)) {
      return redirect()->back()->with('error', 'Invalid card number.');
    }
    // ... expiry validation

    $expertId = session('pending_expert_id');
    if (!$expertId) {
      return redirect()->back()->with('error', 'Session expired. Please start over.');
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
}
