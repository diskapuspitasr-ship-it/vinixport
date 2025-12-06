@extends('layouts.master')

@section('title', 'Analytics - VinixPort')

@section('content')
    <div class="min-h-screen bg-slate-950 font-sans selection:bg-blue-500 selection:text-white pt-28 pb-12 px-4 relative overflow-hidden">

        {{-- Background Effects --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
            <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[60%] rounded-full bg-blue-600/10 blur-[100px]"></div>
            <div class="absolute bottom-[10%] right-[10%] w-[40%] h-[40%] rounded-full bg-purple-600/10 blur-[80px]"></div>
        </div>

        <div class="relative z-10 container mx-auto max-w-5xl">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight mb-2">Portfolio Analytics</h1>
                    <p class="text-slate-400">Ringkasan performa dan distribusi konten portofoliomu.</p>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wide">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Live Data
                </div>
            </div>

            {{-- Stat Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                {{-- Card 1: Total Projects --}}
                <div class="relative bg-slate-900/50 border border-slate-800 p-6 rounded-2xl overflow-hidden group hover:border-blue-500/30 transition-all duration-300 hover:-translate-y-1 shadow-lg">
                    {{-- Background Glow --}}
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500 opacity-10 rounded-full blur-2xl -mr-10 -mt-10 transition-opacity group-hover:opacity-20"></div>

                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-sm text-slate-400 font-medium uppercase tracking-wider mb-1">Total Projects</p>
                            <p class="text-4xl font-bold text-white tracking-tight mb-2">{{ $projectCount }}</p>
                            <p class="text-xs text-slate-500">Proyek aktif yang ditampilkan</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 text-white shadow-lg shadow-blue-900/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Total Certificates --}}
                <div class="relative bg-slate-900/50 border border-slate-800 p-6 rounded-2xl overflow-hidden group hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1 shadow-lg">
                    {{-- Background Glow --}}
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500 opacity-10 rounded-full blur-2xl -mr-10 -mt-10 transition-opacity group-hover:opacity-20"></div>

                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-sm text-slate-400 font-medium uppercase tracking-wider mb-1">Total Certificates</p>
                            <p class="text-4xl font-bold text-white tracking-tight mb-2">{{ $certificateCount }}</p>
                            <p class="text-xs text-slate-500">Sertifikat & lisensi terverifikasi</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-900/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chart Section --}}
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-xl font-bold text-white">Content Overview</h2>
                        <p class="text-sm text-slate-500 mt-1">Perbandingan jumlah konten dalam portofolio</p>
                    </div>
                    {{-- Custom Legend --}}
                    <div class="flex gap-4 text-xs font-medium text-slate-400">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span> Projects
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Certificates
                        </div>
                    </div>
                </div>

                {{-- Canvas Container --}}
                <div class="h-80 w-full relative">
                    <canvas id="analyticsBarChart"></canvas>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-800 flex justify-center">
                    <p class="text-slate-500 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Data diperbarui secara real-time saat Anda mengunggah konten baru.
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('analyticsBarChart').getContext('2d');
            const chartData = @json($chartData);

            // Konfigurasi Chart.js agar mirip dengan desain Recharts
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Total Items',
                        data: chartData.data,
                        backgroundColor: chartData.backgrounds,
                        borderColor: chartData.colors,
                        borderWidth: 0,
                        borderRadius: 8, // Rounded corners on top
                        borderSkipped: false,
                        barThickness: 60,
                        maxBarThickness: 80
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Kita pakai custom legend di HTML
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#f8fafc',
                            bodyColor: '#cbd5e1',
                            borderColor: '#1e293b',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return context.raw + ' Items';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    family: "'Inter', sans-serif",
                                    weight: '600'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(51, 65, 85, 0.4)', // Slate-700 opacity
                                drawBorder: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                color: '#64748b',
                                precision: 0 // Hilangkan desimal
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
