<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function locations()
    {
        return $this->hasMany(CompanyLocation::class);
    }

    public function representatives()
    {
        return $this->hasMany(CompanyRepresentative::class);
    }

    public function kblis()
    {
        return $this->belongsToMany(Kbli::class, 'company_kbli', 'company_id', 'kbli_code', 'id', 'code');
    }
}
