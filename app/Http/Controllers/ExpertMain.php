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
use Illuminate\Support\Facades\File;


class ExpertMain extends Controller
{
  public function expert_dashboard()
  {
    // --- Earnings Summary ---
    $todayEarnings = 1250;       // ₹
    $weeklyEarnings = 8750;      // ₹
    $monthlyEarnings = 34200;     // ₹

    // --- Today's Jobs ---
    $todaysJobs = [
      (object) [
        'id'       => 101,
        'customer' => 'Rajesh Sharma',
        'service'  => 'Plumbing',
        'time'     => '10:00 AM',
        'address'  => '123 Main St, Bangalore',
        'status'   => 'pending',   // pending, confirmed, completed
      ],
      (object) [
        'id'       => 102,
        'customer' => 'Priya Singh',
        'service'  => 'Electrical',
        'time'     => '02:00 PM',
        'address'  => '45 Park Ave, Bangalore',
        'status'   => 'confirmed',
      ],
      (object) [
        'id'       => 103,
        'customer' => 'Amit Verma',
        'service'  => 'AC Repair',
        'time'     => '04:30 PM',
        'address'  => '78 Lake View, Bangalore',
        'status'   => 'pending',
      ],
    ];

    // --- Upcoming Bookings (next 7 days) ---
    $upcomingBookings = [
      (object) [
        'id'       => 104,
        'customer' => 'Neha Gupta',
        'service'  => 'Carpentry',
        'date'     => '2025-05-05',
        'time'     => '11:00 AM',
      ],
      (object) [
        'id'       => 105,
        'customer' => 'Suresh Kumar',
        'service'  => 'Plumbing',
        'date'     => '2025-05-07',
        'time'     => '03:00 PM',
      ],
      (object) [
        'id'       => 106,
        'customer' => 'Kavita Reddy',
        'service'  => 'Electrical',
        'date'     => '2025-05-09',
        'time'     => '10:00 AM',
      ],
    ];

    // --- Performance Stats ---
    $completionRate = 98;      // percentage
    $totalJobs      = 156;     // total completed + ongoing
    $rating         = 4.9;     // average rating (out of 5)

    // --- Expert Info (used in top greeting) ---
    // The top greeting uses `auth()->user()` directly, so no need to pass.
    // But we include rating & totalJobs for the top greeting's display.

    return view('expert.dashboard', compact(
      'todayEarnings',
      'weeklyEarnings',
      'monthlyEarnings',
      'todaysJobs',
      'upcomingBookings',
      'completionRate',
      'totalJobs',
      'rating'
    ));
  }


  public function showRechargeForm()
  {
    return view('expert.recharge');
  }

  // Process recharge (simulate payment)
  public function rechargeProcess(Request $request)
  {
    return redirect()->route('expert.dashboard')->with('success', 'Balance recharged successfully!');

    $validated = $request->validate([
      'amount' => 'required|numeric|min:50|max:50000',
      'method' => 'required|in:easypaisa,jazzcash,bank_card',
    ]);

    // Additional validation based on payment method
    if ($request->method === 'easypaisa' || $request->method === 'jazzcash') {
      $request->validate([
        'mobile_number' => 'required|digits:10|regex:/^[0-9]{10}$/',
      ]);
    } elseif ($request->method === 'bank_card') {
      $request->validate([
        'card_number' => 'required|digits:16',
        'expiry_month' => 'required|digits:2|between:01,12',
        'expiry_year'  => 'required|digits:2',
        'cvv'          => 'required|digits:3',
      ]);
    }

    $user = Auth::user();
    $user->balance += $validated['amount'];
    $user->save();

    return redirect()->route('expert.dashboard')->with('success', 'Balance recharged successfully!');
  }

