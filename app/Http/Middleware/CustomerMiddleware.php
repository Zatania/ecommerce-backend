<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() && auth()->user()->role === 'customer') {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized. Not a customer.'], 403);
    }
}
