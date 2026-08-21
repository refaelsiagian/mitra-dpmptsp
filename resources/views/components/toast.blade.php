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

<!-- JS Triggered Toast (Vanilla JS to avoid CSP eval issues) -->
<div id="js-global-toast" class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999] bg-slate-800 border border-slate-700 text-white px-5 py-3.5 rounded-xl shadow-2xl flex items-center gap-3 transition-all duration-300 transform opacity-0 -translate-y-4 pointer-events-none">
    
    <div id="js-toast-success-icon" class="bg-emerald-500/20 text-emerald-400 rounded-full p-1 shrink-0 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
    </div>
    
    <div id="js-toast-error-icon" class="bg-red-500/20 text-red-400 rounded-full p-1 shrink-0 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
    </div>

    <p id="js-toast-message" class="font-bold text-sm"></p>
    <button onclick="hideJsToast()" class="text-slate-400 hover:text-white ml-2 transition-colors shrink-0 pointer-events-auto">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div>

<script>
    let jsToastTimer = null;
    
    function hideJsToast() {
        const toast = document.getElementById('js-global-toast');
        if (toast) {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', '-translate-y-4', 'pointer-events-none');
        }
    }

    window.addEventListener('show-toast', function(e) {
        const toast = document.getElementById('js-global-toast');
        const msgEl = document.getElementById('js-toast-message');
        const successIcon = document.getElementById('js-toast-success-icon');
        const errorIcon = document.getElementById('js-toast-error-icon');
        
        if (!toast || !msgEl) return;
        
        const detail = e.detail || {};
        msgEl.innerText = detail.message || '';
        
        if (detail.type === 'error') {
            errorIcon.classList.remove('hidden');
            successIcon.classList.add('hidden');
        } else {
            successIcon.classList.remove('hidden');
            errorIcon.classList.add('hidden');
        }
        
        toast.classList.remove('opacity-0', '-translate-y-4', 'pointer-events-none');
        toast.classList.add('opacity-100', 'translate-y-0');
        
        if (jsToastTimer) clearTimeout(jsToastTimer);
        jsToastTimer = setTimeout(() => {
            hideJsToast();
        }, 3000);
    });
</script>
