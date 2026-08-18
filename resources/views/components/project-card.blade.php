@props([
    'type' => 'tender',
    'typeLabel' => 'Tender Resmi',
    'title' => 'Judul Proyek',
    'company' => 'Nama Perusahaan',
    'companyUrl' => '#',
    'location' => 'Lokasi Proyek',
    'category' => 'Kategori Proyek',
    'valueLabel' => 'Estimasi Nilai',
    'value' => 'Rp -',
    'deadline' => 'Terbuka',
    'url' => '#',
    'description' => 'Deskripsi singkat mengenai peluang proyek atau kemitraan yang ditawarkan.'
])

@php
    // Color theme based on project type
    $theme = match($type) {
        'konstruksi' => [
            'badgeBg' => 'bg-blue-50', 'badgeText' => 'text-blue-700', 'badgeBorder' => 'border-blue-200',
            'btnBg' => 'bg-blue-600 hover:bg-blue-700', 'btnShadow' => 'shadow-blue-200',
            'valueColor' => 'text-emerald-600', 'accent' => 'border-l-blue-500'
        ],
        'subkontrak' => [
            'badgeBg' => 'bg-purple-50', 'badgeText' => 'text-purple-700', 'badgeBorder' => 'border-purple-200',
            'btnBg' => 'bg-purple-600 hover:bg-purple-700', 'btnShadow' => 'shadow-purple-200',
            'valueColor' => 'text-emerald-600', 'accent' => 'border-l-purple-500'
        ],
        'kso' => [
            'badgeBg' => 'bg-teal-50', 'badgeText' => 'text-teal-700', 'badgeBorder' => 'border-teal-200',
            'btnBg' => 'bg-teal-600 hover:bg-teal-700', 'btnShadow' => 'shadow-teal-200',
            'valueColor' => 'text-teal-700', 'accent' => 'border-l-teal-500'
        ],
        'rantai_pasok' => [
            'badgeBg' => 'bg-amber-50', 'badgeText' => 'text-amber-800', 'badgeBorder' => 'border-amber-200',
            'btnBg' => 'bg-amber-700 hover:bg-amber-800', 'btnShadow' => 'shadow-amber-200',
            'valueColor' => 'text-amber-800', 'accent' => 'border-l-amber-500'
        ],
        'outsourcing' => [
            'badgeBg' => 'bg-indigo-50', 'badgeText' => 'text-indigo-700', 'badgeBorder' => 'border-indigo-200',
            'btnBg' => 'bg-indigo-600 hover:bg-indigo-700', 'btnShadow' => 'shadow-indigo-200',
            'valueColor' => 'text-indigo-700', 'accent' => 'border-l-indigo-500'
        ],
        'distribusi' => [
            'badgeBg' => 'bg-cyan-50', 'badgeText' => 'text-cyan-800', 'badgeBorder' => 'border-cyan-200',
            'btnBg' => 'bg-cyan-600 hover:bg-cyan-700', 'btnShadow' => 'shadow-cyan-200',
            'valueColor' => 'text-cyan-700', 'accent' => 'border-l-cyan-500'
        ],
        'perdagangan' => [
            'badgeBg' => 'bg-rose-50', 'badgeText' => 'text-rose-700', 'badgeBorder' => 'border-rose-200',
            'btnBg' => 'bg-rose-600 hover:bg-rose-700', 'btnShadow' => 'shadow-rose-200',
            'valueColor' => 'text-rose-700', 'accent' => 'border-l-rose-500'
        ],
        default => [
            'badgeBg' => 'bg-slate-50', 'badgeText' => 'text-slate-700', 'badgeBorder' => 'border-slate-200',
            'btnBg' => 'bg-blue-600 hover:bg-blue-700', 'btnShadow' => 'shadow-slate-200',
            'valueColor' => 'text-emerald-600', 'accent' => 'border-l-slate-400'
        ]
    };
@endphp

<div class="group bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between border-l-4 {{ $theme['accent'] }} relative overflow-hidden">
    <div>
        <!-- Header Row: Badge & Deadline -->
        <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $theme['badgeBg'] }} {{ $theme['badgeText'] }} {{ $theme['badgeBorder'] }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                {{ $typeLabel }}
            </span>
            
            <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full border border-slate-200/60 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $deadline }}
            </span>
        </div>

        <!-- Project Title -->
        <h3 class="text-lg sm:text-xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors mb-1.5 leading-snug">
            <a href="{{ $url }}">{{ $title }}</a>
        </h3>

        <!-- Company Initiator -->
        <div class="flex items-center gap-1.5 mb-3 text-sm font-medium">
            <span class="text-slate-400">Oleh:</span>
            <a href="{{ $companyUrl }}" class="text-slate-700 hover:text-blue-600 font-semibold transition-colors underline decoration-slate-300 underline-offset-2">{{ $company }}</a>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><polyline points="20 6 9 17 4 12"/></svg>
        </div>

        <!-- Description -->
        <p class="text-sm text-slate-600 leading-relaxed mb-4 line-clamp-2">
            {{ $description }}
        </p>

        <!-- Location & Category Chips -->
        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 font-medium pb-4 border-b border-slate-100">
            <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <span>{{ $location }}</span>
            </div>
            <span class="text-slate-300">•</span>
            <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                <span>{{ $category }}</span>
            </div>
        </div>
    </div>

    <!-- Footer Row: Value & CTA Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 mt-auto">
        <div>
            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">{{ $valueLabel }}</span>
            <span class="text-lg font-bold {{ $theme['valueColor'] }} tracking-tight">{{ $value }}</span>
        </div>
        
        <div class="flex items-center gap-2">
            <a href="{{ $url }}" class="px-5 py-2.5 {{ $theme['btnBg'] }} text-white text-sm font-bold rounded-xl transition-colors shadow-sm {{ $theme['btnShadow'] }} flex items-center justify-center gap-2 focus:ring-2 focus:ring-offset-1 focus:outline-none">
                Lihat Detail Peluang
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>
