<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized - Not an admin.'], 403);
    }
}
