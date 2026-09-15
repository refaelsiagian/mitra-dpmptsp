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

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function rab()
    {
        return $this->hasOne(Rab::class);
    }

    public function getIsInvitedAttribute()
    {
        return \App\Models\ProjectInvitation::where('project_id', $this->project_id)
            ->where('invited_company_id', $this->company_id)
            ->exists();
    }
}