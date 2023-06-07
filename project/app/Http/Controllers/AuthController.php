<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        // Log in the user
        Auth::login($user);
        
        $token = JWTAuth::fromUser($user);

        // Set the token as a session variable
        session(['jwt_token' => $token]);

        // Redirect the user to the desired page
        return redirect('/');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);

        // Set the token as a session variable
        session(['jwt_token' => $token]);

        // Redirect the user to the desired page
        return redirect('/');
    }

    public function logout()
    {
        // Clear the session token
        session()->forget('jwt_token');

        // Redirect the user to the desired page
        return redirect('/');
    }

    public function getAuthenticatedUser()
    {
        // Retrieve the user from the session token
        $token = session('jwt_token');
        $user = JWTAuth::toUser($token);

        return response()->json(compact('user'));
    }
}
