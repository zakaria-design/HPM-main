<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyIsManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
       public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role !== 'manager') {
            return redirect()->back()->with('error', 'Akses ditolak: hanya manager.');
        }

        return $next($request);
    }
}
