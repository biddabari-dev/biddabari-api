<?php

namespace App\Http\Middleware;

use App\helper\ViewHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SingleDeviceCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->device_token !== session()->getId()) {
            // Log the user out if the device token does not match
            Auth::guard('web')->logout();
            Auth::guard('sanctum')->user()->tokens()->delete();
            ViewHelper::returEexceptionError('You have been logged out from another device.');
//            return redirect('/login')->with('error', 'You have been logged out from another device.');
        }

        return $next($request);
    }
}
