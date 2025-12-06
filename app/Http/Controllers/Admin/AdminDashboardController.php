<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentSubmission;
use App\Models\Certificate;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index() {
        // 1. Hitung Total Data
        $stats = [
            'users'        => User::where('role', '!=', 'admin')->count(),
            'projects'     => Project::count(),
            'certificates' => Certificate::count(),
            'questions'    => Assessment::count(),
            'submissions'  => AssessmentSubmission::distinct('user_id')->count('user_id'),
        ];

        // 2. Data Tambahan untuk Grafik (Opsional: User baru bulan ini)
        // Contoh sederhana: Kita kirim data statistik di atas ke grafik
        $chartData = [
            'labels' => ['Users', 'Projects', 'Certificates', 'Submissions'],
            'data'   => [
                $stats['users'],
                $stats['projects'],
                $stats['certificates'],
                $stats['submissions']
            ]
        ];

        return view('pages.admin.dashboard.index', compact('stats', 'chartData'));
    }
}