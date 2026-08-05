<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPortfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'image_path',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
