<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra DPMPTSP - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased h-screen flex overflow-hidden">

    <!-- Sidebar (Left) - Fixed Width & Full Height -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col flex-shrink-0 h-full">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-slate-200">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span>
                Mitra DPMPTSP
            </h1>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
            <a href="/rfp-saya" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ request()->is('rfp-saya') ? 'bg-blue-50 text-blue-700 font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Beranda (RFP Saya)
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
        </nav>
        
        <!-- Sidebar Footer: Profile Widget & Logout -->
        <div class="p-3.5 border-t border-slate-200 bg-slate-50/50 space-y-2.5">
            
            <!-- User Info & Notifications Widget -->
            <div class="flex items-center justify-between gap-2 p-2 rounded-xl bg-white border border-slate-200/80 shadow-2xs">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="relative flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=eff6ff&color=1d4ed8&bold=true" alt="Budi Santoso" class="h-9 w-9 rounded-full object-cover border border-blue-100">
                        <!-- Active Status Dot -->
                        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-slate-900 truncate">Budi Santoso</p>
                        <p class="text-[11px] font-medium text-slate-500 truncate">PT Inovasi Mandiri</p>
                    </div>
                </div>

                <!-- Notification Bell -->
                <button class="relative p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors flex-shrink-0 focus:outline-none focus:ring-2 focus:ring-blue-500" title="Notifikasi (3 Baru)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-500 ring-1 ring-white"></span>
                </button>
            </div>

            <!-- Logout Button -->
            <a href="#" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:text-red-600 hover:bg-red-50/80 transition-colors border border-transparent hover:border-red-200/60">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                Keluar dari Akun
            </a>
        </div>
    </aside>

    <!-- Main Wrapper (No Topbar - Full Height Canvas!) -->
    <div class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50">
        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 custom-scrollbar">
            @yield('content', '<div class="h-full flex items-center justify-center border-2 border-dashed border-slate-300 rounded-2xl bg-white/50"><p class="text-slate-400 font-medium">Content goes here</p></div>')
        </main>
    </div>

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
