<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-display-lg text-ink">Masuk ke Akun</h2>
        <p class="text-body-sm text-muted mt-1">masuk ke System BOM
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="label-airbnb">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="input-airbnb"
                placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="label-airbnb">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="input-airbnb"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 rounded border-hairline text-rausch shadow-sm focus:ring-rausch focus:ring-offset-0 transition">
                <span class="ms-2 text-body-sm text-body">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-body-sm text-rausch hover:text-rausch-active font-medium transition" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <div class="mt-6">
            <button type="submit" class="btn-primary w-full">
                <i class="mdi mdi-login text-lg"></i>
                Masuk
            </button>
        </div>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <p class="text-body-sm text-muted">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-rausch hover:text-rausch-active font-semibold transition">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
