<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
use App\Models\SubService;


class Welcome extends Controller
{

  public function liveLocation()
  {
    $user = Auth::user();
    // echo '<pre>';
    // print_r($user);
    // echo '</pre>';
    // exit;

    if (!$user) {
      return response()->json(['error' => 'Unauthenticated'], 401);
    }

    $ip = request()->ip();

    // Handle localhost / development
    if (in_array($ip, ['127.0.0.1', '::1'])) {
      $ip = '8.8.8.8';
    }

    $cacheKey = 'user-location-' . $ip;

    $location = cache()->remember($cacheKey, now()->addHours(8), function () use ($ip) {

      $response = Http::timeout(10)
        ->get("http://ip-api.com/json/{$ip}?fields=status,message,lat,lon,city,country,regionName,timezone");

      if ($response->successful()) {
        $data = $response->json();

        if (($data['status'] ?? '') === 'success') {
          return [
            'ip'       => $ip,
            'lat'      => $data['lat'] ?? null,
            'lng'      => $data['lon'] ?? null,
            'city'     => $data['city'] ?? null,
            'country'  => $data['country'] ?? null,
            'region'   => $data['regionName'] ?? null,
            'timezone' => $data['timezone'] ?? null,
          ];
        }
      }

      return [
        'ip' => $ip,
        'lat' => null,
        'lng' => null,
        'city' => null,
        'country' => null,
        'region' => null,
        'timezone' => null,
      ];
    });

    // ✅ SAVE TO DATABASE
    DB::table('user_locations')->updateOrInsert(
      ['user_id' => $user->id], // condition (unique key)
      [
        'ip'       => $location['ip'] ?? null,
        'lat'      => $location['lat'] ?? null,
        'lng'      => $location['lng'] ?? null,
        'city'     => $location['city'] ?? null,
        'country'  => $location['country'] ?? null,
        'region'   => $location['region'] ?? null,
        'timezone' => $location['timezone'] ?? null,
        'updated_at' => now(),
        'created_at' => now(), // only used on insert
      ]
    );

    return response()->json($location);
  }

  // ================================== AUTH SYSTEM ==========================
  public function register()
  {
    $cities = City::where('is_active', 1)->orderBy('name')->get();
    return view('auth.register', compact('cities'));
  }

  public function login()
  {
    return view('auth.login');
  }

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

    // Try to log in
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

