<?php

use Livewire\Component;
use App\Models\Company;

new class extends Component {
    public Company $company;

    public function with()
    {
        $pinnedProject = $this->company->projects->where('is_pinned', true)->where('status', 'published')->first();
        $pinnedOffering = $this->company->offerings->where('is_pinned', true)->first();

        return [
            'pinnedProject' => $pinnedProject,
            'pinnedOffering' => $pinnedOffering,
        ];
    }
};
?>

<div class="space-y-6">
    <!-- Pinned Project Box (Highlights an Active Project) -->
    <x-company.pinned-project :pinnedProject="$pinnedProject" />

    <!-- Pinned Offering Box (Highlights a Service/Offering) -->
    <x-company.pinned-offering :pinnedOffering="$pinnedOffering" />
    
    <!-- About Description Card -->
    <x-company.about-card :company="$company" />
</div>
