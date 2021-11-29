<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;

class apiController
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
        $allClient = Client::all();
        foreach ($allClient as $key) {
            if ($request->header('x-api-key')!=null && $key->apiKey == $request->header('x-api-key') && $key->status == 'Active') {
                return $next($request);
            }
        }
    }
}
