<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIS Berkah - Dashboard</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-2.svg') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/project-form.js') }}" data-navigate-track></script>
    <!-- Livewire -->
    @livewireStyles
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cabin', sans-serif;
        }
        /* Role-based visibility toggles */
        html.role_umkm .besar-only { display: none !important; }
        html.role_besar .umkm-only { display: none !important; }
        /* Alpine cloak */
        [x-cloak] { display: none !important; }
    </style>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        // Set the initial role BEFORE rendering the body to prevent layout shift
        const userRole = localStorage.getItem('userRole') || 'role_besar';
        document.documentElement.classList.add(userRole);
    </script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased h-screen flex flex-col md:flex-row overflow-hidden relative">
    
    <!-- Splash Screen -->
    @if(session('show_splash'))
        @php session()->forget('show_splash'); @endphp
        <div x-data="{ showSplash: true }" x-init="setTimeout(() => showSplash = false, 1500);" x-show="showSplash" x-transition.opacity.duration.500ms class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-white">
            <div class="flex-1 flex items-center justify-center">
                <img src="{{ asset('images/logo-1.svg') }}" alt="KIS Berkah" class="h-20 md:h-24 w-auto animate-pulse">
            </div>
            <div class="pb-12 flex flex-col items-center">
                <span class="text-xs font-semibold text-slate-400 mb-2">Dari</span>
                <img src="{{ asset('images/logo-dpmptsp.png') }}" alt="DPMPTSP Sumut" class="h-10 md:h-12 w-auto">
            </div>
        </div>
    @endif


    <!-- Sidebar (Desktop Only) -->
    @persist('sidebar')
    <aside id="sidebar" x-data="{ profileMenuOpen: false, expanded: false }" @mouseenter="expanded = true" @mouseleave="expanded = false" :class="expanded ? 'w-64' : 'w-16'" class="hidden md:flex absolute inset-y-0 left-0 z-50 bg-white flex-col h-full transition-all duration-300 shadow-2xl shadow-slate-900/5">

        <!-- Logo -->
        <div class="h-16 flex items-center px-4 shrink-0 relative">
            <a wire:navigate href="/dashboard" class="flex items-center relative w-full h-8">
                <!-- Collapsed State Logo (Icon Only) -->
                <img src="{{ asset('images/logo-2.svg') }}" alt="KIS Berkah Icon" class="h-8 w-auto absolute left-0 max-w-none">
                <!-- Expanded State Logo (Full Lockup) -->
                <img src="{{ asset('images/logo-1.svg') }}" alt="KIS Berkah Logo" class="h-8 w-auto absolute left-0 max-w-none transition-opacity duration-300 opacity-0 pointer-events-none" :class="expanded ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'">
            </a>
        </div>
        
        <!-- Navigation -->
        <nav x-data="{ currentPath: window.location.pathname }" @@livewire:navigated.window="currentPath = window.location.pathname" class="flex-1 px-3 py-6 space-y-2 overflow-y-auto overflow-x-hidden custom-scrollbar">
            @if(auth()->check() && auth()->user()->role === 'user')
            <a wire:navigate title="Beranda" href="/dashboard" class="flex items-center gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative" :class="[currentPath === '/dashboard' ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold', expanded ? 'justify-start' : 'justify-center']">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="transition-all duration-300 whitespace-nowrap absolute left-14" :class="expanded ? 'visible opacity-100' : 'invisible opacity-0'">Beranda</span>
            </a>

            <a wire:navigate title="Data Legalitas" href="/company/profile" class="flex items-center gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative" :class="[currentPath === '/company/profile' ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold', expanded ? 'justify-start' : 'justify-center']">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                <span class="transition-all duration-300 whitespace-nowrap absolute left-14" :class="expanded ? 'visible opacity-100' : 'invisible opacity-0'">Data Legalitas</span>
            </a>
            
            <a wire:navigate title="Eksplorasi" href="/explore" class="flex items-center gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative" :class="[(currentPath === '/explore' || currentPath.startsWith('/vendor') || currentPath.startsWith('/project')) ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold', expanded ? 'justify-start' : 'justify-center']">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <span class="transition-all duration-300 whitespace-nowrap absolute left-14" :class="expanded ? 'visible opacity-100' : 'invisible opacity-0'">Eksplorasi</span>
            </a>

            <a wire:navigate title="Pesan & Negosiasi" href="/messages" class="flex items-center gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative" :class="[currentPath.startsWith('/messages') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold', expanded ? 'justify-start' : 'justify-center']">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <span class="transition-all duration-300 whitespace-nowrap absolute left-14" :class="expanded ? 'visible opacity-100' : 'invisible opacity-0'">Pesan & Negosiasi</span>
            </a>



            <a title="Pengaturan" href="#" class="flex items-center gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold" :class="expanded ? 'justify-start' : 'justify-center'">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                <span class="transition-all duration-300 whitespace-nowrap absolute left-14" :class="expanded ? 'visible opacity-100' : 'invisible opacity-0'">Pengaturan</span>
            </a>
            @endif

            @if(auth()->check() && auth()->user()->role === 'admin')
            <a wire:navigate title="Dashboard Admin" href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative" :class="[currentPath.startsWith('/admin') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold', expanded ? 'justify-start' : 'justify-center']">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span class="transition-all duration-300 whitespace-nowrap absolute left-14" :class="expanded ? 'visible opacity-100' : 'invisible opacity-0'">Dashboard Admin</span>
            </a>
            <a wire:navigate title="Eksplorasi" href="/explore" class="flex items-center gap-4 px-3 py-3 rounded-xl text-sm transition-colors relative" :class="[(currentPath === '/explore' || currentPath.startsWith('/vendor') || currentPath.startsWith('/project')) ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-semibold', expanded ? 'justify-start' : 'justify-center']">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <span class="transition-all duration-300 whitespace-nowrap absolute left-14" :class="expanded ? 'visible opacity-100' : 'invisible opacity-0'">Eksplorasi</span>
            </a>
            @endif
        </nav>
        
        <!-- Sidebar Footer: Profile Widget & Logout -->
        <div class="p-2 space-y-2">
            
            <!-- User Info & Notifications Widget -->
            <div class="relative">
                <button @click="profileMenuOpen = !profileMenuOpen" @click.away="profileMenuOpen = false" class="w-full flex items-center gap-3 rounded-xl hover:bg-slate-100 transition-all text-left relative overflow-hidden" :class="expanded ? 'p-2 justify-start' : 'p-1 justify-center'">
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
                        @if($company && $company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            {{ $initials }}
                        @endif
                    </div>
                    
                    <div class="transition-all duration-300 absolute left-14 flex items-center justify-between pr-2 w-[164px]" :class="expanded ? 'visible opacity-100' : 'invisible opacity-0'">
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
                    
                    @if(auth()->check() && auth()->user()->role === 'user')
                        @if($company)
                            <a wire:navigate href="{{ route('vendor.show', $company->id) }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                Lihat Profil Publik
                            </a>
                        @endif
                        <a wire:navigate href="{{ route('company.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                            Edit Profil
                        </a>
                    @endif
                    <a wire:navigate href="{{ route('settings.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600" :class="currentPath.startsWith('/settings') ? 'bg-slate-50 text-blue-600' : ''">
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
    @endpersist

    <!-- Main Wrapper (Full Height Canvas!) -->
    <div class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50 relative md:ml-16">
        
        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 custom-scrollbar pb-24 md:pb-6">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content', '<div class="h-full flex items-center justify-center border-2 border-dashed border-slate-300 rounded-2xl bg-white/50"><p class="text-slate-400 font-medium">Content goes here</p></div>')
            @endif
        </main>
    </div>

    <script>
        // Initialize role toggle dropdown
        document.addEventListener('livewire:navigated', () => {
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
        @if(auth()->user() && auth()->user()->role === 'admin')
            <!-- Admin Mobile Navigation -->
            <a wire:navigate href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1 {{ request()->routeIs('admin.dashboard') ? 'fill-blue-50/50' : '' }}"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="text-[10px] font-semibold">Dashboard</span>
            </a>

            <!-- Eksplorasi Admin -->
            <a wire:navigate href="/explore" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors {{ request()->is('explore') || request()->is('vendor*') || request()->is('project*') ? 'text-blue-600' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1 {{ request()->is('explore') || request()->is('vendor*') || request()->is('project*') ? 'fill-blue-50/50' : '' }}"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <span class="text-[10px] font-semibold">Eksplorasi</span>
            </a>

            <!-- Profil Admin -->
            <div class="relative w-full h-full">
                <button @click="openProfileMenu = !openProfileMenu" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span class="text-[10px] font-semibold">Profil</span>
                </button>

                <!-- Admin Profile Menu -->
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
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                AD
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-800 leading-tight">Administrator</span>
                                <span class="text-xs text-slate-500">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <button @click="openProfileMenu = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-full hover:bg-slate-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </button>
                    </div>
                    <a wire:navigate href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-3 text-sm text-slate-700 hover:bg-slate-50 rounded-xl transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                        Pengaturan Akun
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-colors font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                            Keluar dari Akun
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Backdrop for Admin Profile Menu -->
            <div x-show="openProfileMenu" style="display: none;" class="fixed inset-x-0 top-0 bottom-16 bg-slate-900/40 backdrop-blur-sm z-[40] md:hidden" @click="openProfileMenu = false"></div>
        @else
            <!-- Beranda / Dashboard -->
            <a wire:navigate href="/dashboard" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors {{ request()->is('dashboard') ? 'text-blue-600' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1 {{ request()->is('dashboard') ? 'fill-blue-50/50' : '' }}"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="text-[10px] font-semibold">Beranda</span>
            </a>

            <!-- Eksplorasi -->
            <a wire:navigate href="/explore" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors {{ request()->is('explore') || request()->is('vendor*') || request()->is('project*') ? 'text-blue-600' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1 {{ request()->is('explore') || request()->is('vendor*') || request()->is('project*') ? 'fill-blue-50/50' : '' }}"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <span class="text-[10px] font-semibold">Eksplorasi</span>
            </a>

            <!-- Pesan -->
            <a wire:navigate href="/messages" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors {{ request()->is('messages*') ? 'text-blue-600' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1 {{ request()->is('messages*') ? 'fill-blue-50/50' : '' }}"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <span class="text-[10px] font-semibold">Pesan</span>
            </a>

            <!-- Profil -->
            <div class="relative w-full h-full">
                <button @click="openProfileMenu = !openProfileMenu" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-blue-600 transition-colors">
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
                            <img src="{{ asset('images/logo-1.svg') }}" alt="KIS Berkah" class="h-8 w-auto">
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
                    <a wire:navigate href="{{ route('company.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                        Edit Profil
                    </a>
                    <a wire:navigate href="/company/profile" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 transition-colors {{ request()->is('company/profile') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                        Data Legalitas
                    </a>
                    <a wire:navigate href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 transition-colors {{ request()->routeIs('settings.index') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                        Pengaturan
                    </a>
                @elseif(auth()->check() && auth()->user()->role === 'admin')
                    <a wire:navigate href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
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
            <div x-show="openProfileMenu" style="display: none;" class="fixed inset-x-0 top-0 bottom-16 bg-slate-900/40 backdrop-blur-sm z-[40] md:hidden" @click="openProfileMenu = false"></div>
        </div>
        @endif
    </nav>
    
    <!-- Global Toast Notifications -->
    <x-toast />
    @livewireScripts
    
    @if(auth()->check())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.Echo) {
                window.Echo.private('users.{{ auth()->id() }}')
                    .listen('.MessageSent', (e) => {
                        // Check if we are currently looking at this specific conversation in the chat UI
                        const isChatPage = window.location.pathname.startsWith('/messages');
                        
                        // Using Livewire 3 global object to get active component state if available
                        let activeProposalId = null;
                        if (isChatPage && window.Livewire) {
                            const chatComponent = window.Livewire.first();
                            if (chatComponent) {
                                activeProposalId = chatComponent.get('activeProposalId');
                                // Instantly refresh the chat component to load the new message into the DOM (even if it's a background chat)
                                chatComponent.$refresh();
                            }
                        }

                        // If the user is looking at the active chat, do NOT show toast (since they already saw it pop up)
                        if (isChatPage && activeProposalId == e.message.proposal_id) {
                            return;
                        }

                        // Otherwise, show a global notification!
                        window.dispatchEvent(new CustomEvent('show-toast', {
                            detail: {
                                message: 'Pesan Baru: ' + e.message.body,
                                type: 'info'
                            }
                        }));
                    });
            }
        });
    </script>
    @endif
</body>
</html>

