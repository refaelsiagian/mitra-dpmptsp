@props([
    'name', 
    'label', 
    'options', // expects an array like ['value' => 'Label']
    'required' => false, 
    'value' => null, 
    'feedbackKey' => null
])

@php
    $feedbackKey = $feedbackKey ?? $name;
@endphp

<div {{ $attributes->merge(['class' => '']) }}>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    
    <div class="flex gap-4">
        @foreach($options as $val => $text)
        <label class="flex items-center gap-2 cursor-pointer group">
            <input 
                type="radio" 
                name="{{ $name }}" 
                value="{{ $val }}" 
                class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300" 
                {{ old($name, $value) == $val ? 'checked' : '' }}
            >
            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">{{ $text }}</span>
        </label>
        @endforeach
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
