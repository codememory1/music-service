<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\PasswordReset;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RequestRestorationPasswordDTO.
 *
 * @package App\Dto\Transfer
 * @template-extends AbstractDataTransfer<PasswordReset>
 *
 * @author  Codememory
 */
final class RequestRestorationPasswordDto extends AbstractDataTransfer
{
    protected array $propertyNameToData = [
        'user' => 'email'
    ];

    #[Assert\NotBlank(message: 'user@failedToIdentify')]
    #[DtoConstraints\ToEntityCallbackConstraint('callbackUserEntity')]
    public ?User $user = null;

    public function callbackUserEntity(EntityManagerInterface $manager, mixed $value): ?User
    {
        $userRepository = $manager->getRepository(User::class);

        return $userRepository->findActiveByEmail($value);
    }
}