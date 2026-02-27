<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocialLink extends Model
{
    protected $fillable = [
        'user_id',
        'facebook_url',
        'x_url',
        'linkedin_url',
        'instagram_url',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
