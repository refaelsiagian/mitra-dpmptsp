<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'rab_category_id',
        'name',
        'volume',
        'unit',
        'unit_price',
        'total_price',
    ];

    public function category()
    {
        return $this->belongsTo(RabCategory::class, 'rab_category_id');
    }
}
