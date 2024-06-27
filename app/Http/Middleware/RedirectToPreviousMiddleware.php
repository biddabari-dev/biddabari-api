<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToPreviousMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->method() == 'GET')
        {
            session()->put('course_redirect_url', url()->current());
            return $next($request);
        }  else {
            return redirect('/')->with('error', 'Something went wrong. Please start from home page. Thanks.');
        }
    }
}
