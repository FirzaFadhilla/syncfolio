<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspended
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->is_suspended) {
            $reason = auth()->user()->suspend_reason ?? 'Violating community guidelines.';
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Menampilkan pesan error + Alasannya
            return redirect('/login')->withErrors(['email' => 'Your account is suspended. Reason: ' . $reason]);
        }
        return $next($request);
    }
}
