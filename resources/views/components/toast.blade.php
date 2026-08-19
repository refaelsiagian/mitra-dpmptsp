@if(session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms class="fixed top-6 left-1/2 -translate-x-1/2 z-[110] bg-slate-800 border border-slate-700 text-white px-5 py-3.5 rounded-xl shadow-2xl flex items-center gap-3">
    <div class="bg-emerald-500/20 text-emerald-400 rounded-full p-1 shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
    </div>
    <p class="font-bold text-sm">{{ session('success') }}</p>
    <button @click="show = false" class="text-slate-400 hover:text-white ml-2 transition-colors shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div>
@endif

@if(session('info'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms class="fixed top-6 left-1/2 -translate-x-1/2 z-[110] bg-slate-800 border border-slate-700 text-white px-5 py-3.5 rounded-xl shadow-2xl flex items-center gap-3">
    <div class="bg-blue-500/20 text-blue-400 rounded-full p-1 shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
    </div>
    <p class="font-bold text-sm">{{ session('info') }}</p>
    <button @click="show = false" class="text-slate-400 hover:text-white ml-2 transition-colors shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div>
@endif
