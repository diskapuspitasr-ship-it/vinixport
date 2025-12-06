<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserCertificateController extends Controller
{
    public function update(Request $request, $id)
    {
        // 1. Cari Certificate & Pastikan milik user
        $certificate = Certificate::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // 2. Validasi
        $request->validate([
            'title'  => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'date'   => 'required|date',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // 3. Update Data Text
        $certificate->certificate_title = $request->title;
        $certificate->issuer_organization = $request->issuer;
        $certificate->date_issued = $request->date;

        // 4. Handle Image Upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($certificate->image_path) {
                $oldPath = str_replace('/storage/', '', $certificate->image_path);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Upload gambar baru
            $path = $request->file('image')->store('certificates', 'public');
            $certificate->image_path = '/storage/' . $path;
        }

        $certificate->save();

        return back()->with('success', 'Sertifikat berhasil diperbarui!');
    }

    /**
     * Delete Certificate
     */
    public function destroy($id)
    {
        // 1. Cari Certificate & Pastikan milik user
        $certificate = Certificate::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // 2. Hapus Gambar
        if ($certificate->image_path) {
            $oldPath = str_replace('/storage/', '', $certificate->image_path);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // 3. Hapus Data
        $certificate->delete();

        return back()->with('success', 'Sertifikat berhasil dihapus!');
    }
}