<?php

namespace App\Http\Middleware;

use App\Http\Requests\ImportProductsRequest;
use Closure;
use Illuminate\Http\Request;

class ValidateJsonHeaderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('Content-Type') === 'application/json') {
            return $next($request);
        }

        return validationErrors(['Content Type Must Be Json']);
    }
}
