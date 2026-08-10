@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Notifikasi</h1>
        <p class="text-slate-500 mt-2">Kelola undangan dan pemberitahuan Anda.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 text-red-700 border border-red-200 p-4 rounded-xl mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse($invitations as $invitation)
            @php
                $isSender = auth()->user()->company && $invitation->inviting_company_id === auth()->user()->company->id;
                $otherCompany = $isSender ? $invitation->invitedCompany : $invitation->invitingCompany;
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 transition-all hover:shadow-md">
                <div class="flex flex-col sm:flex-row gap-5">
                    <!-- Avatar/Logo -->
                    <div class="w-14 h-14 shrink-0 rounded-full border border-slate-200 overflow-hidden bg-slate-50 flex items-center justify-center">
                        @if($otherCompany->logo)
                            <img src="{{ Storage::url($otherCompany->logo) }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            <span class="text-xl font-bold text-slate-400">{{ substr($otherCompany->name, 0, 1) }}</span>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-2">
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg">
                                    <a href="{{ route('vendor.show', $otherCompany->id) }}" class="hover:text-blue-600 transition-colors">
                                        {{ $otherCompany->name }}
                                    </a>
                                </h3>
                                <p class="text-slate-600">
                                    @if($isSender)
                                        @if($invitation->status === 'accepted')
                                            telah <span class="font-bold text-emerald-600">menerima</span> undangan Anda untuk proyek <span class="font-bold text-slate-800">"{{ $invitation->project->title }}"</span>.
                                        @elseif($invitation->status === 'rejected')
                                            telah <span class="font-bold text-red-600">menolak</span> undangan Anda untuk proyek <span class="font-bold text-slate-800">"{{ $invitation->project->title }}"</span>.
                                        @endif
                                    @else
                                        Mengundang Anda untuk berpartisipasi dalam proyek <span class="font-bold text-slate-800">"{{ $invitation->project->title }}"</span>
                                    @endif
                                </p>
                            </div>
                            <span class="text-xs text-slate-400 whitespace-nowrap">{{ $invitation->updated_at->diffForHumans() }}</span>
                        </div>
                        
                        @if(!$isSender)
                            @if($invitation->status === 'pending')
                                <div class="flex gap-3 mt-4" x-data="{ showRejectModal: false }">
                                    <a href="{{ route('projects.show', $invitation->project_id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors shadow-sm">Lihat Proyek</a>
                                    
                                    <button type="button" @click="showRejectModal = true" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 font-medium rounded-lg text-sm transition-colors">Tolak</button>
                                    
                                    <!-- Reject Modal -->
                                    <div x-show="showRejectModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center">
                                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showRejectModal = false"></div>
                                        <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl p-6 sm:max-w-md w-full border border-slate-200 z-10 m-4">
                                            <h3 class="text-lg font-bold text-slate-900 mb-2">Tolak Undangan?</h3>
                                            <p class="text-sm text-slate-500 mb-5">Apakah Anda yakin ingin menolak tawaran proyek "{{ $invitation->project->title }}" dari {{ $otherCompany->name }}?</p>
                                            
                                            <div class="flex justify-end gap-3">
                                                <button type="button" @click="showRejectModal = false" class="px-4 py-2 text-sm font-bold text-slate-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50">Batal</button>
                                                <form action="{{ route('invitations.update', $invitation->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700">Ya, Tolak</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4">
                                    @if($invitation->status === 'accepted')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-sm font-semibold rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                            Undangan Diterima
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-600 border border-slate-200 text-sm font-semibold rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            Anda menolak tawaran proyek ini
                                        </span>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 border-dashed">
                <svg class="mx-auto h-12 w-12 text-slate-400 mb-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Belum ada notifikasi</h3>
                <p class="text-slate-500">Undangan proyek dari Usaha Besar akan muncul di sini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
