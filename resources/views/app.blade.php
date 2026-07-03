<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>BOM System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen flex flex-col">

    <!-- Navigation (top-nav: white canvas, 80px height, 1px hairline bottom) -->
    <nav class="nav-airbnb">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex justify-between h-full">
                <!-- Logo & Links -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="font-bold text-display-sm text-rausch tracking-tight flex items-center gap-2.5">
                            <span class="w-9 h-9 rounded-airbnb-sm flex items-center justify-center text-white font-bold text-lg bg-rausch">b</span>
                            BOM System
                        </a>
                    </div>
                    <div class="hidden sm:ml-10 sm:flex sm:items-center sm:gap-1">
                        <a href="{{ route('dashboard') }}" class="nav-link-airbnb px-3 py-2 rounded-airbnb-sm {{ request()->routeIs('dashboard') ? 'nav-link-active' : 'nav-link-inactive' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('notes.index') }}" class="nav-link-airbnb px-3 py-2 rounded-airbnb-sm {{ request()->routeIs('notes.*') ? 'nav-link-active' : 'nav-link-inactive' }}">
                            Catatan
                        </a>
                        <a href="{{ route('menus.index') }}" class="nav-link-airbnb px-3 py-2 rounded-airbnb-sm {{ request()->routeIs('menus.*') ? 'nav-link-active' : 'nav-link-inactive' }}">
                            Menu & Resep
                        </a>
                        <a href="{{ route('ingredients.index') }}" class="nav-link-airbnb px-3 py-2 rounded-airbnb-sm {{ request()->routeIs('ingredients.*') ? 'nav-link-active' : 'nav-link-inactive' }}">
                            Bahan Baku
                        </a>
                        <a href="{{ route('reports.index') }}" class="nav-link-airbnb px-3 py-2 rounded-airbnb-sm {{ request()->routeIs('reports.*') ? 'nav-link-active' : 'nav-link-inactive' }}">
                            Laporan
                        </a>
                        <a href="{{ route('calculator.index') }}" class="nav-link-airbnb px-3 py-2 rounded-airbnb-sm {{ request()->routeIs('calculator.*') ? 'nav-link-active' : 'nav-link-inactive' }}">
                            <i class="mdi mdi-calculator-variant"></i> Hitung Cepat
                        </a>
                    </div>
                </div>

                <!-- User Dropdown (Desktop) -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center gap-2 px-4 py-2 text-body-sm font-medium text-body bg-surface-soft rounded-pill hover:shadow-airbnb transition-all duration-150 focus:outline-none border border-hairline">
                            <i class="mdi mdi-account-circle text-xl text-muted"></i>
                            {{ Auth::user()->name }}
                            <i class="mdi mdi-chevron-down text-muted transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-52 bg-canvas rounded-airbnb-md shadow-airbnb border border-hairline py-1 z-50" style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-body-sm text-ink hover:bg-surface-soft transition">
                                Profil Saya
                            </a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.index') }}" class="block px-4 py-2.5 text-body-sm text-ink hover:bg-surface-soft transition">
                                Kelola User
                            </a>
                            @endif
                            <div class="border-t border-hairline-soft my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2.5 text-body-sm text-rausch hover:bg-rausch-light transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-airbnb-sm text-muted hover:text-ink hover:bg-surface-soft focus:outline-none transition" aria-controls="mobile-menu" aria-expanded="false" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <span class="sr-only">Open main menu</span>
                        <i class="mdi mdi-menu text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="sm:hidden hidden border-t border-hairline" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1 bg-canvas">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-rausch-light border-rausch text-rausch' : 'border-transparent text-muted hover:bg-surface-soft hover:text-ink' }} block pl-4 pr-4 py-3 border-l-4 text-body-sm font-medium transition">Dashboard</a>
                <a href="{{ route('notes.index') }}" class="{{ request()->routeIs('notes.*') ? 'bg-rausch-light border-rausch text-rausch' : 'border-transparent text-muted hover:bg-surface-soft hover:text-ink' }} block pl-4 pr-4 py-3 border-l-4 text-body-sm font-medium transition">Catatan</a>
                <a href="{{ route('menus.index') }}" class="{{ request()->routeIs('menus.*') ? 'bg-rausch-light border-rausch text-rausch' : 'border-transparent text-muted hover:bg-surface-soft hover:text-ink' }} block pl-4 pr-4 py-3 border-l-4 text-body-sm font-medium transition">Menu & Resep</a>
                <a href="{{ route('ingredients.index') }}" class="{{ request()->routeIs('ingredients.*') ? 'bg-rausch-light border-rausch text-rausch' : 'border-transparent text-muted hover:bg-surface-soft hover:text-ink' }} block pl-4 pr-4 py-3 border-l-4 text-body-sm font-medium transition">Bahan Baku</a>
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'bg-rausch-light border-rausch text-rausch' : 'border-transparent text-muted hover:bg-surface-soft hover:text-ink' }} block pl-4 pr-4 py-3 border-l-4 text-body-sm font-medium transition">Laporan</a>
                <a href="{{ route('calculator.index') }}" class="{{ request()->routeIs('calculator.*') ? 'bg-rausch-light border-rausch text-rausch' : 'border-transparent text-muted hover:bg-surface-soft hover:text-ink' }} block pl-4 pr-4 py-3 border-l-4 text-body-sm font-medium transition"><i class="mdi mdi-calculator-variant"></i> Hitung Cepat</a>
            </div>
            @auth
            <div class="pt-4 pb-3 border-t border-hairline bg-canvas">
                <div class="flex items-center px-4 mb-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-rausch text-white flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-title-md text-ink">{{ Auth::user()->name }}</div>
                        <div class="text-body-sm text-muted">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}" class="border-transparent text-muted hover:bg-surface-soft hover:text-ink block pl-4 pr-4 py-3 border-l-4 text-body-sm font-medium transition">Profil Saya</a>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="border-transparent text-muted hover:bg-surface-soft hover:text-ink block pl-4 pr-4 py-3 border-l-4 text-body-sm font-medium transition">Kelola User</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left border-transparent text-rausch hover:bg-rausch-light block pl-4 pr-4 py-3 border-l-4 text-body-sm font-medium transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="alert-success mb-6" role="alert">
                    <i class="mdi mdi-check-circle text-xl text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-error mb-6" role="alert">
                    <i class="mdi mdi-alert-circle text-xl text-red-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error mb-6 flex-col items-start" role="alert">
                    <div class="flex items-center gap-3 mb-2 font-medium">
                        <i class="mdi mdi-alert text-xl text-red-500"></i>
                        Terdapat kesalahan pada inputan Anda:
                    </div>
                    <ul class="list-disc pl-10 text-body-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
            
        </div>
    </main>

    <!-- Footer (footer-light: white canvas, clean text) -->
    <footer class="bg-canvas border-t border-hairline mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-caption-sm text-muted">
                &copy; {{ date('Y') }} Made by Brewin staff</p>
        </div>
    </footer>

    @stack('modals')
    @stack('scripts')
</body>
</html>
