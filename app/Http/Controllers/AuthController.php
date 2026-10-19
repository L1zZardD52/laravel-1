<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Показываем форму регистрации.
    public function showRegister()
    {
        return view('auth.register');
    }

    // Регистрируем нового пользователя.
    public function register(Request $request)
    {
        // Проверяем введённые данные.
        $data = $request->validate([
            'login' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'alpha_dash',
                'unique:users,login',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
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

        // Находим роль обычного читателя.
        $readerRole = Role::where('name', 'reader')->firstOrFail();

        // Создаём пользователя с ролью читателя.
        $user = User::create([
            'login' => $data['login'],
            'password' => $data['password'],
            'role_id' => $readerRole->id,
        ]);

        // Авторизуем пользователя после регистрации.
        Auth::login($user);

        // Обновляем идентификатор сессии для безопасности.
        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('status', 'Регистрация прошла успешно.');
    }

    // Показываем форму входа.
    public function showLogin()
    {
        return view('auth.login');
    }

    // Выполняем вход.
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

        return back()
            ->withErrors(['login' => 'Неверный логин или пароль.'])
            ->onlyInput('login');
    }

    // Завершаем сеанс пользователя.
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
// при регистрации роль теперь назначается сервером, а не берётся из формы пользователя.