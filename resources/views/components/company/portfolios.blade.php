@props(['company'])

@if($company->portfolios->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
<div x-show="activeTab === 'portfolios'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-base md:text-lg font-bold text-slate-900">Portofolio Proyek</h2>
        @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
        <a href="{{ route('portfolios.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs md:text-sm font-bold rounded-lg transition-colors shadow-sm shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="md:w-4 md:h-4"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Portofolio
        </a>
        @endif
    </div>

    @if($company->portfolios->count() === 0)
    <div class="text-center p-10 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
        </div>
        <p class="text-slate-500 mb-1 font-medium">Belum ada portofolio yang dibagikan.</p>
    </div>
    @else
    <div class="space-y-6">
        @foreach($company->portfolios as $portfolio)
        <div x-data="{ expanded: false }" class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <!-- Image -->
            <div class="w-full h-64 sm:h-80 bg-slate-100 relative overflow-hidden group">
                @if($portfolio->image_path)
                    <img src="{{ Storage::url($portfolio->image_path) }}" alt="{{ $portfolio->title }}" @click="lightboxImage = '{{ Storage::url($portfolio->image_path) }}'; lightboxOpen = true" class="w-full h-full object-cover cursor-pointer group-hover:scale-105 transition-transform duration-500">
                    
                    <!-- Hover Overlay for Image -->
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none flex items-center justify-center">
                        <div class="bg-white/20 backdrop-blur-sm p-3 rounded-full text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                        </div>
                    </div>
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-400">No Image</div>
                @endif
                
                @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
                <!-- Action Buttons (Owner Only) -->
                <div class="absolute top-4 right-4 flex items-center gap-2">
                    <a href="{{ route('portfolios.edit', $portfolio) }}" class="bg-white/90 hover:bg-blue-50 text-blue-600 backdrop-blur-sm p-2.5 rounded-full shadow-sm transition-colors border border-blue-100" title="Edit Portofolio">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                    </a>
                    <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus portofolio ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white/90 hover:bg-red-50 text-red-600 backdrop-blur-sm p-2.5 rounded-full shadow-sm transition-colors border border-red-100" title="Hapus Portofolio">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                        </button>
                    </form>
                </div>
                @endif
            </div>
            
            <!-- Content -->
            <div class="p-5 sm:p-6">
                <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $portfolio->title }}</h3>
                
                @if($portfolio->description)
                <div class="text-slate-600 text-sm md:text-base leading-relaxed">
                    <p :class="expanded ? '' : 'line-clamp-3'">
                        {!! nl2br(e($portfolio->description)) !!}
                    </p>
                    
                    <button @click="expanded = !expanded" x-show="true" class="text-blue-600 font-semibold mt-2 hover:text-blue-800 transition-colors inline-flex items-center gap-1">
                        <span x-text="expanded ? 'Tampilkan Lebih Sedikit' : 'Selengkapnya'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :class="expanded ? 'rotate-180' : ''" class="transition-transform duration-300"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                </div>
                @endif
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center text-xs text-slate-400 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    Ditambahkan pada {{ $portfolio->created_at->format('d M Y') }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endif
