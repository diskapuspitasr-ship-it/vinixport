@extends('layouts.master')

@section('title', 'Portofolio - ' . $user->name)

@section('content')
    <div class="min-h-screen bg-slate-950 text-slate-200 font-sans selection:bg-blue-500 selection:text-white pt-28 pb-12 px-4 relative overflow-hidden">

        {{-- Background Effects --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
            <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[60%] rounded-full bg-blue-600/10 blur-[100px]"></div>
            <div class="absolute bottom-[10%] right-[10%] w-[40%] h-[40%] rounded-full bg-purple-600/10 blur-[80px]"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">

            {{-- Profile Header Card --}}
            <div class="bg-slate-900/60 backdrop-blur-2xl border border-slate-800 shadow-2xl rounded-2xl overflow-hidden mb-8 relative group">

                {{-- 1. Top Gradient Line --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500 opacity-50 z-20"></div>

                {{-- 2. Banner Background --}}
                <div class="h-40 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden z-0">
                    <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] opacity-30"></div>
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-900/90"></div>
                </div>

                {{-- 3. Profile Content Wrapper --}}
                {{-- PENTING: relative z-10 agar konten naik ke atas background --}}
                <div class="px-8 pb-8 relative z-10">
                    <div class="flex flex-col md:flex-row items-start md:items-end -mt-16 gap-6">

                        {{-- A. Avatar Section (Read Only) --}}
                        <div class="relative group/avatar flex-shrink-0">
                            <div class="absolute -inset-1 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full opacity-50 blur group-hover/avatar:opacity-100 transition duration-500"></div>
                            <img class="relative w-32 h-32 rounded-full border-4 border-slate-900 bg-slate-950 object-cover shadow-xl z-20"
                                src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff' }}"
                                alt="{{ $user->name }}" />
                        </div>

                        {{-- B. Text Info Section --}}
                        <div class="flex-1 w-full pt-2 md:pt-0">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
                                <div class="w-full">

                                    {{-- Nama User --}}
                                    <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight mb-1 relative z-10">
                                        {{ $user->name }}
                                    </h1>

                                    {{-- Email --}}
                                    <p class="text-slate-400 text-sm mb-1 flex items-center gap-2 relative z-10">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        {{ $user->email }}
                                    </p>

                                    {{-- Jabatan / Title --}}
                                    <p class="text-lg text-blue-400 font-medium relative z-10">
                                        {{ $user->jabatan ?? 'Fullstack Developer' }}
                                    </p>
                                </div>

                                {{-- C. Action Buttons --}}
                                <div class="flex gap-3 relative z-10">
                                    {{-- Tombol Download CV --}}
                                    <a href="#"
                                        class="flex text-nowrap items-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 hover:border-slate-600 text-white rounded-xl transition-all text-sm font-bold shadow-lg hover:shadow-blue-900/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download CV
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Grid Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Sidebar --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- About Me (Read Only) --}}
                    <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white">About Me</h3>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm leading-relaxed whitespace-pre-line">
                                {{ $user->bio ?? 'No bio yet.' }}
                            </p>
                        </div>
                    </div>

                    {{-- Share Buttons --}}
                    <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Share Portfolio</h3>
                        <div class="grid grid-cols-3 gap-3">
                            <button onclick="window.open('https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}', '_blank')" class="group flex items-center justify-center py-3 bg-[#0077b5]/10 hover:bg-[#0077b5] border border-[#0077b5]/20 hover:border-[#0077b5] rounded-xl transition-all duration-300">
                                <i class="fa-brands fa-linkedin text-xl text-[#0077b5] group-hover:text-white"></i>
                            </button>
                            <button onclick="window.open('https://twitter.com/intent/tweet?text=Check this portfolio&url={{ urlencode(request()->url()) }}', '_blank')" class="group flex items-center justify-center py-3 bg-white/5 hover:bg-white border border-white/10 hover:border-white rounded-xl transition-all duration-300">
                                <i class="fa-brands fa-x-twitter text-xl text-white group-hover:text-black"></i>
                            </button>
                            <button onclick="window.open('https://wa.me/?text={{ urlencode('Check this out: ' . request()->url()) }}', '_blank')" class="group flex items-center justify-center py-3 bg-[#25D366]/10 hover:bg-[#25D366] border border-[#25D366]/20 hover:border-[#25D366] rounded-xl transition-all duration-300">
                                <i class="fa-brands fa-whatsapp text-xl text-[#25D366] group-hover:text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Right Content --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Skills Analysis Section --}}
                    <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="p-2 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-white">Assessment Report</h2>
                        </div>

                        {{-- Radar Chart Container --}}
                        {{-- <div class="mb-10 flex justify-center relative">
                            <div class="w-full max-w-md h-64 md:h-80 relative">
                                <canvas id="skillsRadarChart"></canvas>
                            </div>
                        </div> --}}

                        {{-- Assessment List --}}
                        <div class="space-y-4">
                            @if (count($assessmentDetails) > 0)
                                @foreach ($assessmentDetails as $item)
                                    <div class="bg-slate-950 border border-slate-800/50 p-5 rounded-xl flex flex-col gap-2 hover:border-slate-700 transition-colors">
                                        <div class="flex justify-between items-center">
                                            <span class="text-slate-200 font-bold tracking-wide">{{ $item->category }}</span>
                                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg {{ $item->scoreClass }}">
                                                {{ $item->score }}%
                                            </span>
                                        </div>
                                        <div class="w-full bg-slate-800 rounded-full h-1.5 mt-1 mb-1">
                                            <div class="h-1.5 rounded-full {{ str_replace('text-', 'bg-', $item->colorClass) }}" style="width: {{ $item->score }}%"></div>
                                        </div>
                                        <p class="text-sm {{ $item->colorClass }} leading-relaxed">
                                            {{ $item->feedback }}
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-6 bg-slate-950/50 rounded-xl border border-dashed border-slate-800">
                                    <p class="text-slate-400 text-sm">Belum ada data asesmen.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Technical Skills Grid --}}
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-indigo-500/10 border border-indigo-500/20 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-white">Technical Skills</h2>
                        </div>

                        @if (count($technicalSkills) > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($technicalSkills as $skill)
                                    @php
                                        $badgeStyle = match ($skill->level) {
                                            'Expert', 'Advanced' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'Intermediate' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                            'Beginner', 'Basic' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            default => 'bg-slate-800 text-slate-400 border-slate-700',
                                        };
                                    @endphp
                                    <div class="bg-slate-900 border border-slate-800 p-4 rounded-xl hover:border-slate-700 transition flex flex-col justify-between h-full group">
                                        <span class="font-bold text-slate-200 text-lg group-hover:text-blue-400 transition-colors">{{ $skill->name }}</span>
                                        <div class="mt-2">
                                            <span class="inline-block px-2.5 py-1 rounded-md text-xs font-semibold border {{ $badgeStyle }}">
                                                {{ $skill->level }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-8 text-center">
                                <p class="text-slate-400 text-sm">Belum ada skill teknis ditambahkan.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Projects Section --}}
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-purple-500/10 border border-purple-500/20 rounded-lg">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-white">Featured Projects</h2>
                        </div>

                        @if ($user->projects->isEmpty())
                            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-12 text-center">
                                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                <p class="text-slate-400 font-medium">Belum ada proyek.</p>
                            </div>
                        @else
                            <div class="grid md:grid-cols-2 gap-6">
                                @foreach ($user->projects as $project)
                                    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-slate-700 transition group">
                                        <div class="h-40 bg-slate-800 relative overflow-hidden">
                                            <img src="{{ $project->image_path ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $project->project_title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
                                        </div>
                                        <div class="p-5">
                                            <h3 class="font-bold text-white mb-2">{{ $project->project_title }}</h3>
                                            <p class="text-slate-400 text-sm mb-4 line-clamp-2">{{ $project->description }}</p>
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @foreach ($project->tags ?? [] as $tag)
                                                    <span class="px-2 py-1 bg-slate-800 text-slate-300 text-xs rounded-md border border-slate-700">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                            <a href="{{ $project->project_link }}" target="_blank" class="text-blue-400 text-sm hover:text-blue-300 flex items-center gap-1">
                                                View Project <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Certificates Section --}}
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-emerald-500/10 border border-emerald-500/20 rounded-lg">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-white">Certificates</h2>
                        </div>

                        @if ($user->certificates->isEmpty())
                            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-12 text-center">
                                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-medium">Belum ada sertifikat.</p>
                            </div>
                        @else
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach ($user->certificates as $cert)
                                    <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 flex items-center gap-4 hover:border-slate-700 transition">
                                        <div class="w-12 h-12 bg-slate-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-white text-sm">{{ $cert->certificate_title }}</h4>
                                            <p class="text-xs text-slate-400">{{ $cert->issuer_organization }} • {{ $cert->date_issued }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('skillsRadarChart').getContext('2d');
            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ['Soft Skills', 'Workplace Readiness', 'Digital Skills'],
                    datasets: [{
                        label: 'Proficiency',
                        data: [chartData['Soft Skills'], chartData['Workplace Readiness'], chartData['Digital Skills']],
                        backgroundColor: 'rgba(59, 130, 246, 0.25)',
                        borderColor: '#3b82f6',
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#3b82f6',
                        borderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            grid: { color: 'rgba(148, 163, 184, 0.1)', circular: false },
                            angleLines: { color: 'rgba(148, 163, 184, 0.2)' },
                            pointLabels: { color: '#cbd5e1', font: { size: 13, family: "'Inter', sans-serif", weight: '600' }, backdropColor: 'transparent' },
                            ticks: { display: false, backdropColor: 'transparent', max: 100, min: 0, stepSize: 20 },
                            suggestedMin: 0, suggestedMax: 100
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)', titleColor: '#f8fafc', bodyColor: '#cbd5e1', borderColor: 'rgba(51, 65, 85, 1)', borderWidth: 1, padding: 12, displayColors: false,
                            callbacks: { label: function(context) { return context.raw + '% Score'; } }
                        }
                    }
                }
            });
        });
    </script>
@endpush --}}
