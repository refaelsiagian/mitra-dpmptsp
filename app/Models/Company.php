<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_pkp' => 'boolean',
        'is_npwp_same_as_nik' => 'boolean',
        'is_usaha_same_as_office' => 'boolean',
        'certifications' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portfolios()
    {
        return $this->hasMany(CompanyPortfolio::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function offerings()
    {
        return $this->hasMany(CompanyOffering::class);
    }

    public function locations()
    {
        return $this->hasMany(CompanyLocation::class);
    }

    public function representatives()
    {
        return $this->hasMany(CompanyRepresentative::class);
    }

    public function kblis()
    {
        return $this->belongsToMany(Kbli::class, 'company_kbli', 'company_id', 'kbli_code', 'id', 'code');
    }

    public function feedbacks()
    {
        return $this->hasMany(VerificationFeedback::class);
    }
}
