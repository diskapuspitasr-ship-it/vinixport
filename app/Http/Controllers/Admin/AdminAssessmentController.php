<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;

class AdminAssessmentController extends Controller
{
    public function index()
    {
        // Ambil data terbaru dengan pagination
        $assessments = Assessment::orderBy('type', 'asc')->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.admin.assessments.index', compact('assessments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:soft_skill,digital_skill,workplace_readiness',
        ]);

        Assessment::create($request->all());

        return back()->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);

        $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:soft_skill,digital_skill,workplace_readiness',
        ]);

        $assessment->update($request->all());

        return back()->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $assessment = Assessment::findOrFail($id);
        $assessment->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus!');
    }
}