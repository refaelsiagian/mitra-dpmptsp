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
<body class="bg-slate-50 text-slate-900 antialiased h-screen flex overflow-hidden relative">

    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar (Left) - Fixed Width & Full Height -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 flex flex-col h-full transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0">
        <!-- Close Button (Mobile Only) -->
        <button onclick="toggleSidebar()" class="md:hidden absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-slate-200">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span>
                Mitra DPMPTSP
            </h1>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
            @if(auth()->check() && auth()->user()->role === 'user')
            <a href="/rfp-saya" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ request()->is('rfp-saya') ? 'bg-blue-50 text-blue-700 font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Beranda (RFP Saya)
            </a>

            <a href="/company/profile" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ request()->is('company/profile') ? 'bg-blue-50 text-blue-700 font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                Data Legalitas
            </a>
            
            <a href="/explore" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm transition-colors {{ request()->is('explore') || request()->is('vendor*') || request()->is('project*') ? 'bg-blue-50 text-blue-700 font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <span>Eksplorasi Vendor</span>
                </div>
                <span class="px-1.5 py-0.5 rounded-full {{ request()->is('explore') || request()->is('vendor*') || request()->is('project*') ? 'bg-blue-200/70 text-blue-800' : 'bg-slate-200 text-slate-600' }} text-[10px] font-extrabold">11</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors font-medium text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                Pengaturan
            </a>
            @endif

            @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                Dashboard Admin
            </a>
            @endif
        </nav>
        
        <!-- Sidebar Footer: Profile Widget & Logout -->
        <div class="p-3.5 border-t border-slate-200 bg-slate-50/50 space-y-2.5">
            
            <!-- User Info & Notifications Widget -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="w-full flex items-center justify-between gap-2 p-2 rounded-xl bg-white border border-slate-200/80 shadow-2xs hover:border-blue-300 hover:ring-1 hover:ring-blue-100 transition-all text-left">
                    <div class="flex items-center gap-2 flex-1 overflow-hidden">
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
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex shrink-0 items-center justify-center font-bold text-blue-700 text-sm overflow-hidden border border-blue-200">
                            {{ $initials }}
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-[11px] font-extrabold text-slate-800 leading-none mb-0.5 truncate">{{ $displayName }}</p>
                            <p class="text-[10px] text-slate-500 font-medium leading-none truncate">{{ $typeName }}{{ $statusName ? ' • ' . $statusName : '' }}</p>
                        </div>
                    </div>
                    <!-- Dots Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute bottom-full left-0 w-full mb-2 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden z-50 py-1"
                     style="display: none;">
                    
                    @if($company)
                        <a href="{{ route('vendor.show', $company->id) }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            Lihat Profil Publik
                        </a>
                    @endif
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
    <div class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50 relative">
        
        <!-- Mobile Topbar (Visible only on md and below) -->
        <div class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-slate-200 z-30">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span>
                <span class="font-bold text-slate-900">Mitra DPMPTSP</span>
            </div>
            <button onclick="toggleSidebar()" class="p-2 -mr-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
        </div>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 custom-scrollbar">
            @yield('content', '<div class="h-full flex items-center justify-center border-2 border-dashed border-slate-300 rounded-2xl bg-white/50"><p class="text-slate-400 font-medium">Content goes here</p></div>')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

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
</body>
</html>
