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

        // 2. Pending or Approved -> Allowed to proceed to Dashboard Sementara
        // (Access limits for pending will be handled later, for now just let them through)
        
        return $next($request);
    }
}
