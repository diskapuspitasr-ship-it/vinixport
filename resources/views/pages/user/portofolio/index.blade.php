@extends('layouts.master')

@section('title', 'Portofolio - ' . $user->name)

@section('content')
    {{-- x-data untuk Global State halaman ini --}}
    <div x-data="{
        showReviewModal: false,
        isEditingBio: false,
        isEditingTitle: false,
        bio: '{{ $user->bio ?? '' }}',
        title: '{{ $user->title ?? 'Fullstack Developer' }}',
        paymentAmount: 150000,
        uploadingAvatar: false
    }"
        class="min-h-screen bg-slate-950 text-slate-200 font-sans selection:bg-blue-500 selection:text-white pt-28 pb-12 px-4 relative overflow-hidden">

        {{-- Background Effects --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
            <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[60%] rounded-full bg-blue-600/10 blur-[100px]"></div>
            <div class="absolute bottom-[10%] right-[10%] w-[40%] h-[40%] rounded-full bg-purple-600/10 blur-[80px]"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">

            {{-- Profile Header Card --}}
            <div
                class="bg-slate-900/60 backdrop-blur-2xl border border-slate-800 shadow-2xl rounded-2xl overflow-hidden mb-8 relative group">
                <div
                    class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500 opacity-50">
                </div>

                <div class="h-40 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] opacity-30">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-900/90"></div>
                </div>

                <div class="px-8 pb-8">
                    <div class="flex flex-col md:flex-row items-start md:items-end -mt-16 gap-6">
                        {{-- Avatar Section --}}
                        <div class="relative group/avatar">
                            <div
                                class="absolute -inset-1 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full opacity-50 blur group-hover/avatar:opacity-100 transition duration-500">
                            </div>
                            <img class="relative w-32 h-32 rounded-full border-4 border-slate-900 bg-slate-950 object-cover shadow-xl"
                                src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff' }}"
                                alt="{{ $user->name }}" />

                            {{-- Upload Avatar Button --}}
                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
                                class="absolute inset-0 z-20">
                                @csrf
                                @method('PUT')
                                <label
                                    class="w-full h-full rounded-full flex items-center justify-center bg-black/50 opacity-0 group-hover/avatar:opacity-100 transition-opacity duration-200 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fillRule="evenodd"
                                            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                            clipRule="evenodd" />
                                    </svg>
                                    <input type="file" name="avatar" class="hidden" onchange="this.form.submit()">
                                </label>
                            </form>
                        </div>

                        <div class="flex-1 w-full">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
                                <div>
                                    <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight mb-1">
                                        {{ $user->name }}</h1>

                                    {{-- Edit Title Section --}}
                                    <div x-show="isEditingTitle" class="flex items-center gap-2 mt-2"
                                        style="display: none;">
                                        <form action="{{ route('user.profile.update') }}" method="POST" class="flex gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="title" x-model="title"
                                                class="bg-slate-950 border border-slate-700 text-white px-3 py-1.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-lg">
                                            <button type="submit"
                                                class="text-sm bg-blue-600 hover:bg-blue-500 text-white px-3 py-1.5 rounded-lg font-bold transition">Save</button>
                                            <button type="button" @click="isEditingTitle = false"
                                                class="text-sm text-slate-400 hover:text-white transition">Cancel</button>
                                        </form>
                                    </div>
                                    <div x-show="!isEditingTitle" @click="isEditingTitle = true"
                                        class="flex items-center gap-2 group/title cursor-pointer mt-1">
                                        <p class="text-lg text-blue-400 font-medium" x-text="title"></p>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4 text-slate-600 opacity-0 group-hover/title:opacity-100 transition-opacity"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fillRule="evenodd"
                                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                clipRule="evenodd" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    {{-- Tombol Download CV (Logic PDF sebaiknya di controller terpisah) --}}
                                    <a href="#"
                                        class="flex items-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 hover:border-slate-600 text-white rounded-xl transition-all text-sm font-bold shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
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

                    {{-- Premium Mentor Card --}}
                    <div
                        class="relative bg-gradient-to-br from-indigo-950 to-slate-900 border border-indigo-500/30 p-6 rounded-2xl overflow-hidden group hover:border-indigo-500/60 transition-all shadow-lg">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-indigo-500/20 border border-indigo-500/30 rounded-lg text-indigo-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-lg leading-tight">Expert Review</h3>
                                    <p class="text-xs text-indigo-300">Premium Feature</p>
                                </div>
                            </div>
                            <p class="text-slate-400 text-sm mb-6 leading-relaxed">
                                Dapatkan feedback profesional dari HR dan Senior Developer untuk kualitas portofolio
                                maksimal.
                            </p>
                            <button @click="showReviewModal = true"
                                class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-900/20 transition-all transform hover:-translate-y-0.5 text-sm flex items-center justify-center gap-2">
                                Review Sekarang
                            </button>
                        </div>
                    </div>

                    {{-- Status Review (Jika ada) --}}
                    @if ($latestReviewRequest)
                        <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-5 text-sm">
                            <h3 class="text-sm font-bold text-white mb-1">Status Premium Review</h3>
                            <p class="text-xs text-slate-500 mb-2">Terakhir update:
                                {{ $latestReviewRequest->updated_at->format('d M Y H:i') }}</p>
                            <p class="text-xs text-slate-300">Status: <span
                                    class="font-semibold capitalize">{{ str_replace('_', ' ', $latestReviewRequest->status) }}</span>
                            </p>
                        </div>
                    @endif

                    {{-- About Me --}}
                    <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white">About Me</h3>
                            <button @click="isEditingBio = true"
                                class="text-slate-500 hover:text-blue-400 transition-colors p-1 rounded hover:bg-slate-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fillRule="evenodd"
                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                        clipRule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div x-show="isEditingBio" style="display: none;">
                            <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <textarea name="bio" rows="6" x-model="bio"
                                    class="w-full bg-slate-950 border border-slate-700 rounded-xl p-3 text-sm text-slate-200 focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none leading-relaxed"></textarea>
                                <div class="flex gap-2 justify-end">
                                    <button type="button" @click="isEditingBio = false"
                                        class="text-xs text-slate-400 hover:text-white px-3 py-1.5">Cancel</button>
                                    <button type="submit"
                                        class="text-xs bg-blue-600 hover:bg-blue-500 text-white px-4 py-1.5 rounded-lg font-bold">Save</button>
                                </div>
                            </form>
                        </div>
                        <div x-show="!isEditingBio">
                            <p class="text-slate-400 text-sm leading-relaxed whitespace-pre-line"
                                x-text="bio || 'No bio yet. Click edit to add one.'"></p>
                        </div>
                    </div>

                    {{-- Share Buttons --}}
                    <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-6">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Share Portfolio</h3>
                        <div class="grid grid-cols-3 gap-3">
                            {{-- LinkedIn --}}
                            <button
                                onclick="window.open('https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}', '_blank')"
                                class="group flex items-center justify-center py-3 bg-[#0077b5]/10 hover:bg-[#0077b5] border border-[#0077b5]/20 hover:border-[#0077b5] rounded-xl transition-all duration-300">
                                <i class="fa-brands fa-linkedin text-xl text-[#0077b5] group-hover:text-white"></i>
                            </button>
                            {{-- Twitter --}}
                            <button
                                onclick="window.open('https://twitter.com/intent/tweet?text=Check my portfolio&url={{ urlencode(request()->url()) }}', '_blank')"
                                class="group flex items-center justify-center py-3 bg-white/5 hover:bg-white border border-white/10 hover:border-white rounded-xl transition-all duration-300">
                                <i class="fa-brands fa-x-twitter text-xl text-white group-hover:text-black"></i>
                            </button>
                            {{-- Whatsapp --}}
                            <button
                                onclick="window.open('https://wa.me/?text={{ urlencode('Check this out: ' . request()->url()) }}', '_blank')"
                                class="group flex items-center justify-center py-3 bg-[#25D366]/10 hover:bg-[#25D366] border border-[#25D366]/20 hover:border-[#25D366] rounded-xl transition-all duration-300">
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
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-white">Skills & Assessment</h2>
                        </div>

                        <div class="mb-10 flex justify-center relative">
                            {{-- Setting height is important for Chart.js responsiveness --}}
                            <div class="w-full max-w-md h-64 md:h-80 relative">
                                <canvas id="skillsRadarChart"></canvas>
                            </div>
                        </div>

                        {{-- 2. Skill List / Analysis Cards (Existing Code) --}}
                        <div class="space-y-4">
                            @if (count($analysisResults) > 0)
                                @foreach ($analysisResults as $item)
                                    <div
                                        class="bg-slate-950 border border-slate-800/50 p-5 rounded-xl flex flex-col gap-2 hover:border-slate-700 transition-colors">
                                        <div class="flex justify-between items-center">
                                            {{-- Menampilkan Nama Skill (Laravel, React, dll) --}}
                                            <span
                                                class="text-slate-200 font-bold tracking-wide">{{ $item->category }}</span>

                                            {{-- Menampilkan Level (Expert, atau 90%) --}}
                                            <span
                                                class="text-xs font-bold px-2.5 py-1 rounded-lg {{ $item->scoreClass }}">
                                                {{ $item->displayLevel }}
                                            </span>
                                        </div>

                                        {{-- Visual Progress Bar --}}
                                        <div class="w-full bg-slate-800 rounded-full h-1.5 mt-1 mb-1">
                                            <div class="h-1.5 rounded-full {{ str_replace('text-', 'bg-', $item->colorClass) }}"
                                                style="width: {{ $item->score }}%"></div>
                                        </div>

                                        <p class="text-sm {{ $item->colorClass }} leading-relaxed">
                                            {{ $item->feedback }}
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="text-center py-10 bg-slate-950/50 rounded-xl border border-dashed border-slate-800">
                                    <p class="text-slate-400 mb-2 font-medium">Belum ada skill ditambahkan.</p>
                                    <p class="text-sm text-slate-500">Edit profilmu untuk menambahkan skill teknis.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Projects Section --}}
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-purple-500/10 border border-purple-500/20 rounded-lg">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-white">Featured Projects</h2>
                        </div>

                        @if ($user->projects->isEmpty())
                            <div
                                class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-12 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-medium">Belum ada proyek.</p>
                                <a href="#"
                                    class="text-sm text-blue-400 hover:text-blue-300 mt-1 inline-block">Mulai bangun
                                    portofoliomu sekarang.</a>
                            </div>
                        @else
                            <div class="grid md:grid-cols-2 gap-6">
                                @foreach ($user->projects as $project)
                                    {{-- Project Card Component --}}
                                    <div
                                        class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-slate-700 transition group">
                                        <div class="h-40 bg-slate-800 relative overflow-hidden">
                                            <img src="{{ $project->image_path ?? 'https://via.placeholder.com/600x400' }}"
                                                alt="{{ $project->project_title }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent">
                                            </div>
                                        </div>
                                        <div class="p-5">
                                            <h3 class="font-bold text-white mb-2">{{ $project->project_title }}</h3>
                                            <p class="text-slate-400 text-sm mb-4 line-clamp-2">
                                                {{ $project->description }}</p>
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @foreach ($project->tags ?? [] as $tag)
                                                    <span
                                                        class="px-2 py-1 bg-slate-800 text-slate-300 text-xs rounded-md border border-slate-700">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                            <a href="{{ $project->project_link }}" target="_blank"
                                                class="text-blue-400 text-sm hover:text-blue-300 flex items-center gap-1">
                                                View Project <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
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
                                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-white">Certificates</h2>
                        </div>

                        @if ($user->certificates->isEmpty())
                            <div
                                class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-12 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-medium">Belum ada sertifikat.</p>
                            </div>
                        @else
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach ($user->certificates as $cert)
                                    <div
                                        class="bg-slate-900 border border-slate-800 rounded-xl p-4 flex items-center gap-4 hover:border-slate-700 transition">
                                        <div
                                            class="w-12 h-12 bg-slate-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-white text-sm">{{ $cert->certificate_title }}</h4>
                                            <p class="text-xs text-slate-400">{{ $cert->issuer_organization }} •
                                                {{ $cert->date_issued }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- Review Payment Modal (Alpine.js) --}}
        <div x-show="showReviewModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-start justify-center p-4 overflow-y-auto">
            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"
                @click="showReviewModal = false"></div>
            <div
                class="relative bg-slate-900 border border-slate-700 w-full max-w-md rounded-2xl shadow-2xl mt-10 mb-10 overflow-hidden">
                <div class="p-8">
                    {{-- Modal Header --}}
                    <div class="text-center">
                        <div
                            class="mx-auto w-16 h-16 bg-indigo-500/10 rounded-full flex items-center justify-center mb-6 text-indigo-400 border border-indigo-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Unlock Premium Review</h3>
                        <p class="text-slate-400 mb-6 text-sm">Hubungkan portofoliomu dengan mentor expert.</p>
                    </div>

                    {{-- Pricing Box --}}
                    <div class="bg-slate-950 rounded-xl p-5 border border-slate-800 mb-6 text-left">
                        <div class="flex justify-between items-center mb-2 text-sm">
                            <span class="text-slate-400">Total Biaya</span>
                            <span class="text-xl font-bold text-white"
                                x-text="'Rp ' + paymentAmount.toLocaleString('id-ID')"></span>
                        </div>
                        <p class="text-xs text-emerald-400 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Termasuk CV Audit & 1-on-1 Chat
                        </p>
                    </div>

                    {{-- Payment Form --}}
                    {{-- Pastikan ada route 'user.review.store' --}}
                    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Bank Pengirim</label>
                            <input type="text" name="payment_bank" required
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Nama Pemilik Rekening</label>
                            <input type="text" name="payment_account_name" required
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Nominal Transfer</label>
                            <input type="number" name="payment_amount" x-model="paymentAmount" required
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Bukti Transfer</label>
                            <input type="file" name="payment_proof" accept="image/*" required
                                class="block w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button type="button" @click="showReviewModal = false"
                                class="flex-1 py-3 border border-slate-700 rounded-xl text-slate-400 font-bold hover:bg-slate-800 hover:text-white transition-all text-sm">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold shadow-lg shadow-indigo-900/30 transition-all text-sm">
                                Bayar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- Load Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('skillsRadarChart').getContext('2d');

            // Ambil data dari Controller PHP
            const chartData = @json($chartData);

            // Setup Gradient untuk background radar (opsional, agar mirip desain)
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); // Blue top
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0.1)'); // Blue bottom

            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ['Soft Skills', 'Workplace Readiness', 'Digital Skills'],
                    datasets: [{
                        label: 'Proficiency',
                        data: [
                            chartData['Soft Skills'],
                            chartData['Workplace Readiness'],
                            chartData['Digital Skills']
                        ],
                        backgroundColor: 'rgba(59, 130, 246, 0.25)', // Area fill color
                        borderColor: '#3b82f6', // Border line color (Blue-500)
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
                            // Garis jaring-jaring (Grid)
                            grid: {
                                color: 'rgba(148, 163, 184, 0.1)', // Slate-400 transparent
                                circular: false
                            },
                            // Garis sudut (Angle lines)
                            angleLines: {
                                color: 'rgba(148, 163, 184, 0.2)'
                            },
                            // Label text (Soft Skills, etc)
                            pointLabels: {
                                color: '#cbd5e1', // Slate-300
                                font: {
                                    size: 13,
                                    family: "'Inter', sans-serif",
                                    weight: '600'
                                },
                                backdropColor: 'transparent' // Hapus background putih default di label
                            },
                            // Angka scale (0, 20, 40...)
                            ticks: {
                                display: false, // Hide angka agar bersih seperti desain
                                backdropColor: 'transparent',
                                max: 100,
                                min: 0,
                                stepSize: 20
                            },
                            suggestedMin: 0,
                            suggestedMax: 100
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hide legend box "Proficiency"
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)', // Slate-900 tooltip
                            titleColor: '#f8fafc',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(51, 65, 85, 1)',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.raw + '% Score';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
