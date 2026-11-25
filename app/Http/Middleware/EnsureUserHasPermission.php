<?php

namespace App\Http\Middleware;

use App\Enums\Permission;
use App\Support\Portal;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();

        if ($user === null || ! $user->is_active) {
            abort(403);
        }

        foreach ($permissions as $permission) {
            if ($user->hasPermission(Permission::from($permission))) {
                return $next($request);
            }
        }

        return redirect()->route(Portal::homeRoute($user));
    }
}
