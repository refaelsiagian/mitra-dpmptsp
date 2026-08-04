@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Profil Perusahaan</h1>
            <p class="text-slate-500 font-medium mt-1">Informasi detail mengenai identitas dan legalitas perusahaan Anda.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali ke Dashboard
        </a>
    </div>

    @if(!$company)
        <div class="bg-amber-50 border border-amber-200 text-amber-800 p-6 rounded-xl flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-500"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <p class="font-medium">Data perusahaan belum lengkap. Silakan lakukan pendaftaran terlebih dahulu.</p>
        </div>
    @else
        <div class="space-y-6">
            <!-- Informasi Utama -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                        Identitas Utama
                    </h2>
                    @if($company->status === 'pending')
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full border border-amber-200">Menunggu Peninjauan</span>
                    @elseif($company->status === 'approved')
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider rounded-full border border-emerald-200">Terverifikasi</span>
                    @endif
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8">
                    <div>
                        <p class="text-sm font-medium text-slate-400 mb-1">Nama Perusahaan</p>
                        <p class="text-base font-semibold text-slate-900">{{ ucwords($company->name) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-400 mb-1">Bentuk Usaha</p>
                        <p class="text-base font-semibold text-slate-900">{{ ucwords(str_replace('-', ' ', $company->pelaku_usaha_type)) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-400 mb-1">Skala Usaha</p>
                        <p class="text-base font-semibold text-slate-900">{{ ucwords($company->skala_usaha) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-400 mb-1">Detail Usaha</p>
                        <p class="text-base font-semibold text-slate-900">{{ strtoupper($company->pelaku_usaha_detail ?? '-') }}</p>
                    </div>
                </div>
            </div>

            <!-- Legalitas -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 9h6"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>
                        Legalitas (NIB & NPWP)
                    </h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Induk Berusaha</p>
                        <p class="text-lg font-bold text-slate-900 font-mono tracking-wide mb-2">{{ $company->nib_number }}</p>
                        <a href="{{ $company->nib_link }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1">
                            Lihat Dokumen <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                        </a>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Pokok Wajib Pajak</p>
                        <p class="text-lg font-bold text-slate-900 font-mono tracking-wide mb-2">{{ $company->npwp_number }}</p>
                        <a href="{{ $company->npwp_link }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1">
                            Lihat Dokumen <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                        </a>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status PKP</p>
                        @if($company->is_pkp)
                            <p class="text-lg font-bold text-green-700 tracking-wide mb-2">SUDAH PKP</p>
                            @if($company->pkp_link)
                            <a href="{{ $company->pkp_link }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1">
                                Lihat Dokumen <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                            </a>
                            @endif
                        @else
                            <p class="text-lg font-bold text-slate-400 tracking-wide mb-2">BELUM PKP</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Penanggung Jawab -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
                        Penanggung Jawab
                    </h2>
                </div>
                <div class="p-6">
                    @foreach($company->representatives as $rep)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 {{ !$loop->last ? 'mb-6 pb-6 border-b border-slate-100' : '' }}">
                            <div>
                                <p class="text-sm font-medium text-slate-400 mb-1">Nama Lengkap</p>
                                <p class="text-base font-bold text-slate-900">{{ $rep->name }}</p>
                                <p class="text-sm font-medium text-slate-500">{{ $rep->position }}</p>
                            </div>
                            <div class="sm:text-right">
                                <p class="text-sm font-medium text-slate-400 mb-1">Identitas ({{ $rep->identity_type }})</p>
                                <p class="text-base font-semibold text-slate-900 font-mono tracking-wide">{{ $rep->identity_number }}</p>
                                <p class="text-sm font-medium text-slate-500">{{ $rep->citizenship_type }} {{ $rep->nationality ? '- ' . $rep->nationality : '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Lokasi -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        Lokasi Perusahaan
                    </h2>
                </div>
                <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($company->locations as $loc)
                        <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 relative overflow-hidden">
                            <!-- Background Icon decoration -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute -bottom-10 -right-6 text-slate-200/50"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            
                            <div class="relative z-10">
                                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                                    @if($loc->type === 'KANTOR_UTAMA')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                        Kantor Utama
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-500"><rect width="16" height="16" x="4" y="4" rx="2"/><rect width="6" height="6" x="9" y="9" rx="1"/><path d="M12 4v16"/><path d="M4 12h16"/></svg>
                                        Lokasi Usaha
                                    @endif
                                </h3>
                                <p class="text-sm text-slate-800 leading-relaxed mb-6">{{ $loc->address }}</p>
                                
                                <div class="text-xs font-medium text-slate-500 space-y-3">
                                    <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-2">
                                        <div class="text-slate-400">Provinsi:</div>
                                        <div class="col-span-2 text-slate-700 uppercase">{{ optional($loc->province)->name ?? '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-2">
                                        <div class="text-slate-400">Kabupaten/Kota:</div>
                                        <div class="col-span-2 text-slate-700 uppercase">{{ optional($loc->regency)->name ?? '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-2">
                                        <div class="text-slate-400">Kecamatan:</div>
                                        <div class="col-span-2 text-slate-700 uppercase">{{ optional($loc->district)->name ?? '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-2">
                                        <div class="text-slate-400">Kelurahan:</div>
                                        <div class="col-span-2 text-slate-700 uppercase">{{ optional($loc->village)->name ?? '-' }}</div>
                                    </div>
                                </div>
                                @if($loc->latitude && $loc->longitude)
                                    <div class="mt-4 pt-4 border-t border-slate-200">
                                        <p class="text-xs font-medium text-slate-400 mb-1">Koordinat Peta</p>
                                        <p class="text-sm font-mono text-slate-700 font-bold bg-white px-2 py-1 inline-block rounded border border-slate-200">{{ $loc->latitude }}, {{ $loc->longitude }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- KBLI -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Daftar KBLI (Bidang Usaha)
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($company->kblis as $kbli)
                            <div class="flex flex-col sm:flex-row gap-4 p-5 rounded-xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-blue-200 transition-colors group">
                                <div class="w-16 h-16 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg flex-shrink-0 border border-blue-200 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    {{ $kbli->code }}
                                </div>
                                <div class="flex-1 flex flex-col justify-center">
                                    <h4 class="font-bold text-slate-900 mb-1">{{ $kbli->name }}</h4>
                                    <p class="text-sm text-slate-500 leading-relaxed">{{ $kbli->description ?? 'Berdasarkan Klasifikasi Baku Lapangan Usaha Indonesia (KBLI).' }}</p>
                                </div>
                            </div>
                        @endforeach
                        @if($company->kblis->isEmpty())
                            <p class="text-sm text-slate-500 italic p-4 text-center border-2 border-dashed border-slate-200 rounded-lg">Belum ada KBLI yang dipilih.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- Floating Action Bar -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] p-4 z-40 transform translate-y-0 transition-transform duration-300">
            <div class="max-w-4xl mx-auto flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800">Tindakan Admin</h3>
                    <p class="text-sm text-slate-500" id="feedback-counter">0 catatan revisi ditambahkan</p>
                </div>
                <div class="flex items-center gap-3">
                    <form action="{{ route('admin.reject', $company->id) }}" method="POST" id="form-reject">
                        @csrf
                        <button type="submit" id="btn-reject" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg shadow-sm transition-colors opacity-50 cursor-not-allowed" disabled>
                            Kembalikan untuk Revisi
                        </button>
                    </form>
                    <form action="{{ route('admin.approve', $company->id) }}" method="POST" id="form-approve">
                        @csrf
                        <button type="submit" id="btn-approve" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                            Verifikasi Perusahaan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Feedback Modal -->
        <div id="feedback-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <h3 class="font-bold text-slate-800">Tambah Catatan Revisi</h3>
                    <button type="button" id="close-modal" class="text-slate-400 hover:text-slate-600">
                        <i class="ph ph-x text-lg"></i>
                    </button>
                </div>
                <div class="p-6">
                    <p class="text-sm font-medium text-slate-500 mb-2">Field: <span id="modal-field-label" class="text-slate-800 font-bold"></span></p>
                    <input type="hidden" id="modal-field-name">
                    <textarea id="modal-message" rows="4" class="w-full p-3 border-slate-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm" placeholder="Jelaskan mengapa data ini perlu direvisi..."></textarea>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-between gap-3">
                    <button type="button" id="btn-delete-modal" class="px-4 py-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 font-medium rounded-lg transition-colors hidden">Hapus</button>
                    <div class="flex gap-3">
                        <button type="button" id="btn-cancel-modal" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors">Batal</button>
                        <button type="button" id="btn-save-feedback" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg shadow-sm transition-colors">Simpan Catatan</button>
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const companyId = {{ $company->id ?? 'null' }};
        if(!companyId) return;

        // Existing feedbacks from DB
        let feedbacks = @json($company->feedbacks->keyBy('field_name'));
        
        const feedbackModal = document.getElementById('feedback-modal');
        const modalFieldLabel = document.getElementById('modal-field-label');
        const modalFieldName = document.getElementById('modal-field-name');
        const modalMessage = document.getElementById('modal-message');
        
        const btnReject = document.getElementById('btn-reject');
        const btnApprove = document.getElementById('btn-approve');
        const feedbackCounter = document.getElementById('feedback-counter');

        // Fields mapping for adding the "+" button
        // We will map display labels to the actual input IDs used in the verify form
        const fieldMap = {
            'Nama Perusahaan': 'company-name',
            'Bentuk Usaha': 'pelaku-usaha',
            'Skala Usaha': 'skala-usaha',
            'Detail Usaha': 'pelaku-usaha-detail',
            'Nomor Induk Berusaha': 'nib-number',
            'Nomor Pokok Wajib Pajak': 'npwp-number',
            'Status PKP': 'pkp-yes', // representative mapping
            'Penanggung Jawab': 'penanggung-jawab',
            'Lokasi Perusahaan': 'lokasi-perusahaan',
            'Daftar KBLI (Bidang Usaha)': 'kbli-search'
        };

        function updateActionButtons() {
            const count = Object.keys(feedbacks).length;
            feedbackCounter.textContent = `${count} catatan revisi ditambahkan`;
            
            if (count > 0) {
                btnReject.disabled = false;
                btnReject.classList.remove('opacity-50', 'cursor-not-allowed');
                
                btnApprove.disabled = true;
                btnApprove.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                btnReject.disabled = true;
                btnReject.classList.add('opacity-50', 'cursor-not-allowed');
                
                btnApprove.disabled = false;
                btnApprove.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            
            // Re-render UI indicators
            document.querySelectorAll('.feedback-btn').forEach(btn => {
                const fieldName = btn.dataset.field;
                const hasFeedback = feedbacks[fieldName] !== undefined;
                
                if (hasFeedback) {
                    btn.innerHTML = '<i class="ph ph-pencil-simple text-white"></i>';
                    btn.classList.remove('bg-slate-100', 'text-slate-400', 'hover:bg-amber-100', 'hover:text-amber-600');
                    btn.classList.add('bg-amber-500', 'hover:bg-amber-600', 'shadow-sm');
                    btn.title = "Edit catatan revisi";
                } else {
                    btn.innerHTML = '<i class="ph ph-plus"></i>';
                    btn.classList.add('bg-slate-100', 'text-slate-400', 'hover:bg-amber-100', 'hover:text-amber-600');
                    btn.classList.remove('bg-amber-500', 'hover:bg-amber-600', 'shadow-sm');
                    btn.title = "Tambah catatan revisi";
                }
            });
            
            // Render actual note boxes
            document.querySelectorAll('.feedback-note-box').forEach(el => el.remove());
            
            Object.values(feedbacks).forEach(fb => {
                const btn = document.querySelector(`.feedback-btn[data-field="${fb.field_name}"]`);
                if (btn) {
                    const noteBox = document.createElement('div');
                    noteBox.className = 'feedback-note-box mt-3 p-3 bg-red-50 border border-red-100 rounded-lg flex items-start gap-2 w-full';
                    noteBox.innerHTML = `
                        <i class="ph ph-warning-circle text-red-500 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-red-700 uppercase tracking-wider mb-1">Catatan Revisi</p>
                            <p class="text-sm text-red-600">${fb.message}</p>
                        </div>
                    `;
                    
                    if (btn.closest('h2')) {
                        // For section headers, add horizontal margins so it doesn't touch the edges
                        noteBox.className = 'feedback-note-box mx-6 mt-5 mb-1 p-3 bg-red-50 border border-red-100 rounded-lg flex items-start gap-2';
                        btn.closest('.border-b').insertAdjacentElement('afterend', noteBox);
                    } else {
                        // For regular fields, append it to the field's container div so it sits below the value
                        noteBox.className = 'feedback-note-box mt-3 p-3 bg-red-50 border border-red-100 rounded-lg flex items-start gap-2 w-full';
                        btn.closest('div').appendChild(noteBox);
                    }
                }
            });
            
            // Bind delete buttons
            document.querySelectorAll('.delete-feedback').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const fieldName = this.dataset.field;
                    deleteFeedback(fieldName);
                });
            });
        }

        // Inject + buttons
        document.querySelectorAll('p.text-sm.font-medium.text-slate-400, p.text-xs.font-bold.text-slate-500, h2.text-lg').forEach(el => {
            const labelText = el.textContent.replace(/\s+/g, ' ').trim();
            const fieldName = fieldMap[labelText];
            
            if (fieldName) {
                // Ensure parent is relative
                el.classList.add('flex', 'items-center', 'justify-between');
                
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'feedback-btn w-6 h-6 rounded-full flex items-center justify-center transition-colors';
                btn.dataset.field = fieldName;
                btn.dataset.label = labelText;
                
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    modalFieldLabel.textContent = labelText;
                    modalFieldName.value = fieldName;
                    
                    const hasFeedback = feedbacks[fieldName];
                    modalMessage.value = hasFeedback ? hasFeedback.message : '';
                    
                    const btnDeleteModal = document.getElementById('btn-delete-modal');
                    if (hasFeedback) {
                        btnDeleteModal.classList.remove('hidden');
                        btnDeleteModal.dataset.field = fieldName;
                    } else {
                        btnDeleteModal.classList.add('hidden');
                    }
                    
                    feedbackModal.classList.remove('hidden');
                    modalMessage.focus();
                });
                
                el.appendChild(btn);
            }
        });

        updateActionButtons();

        // Modal interactions
        document.getElementById('close-modal').addEventListener('click', () => feedbackModal.classList.add('hidden'));
        document.getElementById('btn-cancel-modal').addEventListener('click', () => feedbackModal.classList.add('hidden'));
        
        document.getElementById('btn-delete-modal').addEventListener('click', async function() {
            const fieldName = this.dataset.field;
            if (confirm('Yakin ingin menghapus catatan revisi ini?')) {
                await deleteFeedback(fieldName);
                feedbackModal.classList.add('hidden');
            }
        });
        
        document.getElementById('btn-save-feedback').addEventListener('click', async () => {
            const fieldName = modalFieldName.value;
            const message = modalMessage.value.trim();
            
            if (!message) {
                alert('Pesan catatan tidak boleh kosong');
                return;
            }
            
            try {
                const response = await fetch(`/admin/review/${companyId}/feedback`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ field_name: fieldName, message: message })
                });
                
                const data = await response.json();
                if (data.success) {
                    feedbacks[fieldName] = data.feedback;
                    updateActionButtons();
                    feedbackModal.classList.add('hidden');
                }
            } catch(e) {
                console.error(e);
                alert('Gagal menyimpan catatan');
            }
        });

        async function deleteFeedback(fieldName) {
            try {
                const response = await fetch(`/admin/review/${companyId}/feedback/remove`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ field_name: fieldName })
                });
                
                const data = await response.json();
                if (data.success) {
                    delete feedbacks[fieldName];
                    updateActionButtons();
                }
            } catch(e) {
                console.error(e);
                alert('Gagal menghapus catatan');
            }
        }
    });
</script>
@endsection