    // SUCCESSFUL LOGIN
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
      0 => redirect()->route('admin.dashboard'),
      1 => redirect()->route('user.dashboard'),
      2 => redirect()->route('expert.dashboard'),
      default => abort(403),
    };
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('login')->with('success', 'Logged out successfully');
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
      'city_id'     => 'required|exists:cities,id',
      'user_type'   => 'required|in:customer,expert',
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
            return redirect('/login')->with('error', 'Too many failed attempts. Account has been deactivated.');
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

      if ($user->status == 0) {
        return redirect('/login')->with('error', 'Account is inactive.');
      }

      if ($user->status == 2) {
        return redirect('/login')->with('error', 'Account is suspended.');
      }

      // Single-device logout for non-admins
      if ($user->type != 0) {
        Auth::logoutOtherDevices($validated['password']);
      }

      // Reset sensitive attempts if applicable
      if ($user->is_sensitive) {
        $attemptKey = 'login_attempts_sensitive_' . md5($validated['phone']);
        session()->forget($attemptKey);
      }

      // Log in the user
      Auth::login($user);
      $request->session()->regenerate();

      // ✅ Redirect based on user type
      if ($user->type == 2) {
        return redirect()->route('expert.dashboard')->with('success', 'Welcome back!');
      }
      return redirect()->route('user.dashboard')->with('success', 'Welcome back!');
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
      'type'        => $validated['user_type'] === 'expert' ? 2 : 1,  // expert=2, customer=1
      'city_id'     => $validated['city_id'],
      'referred_by' => $validated['referred_by'] ?? null,
      'balance'     => 300,
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    // ✅ Redirect based on the newly created user's type
    if ($user->type == 2) {
      return redirect()->route('expert.dashboard')->with('success', 'Registration successful! Welcome on board.');
    }
    return redirect()->route('user.dashboard')->with('success', 'Registration successful! Welcome on board.');
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

  public function verify_otp($v_token)
  {
    // echo 'salman';
    // die();

    return view('auth.verify_otp', ['v_token' => $v_token]);
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

  // ================================== AUTH SYSTEM END ==========================

  public function index()
  {
    $priority_services = Service::where('is_active', 1)
      ->where('is_priority', '!=', 0)
      ->orderBy('is_priority', 'asc')
      ->get();

    $services = Service::where('is_active', 1)
      ->where('is_priority', 0)
      ->orderBy('name')
      ->get();

    $experts = ExpertDetail::with('user')->where('profile_status', 1)->limit(6)->get();
    return view('website.index', compact('priority_services', 'services', 'experts'));
  }

  public function search(Request $request)
  {
    $query = $request->input('query');

    if (!$query) {
      return redirect('/');
    }

    // Cities
    $cities = City::where('name', 'LIKE', "%{$query}%")->get();

    // Services
    $services = Service::where('name', 'LIKE', "%{$query}%")->get();

    // Experts = users with type 2 AND they have an expert_detail record
    $experts = User::where('type', 2)
      ->whereHas('expertDetail', function ($q) {
        // Only those who have completed expert profile (optional)
        // $q->where('profile_status', 1);
      })
      ->where(function ($q) use ($query) {
        $q->where('name', 'LIKE', "%{$query}%")
          ->orWhere('email', 'LIKE', "%{$query}%");
      })
      ->with('expertDetail') // load relation if needed in view
      ->limit(20)
      ->get();

    return view('website.search_results', compact('query', 'cities', 'services', 'experts'));
  }

  public function liveSearch(Request $request)
  {
    $query = $request->get('q', '');
    if (strlen($query) < 2) {
      return response()->json([]);
    }

    $cities = City::where('name', 'LIKE', "%{$query}%")
      ->limit(5)
      ->get(['id', 'name', 'slug']);

    $services = Service::where('name', 'LIKE', "%{$query}")
      ->orWhere('name', 'LIKE', "%{$query}%")
      ->limit(5)
      ->get(['id', 'name', 'slug']);

    // Experts: users with type 2 (expert) or those who have expert_details
    $experts = User::where('name', 'LIKE', "%{$query}%")
      ->where('type', 2)  // adjust if your expert type is different
      ->orWhereHas('expertDetail', function ($q) use ($query) {
        $q->where('nic_number', 'LIKE', "%{$query}%");
      })
      ->with('expertDetail')
      ->limit(5)
      ->get(['id', 'name', 'email']);

    return response()->json([
      'cities'   => $cities,
      'services' => $services,
      'experts'  => $experts,
    ]);
  }

  public function areas()
  {
    // No cities passed – they will load via AJAX
    return view('website.areas');
  }

  public function loadMoreAreas(Request $request)
  {
    $offset = $request->input('offset', 0);
    $limit = 6;

    // Use where() directly instead of scope
    $cities = City::where('is_active', 1)
      ->orderBy('name')
      ->skip($offset)
      ->take($limit)
      ->get(['id', 'name', 'slug', 'pic', 'detail']);

    $cities->transform(function ($city) {
      $city->short_detail = Str::limit(strip_tags($city->detail ?? ''), 100);
      return $city;
    });

    $total = City::where('is_active', 1)->count();
    $hasMore = ($offset + $limit) < $total;

    return response()->json([
      'cities' => $cities,
      'hasMore' => $hasMore,
      'nextOffset' => $offset + $limit,
    ]);
  }

  public function services()
  {
    return view('website.services'); // blade view for services
  }

  public function loadMoreServices(Request $request)
  {
    $offset = $request->input('offset', 0);
    $limit = 6;

    // Priority first (is_priority = 1), then the rest, both ordered by slug (or name)
    $services = Service::where('is_active', 1)
      ->orderBy('is_priority', 'desc')
      // ->orderBy('slug')
      ->skip($offset)
      ->take($limit)
      ->get(['id', 'name', 'slug', 'pic', 'price', 'detail']);

    $services->transform(function ($service) {
      $service->short_detail = Str::limit(strip_tags($service->detail ?? ''), 100);
      $service->formatted_price = number_format($service->price, 2);

      // Fix image URL
      if ($service->pic) {
        if (strpos($service->pic, 'uploads/') === 0) {
          $service->image_url = asset($service->pic);
        } else {
          $service->image_url = asset('uploads/services/' . $service->pic);
        }
      } else {
        $service->image_url = null;
      }

      return $service;
    });

    $total = Service::where('is_active', 1)->count();
    $hasMore = ($offset + $limit) < $total;

    return response()->json([
      'services' => $services,
      'hasMore'  => $hasMore,
      'nextOffset' => $offset + $limit,
    ]);
  }


  public function show_subservices($slug)
  {
    $service = Service::where('slug', $slug)->first();
    if ($service) {
      $subServices = SubService::where('service_id', $service->id)
        ->orderBy('is_priority', 'desc')
        ->orderBy('id', 'desc')
        ->get();

      return view('website.show-subservices', compact('service', 'subServices'));
    }
  }

  public function blogs()
  {
    $blogs = Blog::orderBy('created_at', 'desc')->paginate(12);
    return view('website.blogs', compact('blogs'));
  }

  public function blog_detail($slug)
  {
    $blog = Blog::where('slug', $slug)->firstOrFail();
    $recentBlogs = Blog::where('blog_id', '!=', $blog->blog_id)
      ->orderBy('created_at', 'desc')
      ->limit(5)
      ->get();
    return view('website.blog_detail', compact('blog', 'recentBlogs'));
  }

  public function expert_detail($id)
  {
    $expert = ExpertDetail::with(['user', 'rates'])
      ->where('id', $id)
      ->firstOrFail();

    return view('website.expert-detail', compact('expert'));
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












































  //========login......







}
