<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class AuthAdmin
{
    // list of expected headers
    private $expectedHeaders = [
        "X-NITT-APP-USERNAME",
        "X-NITT-APP-NAME",
        "X-NITT-APP-IS-ADMIN",
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
     * check if the value set in admin header is of expected type
     * @param  string $adminHeader
     * @return bool                 true if the value is one of "true" or "false". false otherwise
     */
    private function validateAdminHeader($adminHeader) {
        return in_array($adminHeader, ["true", "false"]);
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

        // return if type of X_NITT_APP_IS_ADMIN is not bool
        if (! $this->validateAdminHeader($request->header('X-NITT-APP-IS-ADMIN'))) {
            return response()->json([
                "message"   => "Invalid header type",
            ], 403);
        }

        // return if user is not admin
        if ($request->header('X-NITT-APP-IS-ADMIN') != 'true') {
            return response()->json([
                "message"   => "User not admin",
            ], 401);
        }

        $response = $next($request);

        return $response->cookie('isLoggedIn', 1, 60, null, null, false, false)
                        ->cookie('username', $request->header('X-NITT-APP-USERNAME'), 60, null, null, false, false);
    }
}
