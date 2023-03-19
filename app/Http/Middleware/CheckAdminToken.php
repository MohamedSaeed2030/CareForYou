<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    use GeneralTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $users = null;
        try {
            $userr = JWTAuth::ParseToken()->authenticate();
        } catch(Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->returnError('E3001', 'INVALID_TOKEN');
            } elseif ($e instanceof TokenExpiredException) {
                return $this->returnError('E3001', 'EXPIRED_TOKEN');
            } else {
                return $this->returnError('E3001', 'TOKEN_NOT_FOUND');
            }
        } catch (Throwable $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->returnError('E3001', 'INVALID_TOKEN');
            } elseif ($e instanceof TokenExpiredException) {
                return $this->returnError('E3001', 'EXPIRED_TOKEN');
            } else {
                return $this->returnError('E3001', 'TOKEN_NOT_FOUND');
            }

            if (! $users) {
                return $this->returnError('E3001', 'Unauthenticate');
            }

            return $next($request);
        }
    }
}
