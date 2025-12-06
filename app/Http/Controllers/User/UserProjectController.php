<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProjectController extends Controller
{
    public function update(Request $request, $id)
    {
        // 1. Cari Project & Pastikan milik user yang sedang login (Security)
        $project = Project::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // 2. Validasi
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'link'        => 'nullable|url',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
        ]);

        // 3. Update Data Text
        $project->project_title = $request->title;
        $project->description = $request->description;
        $project->project_link = $request->link;

        // 4. Handle Image Upload (Jika ada gambar baru)
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($project->image_path) {
                // Bersihkan path '/storage/' untuk mendapatkan relative path
                $oldPath = str_replace('/storage/', '', $project->image_path);
                // Cek apakah file ada di disk public sebelum hapus
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Upload gambar baru
            $path = $request->file('image')->store('projects', 'public');
            $project->image_path = '/storage/' . $path;
        }

        $project->save();

        return back()->with('success', 'Project berhasil diperbarui!');
    }

    /**
     * Delete Project
     */
    public function destroy($id)
    {
        // 1. Cari Project & Pastikan milik user yang sedang login
        $project = Project::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // 2. Hapus Gambar dari Storage
        if ($project->image_path) {
            $oldPath = str_replace('/storage/', '', $project->image_path);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // 3. Hapus Data dari Database
        $project->delete();

        return back()->with('success', 'Project berhasil dihapus!');
    }
}