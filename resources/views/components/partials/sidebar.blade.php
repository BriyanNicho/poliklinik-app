<aside id="dashboard-sidebar" class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col bg-slate-900 text-slate-300 transition-transform lg:static lg:translate-x-0">
    <div class="border-b border-white/10 px-5 py-5">
        <div class="text-lg font-bold text-white">Poliklinik</div>
        <div class="mt-1 text-xs font-semibold uppercase tracking-wider text-primary-content/70">
            {{ ucfirst(auth()->user()->role) }}
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-5">
        @if (auth()->user()->role === 'admin')
            <p class="px-3 text-xs font-bold uppercase tracking-widest text-indigo-300">Menu Admin</p>
            <a href="{{ route('admin.dashboard') }}"
                class="mt-3 flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm transition hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 font-semibold text-white' : '' }}">
                Dashboard Admin
            </a>
        @elseif (auth()->user()->role === 'dokter')
            <p class="px-3 text-xs font-bold uppercase tracking-widest text-purple-300">Menu Dokter</p>
            <a href="{{ route('dokter.dashboard') }}"
                class="mt-3 flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm transition hover:bg-white/10 hover:text-white {{ request()->routeIs('dokter.dashboard') ? 'bg-white/15 font-semibold text-white' : '' }}">
                Dashboard Dokter
            </a>
        @else
            <p class="px-3 text-xs font-bold uppercase tracking-widest text-amber-300">Menu Pasien</p>
            <a href="{{ route('pasien.dashboard') }}"
                class="mt-3 flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm transition hover:bg-white/10 hover:text-white {{ request()->routeIs('pasien.dashboard') ? 'bg-white/15 font-semibold text-white' : '' }}">
                Dashboard Pasien
            </a>
            <a href="{{ route('pasien.daftar-poli.index') }}"
                class="mt-1 flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm transition hover:bg-white/10 hover:text-white {{ request()->routeIs('pasien.daftar-poli.*') ? 'bg-white/15 font-semibold text-white' : '' }}">
                Pendaftaran Poli
            </a>
        @endif
    </nav>

    <div class="border-t border-white/10 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-error btn-sm w-full text-white">Keluar</button>
        </form>
    </div>
</aside>

<div class="fixed inset-0 z-30 hidden bg-black/40 lg:hidden" onclick="toggleSidebar()"></div>
