<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if (! $user->is_active && ! $user->isAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Hesabınız pasif durumdadır.'])->onlyInput('email');
            }

            $request->session()->regenerate();

            return $user->isAdmin()
                ? redirect()->intended(route('admin.dashboard'))
                : redirect()->intended(route('home'));
        }

        return back()->withErrors(['email' => 'E-posta veya şifre hatalı.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
