<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Traits\SetPasswordTrait;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class RestorePasswordDto extends AbstractDataTransfer
{
    use SetPasswordTrait;
    protected array $propertyNameToData = [
        'user' => 'email'
    ];

    #[Assert\NotBlank(message: 'user@failedToIdentify')]
    #[DtoConstraints\ToEntityCallbackConstraint('callbackUserEntity')]
    public ?User $user = null;

    #[Assert\NotBlank(message: 'common@codeIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
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