<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect('/login')
                ->with('error', 'Please login to continue.');
        }

        $user = Auth::user();

        // Define allowed types for this route/group
        $allowedTypes = [0, 1, 2];           // normal users
        // $allowedTypes = [0, 1];     // admins + normal users

        if (! in_array($user->type, $allowedTypes) || $user->status != 1) {
            // Optional: Auth::logout();
            return redirect('/login')
                ->with('error', 'Unauthorized access or account not active.');
        }

        return $next($request);
    }
}