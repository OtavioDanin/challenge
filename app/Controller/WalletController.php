<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use App\Service\WalletService;
use Throwable;

class WalletController
{
    /**
     * @var WalletService
     */
    public function __construct(readonly protected WalletService $walletService)
    {
    }

    public function createBalance(RequestInterface $request, ResponseInterface $response)
    {
        try {
            $this->walletService->saveBalance($request);
            return $response
                ->json(['message' => 'Saldo adicionado com sucesso!'])
                ->withStatus(201);
        } catch (Throwable $thException) {
            return $response
                ->json(['message' => $thException->getMessage()])
                ->withStatus(500);
        }
    }
}
