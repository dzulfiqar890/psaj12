<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScrambleTokenAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionKey = 'scramble_token_verified';

        // If already verified in session, let them through
        if ($request->session()->get($sessionKey)) {
            return $next($request);
        }

        // Show token gate page – token submission is handled by its own POST route
        $error = session('scramble_error');
        return response(view('docs.token-gate', compact('error')), 401);
    }
}
