<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckExpertRole
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Must be authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Login Time Out or Unauthorized access');
        }

        $user = Auth::user();

        // 2. Must be type 0 or 2 (expert or similar role)
        if (!in_array($user->type, [0, 2])) {
            return redirect('/login')->with('error', 'Unauthorized access');
        }

        // 3. Exclude routes where expert profile creation/update is allowed
        $excludedRoutes = ['expert_profile', 'expert_profile.update'];
        if (in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }

        // 4. Check if user has an approved expert profile
        $expertDetail = $user->expertDetail; // uses the hasOne relationship
        $isApproved = $expertDetail && $expertDetail->profile_status == 1;

        if (!$isApproved) {
            // Redirect to expert profile page to complete or verify
            return redirect()->route('expert_profile')
                ->with('warning', 'Please complete your expert profile and wait for approval.');
        }

        return $next($request);
    }
}