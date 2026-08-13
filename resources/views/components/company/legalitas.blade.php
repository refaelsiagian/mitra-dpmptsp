@props(['company'])

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden {{ $attributes->get('class') }}" {{ $attributes->except('class') }}>
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-bold text-slate-900">Informasi Legalitas</h3>
    </div>
    
    <div class="p-6 space-y-5">
        
        <!-- NIB -->
        <div>
            <p class="text-xs text-slate-500 font-medium mb-1">Nomor Induk Berusaha (NIB)</p>
            <div class="flex items-center gap-2">
                <p class="text-slate-900 font-semibold font-mono">{{ $company->nib_number }}</p>
            </div>
        </div>
        
        <!-- PKP -->
        <div>
            <p class="text-xs text-slate-500 font-medium mb-1">Status PKP (Pengusaha Kena Pajak)</p>
            @if($company->is_pkp)
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-sm font-semibold border border-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    Aktif (PKP)
                </div>
            @else
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-500 text-sm font-semibold border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/></svg>
                    Non PKP
                </div>
            @endif
        </div>
        
        <!-- Skala -->
        <div>
            <p class="text-xs text-slate-500 font-medium mb-1">Skala Usaha / Kapasitas</p>
            <p class="text-slate-900 font-medium">{{ ucwords(str_replace('_', ' ', $company->skala_usaha)) }}</p>
        </div>
        
        <!-- KBLI & Certifications -->
        <div class="border-t border-slate-100 pt-5 mt-5">
            @if($company->certifications && count($company->certifications) > 0)
            <p class="text-xs text-slate-500 font-medium mb-3">Sertifikasi & Lisensi</p>
            <div class="flex flex-wrap gap-2 mb-5">
                @foreach($company->certifications as $cert)
                <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    {{ $cert }}
                </span>
                @endforeach
            </div>
            @endif

            <p class="text-xs text-slate-500 font-medium mb-3">Bidang Keahlian (KBLI)</p>
            <div class="flex flex-wrap gap-2">
                @foreach($company->kblis as $kbli)
                <span class="px-2.5 py-1 rounded-md bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold" title="{{ $kbli->name }}">
                    {{ $kbli->code }}
                </span>
                @endforeach
            </div>
        </div>
        
    </div>
</div>
