<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'type',
        'title',
        'description',
        'ruang_lingkup',
        'estimated_value',
        'image',
        'is_budget_negotiable',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'address',
        'offer_end_date',
        'project_start_date',
        'project_end_date',
        'status',
        'metrics',
        'requirements',
        'offerings',
        'attachments',
        'is_public',
        'is_pinned',
    ];

    protected $casts = [
        'is_budget_negotiable' => 'boolean',
        'offer_end_date' => 'date',
        'project_start_date' => 'date',
        'project_end_date' => 'date',
        'metrics' => 'array',
        'requirements' => 'array',
        'offerings' => 'array',
        'attachments' => 'array',
        'is_public' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function rab()
    {
        return $this->hasOne(Rab::class);
    }

    public function getIsExpiredAttribute()
    {
        return $this->offer_end_date && $this->offer_end_date->endOfDay()->isPast() && $this->status === 'published';
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function scopeMatchScale($query, $userScale)
    {
        if ($userScale === 'besar') {
            return $query->whereHas('company', function($q) {
                $q->whereIn('skala_usaha', ['mikro', 'kecil', 'menengah']);
            });
        } elseif (in_array($userScale, ['mikro', 'kecil', 'menengah'])) {
            return $query->whereHas('company', function($q) {
                $q->where('skala_usaha', 'besar');
            });
        }

        return $query;
    }
}
