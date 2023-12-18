<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Esto es un middleware de ejemplo');

        if (auth()->user()->role !== 'admin') {
            return response()->json(
                [
                    "success" => false,
                    "message" => 'Unauthorized'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }
}
