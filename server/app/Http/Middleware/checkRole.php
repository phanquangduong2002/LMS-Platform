<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->checkRole()) return $next($request);
        else return response()->json(['error' => 'You are not an admin or an instructor.'], 403);
    }

    private function checkRole()
    {
        return Auth::check() && (Auth::user()->roles == 'admin' || Auth::user()->roles == 'instructor');
    }
}
