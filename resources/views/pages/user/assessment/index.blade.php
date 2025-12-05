@extends('layouts.master')

@section('title', 'Skill Assessment')

@section('content')
    <div class="min-h-screen bg-slate-950 font-sans selection:bg-blue-500 selection:text-white pt-28 pb-12 px-4 relative overflow-hidden">

        {{-- Background Effects --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
            <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[60%] rounded-full bg-blue-600/10 blur-[100px]"></div>
            <div class="absolute bottom-[10%] right-[10%] w-[40%] h-[40%] rounded-full bg-purple-600/10 blur-[80px]"></div>
        </div>

        <div class="relative z-10 container mx-auto max-w-2xl">

            {{-- KONDISI 1: SUDAH SELESAI --}}
            @if ($hasCompletedAssessment)
                <div class="bg-slate-900/60 backdrop-blur-2xl border border-slate-800 shadow-2xl rounded-2xl p-10 text-center">
                    <div class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold text-white mb-3">Assessment Completed</h1>
                    <p class="text-slate-400 mb-8 leading-relaxed">
                        Anda sudah menyelesaikan penilaian skill. Hasil analisis sudah tersedia di halaman portofolio Anda.
                        Jika Anda merasa skill Anda telah meningkat, Anda dapat mengambil ulang tes ini.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('user.portfolio.index') }}" class="px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold transition-colors border border-slate-700">
                            Lihat Portofolio
                        </a>

                        {{-- Form untuk Reset Assessment --}}
                        <form action="{{ route('user.assessment.destroy') }}" method="POST" onsubmit="return confirm('Yakin ingin mengulang dari awal? Data nilai lama akan dihapus.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold shadow-lg shadow-blue-600/20 transition-all">
                                Ulangi Assessment
                            </button>
                        </form>
                    </div>
                </div>

            {{-- KONDISI 2: BELUM SELESAI (Tampilkan App Quiz) --}}
            @else
                <div x-data="assessmentApp(@js($questions))">

                    {{-- Header Info --}}
                    <div class="flex items-center justify-center md:justify-between mb-6 px-1">
                        <div class="flex items-center gap-3">
                            <span class="flex h-2.5 w-2.5 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500"></span>
                            </span>
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Assessment in Progress</span>
                        </div>
                        <a href="{{ route('user.portfolio.index') }}" class="hidden md:flex text-slate-500 hover:text-white text-sm font-medium transition-colors items-center gap-1">
                            <span>Exit</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    </div>

                    {{-- 1. QUIZ CONTAINER --}}
                    <div x-show="!isComplete" x-transition.opacity.duration.500ms class="bg-slate-900/60 backdrop-blur-2xl border border-slate-800 shadow-2xl rounded-2xl p-6 md:p-10 relative overflow-hidden">

                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500 opacity-50"></div>

                        <div class="flex justify-between items-end mb-8">
                            <div>
                                <span class="inline-block border border-blue-500/30 bg-blue-500/10 text-blue-300 text-[10px] font-bold px-2 py-1 rounded-full mb-2 uppercase tracking-wider" x-text="currentQuestion.type.replace('_', ' ')"></span>
                                <h1 class="text-2xl md:text-3xl font-bold text-white">Skill Check</h1>
                            </div>
                            <div class="text-right">
                                <span class="block text-xs text-slate-500 font-mono mb-1">Question</span>
                                <span class="text-white font-mono text-xl font-bold">
                                    <span x-text="currentIndex + 1"></span> <span class="text-slate-600 text-base">/ <span x-text="questions.length"></span></span>
                                </span>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="w-full bg-slate-800 rounded-full h-1.5 mb-12 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-purple-500 shadow-[0_0_10px_rgba(59,130,246,0.5)] transition-all duration-500 ease-out" :style="`width: ${progress}%`"></div>
                        </div>

                        {{-- Question Text --}}
                        <div class="mb-12 min-h-[100px] flex items-center justify-center">
                            <p class="text-xl md:text-2xl font-medium text-white text-center leading-relaxed" x-text="`&quot;${currentQuestion.question}&quot;`"></p>
                        </div>

                        {{-- Options --}}
                        <div class="space-y-4">
                            <div class="flex justify-between text-xs text-slate-500 font-bold uppercase tracking-wider px-1 mb-2">
                                <span>Sangat Tidak Bisa</span>
                                <span>Sangat Bisa</span>
                            </div>
                            <div class="grid grid-cols-5 gap-3 md:gap-4">
                                <template x-for="score in [1, 2, 3, 4, 5]">
                                    <button @click="selectScore(score)"
                                        :class="answers[currentQuestion.id] === score
                                            ? 'bg-blue-600 border-blue-500 text-white shadow-lg shadow-blue-500/20 scale-105 z-10'
                                            : 'bg-slate-800 border-slate-700 text-slate-400 hover:bg-slate-700 hover:border-slate-600 hover:text-white hover:-translate-y-1'"
                                        class="group relative aspect-square md:aspect-auto md:h-16 rounded-xl border flex items-center justify-center text-xl font-bold transition-all duration-200 outline-none">
                                        <span x-text="score"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="mt-10 pt-6 border-t border-slate-800 flex justify-between items-center">
                             <button @click="prevQuestion()" :disabled="currentIndex === 0"
                                :class="currentIndex === 0 ? 'text-slate-800 cursor-not-allowed' : 'text-slate-400 hover:text-white'"
                                class="flex items-center gap-2 text-sm font-bold transition-colors">
                                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                  Previous
                             </button>
                             <span class="text-[10px] text-slate-600 uppercase tracking-wider hidden md:block">Pilih angka 1 - 5</span>
                        </div>
                    </div>

                    {{-- 2. SUCCESS / FINISH CARD --}}
                    <div x-show="isComplete" style="display: none;" x-transition.opacity.duration.500ms>
                        <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 shadow-2xl rounded-2xl p-8 md:p-10 text-center">
                            <div class="mb-6 inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 shadow-lg shadow-emerald-500/30">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 tracking-tight">Assessment Complete!</h1>
                            <p class="text-lg text-slate-400 mb-8 leading-relaxed max-w-xl mx-auto">
                                Terima kasih telah menyelesaikan asesmen. Hasil analisis keahlian Anda akan diperbarui di portofolio.
                            </p>
                            <div class="flex justify-center gap-4">
                                <button @click="submitData()" x-show="!isSubmitted" class="py-3.5 px-8 rounded-xl bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20 hover:bg-blue-500 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                                    <svg x-show="isLoading" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span x-text="isLoading ? 'Saving...' : 'Simpan Hasil'"></span>
                                </button>
                                <a href="{{ route('user.portfolio.index') }}" x-show="isSubmitted" class="py-3.5 px-8 rounded-xl bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-600/20 hover:bg-emerald-500 transition-all transform hover:-translate-y-0.5">
                                    Lihat Portofolio Saya
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </div>

    {{-- SCRIPT ALPINE.JS (Hanya dirender jika belum selesai assessment atau untuk keperluan logika) --}}
    @if (!$hasCompletedAssessment)
        @push('scripts')
            <script>
                function assessmentApp(questionsData) {
                    return {
                        questions: questionsData,
                        currentIndex: 0,
                        answers: {},
                        isComplete: false,
                        isSubmitted: false,
                        isLoading: false,

                        get currentQuestion() {
                            return this.questions[this.currentIndex];
                        },

                        get progress() {
                            return ((this.currentIndex + 1) / this.questions.length) * 100;
                        },

                        selectScore(score) {
                            this.answers[this.currentQuestion.id] = score;
                            setTimeout(() => {
                                if (this.currentIndex < this.questions.length - 1) {
                                    this.currentIndex++;
                                } else {
                                    this.isComplete = true;
                                }
                            }, 250);
                        },

                        prevQuestion() {
                            if (this.currentIndex > 0) {
                                this.currentIndex--;
                            }
                        },

                        async submitData() {
                            this.isLoading = true;
                            const formattedAnswers = Object.entries(this.answers).map(([id, score]) => ({
                                id: parseInt(id),
                                score: score
                            }));

                            try {
                                const response = await fetch('{{ route('user.assessment.store') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({ answers: formattedAnswers })
                                });

                                if (response.ok) {
                                    this.isSubmitted = true;
                                    // Opsional: Redirect otomatis setelah sukses
                                    // window.location.href = "{{ route('user.portfolio.index') }}";
                                } else {
                                    alert('Gagal menyimpan data. Silakan coba lagi.');
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan jaringan.');
                            } finally {
                                this.isLoading = false;
                            }
                        }
                    }
                }
            </script>
        @endpush
    @endif
@endsection
