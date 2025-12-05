@extends('layouts.master')

@section('title', 'Portofolio - ' . $user->name)

@section('content')
    {{-- x-data untuk Global State halaman ini --}}
    <div x-data="{
        showReviewModal: false,
        isEditingBio: false,
        isEditingTitle: false,
        isEditingSlug: false,
        isEditingProfile: false,
        bio: '{{ $user->bio ?? '' }}',
        title: '{{ $user->jabatan ?? 'Fullstack Developer' }}',
        slug: '{{ $user->slug }}',
        paymentAmount: 150000,
        uploadingAvatar: false
    }" x-init="$watch('showReviewModal', value => {
        if (value) {
            document.body.classList.add('overflow-hidden'); // Matikan scroll body
        } else {
            document.body.classList.remove('overflow-hidden'); // Hidupkan kembali
        }
    });
    $watch('isEditingProfile', value => { // Watcher untuk modal profile juga
        if (value) document.body.classList.add('overflow-hidden');
        else document.body.classList.remove('overflow-hidden');
    })"
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

                {{-- 1. Top Gradient Line --}}
                <div
                    class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500 opacity-50 z-20">
                </div>

                {{-- 2. Banner Background --}}
                <div class="h-40 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden z-0">
                    <div
                        class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] opacity-30">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-900/90"></div>
                </div>

                <div class="px-8 pb-8 relative z-10">

                    <div class="flex flex-col md:flex-row items-start md:items-end -mt-16 gap-6">

                        {{-- A. AVATAR SECTION --}}
                        <div class="relative group/avatar flex-shrink-0">
                            <div
                                class="absolute -inset-1 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full opacity-50 blur group-hover/avatar:opacity-100 transition duration-500">
                            </div>

                            {{-- Image --}}
                            <img class="relative w-32 h-32 rounded-full border-4 border-slate-900 bg-slate-950 object-cover shadow-xl z-20"
                                src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff' }}"
                                alt="{{ $user->name }}" />

                            {{-- Upload Overlay Button --}}
                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
                                class="absolute inset-0 z-30">
                                @csrf @method('PUT')
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

                        {{-- B. TEXT INFO SECTION --}}
                        <div class="flex-1 w-full pt-2 md:pt-0"> {{-- pt-2 untuk jarak di mobile --}}
                            <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
                                <div class="w-full">

                                    {{-- Nama User --}}
                                    <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">
                                        {{ $user->name }}
                                    </h1>

                                    {{-- Email (Read Only) --}}
                                    <p class="text-slate-400 text-sm mb-4 flex items-center gap-2 relative z-10">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $user->email }}
                                    </p>

                                    {{-- EDIT TITLE / JABATAN --}}
                                    <div class="mb-3 relative z-10">
                                        {{-- Mode Edit --}}
                                        <div x-show="isEditingTitle" style="display: none;" class="flex items-center gap-2">
                                            <form action="{{ route('user.profile.update') }}" method="POST"
                                                class="flex gap-2 w-full max-w-md">
                                                @csrf @method('PUT')
                                                <input type="text" name="title" x-model="title"
                                                    class="flex-1 bg-slate-950 border border-slate-700 text-white px-3 py-1.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-lg">
                                                <button type="submit"
                                                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1.5 rounded-lg text-sm font-bold">Save</button>
                                                <button type="button" @click="isEditingTitle = false"
                                                    class="text-slate-400 hover:text-white text-sm">Cancel</button>
                                            </form>
                                        </div>
                                        {{-- Mode View --}}
                                        <div x-show="!isEditingTitle" @click="isEditingTitle = true"
                                            class="flex items-center gap-2 group/title cursor-pointer w-fit">
                                            <p class="text-lg text-blue-400 font-medium" x-text="title || 'Add Title'"></p>
                                            <svg class="w-4 h-4 text-slate-600 opacity-0 group-hover/title:opacity-100 transition-opacity"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fillRule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clipRule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- EDIT SLUG / PUBLIC URL --}}
                                    <div
                                        class="bg-slate-950/50 rounded-lg p-2 border border-slate-800 flex flex-wrap items-center gap-2 w-fit relative z-10">
                                        <span
                                            class="text-xs text-slate-500 font-semibold uppercase tracking-wider flex-shrink-0">Public
                                            URL:</span>

                                        {{-- Mode Edit Slug --}}
                                        <div x-show="isEditingSlug" style="display: none;" class="flex items-center gap-2">
                                            <span
                                                class="text-slate-400 text-xs md:text-sm hidden md:inline">{{ url('/portfolio/view') }}/</span>
                                            <form action="{{ route('user.profile.update') }}" method="POST"
                                                class="flex items-center gap-1">
                                                @csrf @method('PUT')
                                                <input type="text" name="slug" x-model="slug"
                                                    class="bg-slate-900 border border-slate-700 text-white px-2 py-1 rounded text-sm w-32 md:w-40 focus:outline-none focus:border-blue-500">
                                                <button type="submit"
                                                    class="p-1 text-emerald-400 hover:text-emerald-300 bg-emerald-400/10 rounded"><i
                                                        class="fa-solid fa-check"></i></button>
                                                <button type="button" @click="isEditingSlug = false"
                                                    class="p-1 text-red-400 hover:text-red-300 bg-red-400/10 rounded"><i
                                                        class="fa-solid fa-xmark"></i></button>
                                            </form>
                                        </div>

                                        {{-- Mode Tampil Slug --}}
                                        <div x-show="!isEditingSlug" class="flex items-center gap-2 group/slug max-w-full">
                                            <a :href="'{{ url('/portfolio/view') }}/' + slug" target="_blank"
                                                class="text-sm text-slate-300 hover:text-white hover:underline truncate max-w-[180px] md:max-w-xs">
                                                <span class="hidden md:inline">{{ url('/portfolio/view') }}/</span><span
                                                    x-text="slug" class="font-bold text-white"></span>
                                            </a>
                                            <div
                                                class="flex gap-1 opacity-0 group-hover/slug:opacity-100 transition-opacity">
                                                <button @click="isEditingSlug = true"
                                                    class="p-1.5 text-slate-400 hover:text-blue-400 bg-slate-800 hover:bg-slate-700 rounded-md transition-colors"
                                                    title="Edit Slug">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                        <path fillRule="evenodd"
                                                            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                            clipRule="evenodd" />
                                                    </svg>
                                                </button>
                                                <button
                                                    onclick="navigator.clipboard.writeText('{{ url('/portfolio/view') }}/{{ $user->slug }}'); alert('URL berhasil disalin!')"
                                                    class="p-1.5 text-slate-400 hover:text-emerald-400 bg-slate-800 hover:bg-slate-700 rounded-md transition-colors"
                                                    title="Copy Link">
                                                    <i class="fa-regular fa-copy text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- C. ACTION BUTTONS --}}
                                <div class="flex flex-col md:flex-row gap-3 mt-4 md:mt-0 relative z-10">

                                    <button @click="isEditingProfile = true"
                                        class="flex text-nowrap justify-center items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 border border-blue-600 hover:border-blue-500 text-white rounded-xl transition-all text-sm font-bold shadow-lg hover:shadow-blue-900/30">
                                        <i class="fa-solid fa-user-pen"></i>
                                        <span>Edit Profile</span>
                                    </button>

                                    <a href="#"
                                        class="flex text-nowrap justify-center items-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 hover:border-slate-600 text-white rounded-xl transition-all text-sm font-bold shadow-lg hover:shadow-blue-900/20">
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
                            <h2 class="text-xl font-bold text-white">Assessment Report</h2>
                        </div>

                        {{-- <div class="mb-10 flex justify-center relative">
                            <div class="w-full max-w-md h-64 md:h-80 relative">
                                <canvas id="skillsRadarChart"></canvas>
                            </div>
                        </div> --}}

                        {{-- 2. Skill List / Analysis Cards (Existing Code) --}}
                        <div class="space-y-4">
                            @if (count($assessmentDetails) > 0)
                                @foreach ($assessmentDetails as $item)
                                    <div
                                        class="bg-slate-950 border border-slate-800/50 p-5 rounded-xl flex flex-col gap-2 hover:border-slate-700 transition-colors">
                                        <div class="flex justify-between items-center">
                                            <span
                                                class="text-slate-200 font-bold tracking-wide">{{ $item->category }}</span>
                                            <span
                                                class="text-xs font-bold px-2.5 py-1 rounded-lg {{ $item->scoreClass }}">
                                                {{ $item->score }}%
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
                                    class="text-center py-6 bg-slate-950/50 rounded-xl border border-dashed border-slate-800">
                                    <p class="text-slate-400 text-sm">Belum ada data asesmen.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-indigo-500/10 border border-indigo-500/20 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-white">Technical Skills</h2>
                        </div>

                        @if (count($technicalSkills) > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($technicalSkills as $skill)
                                    {{-- LOGIKA WARNA BADGE --}}
                                    @php
                                        $badgeStyle = match ($skill->level) {
                                            'Expert',
                                            'Advanced'
                                                => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'Intermediate' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                            'Beginner', 'Basic' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            default => 'bg-slate-800 text-slate-400 border-slate-700',
                                        };
                                    @endphp

                                    <div
                                        class="bg-slate-900 border border-slate-800 p-4 rounded-xl hover:border-slate-700 transition flex flex-col justify-between h-full group">
                                        <span
                                            class="font-bold text-slate-200 text-lg group-hover:text-blue-400 transition-colors">{{ $skill->name }}</span>
                                        <div class="mt-2">
                                            {{-- Gunakan variable $badgeStyle di class --}}
                                            <span
                                                class="inline-block px-2.5 py-1 rounded-md text-xs font-semibold border {{ $badgeStyle }}">
                                                {{ $skill->level }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            {{-- State Kosong --}}
                            <div
                                class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl p-8 text-center">
                                <p class="text-slate-400 text-sm">Belum ada skill teknis ditambahkan.</p>
                            </div>
                        @endif
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

        {{-- Review Payment Modal --}}
        @include('pages.user.portofolio.components.payment-modal')

        {{-- Edit Modal --}}
        @include('pages.user.portofolio.components.edit-modal')

    </div>
@endsection
