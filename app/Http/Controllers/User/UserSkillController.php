<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSkillController extends Controller
{
    public function update(Request $request)
    {
        // Validasi: skills harus array
        $request->validate([
            'skills' => 'required|array',
            'skills.*.skill_name' => 'required|string|max:255',
            'skills.*.level' => 'required|string|in:Beginner,Intermediate,Advanced,Expert',
        ]);

        $user = Auth::user();

        // Update atau Create data skill untuk user ini
        Skill::updateOrCreate(
            ['user_id' => $user->id],
            ['skills' => $request->skills] // Laravel otomatis mengkonversi array ke JSON
        );

        return back()->with('success', 'Skills berhasil diperbarui!');
    }
}
