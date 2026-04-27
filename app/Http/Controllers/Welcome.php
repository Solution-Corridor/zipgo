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


class Welcome extends Controller
{

  public function index()
  {
    $services = Service::where('is_active', 1)->orderBy('name')->get();
    return view('website.index', compact('services'));
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


  public function forgotPassword()
  {
    return view('auth.forgot_password');
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



  //edit blog
  public function edit_blogs($blog_id)
  {
    $blogs = DB::table('blog')
      ->where('blog_id', '=', $blog_id)
      ->get();
    $blogs = json_decode($blogs, true);
    return view('admin.edit_blogs', ['blogs' => $blogs]);
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
    $total_users    = User::where('type', 1)->count();
    $total_services = Service::where('is_active', 1)->count();
    $total_cities   = City::where('is_active', 1)->count();

    return view('admin.dashboard', compact('total_users', 'total_services', 'total_cities'));
  }

  public function user_dashboard()
  {
    $user = auth()->user();

    return view('user.dashboard', compact(
      'user'
    ));
  }


  public function expert_dashboard()
  {
    $user = auth()->user();

    return view('expert.dashboard', compact(
      'user'
    ));
  }


  public function show($slug)
  {
    // Try to find a service with the given slug
    $service = Service::where('slug', $slug)->first();
    if ($service) {
      return view('website.show-experts', compact('service'));
    }

    // If not a service, try to find a city
    $city = City::where('slug', $slug)->first();
    if ($city) {
      return view('website.show-experts', compact('city'));
    }

    // If neither exists, return 404
    abort(404, 'Page not found');
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



    // Session key unique per login identifier (username/phone)
    $attemptKey = 'login_attempts_sensitive_' . md5($loginInput);

    $attempts = 0;
    $maxAttempts = 5;


    $attempts = session($attemptKey, 0);


    // ────────────────────────────────────────────────
    // Try to log in
    // ────────────────────────────────────────────────
    if (! Auth::attempt($credentials)) {
      // Failed attempt


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


      return back()
        ->withInput($request->only('login'))
        ->withErrors(['login' => $message ?? 'Incorrect username/mobile or password.']);
    }

    // ────────────────────────────────────────────────
    // SUCCESSFUL LOGIN
    // ────────────────────────────────────────────────

    // Reset counter on success
    session()->forget($attemptKey);


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
    return match ((int) $user->type) {
      0 => redirect('dashboard'),
      1 => redirect('user-dashboard'),
      2 => redirect('expert-dashboard'),
      default => abort(403),
    };
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

  public function register()
  {
    $cities = City::where('is_active', 1)->orderBy('name')->get();
    return view('auth.register', compact('cities'));
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('login')->with('success', 'Logged out successfully');
  }
}
