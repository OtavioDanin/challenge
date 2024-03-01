<?php

declare(strict_types=1);

namespace App\Model;

class Wallet extends Model
{
    protected array $fillable = [
        'id',
        'user_id',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}