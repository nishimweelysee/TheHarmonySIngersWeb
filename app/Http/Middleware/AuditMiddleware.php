<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuditMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only audit successful requests
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            $this->logRequest($request, $response);
        }

        return $response;
    }

    /**
     * Log the request details.
     */
    protected function logRequest(Request $request, Response $response): void
    {
        $user = Auth::user();

        // Skip if no user is authenticated (except for login attempts)
        if (!$user && !$this->shouldLogUnauthenticated($request)) {
            return;
        }

        // Skip certain routes that don't need auditing
        if ($this->shouldSkipRoute($request)) {
            return;
        }

        $event = $this->determineEvent($request);

        if (!$event) {
            return;
        }

        AuditLog::create([
            'event' => $event,
            'auditable_type' => null,
            'auditable_id' => null,
            'user_id' => $user?->getKey(),
            'user_type' => $user ? get_class($user) : null,
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'description' => $this->generateDescription($event, $request, $user),
            'metadata' => [
                'method' => $request->method(),
                'route' => $request->route()?->getName(),
                'status_code' => $response->getStatusCode(),
                'response_time' => microtime(true) - LARAVEL_START,
            ],
        ]);
    }

    /**
     * Determine if we should log unauthenticated requests.
     */
    protected function shouldLogUnauthenticated(Request $request): bool
    {
        $loginRoutes = ['login', 'logout', 'register'];
        $routeName = $request->route()?->getName();

        return in_array($routeName, $loginRoutes);
    }

    /**
     * Determine if we should skip this route.
     */
    protected function shouldSkipRoute(Request $request): bool
    {
        $skipRoutes = [
            'audit-logs.index',
            'audit-logs.show',
            'audit-logs.search',
            'livewire.*',
            'telescope.*',
            'horizon.*',
        ];

        $routeName = $request->route()?->getName();

        if (!$routeName) {
            return false;
        }

        foreach ($skipRoutes as $skipRoute) {
            if (fnmatch($skipRoute, $routeName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine the event type based on the request.
     */
    protected function determineEvent(Request $request): ?string
    {
        $method = $request->method();
        $routeName = $request->route()?->getName();

        // Login/logout events
        if ($routeName === 'login') {
            return 'login';
        }

        if ($routeName === 'logout') {
            return 'logout';
        }

        // HTTP method based events
        return match ($method) {
            'GET' => 'viewed',
            'POST' => 'created',
            'PUT', 'PATCH' => 'updated',
            'DELETE' => 'deleted',
            default => null,
        };
    }

    /**
     * Generate a description for the audit event.
     */
    protected function generateDescription(string $event, Request $request, $user): string
    {
        $userName = $user ? $user->name : 'Anonymous';
        $routeName = $request->route()?->getName();
        $url = $request->path();

        return match ($event) {
            'login' => $user ? "{$userName} logged in" : "Anonymous login attempt",
            'logout' => "{$userName} logged out",
            'viewed' => "{$userName} viewed {$url}",
            'created' => "{$userName} created resource via {$url}",
            'updated' => "{$userName} updated resource via {$url}",
            'deleted' => "{$userName} deleted resource via {$url}",
            default => "{$userName} performed {$event} on {$url}",
        };
    }
}
