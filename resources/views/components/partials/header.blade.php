<header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-base-300 bg-base-100 px-4 shadow-sm lg:px-6">
    <button type="button" onclick="toggleSidebar()" class="btn btn-square btn-ghost lg:hidden" aria-label="Buka menu">
        <span class="text-xl">☰</span>
    </button>

    <div class="flex-1">
        <div class="flex items-center gap-2 text-sm">
            <span class="text-base-content/50">Poliklinik</span>
            <span class="text-base-content/30">/</span>
            <span class="font-semibold">{{ $title ?? 'Dashboard' }}</span>
        </div>
    </div>

    <button type="button" onclick="toggleFullscreen()" class="btn btn-square btn-ghost hidden sm:inline-flex" aria-label="Layar penuh">
        <span id="fsIcon">⛶</span>
    </button>

    <div class="avatar placeholder">
        <div class="w-10 rounded-full bg-primary text-primary-content">
            <span>{{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 1)) }}</span>
        </div>
    </div>
    <div class="hidden text-right sm:block">
        <div class="text-sm font-semibold">{{ auth()->user()->nama ?? 'Pengguna' }}</div>
        <div class="text-xs capitalize text-base-content/50">{{ auth()->user()->role ?? 'Pengguna' }}</div>
    </div>
</header>

<script>
    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            document.getElementById('fsIcon').textContent = '⛶';
        } else {
            document.exitFullscreen();
            document.getElementById('fsIcon').textContent = '⛶';
        }
    }

    function toggleSidebar() {
        document.getElementById('dashboard-sidebar').classList.toggle('-translate-x-full');
    }
</script>
