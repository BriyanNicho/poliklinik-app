<x-layouts.guest title="Register - Poliklinik">
    <main class="w-full max-w-2xl overflow-hidden rounded-3xl bg-base-100 shadow-2xl">
        <div class="bg-primary px-8 py-7 text-primary-content">
            <div class="flex items-center gap-3">
                <div class="grid size-12 place-items-center rounded-2xl bg-white/15 text-2xl font-bold">P</div>
                <div>
                    <p class="text-lg font-bold">Poliklinik</p>
                    <p class="text-xs text-primary-content/75">Pendaftaran pasien baru</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <h1 class="text-2xl font-bold">Buat akun pasien</h1>
            <p class="mt-2 text-sm text-base-content/60">Lengkapi data berikut untuk mendaftar.</p>

            @if ($errors->any())
                <div class="alert alert-error mt-6 text-sm">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="mt-6 grid gap-4 sm:grid-cols-2">
                @csrf
                <label class="form-control w-full text-sm font-medium">
                    Nama lengkap
                    <input type="text" name="nama" value="{{ old('nama') }}" required autofocus
                        placeholder="Nama sesuai identitas" class="input input-bordered mt-1 w-full">
                </label>
                <label class="form-control w-full text-sm font-medium">
                    Nomor KTP
                    <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" inputmode="numeric"
                        minlength="16" maxlength="16" required placeholder="16 digit nomor KTP"
                        class="input input-bordered mt-1 w-full">
                </label>
                <label class="form-control w-full text-sm font-medium sm:col-span-2">
                    Alamat
                    <textarea name="alamat" required placeholder="Alamat lengkap"
                        class="textarea textarea-bordered mt-1 w-full">{{ old('alamat') }}</textarea>
                </label>
                <label class="form-control w-full text-sm font-medium">
                    Nomor HP
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" inputmode="tel" required
                        placeholder="08xxxxxxxxxx" class="input input-bordered mt-1 w-full">
                </label>
                <label class="form-control w-full text-sm font-medium">
                    Email
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="nama@email.com" class="input input-bordered mt-1 w-full">
                </label>
                <label class="form-control w-full text-sm font-medium">
                    Password
                    <input type="password" name="password" required placeholder="Minimal 8 karakter"
                        class="input input-bordered mt-1 w-full">
                </label>
                <label class="form-control w-full text-sm font-medium">
                    Konfirmasi password
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                        class="input input-bordered mt-1 w-full">
                </label>
                <button class="btn btn-primary mt-2 w-full sm:col-span-2">Buat akun pasien</button>
            </form>

            <p class="mt-6 text-center text-sm text-base-content/60">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="link link-primary font-semibold">Masuk di sini</a>
            </p>
        </div>
    </main>
</x-layouts.guest>
