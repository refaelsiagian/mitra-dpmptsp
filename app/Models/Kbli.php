<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kbli extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    protected $guarded = [];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_kbli', 'kbli_code', 'company_id', 'code', 'id');
    }
}
