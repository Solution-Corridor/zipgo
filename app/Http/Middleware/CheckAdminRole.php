<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the user has the required role (customize this logic as needed)
            if (Auth::user()->type == '0' || Auth::user()->type == '2') {
                return $next($request);
            }
        }

        // Redirect or return an error response if the user doesn't have the required role
        return redirect('/login')->with('error', 'Login Time Out or Unauthorized access');
    }
}
