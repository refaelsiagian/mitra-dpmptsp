<?php

use Livewire\Component;
use App\Models\Company;

new class extends Component {
    public Company $company;

    public function placeholder()
    {
        return view('components.dashboard.tabs.skeleton');
    }
};
?>

<div class="">
    <x-company.legalitas :company="$company" />
</div>
