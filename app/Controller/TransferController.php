<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use App\Service\TransferService;
use Throwable;

class TransferController
{
    /**
     * @var TransferService
     */
    public function __construct(readonly protected TransferService $transferService)
    {
    }


    public function createTransfer(RequestInterface $request, ResponseInterface $response)
    {
        try {
            $transfer = $this->transferService->save($request->all());
            return $response
                ->json($transfer)
                ->withStatus(201);
        } catch (Throwable $thException) {
            return $response
                ->json(['message' => $thException->getMessage()])
                ->withStatus(500);
        }
    }
}
