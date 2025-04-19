<?php

namespace App\Http\Middleware;

use App\Http\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token  = $request->cookie('token');
        $result = JWTToken::verifyToken($token);

        if($result == 'Unauthorized')
        {
            return redirect('/login');
        }
        else
        {
            $request->headers->set('email', $result->user_email);
            $request->headers->set('email', $result->user_id);
            return $next($request);
        }

    }
}
