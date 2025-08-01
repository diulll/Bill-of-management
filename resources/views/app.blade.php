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
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Navigation -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Links -->
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="font-bold text-xl text-primary tracking-tight flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-lg" style="background: linear-gradient(135deg, #667eea, #764ba2);">b</span>
                            BOM System
                        </a>
                    </div>
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="{{ route('dashboard') }}" class="border-transparent text-slate-500 hover:border-primary hover:text-primary inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 {{ request()->routeIs('dashboard') ? 'border-primary text-primary' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('notes.index') }}" class="border-transparent text-slate-500 hover:border-primary hover:text-primary inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 {{ request()->routeIs('notes.*') ? 'border-primary text-primary' : '' }}">
                            Catatan
                        </a>
                        <a href="{{ route('menus.index') }}" class="border-transparent text-slate-500 hover:border-primary hover:text-primary inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 {{ request()->routeIs('menus.*') ? 'border-primary text-primary' : '' }}">
                            Menu & Resep
                        </a>
                        <a href="{{ route('ingredients.index') }}" class="border-transparent text-slate-500 hover:border-primary hover:text-primary inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 {{ request()->routeIs('ingredients.*') ? 'border-primary text-primary' : '' }}">
                            Bahan Baku
                        </a>
                        <a href="{{ route('reports.index') }}" class="border-transparent text-slate-500 hover:border-primary hover:text-primary inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 {{ request()->routeIs('reports.*') ? 'border-primary text-primary' : '' }}">
                            Laporan
                        </a>
                        <a href="{{ route('calculator.index') }}" class="border-transparent text-slate-500 hover:border-primary hover:text-primary inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 {{ request()->routeIs('calculator.*') ? 'border-primary text-primary' : '' }}">
                            <i class="mdi mdi-calculator-variant"></i> Hitung Cepat
                        </a>
                    </div>
                </div>

                <!-- User Dropdown (Desktop) -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-slate-600 bg-slate-50 rounded-lg hover:bg-slate-100 hover:text-slate-800 transition duration-150 focus:outline-none focus:ring-2 focus:ring-primary/30">
                            <i class="mdi mdi-account-circle text-xl text-slate-400"></i>
                            {{ Auth::user()->name }}
                            <i class="mdi mdi-chevron-down text-slate-400 transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-50" style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                                Profil Saya
                            </a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                                Kelola User
                            </a>
                            @endif
                            <div class="border-t border-slate-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary" aria-controls="mobile-menu" aria-expanded="false" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <span class="sr-only">Open main menu</span>
                        <i class="mdi mdi-menu text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden hidden" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="bg-indigo-50 border-primary text-primary block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Dashboard</a>
                <a href="{{ route('notes.index') }}" class="border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Catatan</a>
                <a href="{{ route('menus.index') }}" class="border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Menu & Resep</a>
                <a href="{{ route('ingredients.index') }}" class="border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Bahan Baku</a>
                <a href="{{ route('reports.index') }}" class="border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Laporan</a>
                <a href="{{ route('calculator.index') }}" class="border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"><i class="mdi mdi-calculator-variant"></i> Hitung Cepat</a>
            </div>
            @auth
            <div class="pt-4 pb-3 border-t border-slate-200">
                <div class="flex items-center px-4 mb-3">
                    <div class="flex-shrink-0">
                        <i class="mdi mdi-account-circle text-3xl text-slate-400"></i>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-slate-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-slate-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}" class="border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Profil Saya</a>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Kelola User</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left border-transparent text-red-600 hover:bg-red-50 hover:border-red-300 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
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
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative shadow-sm flex items-center gap-3" role="alert">
                    <i class="mdi mdi-check-circle text-xl text-green-500"></i>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative shadow-sm flex items-center gap-3" role="alert">
                    <i class="mdi mdi-alert-circle text-xl text-red-500"></i>
                    <span class="block sm:inline font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-lg relative shadow-sm" role="alert">
                    <div class="flex items-center gap-3 mb-2 font-medium">
                        <i class="mdi mdi-alert text-xl text-red-500"></i>
                        Terdapat kesalahan pada inputan Anda:
                    </div>
                    <ul class="list-disc pl-10 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
            
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-slate-500 text-medium">
                &copy; {{ date('Y') }} Made by Brewin staff</p>
        </div>
    </footer>

    @stack('modals')
    @stack('scripts')
</body>
</html>
