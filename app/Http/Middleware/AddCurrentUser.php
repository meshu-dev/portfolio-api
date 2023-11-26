<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddCurrentUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('sanctum')->user();
        $request->request->add(['user' => $user]);

        return $next($request);
    }
}
