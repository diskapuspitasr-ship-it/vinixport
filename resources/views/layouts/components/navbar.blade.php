<nav x-data="{ mobileMenuOpen: false, scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="{ 'bg-slate-950/80 backdrop-blur-md border-slate-800 py-3': scrolled || mobileMenuOpen, 'bg-transparent border-transparent py-5': !scrolled && !mobileMenuOpen }"
     class="fixed top-0 w-full z-50 transition-all duration-300 border-b">

    <div class="container flex flex-wrap justify-between items-center mx-auto px-6">

        {{-- Logo Section --}}
        <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? url('/admin') : url('/portfolio')) : url('/') }}"
           class="flex items-center gap-3 group">

            {{-- Logo Icon (Inline SVG) --}}
            <div class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 shadow-lg shadow-blue-500/20">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-white transform rotate-3">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <span class="self-center text-xl font-bold tracking-tight text-white">
                Vinix<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">Port</span>
            </span>
        </a>

        {{-- Desktop Actions (Right Side) --}}
        <div class="flex items-center md:order-2">
            <div class="hidden md:flex items-center gap-4">
                @auth
                    {{-- Logged In View --}}
                    <div class="flex items-center gap-4 pl-4 border-l border-slate-800">
                        <div class="text-right hidden lg:block">
                            <p class="text-xs text-slate-400">Signed in as {{ Auth::user()->role === 'admin' ? 'Admin' : 'User' }}</p>
                            <p class="text-sm font-bold text-white">{{ explode(' ', Auth::user()->name)[0] }}</p>
                        </div>

                        {{-- Logout Form (Laravel Security Best Practice) --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-slate-300 hover:text-white hover:bg-red-500/10 hover:border-red-500/50 border border-transparent px-4 py-2 rounded-full text-sm font-medium transition-all duration-300">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Guest View --}}
                    <a href="{{ route('guest.login.index') }}" class="text-slate-300 hover:text-white font-medium text-sm transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('guest.register.index') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-blue-600/20 transition-all transform hover:-translate-y-0.5">
                        Daftar Gratis
                    </a>
                @endauth
            </div>

            {{-- Hamburger Button (Mobile) --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                    type="button"
                    class="inline-flex items-center p-2 ml-3 text-slate-400 rounded-lg md:hidden hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-700 transition-colors">
                <span class="sr-only">Open main menu</span>
                {{-- Icon Toggle based on state --}}
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Desktop Navigation Links (Center) --}}
        <div class="hidden md:flex justify-between items-center w-full md:w-auto md:order-1" id="mobile-menu">
            <ul class="flex flex-col mt-4 md:flex-row md:space-x-2 md:mt-0 font-medium">
                @guest
                    <li><x-nav-link href="{{ url('/') }}" :active="request()->is('/')">Home</x-nav-link></li>
                @endguest

                @auth
                    @if(Auth::user()->role !== 'admin')
                        <li><x-nav-link href="{{ route('user.assessment.index') }}" :active="request()->is('assessment*')">Assessment</x-nav-link></li>
                        <li><x-nav-link href="{{ route('user.portfolio.index') }}" :active="request()->is('portfolio*')">Portfolio</x-nav-link></li>
                        <li><x-nav-link href="{{ route('user.upload.index') }}" :active="request()->is('upload*')">Upload</x-nav-link></li>
                        <li><x-nav-link href="{{ route('user.analytic.index') }}" :active="request()->is('analytics*')">Analytics</x-nav-link></li>
                    @else
                        <li><x-nav-link href="{{ route('admin.dashboard.index') }}" :active="request()->routeIs('admin.dashboard.index')">Dashboard</x-nav-link></li>
                        <li><x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">Users</x-nav-link></li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>

    {{-- Mobile Menu Dropdown --}}
    <div :class="{'max-h-screen opacity-100': mobileMenuOpen, 'max-h-0 opacity-0': !mobileMenuOpen}"
         class="md:hidden transition-all duration-300 ease-in-out overflow-hidden bg-slate-950 border-t border-slate-800 shadow-2xl">
        <div class="px-6 pt-4 pb-8">
            <ul class="flex flex-col space-y-3">
                @guest
                    <li><x-nav-link href="{{ url('/') }}" :active="request()->is('/')" @click="mobileMenuOpen = false">Home</x-nav-link></li>
                @endguest

                @auth
                    @if(Auth::user()->role !== 'admin')
                        <li><x-nav-link href="{{ route('user.assessment.index') }}" :active="request()->is('assessment*')" @click="mobileMenuOpen = false">Skill Assessment</x-nav-link></li>
                        <li><x-nav-link href="{{ route('user.portfolio.index') }}" :active="request()->is('portfolio*')" @click="mobileMenuOpen = false">My Portfolio</x-nav-link></li>
                        <li><x-nav-link href="{{ route('user.upload.index') }}" :active="request()->is('upload*')" @click="mobileMenuOpen = false">Upload Project</x-nav-link></li>
                        <li><x-nav-link href="{{ route('user.analytic.index') }}" :active="request()->is('analytics*')" @click="mobileMenuOpen = false">Analytics</x-nav-link></li>
                    @else
                        <li><x-nav-link href="{{ route('admin.dashboard.index') }}" :active="request()->routeIs('admin.dashboard.index')" @click="mobileMenuOpen = false">Dashboard</x-nav-link></li>
                        <li><x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')" @click="mobileMenuOpen = false">Users</x-nav-link></li>
                    @endif
                @endauth

                <li class="border-t border-slate-800 my-2 pt-4">
                    @auth
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500"></div>
                                <span class="text-white font-semibold">{{ Auth::user()->name }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-center py-3 bg-red-500/10 text-red-400 rounded-xl font-semibold border border-red-500/20 hover:bg-red-500/20 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('guest.login.index') }}" class="w-full text-center py-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-xl font-medium transition">
                                Login
                            </a>
                            <a href="{{ route('guest.register.index') }}" class="w-full text-center py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-900/50">
                                Daftar Gratis
                            </a>
                        </div>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>
