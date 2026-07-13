<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $login = trim((string) $request->validated('login'));
        $credentials = [
            filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'id' => filter_var($login, FILTER_VALIDATE_EMAIL)
                ? Str::lower($login)
                : $login,
            'password' => $request->validated('password'),
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => 'ID, email, atau password yang Anda masukkan salah.',
            ]);
        }

        if (! Auth::user()?->isAdmin()) {
            Auth::logout();

            throw ValidationException::withMessages([
                'login' => 'Akun ini tidak memiliki akses administrator.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Anda berhasil login.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'))->with('success', 'Anda telah berhasil logout.');
    }
}
