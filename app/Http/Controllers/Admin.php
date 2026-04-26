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

use function Symfony\Component\Clock\now;

use App\Models\ExpertDetail;

use Illuminate\Validation\ValidationException;

class Admin extends Controller
{



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


  public function experts(Request $request)
  {
    // Pending experts (profile_status = 0)
    $pendingExperts = DB::table('expert_details')
      ->join('users', 'expert_details.user_id', '=', 'users.id')
      ->leftJoin('services', 'expert_details.service_id', '=', 'services.id') // left join in case service is null
      ->select(
        'expert_details.*',
        'users.username',
        'users.email',
        'users.phone',
        'services.name as service_name'
      )
      ->where('expert_details.profile_status', 0)
      ->orderBy('expert_details.created_at', 'desc')
      ->get();

    // Verified experts (profile_status = 1)
    $verifiedExperts = DB::table('expert_details')
      ->join('users', 'expert_details.user_id', '=', 'users.id')
      ->leftJoin('services', 'expert_details.service_id', '=', 'services.id')
      ->select(
        'expert_details.*',
        'users.username',
        'users.email',
        'users.phone',
        'services.name as service_name'
      )
      ->where('expert_details.profile_status', 1)
      ->orderBy('expert_details.created_at', 'desc')
      ->get();

    $rejectedExperts = DB::table('expert_details')
      ->join('users', 'expert_details.user_id', '=', 'users.id')
      ->leftJoin('services', 'expert_details.service_id', '=', 'services.id')
      ->select(
        'expert_details.*',
        'users.username',
        'users.email',
        'users.phone',
        'services.name as service_name'
      )
      ->where('expert_details.profile_status', 2)
      ->orderBy('expert_details.created_at', 'desc')
      ->get();

    return view('expert.experts', compact('pendingExperts', 'verifiedExperts', 'rejectedExperts'));
  }

  // Handle expert verification
  public function verifyExpert($id)
  {
    $updated = DB::table('expert_details')
      ->where('id', $id)
      ->update(['profile_status' => 1]);

    if ($updated) {
      return redirect()->back()->with('success', 'Expert verified successfully.');
    }
    return redirect()->back()->with('error', 'Verification failed.');
  }

  // Handle expert rejection
  public function rejectExpert($id)
  {
    $updated = DB::table('expert_details')
      ->where('id', $id)
      ->update(['profile_status' => 2]);

    if ($updated) {
      return redirect()->back()->with('success', 'Expert rejected successfully.');
    }
    return redirect()->back()->with('error', 'Rejection failed.');
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
