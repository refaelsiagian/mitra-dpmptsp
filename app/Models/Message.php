<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function sender()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
