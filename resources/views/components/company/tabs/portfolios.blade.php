<?php

use Livewire\Component;
use App\Models\Company;

new class extends Component {
    public Company $company;

    public function with()
    {
        $partnerships = \App\Models\Proposal::where('company_id', $this->company->id)
            ->where('status', 'accepted')
            ->whereHas('project', function($q) {
                $q->whereIn('status', ['published', 'closed']);
            })
            ->with(['project.company', 'project.company.locations.regency'])
            ->latest()
            ->get();
            
        return [
            'partnerships' => $partnerships
        ];
    }
    
    public function placeholder()
    {
        return view('components.dashboard.tabs.skeleton');
    }
};
?>

<div class="">
    <x-company.portfolios :company="$company" :partnerships="$partnerships" />
</div>
