<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-display-lg text-ink">Buat Akun Baru</h2>
        <p class="text-body-sm text-muted mt-1">Daftar untuk mulai menggunakan BOM System</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="label-airbnb">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="input-airbnb"
                placeholder="Masukkan nama Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="label-airbnb">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="input-airbnb"
                placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="label-airbnb">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="input-airbnb"
                placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="label-airbnb">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="input-airbnb"
                placeholder="Ulangi password Anda" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit -->
        <div class="mt-6">
            <button type="submit" class="btn-primary w-full">
                <i class="mdi mdi-account-plus text-lg"></i>
                Daftar
            </button>
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-body-sm text-muted">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-rausch hover:text-rausch-active font-semibold transition">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
