@extends('layouts.master')

@section('title', 'Admin Dashboard - VinixPort')

@section('content')
    <div class="min-h-screen bg-slate-950 text-slate-200 font-sans pt-28 pb-12 px-4 relative overflow-hidden">

        {{-- Background Effects --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
            <div class="absolute -top-[10%] right-[10%] w-[50%] h-[50%] rounded-full bg-indigo-600/10 blur-[120px]"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">

            {{-- Header --}}
            <div class="mb-10 flex flex-col md:flex-row justify-between items-end gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Admin Dashboard</h1>
                    <p class="text-slate-400">Ringkasan aktivitas dan statistik platform VinixPort.</p>
                </div>
                <div class="px-4 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs font-mono text-slate-400">
                    Last Update: {{ now()->format('d M Y, H:i') }}
                </div>
            </div>

            {{-- STAT CARDS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-10">

                {{-- Card 1: Users --}}
                <div
                    class="bg-slate-900/60 border border-slate-800 p-6 rounded-2xl hover:border-blue-500/50 transition group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Users</p>
                            <h3 class="text-3xl font-bold text-white">{{ $stats['users'] }}</h3>
                        </div>
                        <div
                            class="p-3 bg-blue-500/10 text-blue-400 rounded-xl group-hover:bg-blue-500 group-hover:text-white transition">
                            <i class="fa-solid fa-users text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Projects --}}
                <div
                    class="bg-slate-900/60 border border-slate-800 p-6 rounded-2xl hover:border-purple-500/50 transition group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Projects</p>
                            <h3 class="text-3xl font-bold text-white">{{ $stats['projects'] }}</h3>
                        </div>
                        <div
                            class="p-3 bg-purple-500/10 text-purple-400 rounded-xl group-hover:bg-purple-500 group-hover:text-white transition">
                            <i class="fa-solid fa-layer-group text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Certificates --}}
                <div
                    class="bg-slate-900/60 border border-slate-800 p-6 rounded-2xl hover:border-emerald-500/50 transition group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Certificates</p>
                            <h3 class="text-3xl font-bold text-white">{{ $stats['certificates'] }}</h3>
                        </div>
                        <div
                            class="p-3 bg-emerald-500/10 text-emerald-400 rounded-xl group-hover:bg-emerald-500 group-hover:text-white transition">
                            <i class="fa-solid fa-certificate text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Questions --}}
                <div
                    class="bg-slate-900/60 border border-slate-800 p-6 rounded-2xl hover:border-amber-500/50 transition group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Assessments</p>
                            <h3 class="text-3xl font-bold text-white">{{ $stats['questions'] }}</h3>
                            <span class="text-xs text-slate-500">Active Questions</span>
                        </div>
                        <div
                            class="p-3 bg-amber-500/10 text-amber-400 rounded-xl group-hover:bg-amber-500 group-hover:text-white transition">
                            <i class="fa-solid fa-clipboard-list text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Card 5: Submissions --}}
                <div
                    class="bg-slate-900/60 border border-slate-800 p-6 rounded-2xl hover:border-pink-500/50 transition group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Submissions</p>
                            <h3 class="text-3xl font-bold text-white">{{ $stats['submissions'] }}</h3>
                            <span class="text-xs text-slate-500">Total User Answers</span>
                        </div>
                        <div
                            class="p-3 bg-pink-500/10 text-pink-400 rounded-xl group-hover:bg-pink-500 group-hover:text-white transition">
                            <i class="fa-solid fa-file-signature text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CHART SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Chart Area --}}
                <div class="lg:col-span-2 bg-slate-900/60 border border-slate-800 rounded-2xl p-8">
                    <h3 class="text-lg font-bold text-white mb-6">Platform Overview</h3>
                    <div class="h-80 w-full">
                        <canvas id="adminChart"></canvas>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-gradient-to-br from-slate-900 to-slate-800 border border-slate-700 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.users.index') }}"
                                class="w-full py-3 px-4 bg-slate-950 hover:bg-slate-900 border border-slate-700 rounded-xl text-slate-300 text-sm font-medium flex items-center justify-between transition group">
                                <span>Manage Users</span>
                                <i class="fa-solid fa-arrow-right text-slate-600 group-hover:text-white transition"></i>
                            </a>
                            <button
                                class="w-full py-3 px-4 bg-slate-950 hover:bg-slate-900 border border-slate-700 rounded-xl text-slate-300 text-sm font-medium flex items-center justify-between transition group">
                                <span>Add New Assessment Question</span>
                                <i class="fa-solid fa-plus text-slate-600 group-hover:text-emerald-400 transition"></i>
                            </button>
                            <button
                                class="w-full py-3 px-4 bg-slate-950 hover:bg-slate-900 border border-slate-700 rounded-xl text-slate-300 text-sm font-medium flex items-center justify-between transition group">
                                <span>Review Reports</span>
                                <i class="fa-solid fa-download text-slate-600 group-hover:text-blue-400 transition"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('adminChart').getContext('2d');
            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Total Data',
                        data: chartData.data,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)', // Blue (Users)
                            'rgba(168, 85, 247, 0.8)', // Purple (Projects)
                            'rgba(16, 185, 129, 0.8)', // Emerald (Certs)
                            'rgba(236, 72, 153, 0.8)' // Pink (Submissions)
                        ],
                        borderRadius: 6,
                        borderSkipped: false,
                        barThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            borderColor: '#334155',
                            borderWidth: 1,
                            padding: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            ticks: {
                                color: '#94a3b8'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
