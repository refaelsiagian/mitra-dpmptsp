@php
    $hasProjectRab = $proposal->project->rab !== null;
    $hasProposalRab = $proposal->rab !== null;
    $isRabAdjusted = false;
    
    if ($hasProjectRab && $hasProposalRab) {
        $isRabAdjusted = $proposal->rab->total_amount !== $proposal->project->rab->total_amount;
    }
@endphp

@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto pb-10">
    <div class="pt-4 mb-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $isRabAdjusted ? 'Perbandingan RAB' : 'Detail RAB' }}</h1>
            <p class="text-slate-500 text-sm mt-1">
                @if($isRabAdjusted)
                Bandingkan RAB acuan proyek dengan RAB yang diajukan oleh <strong class="text-slate-800">{{ $proposal->company->name }}</strong>.
                @else
                Melihat detail Rencana Anggaran Biaya (RAB) untuk proposal ini.
                @endif
            </p>
        </div>
        <a wire:navigate href="{{ route('proposals.show', $proposal->id) }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition-colors shadow-sm whitespace-nowrap flex-shrink-0">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Kembali ke Proposal
            </div>
        </a>
    </div>

    @if($isRabAdjusted)
        <!-- Alert Banner -->
        <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 mb-8 flex items-start gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <div>
                <h4 class="font-bold text-sm">Mode Bandingkan (Side-by-Side)</h4>
                <p class="text-sm mt-1 opacity-90 text-blue-700">Periksa perbedaan antara target anggaran proyek awal (kiri/atas) dengan penawaran riil yang diajukan oleh calon mitra (kanan/bawah). Hal ini dapat mempermudah Anda dalam mengambil keputusan pada tahap negosiasi.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 items-start">
            <!-- RAB Proyek (UB) -->
            <div class="bg-white p-4 md:p-6 rounded-3xl border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-800 tracking-tight">RAB Proyek Anda</h2>
                        <p class="text-sm text-slate-500 mt-1">Nilai Acuan/Target Awal</p>
                    </div>
                </div>
                
                <div class="-mx-2 sm:mx-0">
                    <x-rab-display :rab="$proposal->project->rab" :hideTitle="true" :noCard="true" />
                </div>
            </div>

            <!-- RAB UMKM -->
            <div class="bg-white p-4 md:p-6 rounded-3xl border-2 border-blue-200 shadow-md relative overflow-hidden">
                <!-- Decorative Accent -->
                <div class="absolute top-0 right-0 w-48 h-48 bg-blue-400 rounded-full blur-[80px] opacity-20 -mr-10 -mt-10 pointer-events-none"></div>
                
                <div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
                    <div>
                        <h2 class="text-xl font-black text-blue-900 tracking-tight">RAB Diajukan (Penawaran)</h2>
                        <p class="text-sm text-blue-600 mt-1">Dibuat oleh <span class="font-bold">{{ $proposal->company->name }}</span></p>
                    </div>
                </div>
                
                <div class="-mx-2 sm:mx-0 relative z-10">
                    <x-rab-display :rab="$proposal->rab" :hideTitle="true" :noCard="true" />
                </div>
            </div>
        </div>
    @else
        <div class="max-w-4xl mx-auto">
            @if($hasProjectRab && $hasProposalRab)
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 mb-8 flex items-start gap-3 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <div>
                        <h4 class="font-bold text-sm">Disetujui Tanpa Penyesuaian</h4>
                        <p class="text-sm mt-1 opacity-90 text-emerald-700">Mitra menyetujui Rencana Anggaran Biaya (RAB) awal proyek Anda tanpa ada perubahan nilai sedikitpun.</p>
                    </div>
                </div>

                <div class="bg-white p-4 md:p-6 rounded-3xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-black text-slate-800 tracking-tight">RAB Disetujui</h2>
                            <p class="text-sm text-slate-500 mt-1">Sesuai dengan target awal proyek Anda.</p>
                        </div>
                    </div>
                    
                    <div class="-mx-2 sm:mx-0">
                        <x-rab-display :rab="$proposal->project->rab" :hideTitle="true" :noCard="true" />
                    </div>
                </div>
            @elseif(!$hasProjectRab && $hasProposalRab)
                <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 mb-8 flex items-start gap-3 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    <div>
                        <h4 class="font-bold text-sm">RAB Penawaran</h4>
                        <p class="text-sm mt-1 opacity-90 text-blue-700">Proyek Anda tidak memiliki RAB acuan, namun mitra ini melampirkan usulan RAB.</p>
                    </div>
                </div>

                <div class="bg-white p-4 md:p-6 rounded-3xl border-2 border-blue-200 shadow-md relative overflow-hidden">
                    <div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-black text-blue-900 tracking-tight">RAB Diajukan (Penawaran)</h2>
                            <p class="text-sm text-blue-600 mt-1">Dibuat oleh <span class="font-bold">{{ $proposal->company->name }}</span></p>
                        </div>
                    </div>
                    
                    <div class="-mx-2 sm:mx-0">
                        <x-rab-display :rab="$proposal->rab" :hideTitle="true" :noCard="true" />
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
