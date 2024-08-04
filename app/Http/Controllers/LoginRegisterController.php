<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class LoginRegisterController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // new Middleware('guest', except: ['home', 'logout']),
            // new Middleware('auth', only: ['home', 'logout']),
        ];
    }

    public function registration(): View
    {
        return view('auth.register');
    }

    public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // After register login and redirect
        // $credentials = $request->only('email', 'password');
        // Auth::attempt($credentials);
        // $request->session()->regenerate();

        return redirect()->route('login')->withSuccess('You have successfully registered & logged in!');
    }

    public function login(): View
    {
        return view('auth.login');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|email:rfc,dns|max:255',
            'password' => 'required|string|min:8'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->type == 'admin') {
                return redirect()->route('admin.dashboard')->withSuccess('You have Successfully logged in.');
            } else if (auth()->user()->type == 'manager') {
                return redirect()->route('manager.dashboard')->withSuccess('You have Successfully logged in.');
            } else {
                return redirect()->route('user.dashboard')->withSuccess('You have Successfully logged in.');
            }
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }

    public function userDashboard()
    {
        if(Auth::check()){
            return view('auth.user');
        }

        return redirect("login")->withSuccess('Oops! You do not have access');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->withSuccess('You have logged out successfully!');
    }

    public function managerDashboard()
    {
        if(Auth::check()){
            return view('auth.manager');
        }

        return redirect("login")->withSuccess('Oops! You do not have access');
    }

    public function adminDashboard()
    {
        if(Auth::check()){
            return view('auth.admin');
        }

        return redirect("login")->withSuccess('Oops! You do not have access');
    }
}
