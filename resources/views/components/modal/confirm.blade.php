@props([
    'showProperty',
    'iconBgClass' => 'bg-red-100',
    'iconTextClass' => 'text-red-600',
    'title',
])

<template x-teleport="body">
    <div x-show="{{ $showProperty }}" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4"
         style="display: none;">
         
         <div x-show="{{ $showProperty }}"
              @click.away="{{ $showProperty }} = false"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
              x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden relative flex flex-col max-h-full">
            <div class="p-6 overflow-y-auto">
                <div class="w-12 h-12 rounded-full {{ $iconBgClass }} flex items-center justify-center mb-4">
                    <span class="{{ $iconTextClass }} inline-flex">
                        @if(isset($icon))
                            {{ $icon }}
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        @endif
                    </span>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2">{{ $title }}</h3>
                <div class="text-slate-600 text-sm mb-4 leading-relaxed">
                    {{ $slot }}
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3 shrink-0">
                <button type="button" @click="{{ $showProperty }} = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-200 bg-slate-100 rounded-xl transition-colors">
                    Batal
                </button>
                @if(isset($actions))
                    {{ $actions }}
                @endif
            </div>
        </div>
    </div>
</template>
