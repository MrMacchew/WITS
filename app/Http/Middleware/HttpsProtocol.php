<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol {

    public function handle($request, Closure $next)
    {

        $isEnv = in_array(env('APP_ENV'), ['prod', 'production']);
        // dd('is env: prod or production', $isEnv);
        if (!$request->secure() && $isEnv) {
                return redirect()->secure($request->getRequestUri());
        }

        return $next($request);

    }
}
