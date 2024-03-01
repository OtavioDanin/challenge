<?php

declare(strict_types=1);

namespace App\Service;

use App\Repositorie\{TransferRepository, WalletRepository, TransactionRepository};
use App\Http\HttpClient;
use App\Http\HttpClientInterface;
use Ramsey\Uuid\Uuid;
use Exception;

class TransferService
{
    /**
     * @var TransferRepository
     */
    /**
     * @var WalletRepository
     */
    /**
     * @var TransactionRepository
     */
    /**
     * @var HttpClientInterface
     */
    public function __construct(
        readonly protected TransferRepository $transferRepository,
        readonly protected WalletRepository $walletRepository,
        readonly protected TransactionRepository $transactionRepository,
        readonly protected HttpClient $httpClient
    ) {
    }

    public function save(array $payloadTransfer): array
    {
        $this->authorizeTransaction();
        $senderId = $payloadTransfer['senderId'];
        $receiverId = $payloadTransfer['receiverId'];
        $value = (float) $payloadTransfer['value'];

        $userType = $this->walletRepository->findUserType($senderId);
        if ($userType === 'MERCHANT') {
            throw new Exception('Usuário do tipo Lojista não está autorizado a realizar transação');
        }
        $userSender = $this->walletRepository->findBalanceByUserId($senderId);
        $diferenceBalanceSender = $userSender['balance'] - $value;
        if ($userSender['balance'] <= 0 || $diferenceBalanceSender <= 0) {
            throw new Exception('Saldo insuficiente');
        }

        $debit = $this->makeTransfer($userSender['id'], $value, 'DEBIT');
        if (count($debit) === 0) {
            throw new Exception('Falha ao Realizar a transferencia');
        }

        $userReceiver = $this->walletRepository->findBalanceByUserId($receiverId);
        $credit = $this->makeTransfer($userReceiver['id'], $value, 'CREDIT');
        if (count($credit) === 0) {
            throw new Exception('Falha ao Receber a transferencia');
        }

        $transaction = $this->createTransaction($debit['id'], $credit['id']);
        if (count($transaction) === 0) {
            throw new Exception('Falha ao realizar a transação');
        }

        $isUpdateSender = $this->makeUpdateBalance($senderId, $diferenceBalanceSender);

        $newBalanceReceiver = $userReceiver['balance'] + $value;
        $isUpdateReceiver = $this->makeUpdateBalance($receiverId, $newBalanceReceiver);

        return ($isUpdateSender && $isUpdateReceiver) ? ['message' => 'Transferencia realizada com sucesso', 'data' => $value] : ['message' => 'Falha na realização da Transferencia', 'data' => []];
    }

    private function authorizeTransaction(): void
    {
        $responseAuthorize = $this->httpClient->sendGet('https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');
        if ($responseAuthorize->statusCode !== 200) {
            throw new Exception('Falha no Serviço Autorizador');
        }
        if (json_decode($responseAuthorize->content)->message !== 'Autorizado') {
            throw new Exception('Serviço não Autorizado');
        }
    }

    private function createTransaction($senderId, $receiverId): array
    {
        $data = [
            'id' => $this->generateUUID(),
            'sender' => $senderId,
            'receiver' => $receiverId
        ];
        return $this->transactionRepository->create($data);
    }

    private function makeTransfer(string $userId, float $value, string $typeTransfer)
    {
        $data = [
            'id' => $this->generateUUID(),
            'wallet_id' => $userId,
            'value' => $value,
            'type' => $typeTransfer
        ];
        return $this->transferRepository->createTransfer($data);
    }

    private function makeUpdateBalance(string $userId, float $value)
    {
        $dataBalance = [
            'user_id' => $userId,
            'balance' => $value
        ];
        return $this->walletRepository->updateBalance($dataBalance);
    }

    public function generateUUID(): string
    {
        return Uuid::uuid7()->toString();
    }
}
