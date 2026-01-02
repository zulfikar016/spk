<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Tambahkan ini

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Debug: log request
        Log::info('Login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'url' => $request->fullUrl()
        ]);
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Debug: log success
            Log::info('Login successful', [
                'user_id' => Auth::id(),
                'email' => $request->email
            ]);
            
            // Redirect berdasarkan role
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->route('dashboard');
            } elseif ($user->role == 'manager') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

        // Debug: log failure
        Log::warning('Login failed', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function test()
    {
        
    }
}