<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'company_id',
        'cover_letter',
        'estimated_value',
        'attachment',
        'pinned_portfolios',
        'status',
    ];

    protected $casts = [
        'pinned_portfolios' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
