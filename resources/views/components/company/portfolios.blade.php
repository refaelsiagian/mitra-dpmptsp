@props(['company', 'partnerships' => collect()])

@if($company->portfolios->count() > 0 || $partnerships->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
<div x-show="activeTab === 'portfolios'" x-data="{ activePortoTab: 'internal' }" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6" wire:key="portfolios-header-{{ $company->id }}">
        <!-- Sub Tabs -->
        <div class="flex items-center gap-2 p-1.5 bg-slate-100 rounded-xl w-full sm:w-max">
            <button type="button" @click="activePortoTab = 'internal'" :class="activePortoTab === 'internal' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'" class="flex-1 sm:flex-none px-4 py-2 text-sm rounded-lg transition-all text-center whitespace-nowrap">
                Portofolio Perusahaan
            </button>
            <button type="button" @click="activePortoTab = 'kemitraan'" :class="activePortoTab === 'kemitraan' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700 font-medium'" class="flex-1 sm:flex-none px-4 py-2 text-sm rounded-lg transition-all text-center whitespace-nowrap">
                Riwayat Kemitraan
            </button>
        </div>

        @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
        <a wire:navigate href="{{ route('portfolios.create') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors shadow-sm shrink-0 w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Portofolio
        </a>
        @endif
    </div>

    <!-- Tab Content: Internal -->
    <div x-show="activePortoTab === 'internal'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" wire:key="portfolios-internal-{{ $company->id }}">
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
                <div x-data="{ showDeleteModal: false, openDropdown: false }" class="absolute top-4 right-4 flex items-center justify-end z-20">
                    
                    <!-- Desktop Buttons -->
                    <div class="hidden md:flex items-center gap-2">
                        <a wire:navigate href="{{ route('portfolios.edit', $portfolio) }}" @click.stop class="bg-white/90 hover:bg-blue-50 text-blue-600 backdrop-blur-sm p-2.5 rounded-full shadow-sm transition-colors border border-blue-100" title="Edit Portofolio">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        </a>
                        <button type="button" @click.stop="showDeleteModal = true" class="bg-white/90 hover:bg-red-50 text-red-600 backdrop-blur-sm p-2.5 rounded-full shadow-sm transition-colors border border-red-100" title="Hapus Portofolio">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                        </button>
                    </div>

                    <!-- Mobile Three Dots Menu -->
                    <div class="md:hidden relative">
                        <button type="button" @click.stop="openDropdown = !openDropdown" @click.outside="openDropdown = false" class="bg-white/90 hover:bg-slate-100 text-slate-700 backdrop-blur-sm p-2 rounded-full shadow-sm transition-colors border border-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="openDropdown" style="display: none;" class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg border border-slate-200 py-1.5 z-30" x-transition.opacity>
                            <a wire:navigate href="{{ route('portfolios.edit', $portfolio) }}" @click.stop class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors w-full text-left font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                Edit
                            </a>
                            <button type="button" @click.stop="openDropdown = false; showDeleteModal = true" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                Hapus
                            </button>
                        </div>
                    </div>

                    <x-modal.confirm 
                        showProperty="showDeleteModal" 
                        title="Hapus Portofolio Ini?">
                        <p>Apakah Anda yakin ingin menghapus portofolio <span class="font-bold">"{{ $portfolio->title }}"</span>? Tindakan ini tidak dapat dibatalkan.</p>
                        
                        <x-slot:actions>
                            <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors shadow-sm">
                                    Ya, Hapus
                                </button>
                            </form>
                        </x-slot:actions>
                    </x-modal.confirm>
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

    <!-- Tab Content: Kemitraan -->
    <div x-show="activePortoTab === 'kemitraan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" wire:key="portfolios-kemitraan-{{ $company->id }}">
        @if($partnerships->count() === 0)
        <div class="text-center p-10 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
            </div>
            <p class="text-slate-500 mb-1 font-medium">Belum ada riwayat kemitraan.</p>
        </div>
        @else
        <div class="space-y-4">
            @foreach($partnerships as $partnership)
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-300 hover:shadow-md transition-all group">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition-colors">
                                <a wire:navigate href="{{ route('projects.show', $partnership->project->id) }}">
                                    {{ $partnership->project->title }}
                                </a>
                            </h3>
                        </div>
                        @if($partnership->project->status === 'closed' && $partnership->project->is_public === false)
                            <p class="text-sm text-slate-500 mb-4 italic flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                                Detail proyek telah disembunyikan oleh pemilik.
                            </p>
                        @else
                            <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ Str::limit($partnership->project->description, 150) }}</p>
                        @endif
                        
                        <div class="flex flex-wrap items-center gap-4 text-xs font-medium">
                            <a href="{{ route('vendor.show', $partnership->project->company->id) }}" class="flex items-center gap-2 p-2 bg-slate-50 rounded-lg border border-slate-100 hover:bg-slate-100 transition-colors">
                                @if($partnership->project->company->logo)
                                    <img src="{{ Storage::url($partnership->project->company->logo) }}" alt="{{ $partnership->project->company->name }}" class="w-6 h-6 rounded-full object-cover">
                                @else
                                    <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-[10px]">
                                        {{ substr($partnership->project->company->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-slate-700">Mitra dari <span class="font-bold text-slate-900">{{ $partnership->project->company->name }}</span></span>
                            </a>
                            <span class="text-slate-400 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                Disetujui pada {{ $partnership->updated_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endif
