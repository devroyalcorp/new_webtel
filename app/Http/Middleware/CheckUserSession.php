<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

class CheckUserSession
{
    public function handle(Request $request, Closure $next)
    {
        // Skip routes for admin and login
        if ($request->routeIs('admin.*') || $request->routeIs('login.*')) {
            return $next($request);
        }

        $session_user = Session::get('user_session_details');

        if (!isset($session_user)) {
            return response()->view('admin.login-left-content');
        }

        return $next($request);
    }
}
