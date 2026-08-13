@props(['company'])

<!-- Hero Section -->
<div class="relative mb-4">
    <!-- Banner Image -->
    <div class="w-full aspect-[3/1] md:aspect-[4/1] lg:aspect-[5/1] bg-slate-200 relative group rounded-2xl overflow-hidden shadow-sm border border-slate-200">
        @if($company->banner)
            <img src="{{ Storage::url($company->banner) }}" alt="Company Banner" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
        @else
            <img src="https://images.unsplash.com/photo-1541888087588-82cc68dd6279?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Default Banner" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
        
    </div>
</div>

<!-- Company Header Info -->
<div class="flex flex-row items-end sm:items-start gap-4 sm:gap-6 relative px-1 sm:px-0">
    <!-- Avatar -->
    <div class="-mt-12 sm:-mt-16 w-20 sm:w-28 md:w-32 aspect-square shrink-0 bg-white rounded-2xl shadow-xl ring-4 ring-white overflow-hidden flex items-center justify-center z-10 relative">
        @if($company->logo)
            <img src="{{ Storage::url($company->logo) }}" alt="Logo" class="w-full h-full object-cover">
        @else
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        @endif
    </div>

    <!-- Company Details -->
    <div class="flex-1 flex flex-col justify-end sm:justify-start pb-1 sm:pb-0 sm:mt-2">
        <h1 class="text-xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight mb-1">{{ $company->name }}</h1>
        <p class="text-slate-600 font-medium text-xs sm:text-base line-clamp-2 sm:line-clamp-none">
            @if($company->established_year) Berdiri sejak {{ $company->established_year }} • @endif 
            {{ $company->tagline ?? ($company->kblis->first()->name ?? 'Bidang Usaha Umum') }}
        </p>
    </div>

    <!-- Action Buttons (Desktop) -->
    <div class="hidden sm:block shrink-0 mt-1">
        @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
        <a href="{{ route('company.profile.edit') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
            Edit Profil
        </a>
        @else
        <button onclick="openInviteModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white hover:bg-blue-700 rounded-xl text-sm font-bold shadow-sm transition-colors shadow-blue-600/20">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            Undang ke Proyek
        </button>
        @endif
    </div>
</div>

<!-- Action Buttons (Mobile) -->
<div class="sm:hidden mt-4">
    @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
    <a href="{{ route('company.profile.edit') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
        Edit Profil
    </a>
    @else
    <button onclick="openInviteModal()" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-xl text-sm font-bold shadow-sm transition-colors shadow-blue-600/20">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        Undang ke Proyek
    </button>
    @endif
</div>
