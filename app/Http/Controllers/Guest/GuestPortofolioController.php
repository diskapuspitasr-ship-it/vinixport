<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GuestPortofolioController extends Controller
{
    public function index(string $slug)
    {
        $user = User::with(['skill', 'projects', 'certificates', 'assessmentSubmissions.assessment'])
            ->where('slug', '=', $slug)
            ->firstOrFail();

        $chartData = [
            'Soft Skills' => 0,
            'Workplace Readiness' => 0,
            'Digital Skills' => 0,
        ];

        $assessmentDetails = []; // Data untuk list di bawah chart

        $typeMapping = [
            'soft_skill' => 'Soft Skills',
            'digital_skill' => 'Digital Skills',
            'workplace_readiness' => 'Workplace Readiness',
        ];

        foreach ($typeMapping as $dbType => $label) {
            // Filter submissions per tipe
            $submissions = $user->assessmentSubmissions->filter(function ($sub) use ($dbType) {
                return $sub->assessment && $sub->assessment->type === $dbType;
            });

            if ($submissions->count() > 0) {
                $average = $submissions->avg('value'); // Nilai 1-5
                $percentage = round(($average / 5) * 100); // Konversi ke 0-100%

                // Isi Chart Data
                $chartData[$label] = $percentage;

                // Isi Assessment Details (List di bawah chart)
                $feedback = '';
                $colorClass = 'text-slate-400';
                $scoreClass = 'bg-slate-500/10 text-slate-400 border-slate-500/20';

                if ($percentage >= 80) {
                    $colorClass = 'text-emerald-400';
                    $scoreClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                    if ($label === 'Soft Skills') {
                        $feedback = 'Kemampuan komunikasi dan interpersonal sangat baik.';
                    } elseif ($label === 'Digital Skills') {
                        $feedback = 'Sangat mahir dalam ekosistem digital.';
                    } elseif ($label === 'Workplace Readiness') {
                        $feedback = 'Mentalitas profesional sangat matang.';
                    }
                } elseif ($percentage >= 60) {
                    $colorClass = 'text-amber-400';
                    $scoreClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
                    if ($label === 'Soft Skills') {
                        $feedback = 'Interaksi cukup baik, tingkatkan negosiasi.';
                    } elseif ($label === 'Digital Skills') {
                        $feedback = 'Cukup familiar dengan teknologi dasar.';
                    } elseif ($label === 'Workplace Readiness') {
                        $feedback = 'Etos kerja terbentuk, tingkatkan inisiatif.';
                    }
                } else {
                    $colorClass = 'text-red-400';
                    $scoreClass = 'bg-red-500/10 text-red-400 border-red-500/20';
                    $feedback = 'Perlu pengembangan lebih lanjut.';
                }

                $assessmentDetails[] = (object) [
                    'category' => $label,
                    'score' => $percentage,
                    'feedback' => $feedback,
                    'colorClass' => $colorClass,
                    'scoreClass' => $scoreClass,
                ];
            }
        }

        // ==========================================
        // BAGIAN 3: TECHNICAL SKILLS (GRID)
        // ==========================================
        // Ambil dari JSON 'skills' (Laravel, React, dll)
        $technicalSkills = [];
        $rawSkills = $user->skill ? $user->skill->skills : [];

        if (!empty($rawSkills)) {
            foreach ($rawSkills as $skillItem) {
                $skill = (array) $skillItem;
                $technicalSkills[] = (object) [
                    'name' => $skill['skill_name'] ?? 'Unknown',
                    'level' => $skill['level'] ?? 'Beginner',
                ];
            }
        }

        $latestReviewRequest = null;

        return view('pages.guest.portofolio.index', [
            'user' => $user,
            'chartData' => $chartData,
            'assessmentDetails' => $assessmentDetails, // List di bawah chart
            'technicalSkills' => $technicalSkills, // Grid Skill Teknis
            'latestReviewRequest' => $latestReviewRequest,
        ]);
    }
}