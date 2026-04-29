<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // --- VIEW METHODS ---

    public function showLogin() { 
        return view('auth.login'); 
    }

    public function showRegister() { 
        return view('auth.register'); 
    }

    // --- LOGIC METHODS ---

    public function login(Request $request)
    {
        // 1. Validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Attempt Login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // --- ADMIN SECURITY ALERT (Optional) ---
            if($user->role == 'admin') {
                Mail::raw("Security Alert: Your Admin account was accessed on " . now()->toDayDateTimeString(), function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Admin Login Security Alert');
                });
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/');
        }

        // 3. Fail Response
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted', 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', 
        ]);

        Auth::login($user);
        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}