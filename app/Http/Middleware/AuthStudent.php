<?php

namespace App\Http\Middleware;

use Closure;

class AuthStudent
{
    // list of expected headers
    private $expectedHeaders = [
        "X_NITT_APP_USERNAME",
        "X_NITT_APP_NAME",
        "X_NITT_APP_IS_ADMIN",
    ];

    /**
     * to check if the expected headers are set
     * @param  Request $request
     * @return bool                 true, if all the expected header are set. false, otherwise
     */
    private function expectedHeadersSet($request) {
        foreach ($this->expectedHeaders as $header) {
            if (!$request->hasHeader($header)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return error if all expected header not set
        if (!$this->expectedHeadersSet($request)) {
            return response()->json([
                "message"   => "Expected headers not set",
            ], 403);
        }

        $response = $next($request);

        return $response->cookie('isLoggedIn', 1, 60, null, null, false, false)
                        ->cookie('username', $request->header('X_NITT_APP_USERNAME'), 60, null, null, false, false);
    }
}
