<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserPorofileController extends Controller
{
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Validasi Input
        $request->validate([
            'name'   => 'nullable|string|max:255',
            'email'  => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'title'  => 'nullable|string|max:100', // Input 'title' masuk ke kolom 'jabatan'
            'bio'    => 'nullable|string|max:1000',
            'slug'   => 'nullable|string|max:100|alpha_dash|unique:users,slug,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('title')) {
            $user->jabatan = $request->input('title');
        }

        if ($request->has('bio')) {
            $user->bio = $request->input('bio');
        }

        if ($request->has('slug')) {
            $user->slug = $request->input('slug');
        }

        // 4. Update Avatar (Jika ada file yang diupload)
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada (dan bukan URL eksternal dummy)
            if ($user->avatar_url && !str_contains($user->avatar_url, 'ui-avatars.com')) {
                // Hapus '/storage/' di depan path agar bisa dihapus oleh Storage facade
                $oldPath = str_replace('/storage/', '', $user->avatar_url);
                Storage::disk('public')->delete($oldPath);
            }

            // Simpan file baru ke folder 'avatars' di storage public
            $path = $request->file('avatar')->store('avatars', 'public');

            // Simpan path yang bisa diakses publik ke database
            $user->avatar_url = '/storage/' . $path;
        }

        // 5. Simpan Perubahan ke Database
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}