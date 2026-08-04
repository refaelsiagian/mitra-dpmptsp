<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationFeedback extends Model
{
    use HasFactory;

    protected $table = 'verification_feedbacks';

    protected $fillable = [
        'company_id',
        'field_name',
        'message',
        'is_resolved'
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
