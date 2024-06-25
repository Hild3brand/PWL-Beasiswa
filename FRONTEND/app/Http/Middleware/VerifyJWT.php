<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class VerifyJWT
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
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $client = new Client();
        try {
            $response = $client->post('http://localhost:5000/api/v1/verify-token', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);

            if ($response->getStatusCode() !== 200 || !$responseBody['valid']) {
                return response()->json(['error' => 'Token is invalid'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not verify token'], 500);
        }

        return $next($request);
    }
}