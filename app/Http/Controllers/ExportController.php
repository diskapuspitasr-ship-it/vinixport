<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportPdf(string $userId)
    {
        $user = User::with(['skill', 'projects', 'certificates', 'assessmentSubmissions.assessment'])
                    ->find($userId);

        // --- 1. HITUNG DATA ASSESSMENT (Copy logic dari index) ---
        // Kita butuh data ini untuk ditampilkan sebagai Progress Bar di PDF
        $assessmentDetails = [];
        $typeMapping = [
            'soft_skill' => 'Soft Skills',
            'digital_skill' => 'Digital Skills',
            'workplace_readiness' => 'Workplace Readiness',
        ];

        if ($user->assessmentSubmissions && $user->assessmentSubmissions->count() > 0) {
            foreach ($typeMapping as $dbType => $label) {
                $submissions = $user->assessmentSubmissions->filter(function ($sub) use ($dbType) {
                    return $sub->assessment && $sub->assessment->type === $dbType;
                });

                if ($submissions->count() > 0) {
                    $average = $submissions->avg('value');
                    $percentage = round(($average / 5) * 100);

                    $assessmentDetails[] = (object) [
                        'category' => $label,
                        'score' => $percentage,
                    ];
                }
            }
        }

        // --- 2. SIAPKAN TECHNICAL SKILLS ---
        $technicalSkills = [];
        $rawSkills = $user->skill ? $user->skill->skills : [];
        if (!empty($rawSkills)) {
            foreach ($rawSkills as $skillItem) {
                $skill = (array) $skillItem;
                $technicalSkills[] = (object) [
                    'name' => $skill['skill_name'] ?? 'Unknown',
                    'level' => $skill['level'] ?? 'Beginner'
                ];
            }
        }

        // --- 3. GENERATE PDF ---
        // Load view khusus untuk PDF
        $pdf = Pdf::loadView('pages.portofolio.pdf', [
            'user' => $user,
            'assessmentDetails' => $assessmentDetails,
            'technicalSkills' => $technicalSkills
        ]);

        // Setup kertas A4 Portrait
        $pdf->setPaper('a4', 'portrait');

        // Download file dengan nama dinamis
        return $pdf->download('Portfolio-' . str_replace(' ', '-', $user->name) . '.pdf');
    }
}
