<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Введите логин',
            'password.required' => 'Введите пароль',
        ]);

        if (Auth::attempt(['login' => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Вы успешно вошли в систему.');
        }

        return back()->withErrors([
            'login' => 'Неверный логин или пароль.',
        ])->onlyInput('login');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'min:3', 'max:50', 'unique:users,login'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ], [
            'login.required' => 'Укажите логин',
            'login.unique' => 'Пользователь с таким логином уже существует',
            'login.min' => 'Логин должен содержать минимум 3 символа',
            'password.required' => 'Укажите пароль',
            'password.min' => 'Пароль должен содержать минимум 4 символа',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $defaultRole = Role::firstOrCreate(['name' => 'user']);

        $user = User::create([
            'login' => $data['login'],
            'name' => $data['login'],
            'password' => Hash::make($data['password']),
            'role_id' => $defaultRole->id,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Регистрация прошла успешно.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Вы вышли из системы.');
    }
}
