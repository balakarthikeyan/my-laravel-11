<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $log = [];
    	$log['url'] = $request->fullUrl();
    	$log['method'] = $request->method();
    	$log['ip'] = $request->ip();
    	$log['agent'] = $request->header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 0;
        
        // Log the incoming request
        info('Incoming request: ' . request()->json($log));
  
        // Continue to the next middleware or controller
        return $next($request);
    }
}
