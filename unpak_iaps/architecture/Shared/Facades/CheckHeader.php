<?php

namespace Architecture\Shared\Facades;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        header('Access-Control-Allow-Origin:  ' . env('APP_URL', 'localhost'));
        header('Access-Control-Allow-Methods:  GET, POST, PUT, DELETE, OPTIONS');

        return $next($request);
    }
}