<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Support\Portal;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user === null || ! $user->is_active) {
            abort(403);
        }

        $allowed = collect($roles)->map(fn (string $role) => UserRole::from($role));

        if (! $allowed->contains($user->role)) {
            return redirect()->route(Portal::homeRoute($user));
        }

        return $next($request);
    }
}
