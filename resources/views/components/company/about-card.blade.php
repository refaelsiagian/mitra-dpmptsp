@props(['company'])

<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900 mb-4">Tentang Perusahaan</h2>
    <div class="prose prose-slate max-w-none text-slate-600 prose-p:leading-relaxed text-sm md:text-base">
        @if($company->description)
            {!! nl2br(e($company->description)) !!}
        @else
            <div class="flex flex-col items-center justify-center py-8 px-4 bg-slate-50/50 border-2 border-dashed border-slate-200 rounded-2xl">
                <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                </div>
                <p class="text-slate-500 font-bold text-sm text-center mb-1">Belum ada deskripsi profil perusahaan</p>
                <p class="text-slate-400 text-xs text-center max-w-xs mb-4">Tambahkan latar belakang, visi misi, dan layanan utama untuk menarik klien.</p>
                
                @if(auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id)
                <a href="{{ route('company.profile.edit') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold text-xs rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Tambahkan Deskripsi
                </a>
                @endif
            </div>
        @endif
    </div>
    
    <!-- Contact & Web -->
    <div class="flex flex-wrap gap-4 mt-6 pt-6 border-t border-slate-100">
        @if($company->phone)
        <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-3 py-2 rounded-lg border border-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            {{ $company->phone }}
        </div>
        @endif
        @if($company->website)
        <div class="flex items-center gap-2 text-sm text-slate-600 bg-slate-50 px-3 py-2 rounded-lg border border-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
            <a href="{{ $company->website }}" target="_blank" class="hover:text-blue-600">{{ str_replace(['http://', 'https://'], '', $company->website) }}</a>
        </div>
        @endif
    </div>
</div>
