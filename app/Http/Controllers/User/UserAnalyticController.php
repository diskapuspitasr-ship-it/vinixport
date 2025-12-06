<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserAnalyticController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Ambil Data Counts
        $projectCount = $user->projects()->count();
        $certificateCount = $user->certificates()->count();

        // 2. Siapkan Data Chart
        $chartData = [
            'labels' => ['Projects', 'Certificates'],
            'data' => [$projectCount, $certificateCount],
            'colors' => ['#3B82F6', '#10B981'], // Blue & Emerald
            'backgrounds' => ['rgba(59, 130, 246, 0.8)', 'rgba(16, 185, 129, 0.8)']
        ];

        return view('pages.user.analytic.index', compact('projectCount', 'certificateCount', 'chartData'));
    }
}
