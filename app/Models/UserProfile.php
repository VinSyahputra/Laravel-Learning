<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'birth_date',
        'phone_dial_code',
        'phone_number',
        'identity_card_number',
        'bio',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getBirthDateDisplayAttribute(): ?string
    {
        return $this->birth_date?->format('F j, Y');
    }
}
