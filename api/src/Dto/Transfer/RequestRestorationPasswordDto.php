<?php

namespace App\Dto\Transfer;

use App\Repository\UserRepository;
use Codememory\Dto\Constraints as DC;
use App\Entity\PasswordReset;
use App\Entity\User;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<PasswordReset>
 */
final class RequestRestorationPasswordDto extends DataTransfer
{
    #[DC\ToEntity(whereCallback: 'userCallback')]
    #[DC\Validation([
        new Assert\NotBlank(message: 'user@failedToIdentify')
    ])]
    public ?User $email = null;

    public function userCallback(UserRepository $userRepository, mixed $value): ?User
    {
        if (null !== $value) {
            return $userRepository->findActiveByEmail($value);
        }

        return null;
    }
}