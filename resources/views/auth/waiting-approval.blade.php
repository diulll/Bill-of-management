<x-guest-layout>
    <div class="text-center">
        <div class="mb-6">
            <div class="mx-auto w-16 h-16 rounded-full bg-rausch-light flex items-center justify-center">
                <i class="mdi mdi-clock-outline text-3xl text-rausch"></i>
            </div>
        </div>

        <h2 class="text-display-lg text-ink mb-2">Menunggu Persetujuan</h2>
        <p class="text-body-sm text-muted leading-relaxed mb-6">
            Akun Anda telah berhasil didaftarkan. Silakan tunggu hingga <strong>Admin</strong> menyetujui akun Anda sebelum dapat mengakses sistem.
        </p>

        <div class="bg-rausch-light border border-rausch/20 rounded-airbnb-sm px-4 py-3 mb-6">
            <div class="flex items-center justify-center gap-2 text-rausch text-body-sm font-medium">
                <i class="mdi mdi-loading mdi-spin text-lg"></i>
                Status: Menunggu persetujuan admin...
            </div>
        </div>

        <p class="text-caption-sm text-muted mb-6">
            Anda login sebagai <strong>{{ auth()->user()->email }}</strong>
        </p>

        <div class="flex items-center justify-center gap-3">
            <a href="{{ route('approval.waiting') }}" class="btn-secondary btn-sm">
                <i class="mdi mdi-refresh text-lg"></i>
                Cek Ulang
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-body-sm font-medium text-rausch bg-rausch-light rounded-airbnb-sm hover:bg-red-100 active:scale-[0.97] transition-all duration-150">
                    <i class="mdi mdi-logout text-lg"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
