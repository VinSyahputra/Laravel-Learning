<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    protected $fillable = [
        'user_id',
        'company',
        'job_title',
        'period_start',
        'period_end',
        'is_current',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end'   => 'date',
        'is_current'   => 'boolean',
        'sort_order'   => 'integer',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
