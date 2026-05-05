<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
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
    // ------------------- 1. Service Categories (priority order) -------------------
    $prioritySlugs = [
      'plumbing',
      'ac-repair-installation',
      'carpenter',
      'painter',
      'pest-control',
      'appliance-repair',
      'water-tank-cleaning',
      'ironing-service',
    ];

    $allServices = Service::where('is_active', 1)->get();

    $priorityServices = collect();
    foreach ($prioritySlugs as $slug) {
      $service = $allServices->firstWhere('slug', $slug);
      if ($service) $priorityServices->push($service);
    }

    $otherServices = $allServices->reject(function ($service) use ($prioritySlugs) {
      return in_array($service->slug, $prioritySlugs);
    })->sortBy('name');

    $services = $priorityServices->concat($otherServices);

    $categories = $services->map(function ($service) {
      return (object)[
        'id'  => $service->id,
        'name'  => $service->name,
        'slug'  => $service->slug,
        'icon'  => $this->getIcon($service->name),
        'color' => $this->getColor($service->name),
      ];
    });

    // ------------------- 2. Dynamic Nearby Professionals -------------------
    $user = Auth::user();
    $limit = 6;
    $nearbyProfessionals = collect();

    if ($user && $user->city_id) {
      // Stage 1: same city, newest first
      $sameCityExperts = ExpertDetail::where('profile_status', 1)
        ->whereHas('user', function ($query) use ($user) {
          $query->where('type', 2)
            ->where('city_id', $user->city_id)
            ->where('status', 1);
        })
        ->with(['user.city', 'service', 'rates'])
        ->orderBy('created_at', 'desc')
        ->take($limit)
        ->get();

      $collectedIds = $sameCityExperts->pluck('id')->toArray();
      $nearbyProfessionals = $sameCityExperts;

      // Stage 2: newest from any city (newbies)
      if ($nearbyProfessionals->count() < $limit) {
        $needed = $limit - $nearbyProfessionals->count();
        $newbyExperts = ExpertDetail::where('profile_status', 1)
          ->whereNotIn('id', $collectedIds)
          ->whereHas('user', fn($q) => $q->where('type', 2)->where('status', 1))
          ->with(['user.city', 'service', 'rates'])
          ->orderBy('created_at', 'desc')
          ->take($needed)
          ->get();

        $nearbyProfessionals = $nearbyProfessionals->concat($newbyExperts);
        $collectedIds = array_merge($collectedIds, $newbyExperts->pluck('id')->toArray());
      }

      // Stage 3: any remaining approved experts
      if ($nearbyProfessionals->count() < $limit) {
        $needed = $limit - $nearbyProfessionals->count();
        $anyExperts = ExpertDetail::where('profile_status', 1)
          ->whereNotIn('id', $collectedIds)
          ->whereHas('user', fn($q) => $q->where('type', 2)->where('status', 1))
          ->with(['user.city', 'service', 'rates'])
          ->inRandomOrder()
          ->take($needed)
          ->get();

        $nearbyProfessionals = $nearbyProfessionals->concat($anyExperts);
      }
    } else {
      // No logged-in user or no city → latest 10 approved experts
      $nearbyProfessionals = ExpertDetail::where('profile_status', 1)
        ->whereHas('user', fn($q) => $q->where('type', 2)->where('status', 1))
        ->with(['user.city', 'service', 'rates'])
        ->orderBy('created_at', 'desc')
        ->take($limit)
        ->get();
    }

    // Transform each expert (now using full_name)
    $nearbyProfessionals = $nearbyProfessionals->map(function ($expert) {
      $user = $expert->user;
      $service = $expert->service;

      // Use full_name from expert_details if available, else user.name/username
      $displayName = $expert->full_name ?? $user->name ?? $user->username ?? 'Professional';

      $price = $expert->rates->isNotEmpty() ? round($expert->rates->avg('rate')) : 0;
      $rating = 4.5;
      $cityName = $user->city ? $user->city->name : 'Unknown City';
      $selfieImage = $expert->selfie_image ? asset($expert->selfie_image) : null;
      $avatarInitial = strtoupper(substr($displayName, 0, 1));
      $avatarColor = $this->getAvatarColor($displayName);

      return (object)[
        'id'           => $expert->id,
        'name'         => $displayName,
        'profession'   => $service ? $service->name : 'Service Professional',
        'rating'       => $rating,
        'distance'     => $cityName,
        'price'        => $price,
        'selfie_image' => $selfieImage,
        'avatar'       => $avatarInitial,
        'avatar_color' => $avatarColor,
      ];
    });

    // ------------------- 3. Static Service Packages -------------------
    $packages = [
      (object) ['title' => 'Plumbing Maintenance',      'discount' => '20% OFF', 'price' => 999,  'description' => 'Includes inspection + 2 repairs',      'icon' => 'gift'],
      (object) ['title' => 'Full Home Electrification', 'discount' => '15% OFF', 'price' => 2499, 'description' => 'Wiring + 10 points + safety check',    'icon' => 'gift'],
      (object) ['title' => 'AC Service & Repair',       'discount' => '10% OFF', 'price' => 1499, 'description' => 'Gas refill + cleaning + check',       'icon' => 'gift'],
    ];

    return view('user.dashboard', compact('categories', 'nearbyProfessionals', 'packages'));
  }

  // ------------------- Helper Methods -------------------
  private function getAvatarColor(string $name): string
  {
    $colors = ['blue', 'yellow', 'amber', 'green', 'red', 'purple', 'pink', 'indigo'];
    $index = abs(crc32($name)) % count($colors);
    return $colors[$index];
  }

  private function getIcon($name)
  {
    $name = strtolower($name);

    return match (true) {
      // Home & Repair
      str_contains($name, 'plumb') => 'droplet',
      str_contains($name, 'ac') => 'snowflake',
      str_contains($name, 'carpenter') => 'hammer',
      str_contains($name, 'paint') => 'palette',
      str_contains($name, 'clean') => 'spray-can',
      str_contains($name, 'repair') => 'wrench',
      str_contains($name, 'design') => 'pen-tool',
      str_contains($name, 'construction') => 'building',
      str_contains($name, 'garden') => 'leaf',
      str_contains($name, 'water tank') => 'droplet',
      str_contains($name, 'electric') => 'zap',

      // Beauty & Personal Care
      str_contains($name, 'salon') || str_contains($name, 'hair') => 'scissors',
      str_contains($name, 'makeup') => 'eye',
      str_contains($name, 'bridal') => 'heart',
      str_contains($name, 'skincare') || str_contains($name, 'facial') => 'sun',
      str_contains($name, 'spa') || str_contains($name, 'massage') => 'heart',
      str_contains($name, 'nail') => 'hand',
      str_contains($name, 'mehndi') => 'feather',
      str_contains($name, 'barber') || str_contains($name, 'grooming') => 'scissors',

      // Medical & Health
      str_contains($name, 'doctor') || str_contains($name, 'clinic') => 'stethoscope',
      str_contains($name, 'specialist') => 'users',
      str_contains($name, 'dentist') => 'smile',
      str_contains($name, 'eye') => 'eye',
      str_contains($name, 'diagnostic') || str_contains($name, 'lab') => 'flask',
      str_contains($name, 'physiotherapy') => 'activity',
      str_contains($name, 'nursing') => 'user-plus',
      str_contains($name, 'ambulance') => 'truck',
      str_contains($name, 'pharmacy') => 'plus-circle',
      str_contains($name, 'mental') => 'brain',
      str_contains($name, 'emergency') || str_contains($name, 'rescue') => 'alert-triangle',

      // Education & Tutoring
      str_contains($name, 'tutor') || str_contains($name, 'course') => 'book',
      str_contains($name, 'online tutor') => 'monitor',
      str_contains($name, 'coaching') => 'trending-up',
      str_contains($name, 'language') => 'globe',
      str_contains($name, 'computer course') => 'cpu',
      str_contains($name, 'quran') => 'book-open',
      str_contains($name, 'skill') => 'award',
      str_contains($name, 'test preparation') => 'check-square',

      // IT & Digital
      str_contains($name, 'graphic') || str_contains($name, 'logo') => 'image',
      str_contains($name, 'web') || str_contains($name, 'app') => 'code',
      str_contains($name, 'seo') => 'trending-up',
      str_contains($name, 'social media') => 'share-2',
      str_contains($name, 'content writing') => 'edit-3',
      str_contains($name, 'video editing') => 'video',
      str_contains($name, 'virtual assistant') => 'headphones',
      str_contains($name, 'data entry') => 'database',
      str_contains($name, 'programming') => 'terminal',
      str_contains($name, 'copywriting') => 'file-text',
      str_contains($name, 'illustration') => 'pen-tool',
      str_contains($name, 'consulting') => 'briefcase',

      // Electronics Repair
      str_contains($name, 'mobile repair') => 'smartphone',
      str_contains($name, 'laptop repair') => 'laptop',
      str_contains($name, 'computer repair') => 'cpu',
      str_contains($name, 'tv repair') => 'monitor',
      str_contains($name, 'fridge repair') => 'thermometer',
      str_contains($name, 'washing machine') => 'droplet',
      str_contains($name, 'generator') => 'zap',
      str_contains($name, 'auto mechanic') => 'car',

      // Finance & Legal
      str_contains($name, 'account') || str_contains($name, 'tax') => 'calculator',
      str_contains($name, 'legal') || str_contains($name, 'lawyer') => 'scale',
      str_contains($name, 'hr') || str_contains($name, 'recruitment') => 'users',
      str_contains($name, 'business registration') => 'file',
      str_contains($name, 'bank') || str_contains($name, 'loan') || str_contains($name, 'insurance') => 'credit-card',
      str_contains($name, 'investment') => 'trending-up',

      // Transport & Logistics
      str_contains($name, 'courier') || str_contains($name, 'delivery') => 'truck',
      str_contains($name, 'movers') || str_contains($name, 'packers') => 'package',
      str_contains($name, 'bike delivery') => 'bike',
      str_contains($name, 'car rental') => 'car',
      str_contains($name, 'truck rental') => 'truck',
      str_contains($name, 'ride') => 'navigation',
      str_contains($name, 'logistics') => 'archive',
      str_contains($name, 'bus service') => 'bus',
      str_contains($name, 'fuel') => 'droplet',

      // Events & Entertainment
      str_contains($name, 'catering') => 'utensils',
      str_contains($name, 'wedding') => 'heart',
      str_contains($name, 'photo') || str_contains($name, 'videography') => 'camera',
      str_contains($name, 'decoration') => 'gift',
      str_contains($name, 'dj') || str_contains($name, 'sound') => 'music',
      str_contains($name, 'event hall') => 'map-pin',
      str_contains($name, 'birthday') => 'cake',

      // Security & Safety
      str_contains($name, 'security') => 'shield',
      str_contains($name, 'cctv') => 'camera',
      str_contains($name, 'fire safety') => 'flame',
      str_contains($name, 'locksmith') => 'lock',

      // Professional & Creative
      str_contains($name, 'translation') => 'globe',
      str_contains($name, 'voice-over') => 'mic',
      str_contains($name, 'printing') => 'printer',
      str_contains($name, 'stationery') => 'clipboard',

      // Pets
      str_contains($name, 'pet') => 'paw',
      str_contains($name, 'vet') => 'activity',

      // Food & Home
      str_contains($name, 'chef') || str_contains($name, 'bakery') => 'utensils',
      str_contains($name, 'meal delivery') => 'coffee',

      // Travel & Booking
      str_contains($name, 'ticket') || str_contains($name, 'tour') || str_contains($name, 'travel') => 'map',
      str_contains($name, 'visa') => 'passport',
      str_contains($name, 'hotel') => 'home',

      // Retail & Utilities
      str_contains($name, 'shop') || str_contains($name, 'store') => 'shopping-bag',
      str_contains($name, 'clothing') => 'shopping-bag',
      str_contains($name, 'general store') => 'box',
      str_contains($name, 'internet') => 'wifi',
      str_contains($name, 'water supply') => 'droplet',
      str_contains($name, 'gas') => 'flame',
      str_contains($name, 'ironing') => 'sun',

      default => 'tool',
    };
  }

  private function getColor($name)
  {
    $name = strtolower($name);

    return match (true) {
      // Home & Repair
      str_contains($name, 'plumb') => 'blue',
      str_contains($name, 'ac') => 'cyan',
      str_contains($name, 'carpenter') => 'amber',
      str_contains($name, 'paint') => 'purple',
      str_contains($name, 'clean') => 'green',
      str_contains($name, 'repair') => 'orange',
      str_contains($name, 'design') => 'fuchsia',
      str_contains($name, 'construction') => 'gray',
      str_contains($name, 'garden') => 'emerald',
      str_contains($name, 'electric') => 'yellow',

      // Beauty
      str_contains($name, 'salon') || str_contains($name, 'hair') => 'pink',
      str_contains($name, 'makeup') => 'rose',
      str_contains($name, 'spa') || str_contains($name, 'massage') => 'teal',
      str_contains($name, 'mehndi') => 'orange',
      str_contains($name, 'barber') => 'slate',

      // Medical
      str_contains($name, 'doctor') || str_contains($name, 'clinic') => 'red',
      str_contains($name, 'dentist') => 'sky',
      str_contains($name, 'eye') => 'indigo',
      str_contains($name, 'lab') => 'pink',
      str_contains($name, 'nursing') => 'blue',
      str_contains($name, 'ambulance') => 'red',
      str_contains($name, 'pharmacy') => 'green',
      str_contains($name, 'mental') => 'purple',
      str_contains($name, 'emergency') || str_contains($name, 'rescue') => 'red',

      // Education
      str_contains($name, 'tutor') || str_contains($name, 'course') => 'indigo',
      str_contains($name, 'coaching') => 'violet',
      str_contains($name, 'language') => 'cyan',
      str_contains($name, 'quran') => 'emerald',
      str_contains($name, 'skill') => 'amber',

      // IT & Digital
      str_contains($name, 'graphic') || str_contains($name, 'logo') => 'purple',
      str_contains($name, 'web') || str_contains($name, 'app') => 'blue',
      str_contains($name, 'seo') || str_contains($name, 'marketing') => 'lime',
      str_contains($name, 'video') => 'red',
      str_contains($name, 'data') => 'slate',
      str_contains($name, 'programming') => 'gray',

      // Repair (electronics)
      str_contains($name, 'mobile') || str_contains($name, 'laptop') || str_contains($name, 'computer') => 'gray',
      str_contains($name, 'tv') => 'zinc',
      str_contains($name, 'fridge') => 'cyan',
      str_contains($name, 'washing machine') => 'blue',
      str_contains($name, 'generator') => 'yellow',
      str_contains($name, 'auto') => 'orange',

      // Finance & Legal
      str_contains($name, 'account') || str_contains($name, 'tax') => 'green',
      str_contains($name, 'legal') || str_contains($name, 'lawyer') => 'slate',
      str_contains($name, 'bank') || str_contains($name, 'loan') || str_contains($name, 'insurance') => 'teal',
      str_contains($name, 'investment') => 'emerald',

      // Transport
      str_contains($name, 'delivery') || str_contains($name, 'courier') => 'orange',
      str_contains($name, 'movers') => 'amber',
      str_contains($name, 'rental') => 'blue',
      str_contains($name, 'ride') => 'green',
      str_contains($name, 'logistics') => 'slate',
      str_contains($name, 'bus') => 'sky',
      str_contains($name, 'fuel') => 'yellow',

      // Events
      str_contains($name, 'catering') => 'rose',
      str_contains($name, 'wedding') => 'pink',
      str_contains($name, 'photo') => 'purple',
      str_contains($name, 'decoration') => 'fuchsia',
      str_contains($name, 'dj') => 'indigo',
      str_contains($name, 'event') => 'violet',
      str_contains($name, 'birthday') => 'yellow',

      // Security
      str_contains($name, 'security') => 'gray',
      str_contains($name, 'cctv') => 'slate',
      str_contains($name, 'fire') => 'red',
      str_contains($name, 'locksmith') => 'amber',

      // Pets
      str_contains($name, 'pet') => 'amber',
      str_contains($name, 'vet') => 'green',

      // Food
      str_contains($name, 'chef') || str_contains($name, 'bakery') => 'orange',
      str_contains($name, 'meal') => 'lime',

      // Travel
      str_contains($name, 'travel') || str_contains($name, 'tour') => 'sky',
      str_contains($name, 'visa') => 'indigo',
      str_contains($name, 'hotel') => 'blue',

      // Retail & Utilities
      str_contains($name, 'shop') || str_contains($name, 'store') => 'slate',
      str_contains($name, 'internet') => 'cyan',
      str_contains($name, 'water') => 'blue',
      str_contains($name, 'gas') => 'orange',
      str_contains($name, 'ironing') => 'gray',

      default => 'slate',
    };
  }

  public function showRechargeForm()
  {
    return view('user.recharge');
  }

  // Process recharge (simulate payment)
  public function rechargeProcess(Request $request)
  {
    return redirect()->route('user.dashboard')->with('success', 'Balance recharged successfully!');

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

    return redirect()->route('user.dashboard')->with('success', 'Balance recharged successfully!');
  }

  public function explore()
  {
    $services = Service::where('is_active', 1)->orderBy('name')->get();

    return view('user.explore', compact('services'));
  }

  public function search()
  {
    // Show search form with popular keywords
    $popularSearches = ['Plumber near me', 'AC repair', 'Electrician 24/7', 'Carpenter for shelf'];
    return view('user.search', compact('popularSearches'));
  }

  public function search_results()
  {
    $service = Service::findOrFail(5);

    $experts = ExpertDetail::where('service_id', 5)
      ->with(['user', 'service'])
      ->get();

    return view('user.search-results', compact('service', 'experts'));
  }

  public function search_service($slug)
  {
    $service = Service::where('slug', $slug)->firstOrFail();

    $experts = ExpertDetail::where('service_id', $service->id)
      ->with(['user', 'service'])
      ->get();

    return view('user.search-results', compact('service', 'experts'));
  }


  public function services()
  {
    $user = Auth::user();
    $query = ExpertDetail::where('profile_status', 1)
      ->whereHas('user', function ($q) {
        $q->where('type', 2)->where('status', 1);
      })
      ->with(['user.city', 'service', 'rates']);

    // Optional: sort by same city first for logged-in user
    if ($user && $user->city_id) {
      // We'll use a raw order by to put same city on top
      $query->orderByRaw("(SELECT city_id FROM users WHERE users.id = expert_details.user_id) = ? DESC", [$user->city_id]);
    }
    $experts = $query->orderBy('created_at', 'desc')->paginate(12); // 12 per page

    // Transform each expert (same as dashboard mapping)
    $experts->getCollection()->transform(function ($expert) use ($user) {
      $userModel = $expert->user;
      $service = $expert->service;
      $displayName = $expert->full_name ?? $userModel->name ?? $userModel->username ?? 'Professional';
      $price = $expert->rates->isNotEmpty() ? round($expert->rates->avg('rate')) : 0;
      $rating = 4.5; // placeholder
      $cityName = $userModel->city ? $userModel->city->name : 'Unknown City';
      $selfieImage = $expert->selfie_image ? asset($expert->selfie_image) : null;
      $avatarInitial = strtoupper(substr($displayName, 0, 1));
      $avatarColor = $this->getAvatarColor($displayName);

      return (object)[
        'id'           => $expert->id,
        'name'         => $displayName,
        'profession'   => $service ? $service->name : 'Service Professional',
        'rating'       => $rating,
        'distance'     => $cityName,
        'price'        => $price,
        'selfie_image' => $selfieImage,
        'avatar'       => $avatarInitial,
        'avatar_color' => $avatarColor,
      ];
    });

    return view('user.services', compact('experts'));
  }

  public function expertDetail($id)
  {
    $expert = ExpertDetail::where('profile_status', 1)
      ->whereHas('user', function ($q) {
        $q->where('type', 2)->where('status', 1);
      })
      ->with(['user.city', 'service', 'rates'])
      ->findOrFail($id);

    $userModel = $expert->user;
    $service = $expert->service;
    $displayName = $expert->full_name ?? $userModel->name ?? $userModel->username ?? 'Professional';

    // Starting price = lowest rate from menu
    $price = $expert->rates->isNotEmpty() ? $expert->rates->min('rate') : 0;

    $cityName = $userModel->city ? $userModel->city->name : 'Unknown City';
    $selfieImage = $expert->selfie_image ? asset($expert->selfie_image) : null;

    $rates = $expert->rates;

    // No rating table, so set to 0 (or remove from view)
    $rating = 0;

    return view('user.expert_detail', compact('expert', 'displayName', 'price', 'rating', 'cityName', 'selfieImage', 'rates', 'service'));
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
