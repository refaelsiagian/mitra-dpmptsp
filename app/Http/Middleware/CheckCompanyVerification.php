<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCompanyVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Let admins bypass this check
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        $company = $user->company;

        // 1. Unsubmit (null status) or Rejected -> Stuck on verify
        if (!$company || $company->status === 'rejected') {
            return redirect()->route('verify');
        }

        // 2. Pending -> Stuck on review
        if ($company->status === 'pending') {
            return redirect()->route('review');
        }

        // 3. Verified -> Allowed to proceed
        return $next($request);
    }
}
