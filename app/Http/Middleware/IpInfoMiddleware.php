<?php

namespace App\Http\Middleware;

use Closure;
use ipinfo\ipinfo\IPinfo;

class IpInfoMiddleware {
    public function handle($request, Closure $next) {
        $client = new IPinfo(env('IPINFO_ACCESS_TOKEN'));
        $details = $client->getDetails($request->ip());

        $request->merge(['ipinfo' => $details]);

        return $next($request);
    }
}
