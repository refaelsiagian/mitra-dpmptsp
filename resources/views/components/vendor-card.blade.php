@props([
    'profileUrl' => '#',
    'name' => 'Nama Vendor',
    'category' => 'Kategori',
    'location' => 'Lokasi',
    'chips' => [],
    'logo' => null
])

<div class="group bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row gap-4 sm:gap-6 relative overflow-hidden">
    
    <!-- Mobile Header Wrapper: Image + Info -->
    <div class="flex flex-row gap-4 sm:contents">
        <!-- Left side: Image -->
        <div class="relative flex-shrink-0">
        <!-- Thumbnail Placeholder -->
        <div class="w-16 h-16 sm:w-32 sm:h-32 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 flex items-center justify-center">
            @if($logo)
                <img src="{{ Storage::url($logo) }}" alt="{{ $name }}" class="w-full h-full object-cover">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300 sm:w-8 sm:h-8"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M12 12v9"/><path d="m8 17 4 4 4-4"/></svg>
            @endif
        </div>
    </div>

    <!-- Middle: Info -->
    <div class="flex-1 flex flex-col justify-center">
        <h3 class="text-lg sm:text-xl font-bold text-slate-900 group-hover:text-blue-700 transition-colors leading-tight">
            <a href="{{ $profileUrl ?? '/vendor-profile' }}">{{ $name ?? 'CV Baja Nusantara' }}</a>
        </h3>
        <p class="text-[11px] sm:text-sm text-slate-500 mt-1 font-medium">
            {{ $category ?? 'Konstruksi Logam & Fabrikasi' }}
        </p>
        
        <div class="flex items-center gap-1 sm:gap-1.5 text-[11px] sm:text-sm text-slate-500 mt-1 sm:mt-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sm:w-[14px] sm:h-[14px]"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span class="truncate">{{ $location ?? 'Medan, Sumatera Utara' }}</span>
        </div>

        <!-- Desktop Chips -->
        <div class="hidden sm:flex flex-wrap gap-2 mt-3">
            @if(isset($chips) && is_array($chips))
                @foreach($chips as $chip)
                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200/60">{{ $chip }}</span>
                @endforeach
            @else
                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200/60">Welding</span>
                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200/60">CNC Machining</span>
                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200/60">Baja Ringan</span>
            @endif
        </div>
    </div>
    </div>
    
    <!-- Mobile Chips -->
    <div class="flex sm:hidden flex-wrap gap-1.5">
        @if(isset($chips) && is_array($chips))
            @foreach($chips as $chip)
                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-medium border border-slate-200/60">{{ $chip }}</span>
            @endforeach
        @else
            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-medium border border-slate-200/60">Welding</span>
            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-medium border border-slate-200/60">CNC Machining</span>
            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-medium border border-slate-200/60">Baja Ringan</span>
        @endif
    </div>

    <!-- Right side: Actions -->
    <div class="flex flex-col items-start sm:items-end justify-center sm:w-40 gap-4 sm:gap-0 border-t sm:border-t-0 sm:border-l border-slate-100 pt-4 sm:pt-0 sm:pl-6 flex-shrink-0">
        <!-- Button -->
        <div class="w-full">
            <a href="{{ $profileUrl ?? '/vendor-profile' }}" class="w-full justify-center items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm shadow-blue-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 focus:outline-none flex text-center">
                Lihat Profil
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>
