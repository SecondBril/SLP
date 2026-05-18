<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        // 1. Validasi Ketat
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Cegah karakter aneh di nama
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'], // Validasi DNS email
            'password' => ['required', 'confirmed', Password::defaults()], // Gunakan standar password Laravel
        ]);

        // 2. Hash Password (BCRYPT bawaan Laravel)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Auto Login setelah register
        Auth::login($user);

        // 4. Mencegah Session Fixation
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Proteksi timing attack ada di dalam method Auth::attempt bawaan Laravel
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // WAJIB: Regenerasi ID sesi setelah login sukses untuk mencegah pencurian sesi
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        // Jangan beritahu secara spesifik apakah email atau password yang salah (security by obscurity)
        return back()->withErrors([
            'email' => 'Kredensial yang Anda masukkan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidasi sesi dan regenerasi token CSRF secara paksa
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
