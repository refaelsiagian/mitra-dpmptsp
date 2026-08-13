@props([
    'name', 
    'label', 
    'id' => null, 
    'type' => 'text', 
    'placeholder' => '', 
    'required' => false, 
    'value' => null, 
    'feedbackKey' => null,
    'icon' => null
])

@php
    $id = $id ?? $name;
    $feedbackKey = $feedbackKey ?? $id;
@endphp

<div class="">
    <label class="block text-sm font-medium text-gray-700 mb-1" for="{{ $id }}" id="label-{{ $id }}">
        {!! $label !!} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <div class="relative rounded-lg shadow-sm">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="ph {{ $icon }} text-gray-400 text-lg"></i>
            </div>
        @endif
        <input 
            name="{{ $name }}" 
            value="{{ old($name, $value) }}" 
            id="{{ $id }}" 
            type="{{ $type }}" 
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'w-full py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white pr-4 ' . ($icon ? 'pl-10' : 'pl-4')]) }}
        >
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
