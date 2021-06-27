<?php

namespace App\Http\Middleware;

use App\Models\AppKey;
use Closure;
use Illuminate\Http\Request;

class CheckAppApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(! AppKey::isApiValid($request->header('api-token'))){
            return response()->json(['Invalid api token'], 401);
        }
        
        return $next($request);
    }
}
