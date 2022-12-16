<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddAuthToken
{
    public function handle(Request $request, Closure $next)
    {
        $cookieName = env('AUTH_COOKIE_NAME');

        if ($request->bearerToken() == null) {    
            if ($request->hasCookie($cookieName) === true) {
                $token = $request->cookie($cookieName);

                $request->headers->add([
                    'Authorization' => "Bearer $token"
                ]);
            }
        }
        
        return $next($request);
    }
}
