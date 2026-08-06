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
        'is_budget_negotiable',
        'location',
        'offer_end_date',
        'project_start_date',
        'project_end_date',
        'status',
        'metrics',
        'requirements',
        'offerings',
        'attachments',
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
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
