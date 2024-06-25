<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Token;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Session;


class decoder extends Controller
{
    public function decode($param){
        $api_token = $param;

        // Convert the string token to a Tymon\JWTAuth\Token instance
        $token = new Token($api_token);

        // Decode the token
        try {
            $decode = JWT::decode($token->get(), new Key(env('JWT_SECRET_KEY_BE'), 'HS256'));

            // Assuming $decode is an object or array
            $payload = (object) $decode;

            // Token JWT from API Node.js
            $role_id = $decode->role_id;
            $prodi_id = $decode->program_studi_id;        

            // Store JWT token in session
            Session::put('role_id', $role_id);
            Session::put('prodi_id', $prodi_id);

            return $payload;
        } catch (\Exception $e) {
            Log::error('JWT Error: ' . $e->getMessage());
            return null; // or handle the error as needed
        }
    }
}
