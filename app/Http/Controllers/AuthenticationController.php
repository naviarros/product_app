<?php

namespace App\Http\Controllers;

// ------- Laravel Packages ------- //
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

// ------- Laravel Models -------- //
use App\Models\User;


class AuthenticationController extends Controller
{
    //

    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $email = $validatedData['email'];
            $password = $validatedData['password'];

            $user = User::where('email', $email)->first();

            if ($user && Hash::check($password, $user->password)) {
                $token = $user->createToken('api-token')->plainTextToken;
                return response()->json([
                    'success' => true,
                    'bearer_token' => $token,
                    'message' => "You've been successfully logged in",
                    'server_response' => 'ok'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid credentials",
                    'server_response' => 'error'
                ], 401);
            }
        } catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e,
                'line_error' => $e->getLine(),
                'server_response' => 'error'
            ]);
        }
    }
}
