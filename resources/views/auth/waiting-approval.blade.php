<x-guest-layout>
    <div class="text-center">
        <div class="mb-6">
            <div class="mx-auto w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-slate-800 mb-2">Menunggu Persetujuan</h2>
        <p class="text-slate-500 leading-relaxed mb-6">
            Akun Anda telah berhasil didaftarkan. Silakan tunggu hingga <strong>Admin</strong> menyetujui akun Anda sebelum dapat mengakses sistem.
        </p>

        <div class="bg-amber-50 border border-amber-200 rounded-lg px-4 py-3 mb-6">
            <div class="flex items-center justify-center gap-2 text-amber-700 text-sm font-medium">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Status: Menunggu persetujuan admin...
            </div>
        </div>

        <p class="text-xs text-slate-400 mb-6">
            Anda login sebagai <strong>{{ auth()->user()->email }}</strong>
        </p>

        <div class="flex items-center justify-center gap-3">
            <a href="{{ route('approval.waiting') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 active:scale-95 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Cek Ulang
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 active:scale-95 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
