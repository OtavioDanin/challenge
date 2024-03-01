<?php

declare(strict_types=1);

namespace App\Model;

class Transaction extends Model
{
    protected array $fillable = [
        'id',
        'sender',
        'receiver',
    ];

    public function originOperation()
    {
        return $this->belongsTo(Transfer::class, 'sender');
    }

    public function destinationOperation()
    {
        return $this->belongsTo(Transfer::class, 'receiver');
    }
}