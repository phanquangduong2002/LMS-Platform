<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->checkAdmin()) return $next($request);
        else return response()->json(['error' => 'You are not an admin.'], 403);
    }

    private function checkAdmin()
    {
        return Auth::check() && Auth::user()->roles == 'admin';
    }
}
