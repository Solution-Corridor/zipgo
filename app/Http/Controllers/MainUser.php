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
    $user = auth()->user();

    return view('user.dashboard', compact(
      'user'
    ));
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
