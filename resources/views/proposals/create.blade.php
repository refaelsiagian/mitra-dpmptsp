@extends('layouts.dashboard')

@section('content')
@php
    $isUB = auth()->check() && auth()->user()->company ? in_array(strtolower(auth()->user()->company->skala_usaha ?? ''), ['besar']) : false;
    $isProjectUB = $project->company ? in_array(strtolower($project->company->skala_usaha ?? ''), ['besar']) : false;
    $isKetertarikan = $isUB && !$isProjectUB;
    $pageTitle = $isKetertarikan ? 'Kirim Ketertarikan' : 'Kirim Penawaran';
    $pageDesc = $isKetertarikan ? 'Ajukan permintaan atau ketertarikan Anda terhadap produk/layanan ini.' : 'Ajukan proposal penawaran Anda untuk proyek ini.';
@endphp

<div class="max-w-4xl mx-auto pb-10">
    <div class="pt-4 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $pageTitle }}</h1>
            <p class="text-slate-500 text-sm mt-1">Ke proyek: <span class="font-semibold text-slate-700">{{ $project->title }}</span></p>
        </div>
        <a wire:navigate href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition-colors shadow-sm">
            Batal
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 border border-red-200">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 border border-red-200">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('proposals.store', $project->id) }}" method="POST" enctype="multipart/form-data" x-data="proposalForm()">
            @csrf

            <!-- Form Body -->
            <div class="p-6 md:p-8 space-y-8">
                
                <!-- Cover Letter -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pesan Pengantar <span class="text-red-500">*</span></label>
                    <p class="text-xs text-slate-500 mb-3">
                        {{ $isKetertarikan ? 'Jelaskan secara singkat ketertarikan atau kebutuhan spesifik Anda terhadap penawaran ini.' : 'Jelaskan secara singkat mengapa perusahaan Anda cocok untuk kebutuhan ini.' }}
                    </p>
                    <textarea name="cover_letter" rows="5" required class="block w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">{{ old('cover_letter') }}</textarea>
                </div>

                <!-- RAB Options -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Rencana Anggaran Biaya (RAB) / Nilai Penawaran <span class="text-red-500">*</span></label>
                    <p class="text-xs text-slate-500 mb-4">Pilih bagaimana Anda ingin menyusun anggaran biaya untuk penawaran ini.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        @if($project->rab)
                        <label class="relative flex items-start p-4 cursor-pointer rounded-xl border-2 transition-all duration-200" :class="rabMode === 'use_project' ? 'border-blue-600 bg-blue-50' : 'border-slate-200 bg-white hover:border-blue-300'">
                            <div class="flex items-center h-5">
                                <input type="radio" name="rab_mode" value="use_project" x-model="rabMode" class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-600 focus:ring-2">
                            </div>
                            <div class="ml-3 text-sm flex-1">
                                <span class="font-bold text-slate-900 block">Setujui RAB Proyek</span>
                                <span class="text-slate-500 block text-xs mt-1">Gunakan estimasi RAB bawaan proyek (Rp {{ number_format($project->rab->total_amount, 0, ',', '.') }}).</span>
                            </div>
                        </label>
                        
                        <label class="relative flex items-start p-4 cursor-pointer rounded-xl border-2 transition-all duration-200" :class="rabMode === 'edit_project' ? 'border-blue-600 bg-blue-50' : 'border-slate-200 bg-white hover:border-blue-300'">
                            <div class="flex items-center h-5">
                                <input type="radio" name="rab_mode" value="edit_project" x-model="rabMode" class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-600 focus:ring-2">
                            </div>
                            <div class="ml-3 text-sm flex-1">
                                <span class="font-bold text-slate-900 block">Sesuaikan RAB Proyek</span>
                                <span class="text-slate-500 block text-xs mt-1">Modifikasi rincian RAB bawaan dari proyek sebagai dasar.</span>
                            </div>
                        </label>
                        @endif
                        
                        <label class="relative flex items-start p-4 cursor-pointer rounded-xl border-2 transition-all duration-200" :class="rabMode === 'create_new' ? 'border-blue-600 bg-blue-50' : 'border-slate-200 bg-white hover:border-blue-300'">
                            <div class="flex items-center h-5">
                                <input type="radio" name="rab_mode" value="create_new" x-model="rabMode" class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-600 focus:ring-2">
                            </div>
                            <div class="ml-3 text-sm flex-1">
                                <span class="font-bold text-slate-900 block">Buat RAB Sendiri</span>
                                <span class="text-slate-500 block text-xs mt-1">Susun rincian RAB dari awal secara detail.</span>
                            </div>
                        </label>
                        
                    </div>
                    
                    <!-- Project Value Display -->
                    <div x-show="rabMode === 'use_project'" style="display: none;" x-transition class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Total Nilai Penawaran</label>
                        <p class="text-xs text-slate-500 mb-3">Nilai ini otomatis disalin dari RAB proyek yang dibuat oleh pemilik proyek.</p>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-500 font-bold">Rp</span>
                            </div>
                            <input type="number" name="estimated_value" value="{{ $project->rab ? $project->rab->total_amount : 0 }}" readonly class="block w-full pl-12 pr-4 py-3 bg-slate-100 border border-slate-300 rounded-xl text-slate-500 focus:outline-none">
                        </div>
                    </div>
                    
                    <!-- RAB Builder Container -->
                    <div x-show="rabMode === 'create_new' || rabMode === 'edit_project'" style="display: none;" x-transition>
                        
                        <template x-if="rabMode === 'create_new'">
                            <x-rab-builder />
                        </template>
                        
                        @if($project->rab)
                        <template x-if="rabMode === 'edit_project'">
                            @php
                                $initialRab = [];
                                $project->rab->load('categories.items');
                                foreach($project->rab->categories as $cat) {
                                    $items = [];
                                    foreach($cat->items as $item) {
                                        $items[] = [
                                            'id' => $item->id,
                                            'name' => $item->name,
                                            'volume' => $item->volume,
                                            'unit' => $item->unit,
                                            'unit_price' => $item->unit_price
                                        ];
                                    }
                                    $initialRab[] = [
                                        'id' => $cat->id,
                                        'name' => $cat->name,
                                        'items' => $items
                                    ];
                                }
                            @endphp
                            <x-rab-builder :initialData="$initialRab" />
                        </template>
                        @endif
                        
                    </div>
                </div>

                <!-- Pinned Portfolios -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pin Portofolio (Maksimal 3)</label>
                    <p class="text-xs text-slate-500 mb-4">
                        {{ $isKetertarikan ? 'Pilih hingga 3 portofolio perusahaan Anda yang relevan (jika diperlukan).' : 'Pilih hingga 3 portofolio yang paling relevan dengan proyek ini untuk ditonjolkan.' }}
                    </p>
                    
                    @if($portfolios->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($portfolios as $portfolio)
                            <label class="relative flex items-start p-4 cursor-pointer rounded-xl border-2 transition-all duration-200" 
                                   :class="selected.includes('{{ $portfolio->id }}') ? 'border-blue-600 bg-blue-50' : 'border-slate-200 bg-white hover:border-blue-300'">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="pinned_portfolios[]" value="{{ $portfolio->id }}" 
                                           x-model="selected" 
                                           @change="limitSelection"
                                           class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-600 focus:ring-2">
                                </div>
                                <div class="ml-3 text-sm flex-1">
                                    <span class="font-bold text-slate-900 block">{{ $portfolio->title }}</span>
                                    @if($portfolio->client_name)
                                        <span class="text-slate-500 block text-xs mt-1">Klien: {{ $portfolio->client_name }}</span>
                                    @endif
                                </div>
                            </label>
                            @endforeach
                        </div>
                        <p x-show="showWarning" style="display: none;" class="text-amber-600 text-xs font-semibold mt-2">Maksimal 3 portofolio yang dapat dipilih.</p>
                    @else
                        <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl text-center">
                            <p class="text-sm text-slate-500 mb-3">Anda belum memiliki portofolio yang dapat dilampirkan.</p>
                            <a href="{{ route('portfolios.create') }}" target="_blank" class="text-sm text-blue-600 font-bold hover:underline">Tambah Portofolio Sekarang</a>
                        </div>
                    @endif
                </div>

                <!-- Attachment -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lampiran Dokumen (Opsional)</label>
                    <p class="text-xs text-slate-500 mb-3">
                        {{ $isKetertarikan ? 'Unggah spesifikasi kebutuhan, draft kontrak, atau dokumen pendukung (PDF/ZIP, Max 10MB).' : 'Unggah proposal lengkap, RAB, atau dokumen teknis pendukung (PDF/ZIP, Max 10MB).' }}
                    </p>
                    <input type="file" name="attachment" accept=".pdf,.zip,.doc,.docx" @change="validateFileSize" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

            </div>

            <!-- Footer -->
            <div class="px-6 md:px-8 py-5 bg-slate-50 border-t border-slate-200 flex flex-col-reverse md:flex-row justify-end items-center gap-3">
                <a wire:navigate href="{{ route('projects.show', $project->id) }}" class="w-full md:w-auto px-6 py-3 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition-colors shadow-sm text-center">Batal</a>
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-colors shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9 22 2z"/></svg>
                    {{ $pageTitle }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function proposalForm() {
    return {
        rabMode: '{{ $project->rab ? "use_project" : "create_new" }}',
        selected: [],
        showWarning: false,
        limitSelection(e) {
            if (this.selected.length > 3) {
                // Remove the last selected item
                this.selected = this.selected.filter(id => id !== e.target.value);
                this.showWarning = true;
                setTimeout(() => { this.showWarning = false; }, 3000);
            }
        },
        validateFileSize(e) {
            const file = e.target.files[0];
            if (file && file.size > 10 * 1024 * 1024) { // 10MB limit
                window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Ukuran lampiran maksimal adalah 10MB.', type: 'error' } }));
                e.target.value = ''; // clear the input
            }
        }
    }
}
</script>
@endsection
