<?php

namespace App\Security\PasswordReset;

use App\Dto\Transfer\RestorePasswordDto;
use App\Entity\PasswordReset;
use App\Exception\Http\InvalidException;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Repository\PasswordResetRepository;

final class RestorePassword
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly PasswordResetRepository $passwordResetRepository
    ) {
    }

    public function restore(RestorePasswordDto $dto): PasswordReset
    {
        $this->validator->validate($dto);

        $passwordReset = $this->passwordResetRepository->findByCodeAndUserInProcess($dto->user, $dto->code);

        if (null === $passwordReset || false === $passwordReset->isValidTtlByCreatedAt()) {
            throw InvalidException::invalidCode();
        }

        $dto->user->setPassword($dto->password);

        $passwordReset->setCompletedStatus();

        $this->flusher->save();

        return $passwordReset;
    }
}