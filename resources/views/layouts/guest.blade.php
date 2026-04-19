<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>BOM System — Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="text-slate-800 antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side: Decorative Panel -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <circle cx="20" cy="20" r="1.5" fill="white"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)"/>
                </svg>
            </div>
            <div class="relative z-10 flex flex-col justify-center items-center w-full px-12 text-white">
                <div class="mb-8">
                    <span class="w-24 h-24 rounded-2xl flex items-center justify-center text-indigo-600 font-bold text-6xl bg-white/20 backdrop-blur-sm border border-white/30 shadow-lg">b</span>
                </div>
                <h1 class="text-4xl font-bold mb-4 text-center">BOM System</h1>
                <p class="text-lg text-white/80 text-center max-w-sm leading-relaxed">
                    Kelola Bill of Materials, resep, dan kalkulasi bahan baku Anda dengan mudah dan efisien.
                </p>
                <div class="mt-12 grid grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="text-3xl font-bold text-white/90">📊</div>
                        <div class="text-sm text-white/60 mt-2">Laporan</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-white/90">🧮</div>
                        <div class="text-sm text-white/60 mt-2">Kalkulasi</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-white/90">📦</div>
                        <div class="text-sm text-white/60 mt-2">Inventori</div>
                    </div>
                </div>
            </div>
            <!-- Floating shapes -->
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/5 rounded-full"></div>
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
            <div class="absolute top-1/3 right-10 w-24 h-24 bg-white/5 rounded-full"></div>
        </div>

        <!-- Right Side: Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 sm:px-12 bg-slate-50">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center justify-center mb-8">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-xl" style="background: linear-gradient(135deg, #667eea, #764ba2);">b</span>
                        <span class="text-2xl font-bold text-slate-800">BOM System</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-8 sm:p-10 border border-slate-100">
                    {{ $slot }}
                </div>

                <p class="text-center text-sm text-slate-400 mt-8">
                    &copy; {{ date('Y') }} BOM System. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
