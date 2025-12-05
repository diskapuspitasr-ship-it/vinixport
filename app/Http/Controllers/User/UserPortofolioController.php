<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPortofolioController extends Controller
{
    public function index()
    {
        // 1. Eager Load Relasi
        $user = User::with(['skill', 'projects', 'certificates', 'assessmentSubmissions.assessment'])->find(Auth::id());

        // ==========================================
        // BAGIAN 1: DATA UNTUK RADAR CHART (AMBIL DARI TABLE ASSESSMENTS)
        // ==========================================
        $chartData = [
            'Soft Skills' => 0,
            'Workplace Readiness' => 0,
            'Digital Skills' => 0,
        ];

        $typeMapping = [
            'soft_skill' => 'Soft Skills',
            'digital_skill' => 'Digital Skills',
            'workplace_readiness' => 'Workplace Readiness',
        ];

        // Pastikan user memiliki assessmentSubmissions yang di-load
        if ($user->assessmentSubmissions && $user->assessmentSubmissions->count() > 0) {
            foreach ($typeMapping as $dbType => $label) {
                // Filter submissions berdasarkan tipe assessment
                $submissions = $user->assessmentSubmissions->filter(function ($sub) use ($dbType) {
                    return $sub->assessment && $sub->assessment->type === $dbType;
                });

                if ($submissions->count() > 0) {
                    // Hitung rata-rata nilai (misal 1-5)
                    $average = $submissions->avg('value');

                    // Konversi ke persen (0-100)
                    $percentage = ($average / 5) * 100;

                    $chartData[$label] = round($percentage);
                }
            }
        }
        // ==========================================
        // BAGIAN 2: DATA UNTUK LIST SKILL (AMBIL DARI JSON SKILLS)
        // ==========================================
        $rawSkills = $user->skill ? $user->skill->skills : [];
        $analysisResults = [];

        if (!empty($rawSkills)) {
            foreach ($rawSkills as $skillItem) {
                // Konversi ke array
                $skill = (array) $skillItem;
                $name = $skill['skill_name'] ?? 'Unknown Skill';
                $levelData = $skill['level'] ?? 0;

                // Konversi Level String (Expert) ke Angka (90)
                if (is_string($levelData)) {
                    $score = match ($levelData) {
                        'Expert' => 90,
                        'Advanced' => 80,
                        'Intermediate' => 60,
                        'Beginner' => 40,
                        default => 20,
                    };
                } else {
                    $score = (int) $levelData;
                }

                // Tentukan Warna & Feedback berdasarkan Skor
                $feedback = '';
                $colorClass = 'text-slate-400';
                $scoreClass = 'bg-slate-500/10 text-slate-400 border-slate-500/20';

                if ($score >= 80) {
                    $colorClass = 'text-emerald-400';
                    $scoreClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                    $feedback = 'Sangat mahir (Expert/Advanced).';
                } elseif ($score >= 60) {
                    $colorClass = 'text-amber-400';
                    $scoreClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
                    $feedback = 'Kompeten (Intermediate).';
                } else {
                    $colorClass = 'text-red-400';
                    $scoreClass = 'bg-red-500/10 text-red-400 border-red-500/20';
                    $feedback = 'Pemula (Beginner).';
                }

                // --- PERBAIKAN UTAMA: FILTER DIHAPUS ---
                // Kita masukkan SEMUA skill yang ada di JSON ke list
                $analysisResults[] = (object) [
                    'category' => $name, // "Laravel", "React", dll
                    'score' => $score,
                    'displayLevel' => is_string($levelData) ? $levelData : $score . '%', // Tampilkan teks asli jika ada
                    'feedback' => $feedback,
                    'colorClass' => $colorClass,
                    'scoreClass' => $scoreClass,
                ];
            }
        }

        $latestReviewRequest = null;

        return view('pages.user.portofolio.index', [
            'user' => $user,
            'chartData' => $chartData,
            'analysisResults' => $analysisResults,
            'latestReviewRequest' => $latestReviewRequest,
        ]);
    }
}