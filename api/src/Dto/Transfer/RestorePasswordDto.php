<?php

namespace App\Dto\Transfer;

use App\Repository\UserRepository;
use Codememory\Dto\Constraints as DC;
use App\Dto\Transfer\Traits\SetPasswordTrait;
use App\Entity\User;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class RestorePasswordDto extends DataTransfer
{
    use SetPasswordTrait;

    #[DC\ToEntity(whereCallback: 'emailCallback')]
    #[DC\Validation([
        new Assert\NotBlank(message: 'user@failedToIdentify')
    ])]
    public ?User $email = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'common@codeIsRequired')
    ])]
    public ?string $code = null;

    public function emailCallback(UserRepository $userRepository, mixed $value): ?User
    {
        if (null !== $value) {
            return $userRepository->findActiveByEmail($value);
        }

        return null;
    }
}