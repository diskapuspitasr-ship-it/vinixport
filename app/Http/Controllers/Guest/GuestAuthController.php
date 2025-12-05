<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class GuestAuthController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function login()
    {
        return view('pages.auth.login.index'); // Pastikan Anda membuat file: resources/views/auth/login.blade.php
    }

    /**
     * Memproses data login.
     */
    public function authenticate(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // --- PERBAIKAN DISINI ---
            // Arahkan ke NAMA ROUTE dashboard user, bukan nama file view
            return redirect()->intended(route('user.portfolio.index'));
        }

        // 3. Jika Gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan form register.
     */
    public function register()
    {
        return view('pages.auth.register.index'); // Pastikan Anda membuat file: resources/views/auth/register.blade.php
    }

    /**
     * Memproses pendaftaran user baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        // HAPUS validasi 'role' karena inputnya tidak ada di form blade
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Generate Slug Unik dari Name
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;

        // Cek apakah slug sudah ada di database (Looping collision check)
        while (User::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // 3. Buat User Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role di-hardcode jadi 'user'
            'slug' => $slug,  // Masukkan slug unik hasil generate
        ]);

        // 4. Auto Login
        Auth::login($user);

        // 5. Redirect
        return redirect()->route('user.portfolio.index');
    }

    /**
     * Proses Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}