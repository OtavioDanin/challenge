<?php

declare(strict_types=1);

namespace App\Repositorie;

use App\Model\User;

/**
  * @var User
*/
class UserRepository    
{
    public function __construct(readonly protected User $user) 
    {
    }

    public function create(array $data): bool
    {
        $this->user->id = $data['id'];
        $this->user->name = $data['name'];
        $this->user->identity_document = $data['identity_document'];
        $this->user->email = $data['email'];
        $this->user->password = $data['password'];
        $this->user->user_type = $data['user_type'];

        return $this->user->save();
    }

    public function findUserByIdentity(string $identity)
    {
      return $this->user->newModelQuery()->where('identity_document', '=', $identity)->first()?->getAttribute('identity_document');
    }

    public function findUserByEmail(string $email)
    {
      return $this->user->newModelQuery()->where('email', '=', $email)->first()?->getAttribute('email');
    }
}