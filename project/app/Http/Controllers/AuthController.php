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

        // API request
        if ($request->expectsJson()) {
            $token = JWTAuth::fromUser($user);
            return response()->json(['token' => $token], 201);
        }else{
            // WEB request
            Auth::login($user);
            $token = JWTAuth::fromUser($user);
            session(['jwt_token' => $token]);
            return redirect('/');
        }
        
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            // API request
            if ($request->expectsJson()) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            // WEB request
            return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);

        // API request
        if ($request->expectsJson()) {
            $token = JWTAuth::fromUser($user);
            return response()->json(['token' => $token]);
        }else{
            // WEB request
            session(['jwt_token' => $token]);
            return redirect('/');
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();

        // API request
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logout successful']);
        }

        // WEB request
        session()->forget('jwt_token');
        return redirect('/');
    }

    public function getAuthenticatedUser(Request $request)
    {
        // Retrieve the user from the session or token
        $user = $request->expectsJson() ? JWTAuth::parseToken()->authenticate() : Auth::user();

        // API request
        if ($request->expectsJson()) {
            return response()->json(compact('user'));
        }

        // WEB request
        return view('profile', compact('user'));
    }
}
