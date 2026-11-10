@php
    $baseLink = 'flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm transition hover:bg-white/10 hover:text-white';
    $active = 'bg-white/15 font-semibold text-white';
    $inactive = '';
@endphp

<aside id="dashboard-sidebar" class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col bg-slate-950 text-slate-300 shadow-2xl transition-transform lg:static lg:translate-x-0 lg:shadow-none">
    <div class="border-b border-white/10 px-6 py-6">
        <div class="flex items-center gap-3">
            <div class="grid size-10 place-items-center rounded-xl bg-primary text-lg font-bold text-primary-content shadow-lg shadow-primary/20">P</div>
            <div class="text-lg font-bold text-white">Poliklinik</div>
        </div>
        <div class="mt-3 text-xs font-semibold uppercase tracking-wider text-primary-content/70">
            {{ ucfirst(auth()->user()->role) }}
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-5">
        @if (auth()->user()->role === 'admin' || request()->is('admin*'))
            <p class="px-3 text-xs font-bold uppercase tracking-widest text-indigo-300">Menu Admin</p>
            <div class="mt-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ $baseLink }} {{ request()->routeIs('admin.dashboard') ? $active : $inactive }}">
                    <i class="fas fa-gauge w-4 text-center"></i>
                    Dashboard Admin
                </a>

                <a href="{{ route('polis.index') }}"
                    class="{{ $baseLink }} {{ request()->routeIs('polis.*') ? $active : $inactive }}">
                    <i class="fas fa-hospital w-4 text-center"></i>
                    Manajemen Poli
                </a>

                <a href="{{ route('dokter.index') }}"
                    class="{{ $baseLink }} {{ request()->routeIs('dokter.*') ? $active : $inactive }}">
                    <i class="fas fa-user-doctor w-4 text-center"></i>
                    Manajemen Dokter
                </a>

                <a href="{{ route('pasien.index') }}"
                    class="{{ $baseLink }} {{ request()->routeIs('pasien.*') ? $active : $inactive }}">
                    <i class="fas fa-bed-pulse w-4 text-center"></i>
                    Manajemen Pasien
                </a>

                <a href="{{ route('obat.index') }}"
                    class="{{ $baseLink }} {{ request()->routeIs('obat.*') ? $active : $inactive }}">
                    <i class="fas fa-pills w-4 text-center"></i>
                    Manajemen Obat
                </a>
            </div>
        @elseif (auth()->user()->role === 'dokter' || request()->is('dokter*'))
            {{-- ================ DOKTER ================ --}}
            <p class="mt-1 px-3 text-xs font-bold uppercase tracking-widest text-indigo-300">
                Menu Dokter
            </p>

            <div class="mt-3 space-y-1">
                <a href="{{ route('dokter.dashboard') }}"
                   class="{{ $baseLink }} {{ request()->routeIs('dokter.dashboard') ? $active : $inactive }}">
                    <i class="fas fa-stethoscope w-4 text-center"></i>
                    Dashboard Dokter
                </a>

                <a href="{{ route('jadwal-periksa.index') }}"
                   class="{{ $baseLink }} {{ request()->routeIs('jadwal-periksa.*') ? $active : $inactive }}">
                    <i class="fas fa-calendar-days w-4 text-center"></i>
                    Jadwal Periksa
                </a>

                <a href="{{ route('periksa-pasien.index') }}"
                   class="{{ $baseLink }} {{ request()->routeIs('periksa-pasien.*') ? $active : $inactive }}">
                    <i class="fas fa-notes-medical w-4 text-center"></i>
                    Periksa Pasien
                </a>

                <a href="{{ route('riwayat-pasien.index') }}"
                   class="{{ $baseLink }} {{ request()->routeIs('riwayat-pasien.*') ? $active : $inactive }}">
                    <i class="fas fa-clock-rotate-left w-4 text-center"></i>
                    Riwayat Pasien
                </a>
            </div>
        @else
            <p class="px-3 text-xs font-bold uppercase tracking-widest text-amber-300">Menu Pasien</p>
            <div class="mt-3 space-y-1">
                <a href="{{ route('pasien.dashboard') }}"
                    class="{{ $baseLink }} {{ request()->routeIs('pasien.dashboard') ? $active : $inactive }}">
                    Dashboard Pasien
                </a>
                <a href="{{ route('pasien.daftar-poli.index') }}"
                    class="{{ $baseLink }} {{ request()->routeIs('pasien.daftar-poli.*') ? $active : $inactive }}">
                    Pendaftaran Poli
                </a>
            </div>
        @endif
    </nav>

    <div class="border-t border-white/10 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-error btn-sm w-full text-white">Keluar</button>
        </form>
    </div>
</aside>

<div id="dashboard-sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden" onclick="toggleSidebar()"></div>
