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


class MainUser extends Controller
{
  public function user_dashboard()
  {
    // 1. Categories for horizontal scroll
    $categories = [
      (object) ['name' => 'Plumber', 'icon' => 'droplet', 'color' => 'blue'],
      (object) ['name' => 'Electrician', 'icon' => 'zap', 'color' => 'yellow'],
      (object) ['name' => 'Carpenter', 'icon' => 'hammer', 'color' => 'amber'],
      (object) ['name' => 'AC Repair', 'icon' => 'snowflake', 'color' => 'cyan'],
      (object) ['name' => 'Painter', 'icon' => 'palette', 'color' => 'purple'],
      (object) ['name' => 'Cleaner', 'icon' => 'spray-can', 'color' => 'green'],
      (object) ['name' => 'Electrician', 'icon' => 'plug', 'color' => 'orange'],
      (object) ['name' => 'Plumber', 'icon' => 'wrench', 'color' => 'teal'],
    ];

    // 2. Nearby professionals
    $nearbyProfessionals = [
      (object) [
        'name' => 'Ramesh K.',
        'profession' => 'Plumber',
        'rating' => 4.9,
        'distance' => '1.2 km',
        'price' => 299,
        'avatar' => 'R',
        'avatar_color' => 'blue'
      ],
      (object) [
        'name' => 'Sunil E.',
        'profession' => 'Electrician',
        'rating' => 4.8,
        'distance' => '3.0 km',
        'price' => 399,
        'avatar' => 'S',
        'avatar_color' => 'yellow'
      ],
      (object) [
        'name' => 'Mohan C.',
        'profession' => 'Carpenter',
        'rating' => 4.7,
        'distance' => '2.5 km',
        'price' => 499,
        'avatar' => 'M',
        'avatar_color' => 'amber'
      ],
    ];

    // 3. Service packages
    $packages = [
      (object) [
        'title' => 'Plumbing Maintenance',
        'discount' => '20% OFF',
        'price' => 999,
        'description' => 'Includes inspection + 2 repairs',
        'icon' => 'gift'
      ],
      (object) [
        'title' => 'Full Home Electrification',
        'discount' => '15% OFF',
        'price' => 2499,
        'description' => 'Wiring + 10 points + safety check',
        'icon' => 'gift'
      ],
      (object) [
        'title' => 'AC Service & Repair',
        'discount' => '10% OFF',
        'price' => 1499,
        'description' => 'Gas refill + cleaning + check',
        'icon' => 'gift'
      ],
    ];

    // You can also add a welcome message for top_greetings (optional)
    // The top_greetings include already uses $user->name etc.

    return view('user.dashboard', compact('categories', 'nearbyProfessionals', 'packages'));
  }

  public function explore()
  {
    // Dummy categories with sub‑services
    $exploreCategories = [
      (object) ['name' => 'Plumbing', 'icon' => 'droplet', 'services' => ['Tap repair', 'Pipe leakage', 'Water heater install']],
      (object) ['name' => 'Electrical', 'icon' => 'zap', 'services' => ['Wiring', 'Fan repair', 'Switchboard fix']],
      (object) ['name' => 'Carpentry', 'icon' => 'hammer', 'services' => ['Furniture assembly', 'Door repair', 'Cabinet making']],
      (object) ['name' => 'Cleaning', 'icon' => 'spray-can', 'services' => ['Sofa cleaning', 'Bathroom scrub', 'Kitchen deep clean']],
    ];

    return view('user.explore', compact('exploreCategories'));
  }

  public function search()
  {
    // Show search form with popular keywords
    $popularSearches = ['Plumber near me', 'AC repair', 'Electrician 24/7', 'Carpenter for shelf'];
    return view('user.search', compact('popularSearches'));
  }

  public function search_results(Request $request)
  {
    $query = $request->input('query');
    // Dummy results
    $results = [
      (object) ['name' => 'Rajesh Plumber', 'rating' => 4.9, 'distance' => '0.8 km', 'price' => 299, 'expertise' => 'Leakage & Installation'],
      (object) ['name' => 'Elite Electricians', 'rating' => 4.8, 'distance' => '1.2 km', 'price' => 399, 'expertise' => 'Wiring & Repairs'],
      (object) ['name' => 'CoolAir AC', 'rating' => 4.7, 'distance' => '2.0 km', 'price' => 499, 'expertise' => 'Gas refill, Service'],
    ];

    return view('user.search-results', compact('query', 'results'));
  }

  public function bookings()
  {
    // Dummy bookings (upcoming & past)
    $upcoming = [
      (object) ['id' => 101, 'professional' => 'Ramesh K.', 'service' => 'Plumbing', 'date' => '2025-05-05 10:00 AM', 'status' => 'Confirmed'],
      (object) ['id' => 102, 'professional' => 'Sunil E.', 'service' => 'Electrical', 'date' => '2025-05-07 02:00 PM', 'status' => 'Pending'],
    ];

    $past = [
      (object) ['id' => 99, 'professional' => 'Mohan C.', 'service' => 'Carpentry', 'date' => '2025-04-20', 'status' => 'Completed'],
    ];

    return view('user.bookings', compact('upcoming', 'past'));
  }

  public function booking_show($id)
  {
    // Dummy single booking detail
    $booking = (object) [
      'id' => $id,
      'professional' => 'Ramesh K.',
      'service' => 'Plumbing',
      'date' => '2025-05-05 10:00 AM',
      'address' => '123 Main St, Bangalore',
      'price' => 299,
      'status' => 'Confirmed',
      'description' => 'Fix leaking kitchen pipe',
    ];

    return view('user.booking-detail', compact('booking'));
  }

  public function booking_store(Request $request)
  {
    // Dummy store – redirect back with success
    return redirect()->route('customer.bookings')->with('success', 'Booking created (demo)!');
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


































  public function awards()
  {
    return view('user.awards');
  }

  public function pre_dashboard()
  {
    return view('user.pre_dashboard');
  }

  public function info()
  {
    return view('user.info');
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

  public function crypto()
  {
    return view('user.crypto');
  }

  public function sample()
  {
    return view('user.sample');
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

  public function download_app()
  {
    return view('user.download_app');
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
}
