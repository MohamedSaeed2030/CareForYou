<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->api_password !== env('API_PASSWORD', 'mLyN5MVqCGN211auX2iw6jPIurV')) {
            return response()->json(['message' => 'Unauthenticated']);
        }

        return $next($request);
    }
}
