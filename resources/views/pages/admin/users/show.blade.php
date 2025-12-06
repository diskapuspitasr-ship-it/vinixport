@extends('layouts.master')

@section('title', 'User Detail - ' . $user->name)

@section('content')
    <div class="min-h-screen bg-slate-950 text-slate-200 pt-28 pb-12 px-4 font-sans">

        <div class="container mx-auto max-w-4xl">

            {{-- Back Button --}}
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-2 text-slate-400 hover:text-white mb-6 transition">
                <i class="fa-solid fa-arrow-left"></i> Back to Users
            </a>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Left: Profile Card --}}
                <div class="md:col-span-1">
                    <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 text-center sticky top-28">
                        <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                            class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-slate-800 bg-slate-950 object-cover">

                        <h2 class="text-2xl font-bold text-white mb-1">{{ $user->name }}</h2>
                        <p class="text-blue-400 font-medium">{{ $user->jabatan ?? 'No Title' }}</p>

                        <div class="mt-4 flex justify-center gap-2">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold uppercase border bg-slate-800 border-slate-700 text-slate-300">
                                {{ $user->role }}
                            </span>
                        </div>

                        <div class="mt-6 pt-6 border-t border-slate-800 text-left space-y-3 text-sm">
                            <div>
                                <label class="block text-xs text-slate-500 mb-1">Email</label>
                                <p class="text-white">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-slate-500 mb-1">Joined Date</label>
                                <p class="text-white">{{ $user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Details --}}
                <div class="md:col-span-2 space-y-6">

                    {{-- Bio --}}
                    <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Biography</h3>
                        <p class="text-slate-400 leading-relaxed whitespace-pre-line">
                            {{ $user->bio ?? 'User has not written a bio yet.' }}
                        </p>
                    </div>

                    {{-- Skills --}}
                    <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Skills</h3>
                        @if ($user->skill && $user->skill->skills)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($user->skill->skills as $skill)
                                    <span
                                        class="px-3 py-1 bg-slate-950 border border-slate-700 rounded-lg text-sm text-slate-300">
                                        {{-- PERBAIKAN DISINI: Gunakan -> karena cast 'object' --}}
                                        {{ $skill->skill_name ?? ($skill->name ?? '') }}
                                        <span class="text-slate-500 text-xs ml-1">({{ $skill->level ?? '' }})</span>
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-500 text-sm">No skills added.</p>
                        @endif
                    </div>

                    {{-- Projects --}}
                    <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Projects ({{ $user->projects->count() }})</h3>

                        @if ($user->projects->count() > 0)
                            <div class="space-y-4">
                                @foreach ($user->projects as $project)
                                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 flex gap-4">
                                        <img src="{{ $project->image_path ?? 'https://via.placeholder.com/100' }}"
                                            class="w-20 h-20 rounded-lg object-cover bg-slate-800">
                                        <div>
                                            <h4 class="font-bold text-white">{{ $project->project_title }}</h4>
                                            <p class="text-slate-400 text-sm line-clamp-1">{{ $project->description }}</p>
                                            <a href="{{ $project->project_link }}" target="_blank"
                                                class="text-blue-400 text-xs mt-2 inline-block hover:underline">View
                                                Project</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-500 text-sm">No projects uploaded.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
