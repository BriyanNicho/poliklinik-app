<header class="sticky top-0 z-30 flex min-h-16 items-center gap-3 border-b border-base-300/80 bg-base-100/95 px-4 shadow-sm backdrop-blur lg:gap-4 lg:px-8">
    <button type="button" onclick="toggleSidebar()" class="btn btn-square btn-ghost lg:hidden" aria-label="Buka menu" aria-controls="dashboard-sidebar">
        <i class="fas fa-bars text-lg"></i>
    </button>

    <div class="flex-1">
        <div class="flex items-center gap-2 text-sm">
            <span class="hidden text-base-content/50 sm:inline">Poliklinik</span>
            <span class="hidden text-base-content/30 sm:inline">/</span>
            <span class="truncate font-semibold">{{ $title ?? 'Dashboard' }}</span>
        </div>
    </div>

    <button type="button" onclick="toggleFullscreen()" class="btn btn-square btn-ghost hidden sm:inline-flex" aria-label="Layar penuh">
        <span id="fsIcon">⛶</span>
    </button>

    <div class="avatar placeholder">
        <div class="w-9 rounded-xl bg-primary text-primary-content shadow-sm">
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
            document.documentElement.requestFullscreen().catch(() => {});
            document.getElementById('fsIcon').textContent = '⛶';
        } else {
            document.exitFullscreen();
            document.getElementById('fsIcon').textContent = '⛶';
        }
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('dashboard-sidebar');
        const overlay = document.getElementById('dashboard-sidebar-overlay');
        const isClosed = sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden', isClosed);
    }
</script>
