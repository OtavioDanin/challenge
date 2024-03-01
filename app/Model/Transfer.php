<?php

declare(strict_types=1);

namespace App\Model;

class Transfer extends Model
{
    protected array $fillable = [
        'id',
        'wallet_id',
        'type',
        'value',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function transactionOrigin()
    {
        return $this->hasOne(Transaction::class, 'sender');
    }

    public function transactionDestination()
    {
        return $this->hasOne(Transaction::class, 'receiver');
    }
}