<?php

declare(strict_types=1);

namespace App\Service;

use App\Repositorie\WalletRepository;
use Exception;

class WalletService
{
    /**
     * @var WalletRepository
     */

    public function __construct(readonly protected WalletRepository $walletRepository)
    {
    }

    public function saveBalance($payloadBalance): bool
    {
        $user_id = $payloadBalance->input('user_id');
        $value = (float)$payloadBalance->input('value');

        $this->validateUserId($user_id);
        $currentBalance = $this->getBalanceByUserId($user_id);

        $newBalance = $this->sumBalance($currentBalance, $value);
        $data = ['user_id' => $user_id, 'balance' => $newBalance];
        $isCreateBalance =  $this->walletRepository->updateBalance($data);
        if (!$isCreateBalance) {
            throw new Exception('Falha ao adicionar Saldo');
        }
        return $isCreateBalance;
    }

    private function sumBalance(?float $currentBalance, float $value): float
    {
        return $currentBalance + $value;
    }

    private function validateUserId(string $user_id)
    {
        $validator = new \Ramsey\Uuid\Rfc4122\Validator();
        if (!$validator->validate($user_id)) {
            throw new Exception('Identificador inválido para o usuário!');
        }
    }

    private function getBalanceByUserId($user_id): float
    {
        $currentBalance = $this->walletRepository->findBalanceByUserId($user_id);
        if (count($currentBalance)===0) {
            throw new Exception('É necessário possuir uma carteira para a realização de transferencias!');
        }
        return (float) $currentBalance['balance'];
    }
}
