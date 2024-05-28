<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleWare
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() && auth()->user()->role === 'super_admin') {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized. Not a super admin.'], 403);
    }
}
