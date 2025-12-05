@props(['title', 'description'])

<div class="group relative p-8 bg-slate-900 border border-slate-800 rounded-2xl hover:border-blue-500/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-500/10 overflow-hidden">
    {{-- Hover Gradient Blob --}}
    <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-600/20 rounded-full blur-3xl group-hover:bg-blue-600/30 transition-all duration-500"></div>

    <div class="relative z-10">
        <div class="w-14 h-14 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
            {{-- Slot untuk Icon SVG --}}
            {{ $icon }}
        </div>
        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors">{{ $title }}</h3>
        <p class="text-slate-400 leading-relaxed text-sm">{{ $description }}</p>
    </div>
</div>
