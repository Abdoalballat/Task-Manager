<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class role_model
{
public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            Auth::guard('web')->logout();
            $request->session()->regenerateToken();
            $request->session()->invalidate();
            return redirect()->route('login')->with(['faild','Unauthorized access.']);
        }

        return $next($request);
    }
}
