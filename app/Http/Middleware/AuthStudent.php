<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AuthStudent
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

        try {
            if(!User::where('username',$request->header('X-NITT-APP-USERNAME'))->exists())
                User::create($request->header('X-NITT-APP-USERNAME'));
            $response = $next($request);
            
            return $response->cookie('isLoggedIn', 1, 60, null, null, false, false)
                            ->cookie('username',  $request->header('X-NITT-APP-USERNAME'), 60, null, null, false, false);

        } catch (Exception $e) {
            return response()->json([
                "message"   => $e->getMessage(),
            ], 500);
        }

    }
}
