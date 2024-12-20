<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SchemeHttpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Check if the request is using HTTP and not HTTPS
         if ($request->isSecure()) {
            // Redirect to HTTP if the request is secure (HTTPS)
            return redirect()->to('http://' . $request->getHost() . $request->getRequestUri());
        }

        // Proceed to the next middleware or controller
        return $next($request);
    }
}
