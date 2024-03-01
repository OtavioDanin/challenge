<?php

declare(strict_types=1);

namespace App\Repositorie;

use App\Model\Wallet;
use Exception;

class WalletRepository
{
  /**
  * @var Wallet
  */
    public function __construct(readonly protected Wallet $wallet)
    {
    }

    public function createWallet($data)
    {
        $this->wallet->id = $data['id'];
        $this->wallet->user_id = $data['user_id'];
        $this->wallet->balance = $data['balance'];

        return $this->wallet->save($data);
    }

    public function updateBalance($data): bool
    {
        $this->wallet->user_id = $data['user_id'];
        return $this->wallet->newModelQuery()->where('user_id', '=', $data['user_id'])->update(['balance' => $data['balance']]) === 1 ? true : false;
    }

    public function findBalanceByUserId($user_id): ?array
    {
      return $this->wallet->newModelQuery()->where('user_id', '=', $user_id)->first()?->getAttributes();
    }

    public function findUserType(string $userId)
    {
        $this->wallet->user_id = $userId;
        return $this->wallet->user()->getResults()?->getAttribute('user_type');
    }
}