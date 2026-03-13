<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Check if user account is approved
            if ($user->status === 'pending') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is pending admin approval. Please wait for activation.',
                ]);
            }

            if ($user->status === 'suspended') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been suspended. Please contact support.',
                ]);
            }

            return redirect()->intended($this->getDashboardRoute($user));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    private function getDashboardRoute($user)
    {
        switch ($user->role) {
            case 'admin':
                return route('admin.dashboard');
            case 'teacher':
                return route('teacher.dashboard');
            default:
                return route('student.dashboard');
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student'],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => 'pending', // Requires admin approval
        ]);

        return redirect()->route('register')->with('success', 'Registration successful. Please wait for admin approval.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
