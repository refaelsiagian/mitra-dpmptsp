<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'proposal_id',
        'title',
        'total_amount',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function categories()
    {
        return $this->hasMany(RabCategory::class);
    }

    // Helper to deeply load the entire RAB
    public function scopeWithFullDetails($query)
    {
        return $query->with('categories.items');
    }
}
