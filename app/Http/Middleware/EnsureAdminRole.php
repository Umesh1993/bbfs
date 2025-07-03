<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next)
    {
       if (!Auth::guard('admin')->check()) {
            dd('Not authenticated as admin'); // Debug this
            return redirect()->route('admin.login')->withErrors(['error' => 'Please login to continue.']);
        }

        return $next($request);
    }
}
