<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserUploadController extends Controller
{
    public function index(){
        return view('pages.user.upload.index');
    }

    public function store(Request $request)
    {
        // Validasi awal (tipe upload)
        $request->validate([
            'upload_type' => 'required|in:project,certificate',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
        ]);

        $user = Auth::user();
        $path = $request->file('image')->store('uploads', 'public');
        $imageUrl = '/storage/' . $path;

        if ($request->upload_type === 'project') {
            // Validasi Project
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'link' => 'nullable|url',
                'tags' => 'nullable|string', // Comma separated string
            ]);

            // Convert tags string "React, Laravel" -> Array ["React", "Laravel"]
            $tagsArray = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];

            Project::create([
                'user_id' => $user->id,
                'project_title' => $request->title,
                'description' => $request->description,
                'project_link' => $request->link,
                'tags' => $tagsArray, // Model akan otomatis cast ke JSON
                'image_path' => $imageUrl,
            ]);

            $message = 'Project published successfully!';

        } else {
            // Validasi Certificate
            $request->validate([
                'title' => 'required|string|max:255',
                'issuer' => 'required|string|max:255',
                'date' => 'required|date',
            ]);

            Certificate::create([
                'user_id' => $user->id,
                'certificate_title' => $request->title,
                'issuer_organization' => $request->issuer,
                'date_issued' => $request->date,
                'image_path' => $imageUrl,
            ]);

            $message = 'Certificate saved successfully!';
        }

        return redirect()->route('user.portfolio.index')->with('success', $message);
    }
}
