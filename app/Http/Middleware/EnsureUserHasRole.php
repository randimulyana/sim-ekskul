<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Tangani request yang masuk.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->guest(route('login'));
        }

        if (! in_array($request->user()->role, $roles, true)) {
            abort(403, 'Akses tidak diizinkan. Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}
