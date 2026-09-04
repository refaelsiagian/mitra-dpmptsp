<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;
use App\Models\Project;
use App\Models\Province;
use App\Models\Kbli;

class ExploreMarketplace extends Component
{
    public $search = '';
    public $kbli = '';
    public $scheme = '';
    
    public $province_id = '';
    public $regency_id = '';
    public $district_id = '';
    public $village_id = '';
    
    public $activeTab = 'vendors';
    
    public $perPageVendors = 10;
    public $perPageProjects = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'kbli' => ['except' => ''],
        'scheme' => ['except' => ''],
        'province_id' => ['except' => ''],
        'regency_id' => ['except' => ''],
        'district_id' => ['except' => ''],
        'village_id' => ['except' => ''],
        'activeTab' => ['except' => 'vendors', 'as' => 'tab'],
    ];

    public function loadMoreVendors()
    {
        $this->perPageVendors += 10;
    }

    public function loadMoreProjects()
    {
        $this->perPageProjects += 10;
    }

    public function updating($name, $value)
    {
        if (in_array($name, ['search', 'kbli', 'scheme', 'province_id', 'regency_id', 'district_id', 'village_id'])) {
            $this->perPageVendors = 10;
            $this->perPageProjects = 10;
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'kbli', 'scheme', 'province_id', 'regency_id', 'district_id', 'village_id']);
        $this->perPageVendors = 10;
        $this->perPageProjects = 10;
    }

    public function render()
    {
        $userScale = auth()->check() && auth()->user()->company ? auth()->user()->company->skala_usaha : null;

        // Fetch Vendors
        $vendorsQuery = Company::with(['kblis', 'locations.regency'])
            ->where('status', 'verified')
            ->matchScale($userScale);

        if ($this->search) {
            $vendorsQuery->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('pelaku_usaha_type', 'like', "%{$this->search}%")
                  ->orWhere('pelaku_usaha_detail', 'like', "%{$this->search}%")
                  ->orWhereHas('kblis', function($kbliQ) {
                      $kbliQ->where('name', 'like', "%{$this->search}%");
                  });
            });
        }

        if ($this->kbli) {
            $vendorsQuery->whereHas('kblis', function($q) {
                $q->where('code', $this->kbli);
            });
        }

        if ($this->province_id) {
            $vendorsQuery->whereHas('locations', function($q) {
                $q->where('province_id', $this->province_id);
                if ($this->regency_id) $q->where('regency_id', $this->regency_id);
                if ($this->district_id) $q->where('district_id', $this->district_id);
                if ($this->village_id) $q->where('village_id', $this->village_id);
            });
        }

        $vendors = $vendorsQuery->paginate($this->perPageVendors, ['*'], 'vendor_page');

        // Fetch Projects
        $projectsQuery = Project::with(['company.locations.regency'])
            ->where('status', 'published')
            ->where(function($q) {
                $q->whereNull('offer_end_date')
                  ->orWhere('offer_end_date', '>=', now()->startOfDay());
            })
            ->matchScale($userScale);

        if ($this->search) {
            $projectsQuery->where(function($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%")
                  ->orWhereHas('company', function($cQ) {
                      $cQ->where('name', 'like', "%{$this->search}%");
                  });
            });
        }

        if ($this->scheme) {
            $projectsQuery->where('type', $this->scheme);
        }

        if ($this->province_id) {
            $projectsQuery->where(function($q) {
                $q->where(function($pQ) {
                    $pQ->where('province_id', $this->province_id);
                    if ($this->regency_id) $pQ->where('regency_id', $this->regency_id);
                    if ($this->district_id) $pQ->where('district_id', $this->district_id);
                    if ($this->village_id) $pQ->where('village_id', $this->village_id);
                })
                ->orWhereHas('company.locations', function($cQ) {
                    $cQ->where('province_id', $this->province_id);
                    if ($this->regency_id) $cQ->where('regency_id', $this->regency_id);
                    if ($this->district_id) $cQ->where('district_id', $this->district_id);
                    if ($this->village_id) $cQ->where('village_id', $this->village_id);
                });
            });
        }

        $projects = $projectsQuery->paginate($this->perPageProjects, ['*'], 'project_page');

        $provinces = Province::orderBy('name')->get();
        $kblis = Kbli::orderBy('code')->get();

        return view('livewire.explore-marketplace', compact('vendors', 'projects', 'provinces', 'kblis'));
    }
}
