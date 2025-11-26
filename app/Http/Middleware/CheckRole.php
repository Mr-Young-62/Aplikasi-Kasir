<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->level) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak memiliki role yang valid.');
        }

        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // Redirect based on user's actual role
        return $this->redirectToDashboard($user->level->nama_level);
    }

    private function redirectToDashboard($role): Response
    {
        $route = match($role) {
            'Administrator' => 'admin.dashboard',
            'Waiter' => 'waiter.dashboard',
            'Kasir' => 'kasir.dashboard',
            'Owner' => 'owner.dashboard',
            'Pelanggan' => 'pelanggan.dashboard',
            default => 'home'
        };

        return redirect()->route($route)->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}
