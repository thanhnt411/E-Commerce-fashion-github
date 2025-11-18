<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class NormalizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('string') || $request->has('email')) {
            $string = trim($request->input('string'));
            $email = strtolower($request->input('email'));
            return redirect()->back();
        }
        return $next($request);
        Log::info('NormalizeInput middleware ran', $request->all());
    }
}
