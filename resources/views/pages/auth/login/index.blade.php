<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - VinixPort</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js (Untuk interaksi loading state) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-950 text-slate-200 font-sans antialiased selection:bg-blue-500 selection:text-white">
    <div
        class="min-h-screen pt-10 flex items-center justify-center bg-slate-950 relative overflow-hidden font-sans selection:bg-blue-500 selection:text-white">

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
                <h2 class="text-3xl font-bold text-white tracking-tight mb-2">Welcome Back</h2>
                <p class="text-slate-400">Sign in to continue your journey</p>
            </div>

            <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 shadow-2xl rounded-2xl p-8">

                {{-- Alert: Success (Biasanya setelah Register) --}}
                @if (session('success') || session('status'))
                    <div
                        class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm mb-6 flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') ?? session('status') }}</span>
                    </div>
                @endif

                {{-- Alert: Error (Validation or Credentials) --}}
                @if ($errors->any())
                    <div
                        class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm mb-6 flex items-start gap-3">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Demo Hint Box --}}
                {{-- <div class="bg-blue-500/5 border border-blue-500/10 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        <p class="text-xs font-bold text-blue-400 uppercase tracking-wider">Demo Account</p>
                    </div>
                    <div class="grid grid-cols-1 gap-1 text-sm font-mono text-slate-400">
                        <div class="flex justify-between">
                            <span>User Email:</span>
                            <span class="text-slate-300 select-all cursor-copy">john.doe@example.com</span>
                        </div>
                        <div class="flex justify-between">
                            <span>User Pass:</span>
                            <span class="text-slate-300 select-all cursor-copy">password123</span>
                        </div>
                        <div
                            class="mt-3 pt-3 border-t border-slate-800 text-xs text-slate-500 font-semibold uppercase tracking-wider">
                            Mentor Demo
                        </div>
                        <div class="flex justify-between">
                            <span>Mentor Email:</span>
                            <span class="text-slate-300 select-all cursor-copy">mentor@vinixport.com</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Mentor Pass:</span>
                            <span class="text-slate-300 select-all cursor-copy">password123</span>
                        </div>
                    </div>
                </div> --}}

                {{-- Login Form --}}
                <form action="{{ route('guest.login.store') }}" method="POST" class="space-y-5" x-data="{ loading: false }"
                    @submit="loading = true">
                    @csrf

                    {{-- Email Input --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email
                            Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            autofocus
                            class="w-full px-4 py-3 bg-slate-950 border @error('email') border-red-500/50 focus:border-red-500 focus:ring-red-500/50 @else border-slate-800 focus:border-blue-500 focus:ring-blue-500/50 @enderror rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 transition-all"
                            placeholder="you@example.com" />
                    </div>

                    {{-- Password Input --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-slate-300">Password</label>
                            <a href="#"
                                class="text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors">Forgot
                                password?</a>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all"
                            placeholder="••••••••" />
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="w-4 h-4 text-blue-600 bg-slate-950 border-slate-800 rounded focus:ring-blue-500 focus:ring-offset-slate-900 cursor-pointer" />
                        <label for="remember-me"
                            class="ml-2 block text-sm text-slate-400 cursor-pointer select-none">Remember me</label>
                    </div>

                    <button type="submit" :disabled="loading"
                        class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow-lg shadow-blue-600/20 hover:shadow-blue-600/40 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2">

                        {{-- Spinner Icon --}}
                        <svg x-show="loading" style="display: none;" class="animate-spin h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>

                        <span x-text="loading ? 'Signing In...' : 'Sign In'">Sign In</span>
                    </button>
                </form>
            </div>

            <p class="mt-8 text-center text-slate-500 text-sm">
                Don't have an account?
                <a href="{{ route('guest.register.index') }}"
                    class="font-bold text-white hover:text-blue-400 transition-colors">
                    Create an account
                </a>
            </p>
        </div>
    </div>
</body>

</html>
