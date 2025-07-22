<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): mixed
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Si l'utilisateur est un admin, rediriger vers le dashboard admin
                if (Auth::user()->is_admin) {
                    return redirect()->route('admin.dashboard');
                }
                // Sinon, rediriger vers le dashboard normal
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
