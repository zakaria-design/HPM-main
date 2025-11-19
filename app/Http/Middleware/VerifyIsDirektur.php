<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyIsDirektur
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role !== 'direktur') {
            return redirect()->back()->with('error', 'Akses ditolak: hanya direktur.');
        }

        return $next($request);
    }
}
