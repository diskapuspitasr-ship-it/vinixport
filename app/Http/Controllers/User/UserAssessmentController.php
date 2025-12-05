<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAssessmentController extends Controller
{
    public function index()
    {
        // 1. Ambil semua pertanyaan
        $questions = Assessment::select('id', 'question', 'type')->get();

        // 2. Hitung total pertanyaan
        $totalQuestions = $questions->count();

        // 3. Hitung total jawaban user saat ini
        $userSubmissionCount = AssessmentSubmission::where('user_id', Auth::id())->count();

        // 4. Cek apakah user sudah menjawab SEMUA pertanyaan
        // Kita asumsikan assessment selesai jika jumlah jawaban >= jumlah pertanyaan
        $hasCompletedAssessment = ($totalQuestions > 0) && ($userSubmissionCount >= $totalQuestions);

        return view('pages.user.assessment.index', compact('questions', 'hasCompletedAssessment'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'answers' => 'required|array',
            'answers.*.id' => 'required|exists:assessments,id',
            'answers.*.score' => 'required|integer|min:1|max:5',
        ]);

        $userId = Auth::id();

        foreach ($data['answers'] as $answer) {
            AssessmentSubmission::updateOrCreate(
                [
                    'user_id' => $userId,
                    'assessment_id' => $answer['id'],
                ],
                [
                    'value' => $answer['score']
                ]
            );
        }

        return response()->json(['message' => 'Assessment saved successfully!']);
    }

    public function destroy()
    {
        // Hapus semua submission milik user yang sedang login
        AssessmentSubmission::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Assessment berhasil di-reset. Silakan mulai dari awal.');
    }
}
