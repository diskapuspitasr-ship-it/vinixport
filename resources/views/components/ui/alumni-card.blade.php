@props(['name', 'title', 'imageUrl'])

<div class="group relative">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-500"></div>
    <div class="relative bg-slate-900 border border-slate-800 p-6 rounded-2xl flex items-center space-x-4 h-full">
        <img class="w-16 h-16 rounded-full object-cover border-2 border-slate-700 group-hover:border-blue-500 transition-colors" src="{{ $imageUrl }}" alt="{{ $name }}" />
        <div>
            <h3 class="text-lg font-bold text-white group-hover:text-blue-300 transition-colors">
                {{ $name }}
            </h3>
            <p class="text-slate-400 text-sm">{{ $title }}</p>
        </div>
    </div>
</div>
