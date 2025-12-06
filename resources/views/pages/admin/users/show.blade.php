@extends('layouts.master')

@section('title', 'User Detail - ' . $user->name)

@section('content')
    <div class="min-h-screen bg-slate-950 text-slate-200 pt-28 pb-12 px-4 font-sans relative overflow-hidden">

        {{-- Background Glow Effect --}}
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-blue-900/10 rounded-full blur-[150px] pointer-events-none"></div>

        <div class="container mx-auto max-w-5xl relative z-10">

            {{-- Back Button --}}
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-2 text-slate-400 hover:text-white mb-8 transition group">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                Back to Users
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Left: Profile Card (Sticky) --}}
                <div class="lg:col-span-4">
                    <div
                        class="bg-slate-900/80 border border-slate-800 rounded-2xl p-8 text-center sticky top-28 shadow-2xl backdrop-blur-xl">

                        {{-- Avatar with Ring --}}
                        <div class="relative inline-block mb-6">
                            <div
                                class="absolute -inset-1 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full opacity-75 blur">
                            </div>
                            <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                class="relative w-32 h-32 rounded-full border-4 border-slate-900 bg-slate-950 object-cover">
                        </div>

                        <h2 class="text-2xl font-bold text-white mb-1">{{ $user->name }}</h2>
                        <p class="text-blue-400 font-medium text-sm mb-4">{{ $user->jabatan ?? 'Fullstack Developer' }}</p>

                        {{-- Role Badge --}}
                        <div class="flex justify-center gap-2 mb-6">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold uppercase border
                                {{ $user->role === 'admin'
                                    ? 'bg-purple-500/10 text-purple-400 border-purple-500/20'
                                    : ($user->role === 'mentor'
                                        ? 'bg-amber-500/10 text-amber-400 border-amber-500/20'
                                        : 'bg-blue-500/10 text-blue-400 border-blue-500/20') }}">
                                {{ $user->role }}
                            </span>
                        </div>

                        {{-- Public Portfolio Link (SLUG) --}}
                        @if ($user->slug)
                            <a href="{{ route('guest.portofolio.index', $user->slug) }}" target="_blank"
                                class="mb-6 flex items-center justify-center gap-2 w-full py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 text-sm font-medium rounded-xl transition border border-slate-700 group">
                                <span>View Public Portfolio</span>
                                <i
                                    class="fa-solid fa-arrow-up-right-from-square text-xs text-slate-400 group-hover:text-white transition"></i>
                            </a>
                        @endif

                        {{-- Info List --}}
                        <div class="pt-6 border-t border-slate-800 text-left space-y-4 text-sm">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Email
                                    Address</label>
                                <div class="flex items-center gap-2 text-slate-300">
                                    <i class="fa-regular fa-envelope text-slate-500"></i>
                                    {{ $user->email }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Joined
                                    Date</label>
                                <div class="flex items-center gap-2 text-slate-300">
                                    <i class="fa-regular fa-calendar text-slate-500"></i>
                                    {{ $user->created_at->format('d M Y') }}
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Portfolio
                                    Slug</label>
                                <div
                                    class="flex items-center gap-2 text-slate-300 font-mono text-xs bg-slate-950 p-2 rounded border border-slate-800">
                                    <span class="truncate">/portfolio/view/{{ $user->slug }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Details Content --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Bio Section --}}
                    <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-indigo-500/10 border border-indigo-500/20 rounded-lg text-indigo-400">
                                <i class="fa-solid fa-user-tag"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Biography</h3>
                        </div>
                        <div class="prose prose-invert prose-sm max-w-none text-slate-400 leading-relaxed">
                            {{ $user->bio ?? 'User has not written a bio yet.' }}
                        </div>
                    </div>

                    {{-- Skills Section --}}
                    <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-blue-500/10 border border-blue-500/20 rounded-lg text-blue-400">
                                <i class="fa-solid fa-code"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Technical Skills</h3>
                        </div>

                        @if ($user->skill && $user->skill->skills)
                            <div class="flex flex-wrap gap-3">
                                @foreach ($user->skill->skills as $skill)
                                    @php
                                        // Ambil data baik dari object maupun array
                                        $skillName = is_object($skill)
                                            ? $skill->skill_name ?? ($skill->name ?? '')
                                            : $skill['skill_name'] ?? ($skill['name'] ?? '');
                                        $skillLevel = is_object($skill) ? $skill->level ?? '' : $skill['level'] ?? '';

                                        $badgeClass = match ($skillLevel) {
                                            'Expert',
                                            'Advanced'
                                                => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'Intermediate' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                            'Beginner' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            default => 'bg-slate-800 text-slate-300 border-slate-700',
                                        };
                                    @endphp
                                    <div
                                        class="px-4 py-2 border rounded-xl text-sm font-medium flex items-center gap-2 {{ $badgeClass }}">
                                        <span>{{ $skillName }}</span>
                                        @if ($skillLevel)
                                            <span class="w-1 h-1 rounded-full bg-current opacity-50"></span>
                                            <span class="text-xs opacity-80">{{ $skillLevel }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 border border-dashed border-slate-800 rounded-xl">
                                <p class="text-slate-500 text-sm">No skills added yet.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Projects Section --}}
                    <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-purple-500/10 border border-purple-500/20 rounded-lg text-purple-400">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white">Projects</h3>
                            </div>
                            <span
                                class="px-3 py-1 bg-slate-800 rounded-full text-xs text-slate-400 border border-slate-700">
                                {{ $user->projects->count() }} Items
                            </span>
                        </div>

                        @if ($user->projects->count() > 0)
                            <div class="space-y-4">
                                @foreach ($user->projects as $project)
                                    <div
                                        class="bg-slate-950 border border-slate-800 rounded-xl p-4 flex flex-col sm:flex-row gap-5 hover:border-slate-700 transition group">
                                        <div
                                            class="w-full sm:w-32 h-32 flex-shrink-0 rounded-lg overflow-hidden bg-slate-900">
                                            <img src="{{ $project->image_path ?? 'https://via.placeholder.com/300' }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                        </div>
                                        <div class="flex-1 flex flex-col justify-center">
                                            <h4
                                                class="text-lg font-bold text-white mb-2 group-hover:text-blue-400 transition">
                                                {{ $project->project_title }}</h4>
                                            <p class="text-slate-400 text-sm line-clamp-2 mb-4">{{ $project->description }}
                                            </p>

                                            <div class="flex items-center justify-between mt-auto">
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($project->tags ?? [] as $tag)
                                                        <span
                                                            class="px-2 py-0.5 bg-slate-800 border border-slate-700 rounded text-[10px] text-slate-400">
                                                            {{ $tag }}
                                                        </span>
                                                    @endforeach
                                                </div>

                                                @if ($project->project_link)
                                                    <a href="{{ $project->project_link }}" target="_blank"
                                                        class="text-blue-400 hover:text-white text-xs font-bold flex items-center gap-1 transition">
                                                        Visit <i
                                                            class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 border border-dashed border-slate-800 rounded-xl">
                                <div
                                    class="w-12 h-12 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-600">
                                    <i class="fa-regular fa-folder-open text-xl"></i>
                                </div>
                                <p class="text-slate-500 text-sm">No projects uploaded.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
