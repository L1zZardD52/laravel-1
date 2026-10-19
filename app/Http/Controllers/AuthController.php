<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'min:3', 'max:30', 'alpha_dash', 'unique:users,login'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'login.required' => 'Введите логин.',
            'login.min' => 'Логин не короче 3 символов.',
            'login.max' => 'Логин не длиннее 30 символов.',
            'login.alpha_dash' => 'Логин: только буквы, цифры, дефис и подчёркивание.',
            'login.unique' => 'Такой логин уже занят.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль не короче 6 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        $user = User::create($data);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Регистрация прошла успешно.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Введите логин.',
            'password.required' => 'Введите пароль.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['login' => 'Неверный логин или пароль.'])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