  public function jobs(Request $request)
  {
    // Dummy data for jobs listing
    $jobs = [
      (object) [
        'id'       => 101,
        'customer' => 'Rajesh Sharma',
        'service'  => 'Plumbing',
        'date'     => '2025-05-01',
        'time'     => '10:00 AM',
        'status'   => 'completed',
        'earnings' => 499,
        'address'  => '123 Main St, Bangalore'
      ],
      (object) [
        'id'       => 102,
        'customer' => 'Priya Singh',
        'service'  => 'Electrical',
        'date'     => '2025-05-02',
        'time'     => '02:00 PM',
        'status'   => 'completed',
        'earnings' => 699,
        'address'  => '45 Park Ave, Bangalore'
      ],
      (object) [
        'id'       => 103,
        'customer' => 'Amit Verma',
        'service'  => 'AC Repair',
        'date'     => '2025-05-03',
        'time'     => '11:00 AM',
        'status'   => 'cancelled',
        'earnings' => 0,
        'address'  => '78 Lake View, Bangalore'
      ],
      (object) [
        'id'       => 104,
        'customer' => 'Neha Gupta',
        'service'  => 'Carpentry',
        'date'     => '2025-05-05',
        'time'     => '03:00 PM',
        'status'   => 'pending',
        'earnings' => null,
        'address'  => '12 Garden Colony, Bangalore'
      ],
      (object) [
        'id'       => 105,
        'customer' => 'Suresh Kumar',
        'service'  => 'Plumbing',
        'date'     => '2025-05-06',
        'time'     => '09:00 AM',
        'status'   => 'confirmed',
        'earnings' => 599,
        'address'  => '67 Lake Road, Bangalore'
      ],
    ];

    // Optional: filter by status from request
    $statusFilter = $request->get('status');
    if ($statusFilter && in_array($statusFilter, ['pending', 'confirmed', 'completed', 'cancelled'])) {
      $jobs = array_filter($jobs, fn($job) => $job->status === $statusFilter);
    }

    return view('expert.jobs', compact('jobs', 'statusFilter'));
  }

  /**
   * Show a single job details.
   */
  public function jobs_show($id)
  {
    // Dummy data – in real app, fetch from DB
    $job = (object) [
      'id'          => (int) $id,
      'customer'    => 'Rajesh Sharma',
      'customer_phone' => '+91 98765 43210',
      'service'     => 'Plumbing',
      'date'        => '2025-05-01',
      'time'        => '10:00 AM',
      'address'     => '123 Main St, Bangalore',
      'status'      => 'pending', // pending, confirmed, completed, cancelled
      'earnings'    => 499,
      'description' => 'Fix leaking kitchen pipe and replace faucet. Also check water pressure.',
      'created_at'  => '2025-04-28',
    ];

    return view('expert.job-detail', compact('job'));
  }

  public function jobs_accept($id)
  {
    return back()->with('success', 'Job accepted.');
  }
  public function jobs_decline($id)
  {
    return back()->with('success', 'Job declined.');
  }
  public function jobs_complete($id)
  {
    return back()->with('success', 'Job marked completed.');
  }

  public function updateStatus(Request $request, $id)
  {
    $status = $request->input('status'); // pending, confirmed, completed, cancelled
    // Dummy update – in real app, update the job in DB
    return back()->with('success', "Job #{$id} status updated to " . ucfirst($status));
  }

