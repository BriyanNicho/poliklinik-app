<x-layouts.guest title="Login - Poliklinik">
    <main class="w-full max-w-md overflow-hidden rounded-3xl bg-base-100 shadow-2xl">
        <div class="bg-primary px-8 py-7 text-primary-content">
            <div class="flex items-center gap-3">
                <div class="grid size-12 place-items-center rounded-2xl bg-white/15 text-2xl font-bold">P</div>
                <div>
                    <p class="text-lg font-bold">Poliklinik</p>
                    <p class="text-xs text-primary-content/75">Layanan kesehatan terpadu</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <h1 class="text-2xl font-bold">Selamat datang kembali</h1>
            <p class="mt-2 text-sm text-base-content/60">Masuk untuk melanjutkan ke akun kamu.</p>

            @if ($errors->any())
                <div class="alert alert-error mt-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success mt-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
                @csrf
                <label class="form-control w-full text-sm font-medium">
                    Email
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="nama@email.com" class="input input-bordered mt-1 w-full">
                </label>
                <label class="form-control w-full text-sm font-medium">
                    Password
                    <input type="password" name="password" required placeholder="Masukkan password"
                        class="input input-bordered mt-1 w-full">
                </label>
                <label class="flex items-center gap-2 text-sm text-base-content/60">
                    <input type="checkbox" name="remember" value="1" class="checkbox checkbox-sm checkbox-primary">
                    Ingat saya
                </label>
                <button class="btn btn-primary w-full">Masuk ke akun</button>
            </form>

            <p class="mt-6 text-center text-sm text-base-content/60">
                Belum punya akun?
                <a href="{{ route('register') }}" class="link link-primary font-semibold">Daftar sekarang</a>
            </p>
        </div>
    </main>
</x-layouts.guest>
