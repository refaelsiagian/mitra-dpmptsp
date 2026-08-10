<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'inviting_company_id',
        'invited_company_id',
        'status',
        'message',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function invitingCompany()
    {
        return $this->belongsTo(Company::class, 'inviting_company_id');
    }

    public function invitedCompany()
    {
        return $this->belongsTo(Company::class, 'invited_company_id');
    }
}
