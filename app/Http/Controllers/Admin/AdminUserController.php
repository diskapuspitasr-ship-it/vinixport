<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        // Ambil data user (paginasi 10 per halaman), urutkan terbaru
        $users = User::where('role', '!=', 'admin')->latest()->paginate(10);
        return view('pages.admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            // 'role' => 'required|in:user,admin,mentor',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'slug' => Str::slug($request->name) . '-' . rand(100, 999), // Slug unik sederhana
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            // 'role' => 'required|in:user,admin,mentor',
            'password' => 'nullable|min:8', // Password opsional saat edit
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            // 'role' => $request->role,
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data user diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }

    public function show($id)
    {
        // Ambil user beserta relasinya untuk halaman detail
        $user = User::with(['projects', 'certificates', 'skill'])->findOrFail($id);
        return view('pages.admin.users.show', compact('user'));
    }
}