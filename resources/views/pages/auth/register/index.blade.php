<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - VinixPort</title>

    {{-- Tailwind CSS (CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-950 text-slate-200 font-sans antialiased selection:bg-blue-500 selection:text-white">

    <div class="min-h-screen flex items-center justify-center relative overflow-hidden font-sans">

        {{-- Background Effects --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
                <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-blue-600/20 blur-[120px]">
                </div>
                <div class="absolute top-[40%] -right-[10%] w-[40%] h-[40%] rounded-full bg-purple-600/10 blur-[100px]">
                </div>
            </div>
        </div>

        <div class="relative z-10 w-full max-w-md px-6 py-12">

            {{-- Header Logo --}}
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-6 group">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform duration-300">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="text-white transform rotate-3">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>
                <h2 class="text-3xl font-bold text-white tracking-tight mb-2">Create Account</h2>
                <p class="text-slate-400">Start building your professional portfolio</p>
            </div>

            <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 shadow-2xl rounded-2xl p-8">

                {{-- Error Handling Alert --}}
                @if ($errors->any())
                    <div
                        class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm mb-6 flex items-start gap-3">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form Register --}}
                <form action="{{ route('guest.register.store') }}" method="POST" class="space-y-5"
                    x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    {{-- Full Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-1.5">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all"
                            placeholder="Alex Doe" />
                    </div>

                    {{-- Email Address --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email
                            Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all"
                            placeholder="you@example.com" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all"
                            placeholder="Minimum 8 characters" />
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-slate-300 mb-1.5">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all"
                            placeholder="Re-enter your password" />
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" :disabled="loading"
                        class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow-lg shadow-blue-600/20 hover:shadow-blue-600/40 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2 mt-2">
                        <svg x-show="loading" style="display: none;" class="animate-spin h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span x-text="loading ? 'Creating Account...' : 'Create Account'">Create Account</span>
                    </button>
                </form>
            </div>

            <p class="mt-8 text-center text-slate-500 text-sm">
                Already have an account?
                <a href="{{ route('guest.login.index') }}"
                    class="font-bold text-white hover:text-blue-400 transition-colors">
                    Sign In
                </a>
            </p>
        </div>
    </div>
</body>

</html>
