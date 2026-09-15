@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    <div class="pt-4 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Revisi RAB & Penawaran</h1>
            <p class="text-slate-500 text-sm mt-1">Ke proyek: <span class="font-semibold text-slate-700">{{ $proposal->project->title }}</span></p>
        </div>
        <a wire:navigate href="{{ route('proposals.show', $proposal->id) }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition-colors shadow-sm">
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
        <form action="{{ route('proposals.update-rab', $proposal->id) }}" method="POST" x-data="rabRevisionForm()">
            @csrf
            @method('PUT')
            <input type="hidden" name="rab_mode" value="builder">

            <div class="p-6 md:p-8 space-y-8">
                
                <!-- Builder -->
                <div>
                    @php
                        $initialRab = [];
                        if ($proposal->rab) {
                            $proposal->rab->load('categories.items');
                            foreach($proposal->rab->categories as $cat) {
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
                        }
                    @endphp
                    <x-rab-builder :initialData="$initialRab" />
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 md:px-8 py-5 bg-slate-50 border-t border-slate-200 flex flex-col-reverse md:flex-row justify-end items-center gap-3">
                <a wire:navigate href="{{ route('proposals.show', $proposal->id) }}" class="w-full md:w-auto px-6 py-3 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition-colors shadow-sm text-center">Batal</a>
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-colors shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Simpan Revisi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function rabRevisionForm() {
    return {
    }
}
</script>
@endsection
