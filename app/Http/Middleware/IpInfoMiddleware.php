<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ipinfo\ipinfo\IPinfo;

class IpInfoMiddleware {
    public function handle(Request $request, Closure $next) {
        $client = new IPinfo(env('IPINFO_ACCESS_TOKEN'));

        $ip_address = $request->ip();
        if ($ip_address !== "127.0.0.1") {
            $details = $client->getDetails($ip_address);

            Log::debug($request->getClientIp());
            Log::debug(print_r($details, TRUE));

            $request->merge(['ipinfo' => $details]);
        }

        return $next($request);
    }
}
