<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user has role and if role has the required permission
        if (!$user->role || !$user->role->permissions()->where('name', $permission)->exists()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Access denied. You do not have permission to perform this action.',
                ], 403);
            }

            abort(403, 'Access denied. You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
