@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto pb-10" x-data="{ activeTab: '{{ request('tab', 'overview') }}', lightboxOpen: false, lightboxImage: '' }">
    
    <!-- Top padding for layout balance -->
    <div class="pt-2"></div>

    <!-- Hero Section -->
    <x-company.hero :company="$company" />
    
    <div class="flex flex-col lg:flex-row gap-8 mt-6">
        <!-- Left Column: Main Content (2/3 width) -->
        <div class="w-full lg:w-2/3">
            
            <!-- Tabs Navigation -->
            <div class="flex border-b border-slate-200 gap-6 mb-6 overflow-x-auto hide-scrollbar snap-x">
                <button @click="activeTab = 'overview'; window.history.replaceState(null, null, '?tab=overview')" 
                    :class="activeTab === 'overview' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors whitespace-nowrap snap-start">
                    Ringkasan
                </button>
                @if($company->projects->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
                <button @click="activeTab = 'offerings'; window.history.replaceState(null, null, '?tab=offerings')" 
                    :class="activeTab === 'offerings' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors whitespace-nowrap snap-start">
                    Proyek & Peluang KSO
                </button>
                @endif
                @if($company->portfolios->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
                <button @click="activeTab = 'portfolios'; window.history.replaceState(null, null, '?tab=portfolios')" 
                    :class="activeTab === 'portfolios' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors whitespace-nowrap">
                    Portofolio Proyek
                </button>
                @endif
                
                <!-- Mobile Only Tab -->
                <button @click="activeTab = 'legalitas'; window.history.replaceState(null, null, '?tab=legalitas')" 
                    :class="activeTab === 'legalitas' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="py-3 px-1 border-b-2 font-semibold text-sm transition-colors lg:hidden whitespace-nowrap">
                    Legalitas
                </button>
            </div>

            <!-- Tab Content: Overview -->
            <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <livewire:company.tabs.overview :company="$company" />
            </div>

            <!-- Tab Content: Offerings -->
            @if($company->projects->count() > 0 || (auth()->check() && auth()->user()->company && auth()->user()->company->id === $company->id))
            <div x-show="activeTab === 'offerings'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <livewire:company.tabs.offerings :company="$company" lazy />
            </div>
            @endif

            <!-- Tab Content: Portfolios -->
            <div x-show="activeTab === 'portfolios'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <livewire:company.tabs.portfolios :company="$company" lazy />
            </div>
            
            <!-- Tab Content: Legalitas (Mobile Only) -->
            <div x-show="activeTab === 'legalitas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="lg:hidden">
                <livewire:company.tabs.legalitas :company="$company" lazy />
            </div>
            
        </div>
        
        <!-- Right Column: Sidebar (1/3 width) -->
        <div class="w-full lg:w-1/3">
            <div class="sticky top-6 flex flex-col gap-6">
                
                <!-- Details Card (Desktop Only) -->
                <x-company.legalitas :company="$company" class="hidden lg:block" />
                
            </div>
        </div>
    </div>
        
    <!-- Lightbox Modal -->
    <div x-show="lightboxOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4" x-transition.opacity style="display: none;">
        <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white p-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <img :src="lightboxImage" class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl" @click.away="lightboxOpen = false">
    </div>

    <!-- Invite Modal -->
    @include('components.invite-modal')
</div>
@endsection
