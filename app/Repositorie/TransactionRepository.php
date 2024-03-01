<?php

declare(strict_types=1);

namespace App\Repositorie;

use App\Model\Transaction;

class TransactionRepository
{
    /**
     * @var Transaction
    */
    public function __construct(readonly protected Transaction $transaction)
    {
    }

    public function create(array $data): array
    {
        return $this->transaction->newModelQuery()->create($data)->first()?->getAttributes();
    }
}