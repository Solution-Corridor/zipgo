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
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\Complaint;
use App\Models\ImportantNote;
use function Symfony\Component\Clock\now;
use Illuminate\Validation\ValidationException;



class Admin extends Controller
{
  public function dashboard()
  {
    $total_users    = User::where('type', 1)->count();
    $total_experts  = User::where('type', 2)->count();
    $total_services = Service::where('is_active', 1)->count();
    $total_cities   = City::where('is_active', 1)->count();

    return view('admin.dashboard', compact('total_users', 'total_experts', 'total_services', 'total_cities'));
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

    return view('admin.experts', compact('pendingExperts', 'verifiedExperts', 'rejectedExperts'));
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

public function users()
{
    $users = User::get();

    return view('admin.users', compact('users'));
}

  public function userDetails($id)
  {
    
    $user = User::with([
        'expertDetail.rates', // nested relation
    ])->findOrFail($id);

    if (!$user) {
      return redirect()->back()->with('error', 'User not found');
    }

    return view('admin.user_details', [
      'user' => $user,
    ]);
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

  public function deleteUser($id)
  {
    // Delete the account with the given ID
    DB::table('users')->where('id', $id)->delete();
    return back()->with('success', 'User deleted successfully');
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
      
      'balance'      => 'required|numeric',
      'type'         => 'required|in:0,1',
      'status'       => 'required|in:0,1',
      'pic'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
      'password'     => 'nullable|min:6',
      
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
      $validated['pic'] = 'uploads/user/' . $filename;
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

    return redirect()->route('admin.users')->with('success', 'User updated successfully');
  }




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




















  public function deleteUserSelf($id)
  {
    // Delete the account with the given ID
    DB::table('users')->where('id', $id)->delete();
    return redirect('/login')->with('success', 'User deleted successfully');
  }
}
