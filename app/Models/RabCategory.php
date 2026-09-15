<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'rab_id',
        'name',
        'total_amount',
    ];

    public function rab()
    {
        return $this->belongsTo(Rab::class);
    }

    public function items()
    {
        return $this->hasMany(RabItem::class);
    }
}
