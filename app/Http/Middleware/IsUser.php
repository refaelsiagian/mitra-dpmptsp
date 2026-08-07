<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if (auth()->user()->role === 'user') {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
