<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class loginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            // Send login request to API Node.js
            $response = Http::post('http://localhost:5000/api/v1/login', [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);

            $body = $response->json();

            // Check if login was successful
            if ($response->successful() && isset($body['data']['token']) && $body['message'] === "Login Success") {
                // Token JWT from API Node.js
                $api_token = $body['data']['token'];

                // Store JWT token in session
                Session::put('api_token', $api_token);

                // Redirect to dashboard view
                return redirect()->route('dashboard')->with('message', $body['message']);
            } else {
                // Handle login failure
                return back()->withErrors(['login' => $body['message']]);
            }
        } catch (\Exception $e) {
            // Handle exceptions
            Log::error('Failed to login.', ['exception' => $e->getMessage()]);
            return back()->withErrors(['login' => 'Failed to login. Please try again later.']);
        }
    }

    public function logout(Request $request)
    {
        // Clear session data including API token (if used)
        Session::forget('api_token'); // Assuming 'api_token' is used for authentication

        // Alternatively, you can use session()->flush() to clear all session data
        // session()->flush();

        // Redirect to login page or any other page after logout
        return redirect('/login');
    }
}