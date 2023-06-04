<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show register form
    public function create(){
        return view('register');
    }
    // Create new user
    public function store(Request $request){
        $formFields = $request->validate([
            'register-email' => ['required', 'email', Rule::unique('users', 'email')],
            'register-password' => ['required', 'confirmed', 'min:8']
        ]);
        $formFields['register-password'] = bcrypt($formFields['register-password']);

        $user = User::create($formFields);

        auth()->login($user);

        return redirect('/')->with('message', 'User created.');
    }
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'logged out');
    }
    public function login(){
        return view('login');
    }

    public function authenticate(Request $request){
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