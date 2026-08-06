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
        'estimated_value',
        'location',
        'start_date',
        'end_date',
        'status',
        'metrics',
        'requirements',
        'offerings',
        'attachments',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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