  public function earnings()
  {
    // Dummy data
    $totalEarnings = 34200;
    $pendingPayout = 5600;
    $thisMonthEarnings = 12500;
    $lastMonthEarnings = 9800;

    $weeklyData = [1250, 2300, 1875, 2900, 3100, 2750, 1980]; // last 7 days

    $withdrawals = [
      (object) ['id' => 1, 'date' => '2025-04-25', 'amount' => 5000, 'status' => 'completed'],
      (object) ['id' => 2, 'date' => '2025-04-18', 'amount' => 3000, 'status' => 'completed'],
      (object) ['id' => 3, 'date' => '2025-04-10', 'amount' => 2000, 'status' => 'pending'],
    ];

    $transactions = [
      (object) ['date' => '2025-05-01', 'description' => 'Plumbing job #101', 'amount' => 499, 'type' => 'credit'],
      (object) ['date' => '2025-05-02', 'description' => 'Electrical job #102', 'amount' => 699, 'type' => 'credit'],
      (object) ['date' => '2025-04-25', 'description' => 'Withdrawal', 'amount' => 5000, 'type' => 'debit'],
    ];

    return view('expert.earnings', compact('totalEarnings', 'pendingPayout', 'thisMonthEarnings', 'lastMonthEarnings', 'weeklyData', 'withdrawals', 'transactions'));
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















































  public function my_complaints()
  {
    // if (auth()->user()->is_complaint_allowed == 0) {
    //   return redirect()->back()->with('error', 'You are not allowed to view complaints.');
    // }

    $complaints = Complaint::where('user_id', auth()->id())
      ->latest()
      ->paginate(10);   // or ->get() if you prefer no pagination

    return view('expert.my_complaints', compact('complaints'));
  }

  public function complaint_store(Request $request)
  {
    $validated = $request->validate([
      'subject' => 'required|string|max:120',
      'detail'  => 'required|string|min:10',
      'screenshot' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
    ]);

    $userId = Auth::id();

    // Check if user already has a pending complaint
    $hasPendingComplaint = Complaint::where('user_id', $userId)
      ->where('status', 'pending')
      ->exists();

    if ($hasPendingComplaint) {
      return redirect()
        ->route('my_complaints')
        ->with('error', 'You already have a pending complaint. Please wait until it is resolved.');
    }

    // Check if user has a recently resolved complaint within the last 24 hours
    $lastResolvedComplaint = Complaint::where('user_id', $userId)
      ->where('status', 'resolved')
      ->latest('resolved_at')
      ->first();

    if ($lastResolvedComplaint && $lastResolvedComplaint->resolved_at->diffInHours(now()) < 24) {
      return redirect()
        ->route('my_complaints')
        ->with('error', 'You can only submit a new complaint after 24 hours from your last resolved complaint.');
    }

    if ($request->hasFile('screenshot')) {

      // Store the new file and get the path
      $file = $request->file('screenshot');

      // Option 1: Simple filename (recommended for most cases)
      $filename = time() . '_' . $file->getClientOriginalName();
      $path = $file->move(public_path('uploads/complaints'), $filename);
      // → then $path would be full server path → you usually want relative path
    }

    Complaint::create([
      'user_id' => $userId,
      'subject' => $validated['subject'],
      'detail'  => $validated['detail'],
      'screenshot' => isset($path) ? 'uploads/complaints/' . $filename : null,
      'status'  => 'pending',
    ]);

    return redirect()
      ->route('my_complaints')
      ->with('success', 'Your complaint has been submitted successfully. We will review it soon.');
  }

  public function sample()
  {
    return view('expert.sample');
  }















  public function showPaymentPage()
  {
    // Get the pending expert record ID from session (set in updateExpert)
    $expertId = session('pending_expert_id');

    if (!$expertId) {
      return redirect()->route('expert.profile')->with('error', 'Invalid payment request. Please try again.');
    }

    // Load expert detail with its related service
    $expertDetail = \App\Models\ExpertDetail::with('service')->find($expertId);

    if (!$expertDetail || $expertDetail->user_id != auth()->id()) {
      return redirect()->route('expert.profile')->with('error', 'Expert record not found.');
    }

    $amount = $expertDetail->service->price ?? 0;

    if ($amount <= 0) {
      return redirect()->route('expert.profile')->with('error', 'Invalid service price. Contact support.');
    }

    // (Optional) store amount in session again for internal consistency, but not required for display
    session(['amount' => $amount]);

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

    // Luhn validation
    if (!$this->validateLuhn($request->card_number)) {
      return redirect()->back()->with('error', 'Invalid card number.');
    }

    // Expiry validation (example)
    $month = $request->expiry_month;
    $year  = $request->expiry_year;
    $currentYear  = date('y');
    $currentMonth = date('m');
    if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
      return redirect()->back()->with('error', 'Card has expired.');
    }

    $expertId = session('pending_expert_id');
    if (!$expertId) {
      return redirect()->back()->with('error', 'Session expired. Please start over.');
    }

    // Retrieve the expert detail with service relation
    $expertDetail = \App\Models\ExpertDetail::with('service')->find($expertId);

    if (!$expertDetail || $expertDetail->user_id != auth()->id()) {
      return redirect()->back()->with('error', 'Invalid expert record.');
    }

    $amount = $expertDetail->service->price ?? 0;

    if ($amount <= 0) {
      return redirect()->back()->with('error', 'Invalid payment amount.');
    }

    // Update payment details
    $expertDetail->update([
      'payment_status' => 'Paid',
      'amount_paid'    => $amount,
    ]);

    // Clear session data
    session()->forget(['pending_expert_id', 'amount']);

    return redirect()->route('expert.profile')->with('success', 'Payment successful! You are now an expert.');
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
