<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->level === 'petugas') {
            return $next($request);
        }
        return redirect('/')->with('error', 'Akses ditolak. Bukan petugas.');
    }
}
