<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Transfer\Traits\SetPasswordTrait;
use App\Entity\User;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class RestorePasswordDto extends AbstractDataTransfer
{
    use SetPasswordTrait;
    protected array $propertyNameToData = [
        'user' => 'email'
    ];

    #[DtoConstraints\ToEntityCallbackConstraint('callbackUserEntity')]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'user@failedToIdentify')
    ])]
    public ?User $user = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'common@codeIsRequired')
    ])]
    public ?string $code = null;

    public function callbackUserEntity(EntityManagerInterface $manager, mixed $value): ?User
    {
        if (null !== $value) {
            $userRepository = $manager->getRepository(User::class);

            return $userRepository->findActiveByEmail($value);
        }

        return null;
    }
}