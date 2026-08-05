<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyOffering extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'category',
        'title',
        'highlight_metric',
        'value_text',
        'description',
        'is_pinned',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
