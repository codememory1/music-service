<?php

namespace App\UseCase\Auth;

use App\Entity\User;
use App\Exceptions\BadException;
use App\Service\PasswordEncoder;

final class Authentication
{
    public function __construct(
        private readonly PasswordEncoder $passwordEncoder
    ) {
    }

    /**
     * @throws BadException
     */
    public function process(User $identifyUser, string $password): User
    {
        if (!$this->passwordEncoder->compare($password, $identifyUser->getPassword())) {
            throw BadException::invalidEmailOrPassword();
        }

        return $identifyUser;
    }
}