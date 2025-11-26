<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                
                if ($user->level) {
                    $route = match($user->level->nama_level) {
                        'Administrator' => 'admin.dashboard',
                        'Waiter' => 'waiter.dashboard',
                        'Kasir' => 'kasir.dashboard',
                        'Owner' => 'owner.dashboard',
                        'Pelanggan' => 'pelanggan.dashboard',
                        default => 'dashboard'
                    };
                    
                    return redirect()->route($route);
                }
                
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
