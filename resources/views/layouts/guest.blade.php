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
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="flex flex-col lg:flex-row lg:min-h-screen">
        <!-- Left Side: Decorative Panel (Rausch gradient) -->
        <div class="min-h-screen lg:min-h-0 lg:w-1/2 relative overflow-hidden flex" style="background: linear-gradient(135deg, #ff385c 0%, #e00b41 60%, #bd1e59 100%);">
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
            <div class="relative z-10 flex flex-col justify-center items-center w-full px-8 sm:px-12 py-16 lg:py-0 text-white">
                <div class="mb-3">
                    <img src="{{ asset('images/Calculator-pana.png') }}" alt="Calculator Illustration" class="object-contain drop-shadow-lg" style="width: 14rem; height: 14rem;">
                </div>
                <h1 class="text-display-xl text-white text-center">BOM System</h1>
                <p class="text-body-sm text-white/80 text-center max-w-sm leading-relaxed mt-2">
                    Kelola Bill of Materials, resep, dan kalkulasi bahan baku Anda dengan mudah dan efisien.
                </p>
                <div class="mt-8 grid grid-cols-3 gap-8 text-center">
                    <div>
                        <i class="mdi mdi-chart-bar text-2xl text-white/90"></i>
                        <div class="text-caption-sm text-white/60 mt-1">Laporan</div>
                    </div>
                    <div>
                        <i class="mdi mdi-calculator-variant text-2xl text-white/90"></i>
                        <div class="text-caption-sm text-white/60 mt-1">Kalkulasi</div>
                    </div>
                    <div>
                        <i class="mdi mdi-package-variant-closed text-2xl text-white/90"></i>
                        <div class="text-caption-sm text-white/60 mt-1">Inventori</div>
                    </div>
                </div>
                <!-- Scroll indicator (mobile only) -->
                <div class="lg:hidden mt-8 animate-bounce">
                    <i class="mdi mdi-chevron-double-down text-2xl text-white/50"></i>
                </div>
            </div>
            <!-- Floating shapes -->
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/5 rounded-full"></div>
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
            <div class="absolute top-1/3 right-10 w-24 h-24 bg-white/5 rounded-full"></div>
        </div>

        <!-- Right Side: Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 sm:px-12 py-12 lg:py-0 bg-canvas min-h-screen lg:min-h-0">
            <div class="w-full max-w-md">
                <div class="card shadow-airbnb p-8 sm:p-10">
                    {{ $slot }}
                </div>

                <p class="text-center text-caption-sm text-muted mt-8">
                    &copy; {{ date('Y') }} make it easy.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
