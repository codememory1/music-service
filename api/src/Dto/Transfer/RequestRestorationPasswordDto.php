<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\PasswordReset;
use App\Entity\User;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<PasswordReset>
 */
final class RequestRestorationPasswordDto extends AbstractDataTransfer
{
    protected array $propertyNameToData = [
        'user' => 'email'
    ];

    #[DtoConstraints\ToEntityCallbackConstraint('callbackUserEntity')]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'user@failedToIdentify')
    ])]
    public ?User $user = null;

    public function callbackUserEntity(EntityManagerInterface $manager, mixed $value): ?User
    {
        if (null !== $value) {
            $userRepository = $manager->getRepository(User::class);

            return $userRepository->findActiveByEmail($value);
        }

        return null;
    }
}