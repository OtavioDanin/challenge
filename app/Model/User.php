<?php

declare(strict_types=1);

namespace App\Model;

class User extends Model
{
    protected ?string $table = 'users';
    public bool $incrementing = false;
    protected array $fillable = ['id', 'name', 'identity_document', 'email', 'password', 'user_type', 'created_at', 'updated_at'];
    protected array $hidden = [
        'password',
    ];

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }

}