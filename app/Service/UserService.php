<?php

declare(strict_types=1);

namespace App\Service;

use App\Repositorie\UserRepository;
use Exception;
use Ramsey\Uuid\Uuid;

class UserService
{
    /**
     * @var UserRepository
    */
    public function __construct(readonly protected UserRepository $userRepository)
    {
    }

    public function saveUser($payloadUser): bool
    {
        $name = $payloadUser->input('name');
        $identifier = $payloadUser->input('identifier');
        $email = $payloadUser->input('email');
        $password = $payloadUser->input('password');
        $user_type = $payloadUser->input('user_type');
        $uuid = Uuid::uuid7();
        $data = [
            'id' => $uuid->toString(),
            'name' => $name,
            'identity_document' => $identifier,
            'email' => $email,
            'password' => $password,
            'user_type' => $user_type
        ];

        $identifierUser = $this->userRepository->findUserByIdentity($identifier);
        if ($identifier === $identifierUser) {
            throw new Exception('Documento de identificação já existente');
        }
        $emailUser = $this->userRepository->findUserByEmail($email);
        if ($email === $emailUser) {
            throw new Exception('E-mail já existente');
        }
        $isCreate = $this->userRepository->create($data);
        if(!$isCreate){
            throw new Exception('Falha na criação do Usuário');
        }
        return $isCreate;
    }
}
