<?php

declare(strict_types=1);

namespace App\Controller;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use App\Service\UserService;
use Throwable;

class UserController extends AbstractController
{
  /**
  * @var UserService
  */
    public function __construct(readonly protected UserService $userService)
    {
    }
    
    public function createUser(RequestInterface $request, ResponseInterface $response)
    {
        try {
            $this->userService->saveUser($request);
            return $response
                    ->json(['message' => 'User Saved'])
                    ->withStatus(201);
        } catch (Throwable $thException) {
            return $response
                    ->json(['message' => $thException->getMessage()])
                    ->withStatus(500);
        }
    }
}
