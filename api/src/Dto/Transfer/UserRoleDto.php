<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Role;
use App\Entity\RolePermissionKey;
use App\Entity\TranslationKey;
use App\Enum\ResponseTypeEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastucture\Dto\AbstractDataTransfer;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Role>
 */
final class UserRoleDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'role@keyIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $key = null;

    #[Assert\NotBlank(message: 'role@titleIsRequired')]
    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@titleTranslationKeyNotExist',
        payload: [ResponseTypeEnum::NOT_EXIST, 409]
    )]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;

    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@shortDescriptionTranslationKeyNotExist',
        payload: [ResponseTypeEnum::NOT_EXIST, 409],
    )]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $shortDescription = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ToEntityCallbackConstraint('callbackPermissionsEntity')]
    public array $permissions = [];

    public function callbackPermissionsEntity(EntityManagerInterface $manager, array $value): array
    {
        $rolePermissionKeyRepository = $manager->getRepository(RolePermissionKey::class);

        foreach ($value as &$permissionKey) {
            $rolePermissionKey = $rolePermissionKeyRepository->findByKey($permissionKey);

            if (null === $rolePermissionKey) {
                throw EntityNotFoundException::rolePermissionKey();
            }

            $permissionKey = $rolePermissionKey;
        }

        return $value;
    }
}