<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Create new user
    public function register(Request $request){
        $request->validate([
            'email' => ['required', 'email', Rule::unique('user', 'email')],
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);

        return redirect('/')->with('message', 'User created.');
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'logged out');
    }

    public function login(Request $request){
        $formFields = $request->validate([
            'email' => ['required','email'],
            'password' => ['required', 'min:8']
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/')->with('message', 'logged in');
        }
        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}