<?php

namespace App\Http\Middleware;

use Closure;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class TokenShinobiAbility extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles, $permissions = '', $validateAll = false)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return response()->json(['error' => 'token_not_provided'], 400);
        }

        try {
            $user = $this->auth->parseToken()->authenticate($token);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        /*if (!$request->user()->ability(explode('|', $roles), explode('|', $permissions), array('validate_all' => $validateAll))) {
            return response()->json('tymon.jwt.invalid', 'token_invalid', 401, 'Unauthorized');
        }*/

        if(!$user->is('donor')) {
            return response()->json(['error' => 'Not allowed to access this resource'], 401);
        }

        return $next($request);
    }
}
