<?php

namespace App\Http\Middleware;

use App\Jobs\ApiRequestResponseLoggerJob;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiRequestResponseLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $data = [
            'user_id'       => $request->user()->id??null,
            'service'       => $request->path(),
            'request'       => json_encode($request->all()),
            'response_code' => $response->getStatusCode(),  
            'response_body' => $request->isJson()? $response->getContent(): null,
            'ip_address'    => $request->ip(),
        ];

        ApiRequestResponseLoggerJob::dispatch($data);
        return $response;
    }
}
