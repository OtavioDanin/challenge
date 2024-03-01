<?php

declare(strict_types=1);

namespace Middleware\Validator;

use Hyperf\HttpServer\Contract\ResponseInterface as HyperfResponseInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
USE Ramsey\Uuid\Rfc4122\Validator;
use InvalidArgumentException;
use Throwable;

class TransactionMiddleware implements MiddlewareInterface
{
    public function __construct(readonly protected HyperfResponseInterface $response)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $dataRequest = $request->getParsedBody();
            $senderId = $dataRequest['senderId'];
            $receiverId = $dataRequest['receiverId'];
            $value = $dataRequest['value'];
            $this->validateParametersBodyNotEmpty($senderId, $receiverId, $value);
            return $handler->handle($request);
        } catch(InvalidArgumentException $iaException){
            return $this->response->json(['message' => $iaException->getMessage()])->withStatus(403);
        } catch (Throwable $thException) {
            return $this->response->json(['message' => $thException->getMessage()])->withStatus(500);
        }
    }

    protected function validateParametersBodyNotEmpty(string $senderId, string $receiverId, string|float $value)
    {
        $validator = new Validator();
        if (!$validator->validate($senderId)) {
            throw new InvalidArgumentException('Identificador inválido para o senderId!');
        }
        if (!$validator->validate($receiverId)) {
            throw new InvalidArgumentException('Identificador inválido para o receiverId!');
        }
        if (strlen(trim($value))===0 || ($value<=0) ) {
            throw new InvalidArgumentException('Valor inválido para transferencia!');
        }
    }
}
