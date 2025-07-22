<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || !str_ends_with(auth()->user()->email, '@emargence.fr')) {
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
