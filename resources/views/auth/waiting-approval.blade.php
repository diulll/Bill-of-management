<x-guest-layout>
    <div class="text-center">
        <div class="mb-6">
            <div class="mx-auto w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center">
                <i class="mdi mdi-clock-outline text-3xl text-amber-500"></i>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-slate-800 mb-2">Menunggu Persetujuan</h2>
        <p class="text-slate-500 leading-relaxed mb-6">
            Akun Anda telah berhasil didaftarkan. Silakan tunggu hingga <strong>Admin</strong> menyetujui akun Anda sebelum dapat mengakses sistem.
        </p>

        <div class="bg-amber-50 border border-amber-200 rounded-lg px-4 py-3 mb-6">
            <div class="flex items-center justify-center gap-2 text-amber-700 text-sm font-medium">
                <i class="mdi mdi-loading mdi-spin text-lg"></i>
                Status: Menunggu persetujuan admin...
            </div>
        </div>

        <p class="text-xs text-slate-400 mb-6">
            Anda login sebagai <strong>{{ auth()->user()->email }}</strong>
        </p>

        <div class="flex items-center justify-center gap-3">
            <a href="{{ route('approval.waiting') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 active:scale-95 transition-all duration-150">
                <i class="mdi mdi-refresh text-lg"></i>
                Cek Ulang
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 active:scale-95 transition-all duration-150">
                    <i class="mdi mdi-logout text-lg"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
