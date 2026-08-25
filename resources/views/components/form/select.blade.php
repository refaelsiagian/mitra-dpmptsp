@props([
    'name', 
    'label', 
    'id' => null, 
    'required' => false, 
    'value' => null, 
    'feedbackKey' => null
])

@php
    $id = $id ?? $name;
    $feedbackKey = $feedbackKey ?? $id;
@endphp

<div class="" x-data="{
    open: false,
    value: '',
    search: '',
    options: [],
    isDisabled: false,
    init() {
        this.updateOptions();
        
        let observer = new MutationObserver(() => {
            this.updateOptions();
        });
        observer.observe(this.$refs.nativeSelect, { childList: true, subtree: true, attributes: true });
        
        this.$refs.nativeSelect.addEventListener('change', () => {
            this.value = this.$refs.nativeSelect.value;
        });
        
        this.value = this.$refs.nativeSelect.value;
        
        // Intercept .value setter to catch x-model updates from parent
        let descriptor = Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype, 'value');
        let self = this;
        if (descriptor) {
            Object.defineProperty(this.$refs.nativeSelect, 'value', {
                get: function() { return descriptor.get.call(this); },
                set: function(val) { 
                    descriptor.set.call(this, val);
                    if (self.value !== val) {
                        self.value = val;
                    }
                }
            });
        }
        
        // Fallback polling for value sync just in case
        setInterval(() => {
            if (this.value !== this.$refs.nativeSelect.value) {
                this.value = this.$refs.nativeSelect.value;
            }
        }, 100);
        
        this.isDisabled = this.$refs.nativeSelect.disabled;
        let attrObserver = new MutationObserver(() => {
            this.isDisabled = this.$refs.nativeSelect.disabled;
        });
        attrObserver.observe(this.$refs.nativeSelect, { attributes: true, attributeFilter: ['disabled'] });

        this.$watch('open', value => {
            if (value) {
                this.search = '';
                setTimeout(() => {
                    if (this.$refs.searchInput) this.$refs.searchInput.focus();
                }, 100);
            }
        });
    },
    updateOptions() {
        this.options = Array.from(this.$refs.nativeSelect.options).map(opt => ({
            value: opt.value,
            text: opt.text,
            disabled: opt.disabled,
            selected: opt.selected
        }));
        this.value = this.$refs.nativeSelect.value;
    },
    selectOption(val) {
        this.value = val;
        this.$refs.nativeSelect.value = val;
        this.$refs.nativeSelect.dispatchEvent(new Event('change', { bubbles: true }));
        this.$refs.nativeSelect.dispatchEvent(new Event('input', { bubbles: true }));
        this.open = false;
    },
    get selectedText() {
        let opt = this.options.find(o => o.value == this.value);
        return opt ? opt.text : 'Pilih...';
    },
    get filteredOptions() {
        if (this.search === '') return this.options;
        return this.options.filter(opt => opt.text.toLowerCase().includes(this.search.toLowerCase()) || opt.disabled);
    }
}">
    <label class="block text-sm font-medium text-gray-700 mb-1" for="{{ $id }}" id="label-{{ $id }}">
        {!! $label !!} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    
    <!-- Hidden native select to maintain form submission and x-model functionality -->
    <select x-ref="nativeSelect"
        name="{{ $name }}" 
        id="{{ $id }}"
        class="hidden"
        {{ $attributes }}
    >
        {{ $slot }}
    </select>

    <!-- Custom Alpine.js Styled Dropdown -->
    <div class="relative" @click.outside="open = false">
        <button type="button" 
            @click="if(!isDisabled) open = !open" 
            class="w-full flex items-center justify-between px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors shadow-sm"
            :class="isDisabled ? 'bg-gray-50 text-gray-400 cursor-not-allowed border-gray-200' : 'bg-white cursor-pointer hover:border-blue-400'"
            :disabled="isDisabled">
            
            <span class="font-medium truncate" :class="isDisabled ? 'text-gray-400' : (value ? 'text-gray-900' : 'text-gray-500')" x-text="selectedText"></span>
            
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 ml-2 transition-transform duration-200" :class="{'rotate-180': open, 'text-gray-300': isDisabled, 'text-gray-400': !isDisabled}"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        
        <div x-show="open" style="display: none;" 
            x-transition:enter="transition ease-out duration-100" 
            x-transition:enter-start="transform opacity-0 scale-95" 
            x-transition:enter-end="transform opacity-100 scale-100" 
            x-transition:leave="transition ease-in duration-75" 
            x-transition:leave-start="transform opacity-100 scale-100" 
            x-transition:leave-end="transform opacity-0 scale-95" 
            class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg flex flex-col max-h-60 overflow-hidden">
            
            <div x-show="options.length > 5" class="p-2 border-b border-gray-100 sticky top-0 bg-white z-10">
                <div class="relative">
                    <i class="ph ph-magnifying-glass absolute left-2 top-2.5 text-gray-400"></i>
                    <input type="text" x-ref="searchInput" x-model="search" class="w-full text-sm outline-none pl-7 pr-2 py-1.5 bg-gray-50 rounded border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="Cari..." @click.stop @keydown.stop>
                </div>
            </div>

            <ul class="overflow-y-auto flex-1 p-1">
                <template x-for="(opt, index) in filteredOptions" :key="index">
                    <li x-show="!opt.disabled || index === 0" @click="if(!opt.disabled) selectOption(opt.value)" 
                        class="px-3 py-2 rounded-lg text-sm transition-colors" 
                        :class="[
                            opt.disabled ? 'text-gray-400 cursor-not-allowed bg-gray-50' : 'cursor-pointer hover:bg-blue-50 hover:text-blue-700',
                            value == opt.value && !opt.disabled ? 'text-blue-700 bg-blue-50 font-semibold' : 'text-gray-700'
                        ]">
                        <span x-text="opt.text"></span>
                    </li>
                </template>
                <li x-show="filteredOptions.filter(o => !o.disabled).length === 0" class="px-3 py-2 text-gray-400 italic text-center text-sm">
                    Tidak ditemukan
                </li>
            </ul>
        </div>
    </div>
    @error($name)
        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
    @enderror
    @if(isset($feedbacks) && isset($feedbacks[$feedbackKey]))
        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100 flex gap-2 items-start">
            <i class="ph ph-warning-circle mt-0.5"></i> 
            <div>
                <span class="font-bold text-xs uppercase tracking-wider block mb-0.5">Catatan Revisi</span>
                {{ $feedbacks[$feedbackKey]->message }}
            </div>
        </div>
    @endif
</div>
