<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAcademic extends Model
{
    protected $fillable = [
        'user_id',
        'institution',
        'degree',
        'field_of_study',
        'year_start',
        'year_end',
        'sort_order',
    ];

    protected $casts = [
        'year_start'  => 'integer',
        'year_end'    => 'integer',
        'sort_order'  => 'integer',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
