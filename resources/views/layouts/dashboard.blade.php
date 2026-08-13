<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra DPMPTSP - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Role-based visibility toggles */
        html.role_umkm .besar-only { display: none !important; }
        html.role_besar .umkm-only { display: none !important; }
    </style>
    <script>
        // Set the initial role BEFORE rendering the body to prevent layout shift
        const userRole = localStorage.getItem('userRole') || 'role_besar';
        document.documentElement.classList.add(userRole);
    </script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased h-screen flex flex-col md:flex-row overflow-hidden relative">
    
    <!-- Mobile Header (Only on Beranda) -->
    @if(request()->is('rfp-saya'))
    <header class="md:hidden bg-white border-b border-slate-200 h-16 flex items-center justify-between px-4 sticky top-0 z-40 shrink-0">
        <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-blue-600 inline-block"></span>
            Mitra DPMPTSP
        </h1>
    </header>
    @endif

    <!-- Sidebar (Desktop Only) -->
    <aside id="sidebar" x-data="{ profileMenuOpen: false }" @mouseleave="profileMenuOpen = false" class="hidden md:flex absolute inset-y-0 left-0 z-50 w-16 hover:w-64 group bg-white border-r border-slate-200 flex-col h-full transition-all duration-300 shadow-2xl shadow-slate-900/5">

        <!-- Logo -->
        <div class="h-16 flex items-center px-5 border-b border-slate-200 shrink-0">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-4">
                <span class="w-3 h-3 rounded-full bg-blue-600 inline-block shrink-0"></span>
                <span class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 whitespace-nowrap">Mitra DPMPTSP</span>
            </h1>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto overflow-x-hidden custom-scrollbar">
            @if(auth()->check() && auth()->user()->role === 'user')
            <a title="Beranda" href="/rfp-saya" class="flex items-center justify-center group-hover:justify-start gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative {{ request()->is('rfp-saya') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 whitespace-nowrap absolute left-14">Beranda</span>
            </a>

            <a title="Data Legalitas" href="/company/profile" class="flex items-center justify-center group-hover:justify-start gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative {{ request()->is('company/profile') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                <span class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 whitespace-nowrap absolute left-14">Data Legalitas</span>
            </a>
            
            <a title="Eksplorasi" href="/explore" class="flex items-center justify-center group-hover:justify-start gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative {{ request()->is('explore') || request()->is('vendor*') || request()->is('project*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <span class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 whitespace-nowrap absolute left-14">Eksplorasi</span>
            </a>

            <a title="Notifikasi" href="{{ route('notifications.index') }}" class="flex items-center justify-center group-hover:justify-start gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative {{ request()->routeIs('notifications.index') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                <div class="relative shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    @php
                        $pendingCount = auth()->user()->company ? auth()->user()->company->receivedInvitations()->whereNull('read_at')->count() : 0;
                        $sentUpdateCount = auth()->user()->company ? auth()->user()->company->sentInvitations()->whereIn('status', ['accepted', 'rejected'])->whereNull('sender_read_at')->count() : 0;
                        $totalBadge = $pendingCount + $sentUpdateCount;
                    @endphp
                    @if($totalBadge > 0)
                        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                    @endif
                </div>
                
                <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 absolute left-14 flex items-center justify-between w-32">
                    <span class="whitespace-nowrap">Notifikasi</span>
                    @if($totalBadge > 0)
                        <span class="px-1.5 py-0.5 rounded-full bg-red-100 text-red-600 text-[10px] font-extrabold">{{ $totalBadge }}</span>
                    @endif
                </div>
            </a>

            <a title="Pengaturan" href="#" class="flex items-center justify-center group-hover:justify-start gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                <span class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 whitespace-nowrap absolute left-14">Pengaturan</span>
            </a>
            @endif

            @if(auth()->check() && auth()->user()->role === 'admin')
            <a title="Dashboard Admin" href="{{ route('admin.dashboard') }}" class="flex items-center justify-center group-hover:justify-start gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 whitespace-nowrap absolute left-14">Dashboard Admin</span>
            </a>
            @endif
        </nav>
        
        <!-- Sidebar Footer: Profile Widget & Logout -->
        <div class="p-3 border-t border-slate-200 bg-slate-50/50 space-y-2">
            
            <!-- User Info & Notifications Widget -->
            <div class="relative">
                <button @click="profileMenuOpen = !profileMenuOpen" @click.away="profileMenuOpen = false" class="w-full flex items-center justify-center group-hover:justify-start gap-2 p-1.5 rounded-xl bg-white border border-slate-200/80 shadow-2xs hover:border-blue-300 hover:ring-1 hover:ring-blue-100 transition-all text-left relative overflow-hidden">
                    @php
                        $user = auth()->user();
                        $company = $user ? $user->company : null;
                        
                        if ($user && $user->role === 'admin') {
                            $initials = 'AD';
                            $displayName = $user->name ?? 'Administrator';
                            $typeName = 'Admin System';
                            $statusName = '';
                        } else {
                            $initials = $company ? strtoupper(substr($company->name, 0, 2)) : 'UK';
                            $displayName = $company->name ?? 'Belum ada data';
                            $typeName = $company ? ucwords(str_replace('-', ' ', $company->pelaku_usaha_type)) : 'Lengkapi Profil';
                            $statusName = $company ? ucfirst($company->skala_usaha) : '';
                        }
                    @endphp
                    <div class="w-9 h-9 rounded-lg bg-blue-100 flex shrink-0 items-center justify-center font-bold text-blue-700 text-sm overflow-hidden border border-blue-200 z-10">
                        {{ $initials }}
                    </div>
                    
                    <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 absolute left-14 flex items-center justify-between pr-2 w-[164px]">
                        <div class="flex-1 overflow-hidden">
                            <p class="text-xs font-bold text-slate-800 leading-none mb-1 truncate">{{ $displayName }}</p>
                            <p class="text-[10px] text-slate-500 font-semibold leading-none truncate">{{ $typeName }}{{ $statusName ? ' • ' . $statusName : '' }}</p>
                        </div>
                        <!-- Dots Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 shrink-0"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="profileMenuOpen" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     class="absolute bottom-full left-0 w-56 mb-2 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden z-50 py-1"
                     style="display: none;">
                    
                    @if($company)
                        <a href="{{ route('vendor.show', $company->id) }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            Lihat Profil Publik
                        </a>
                    @endif
                    <a href="{{ route('company.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                        Edit Profil
                    </a>
                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                        Pengaturan Akun
                    </a>
                    <div class="border-t border-slate-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                            Keluar dari Akun
                        </button>
                    </form>
                </div>
            </div>

            <!-- Role Toggle -->
            <div class="flex items-center justify-between p-2 rounded-lg bg-slate-100 border border-slate-200/50 mt-2 mb-2 hidden">
                <span class="text-[10px] font-bold text-slate-600">Simulasi Akun:</span>
                <select id="roleSelect" onchange="switchRole(this.value)" class="bg-white border border-slate-300 text-slate-700 font-semibold text-[10px] rounded px-1.5 py-0.5 focus:outline-none focus:ring-1 focus:ring-blue-500 cursor-pointer">
                    <option value="role_besar">Usaha Besar</option>
                    <option value="role_umkm">UMKM Lokal</option>
                </select>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper (Full Height Canvas!) -->
    <div class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50 relative md:ml-16">
        
        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 custom-scrollbar pb-24 md:pb-6">
            @yield('content', '<div class="h-full flex items-center justify-center border-2 border-dashed border-slate-300 rounded-2xl bg-white/50"><p class="text-slate-400 font-medium">Content goes here</p></div>')
        </main>
    </div>

    <script>
        // Initialize role toggle dropdown
        document.addEventListener('DOMContentLoaded', () => {
            const role = localStorage.getItem('userRole') || 'role_besar';
            const select = document.getElementById('roleSelect');
            if(select) select.value = role;
        });

        // Switch role function
        function switchRole(role) {
            localStorage.setItem('userRole', role);
            window.location.reload(); // Hard reload to ensure CSS applies flawlessly everywhere
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
    </style>
    <!-- Mobile Bottom Navigation (Visible only on mobile) -->
    <nav class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 md:hidden flex justify-around items-center h-16 px-2 pb-safe shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)]" x-data="{ openProfileMenu: false }">
        <!-- Beranda / RFP Saya -->
        <a href="/rfp-saya" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors {{ request()->is('rfp-saya') ? 'text-blue-600' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1 {{ request()->is('rfp-saya') ? 'fill-blue-50/50' : '' }}"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span class="text-[10px] font-semibold">Beranda</span>
        </a>

        <!-- Eksplorasi -->
        <a href="/explore" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors {{ request()->is('explore') || request()->is('vendor*') || request()->is('project*') ? 'text-blue-600' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1 {{ request()->is('explore') || request()->is('vendor*') || request()->is('project*') ? 'fill-blue-50/50' : '' }}"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <span class="text-[10px] font-semibold">Eksplorasi</span>
        </a>

        <!-- Notifikasi -->
        <a href="{{ route('notifications.index') }}" class="relative flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors {{ request()->routeIs('notifications.index') ? 'text-blue-600' : '' }}">
            <div class="relative mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ request()->routeIs('notifications.index') ? 'fill-blue-50/50' : '' }}"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                @php
                    $pendingCount = auth()->user()->company ? auth()->user()->company->receivedInvitations()->whereNull('read_at')->count() : 0;
                    $sentUpdateCount = auth()->user()->company ? auth()->user()->company->sentInvitations()->whereIn('status', ['accepted', 'rejected'])->whereNull('sender_read_at')->count() : 0;
                    $totalBadge = $pendingCount + $sentUpdateCount;
                @endphp
                @if($totalBadge > 0)
                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full"></span>
                @endif
            </div>
            <span class="text-[10px] font-semibold">Notifikasi</span>
        </a>

        <!-- Profil -->
        <div class="relative w-full h-full">
            <button @click="openProfileMenu = true" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="text-[10px] font-semibold">Profil</span>
            </button>

            <!-- Slide-up Profile Menu (Alpine.js) -->
            <div x-show="openProfileMenu" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-10"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-10"
                 class="fixed inset-x-0 bottom-16 bg-white border-t border-slate-200 rounded-t-2xl shadow-[0_-10px_40px_-10px_rgba(0,0,0,0.15)] p-4 z-[60] flex flex-col gap-1"
                 style="display: none;">
                 
                 <div class="flex items-center justify-between px-2 pb-3 mb-2 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block shrink-0"></span>
                        <span class="font-bold text-slate-900 text-sm">Mitra DPMPTSP</span>
                    </div>
                    <button @click="openProfileMenu = false" class="text-slate-400 hover:text-slate-600 bg-slate-50 p-1 rounded-full shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
                 </div>

                @if(auth()->check() && auth()->user()->role === 'user')
                    @if(auth()->user()->company)
                        <a href="{{ route('vendor.show', auth()->user()->company->id) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            Lihat Profil Publik
                        </a>
                    @endif
                    <a href="{{ route('company.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                        Edit Profil
                    </a>
                    <a href="/company/profile" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 transition-colors {{ request()->is('company/profile') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                        Data Legalitas
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                        Pengaturan
                    </a>
                @elseif(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        Dashboard Admin
                    </a>
                @endif
                
                <div class="border-t border-slate-100 my-1"></div>
                
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 font-medium rounded-xl transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        Keluar Akun
                    </button>
                </form>
            </div>
            
            <!-- Backdrop for Mobile Profile Menu -->
            <div x-show="openProfileMenu" style="display: none;" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[55] md:hidden" @click="openProfileMenu = false"></div>
        </div>
    </nav>
</body>
</html>
