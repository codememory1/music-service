<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Role;
use App\Entity\RolePermissionKey;
use App\Entity\TranslationKey;
use App\Enum\PlatformCodeEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Infrastructure\Validator\Validator;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Role>
 */
final class UserRoleDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'role@keyIsRequired')
    ])]
    public ?string $key = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'role@titleIsRequired'),
        new AppAssert\Exist(
            TranslationKey::class,
            'key',
            'common@titleTranslationKeyNotExist',
            payload: [Validator::PPC => PlatformCodeEnum::ENTITY_NOT_FOUND]
        )
    ])]
    public ?string $title = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new AppAssert\Exist(
            TranslationKey::class,
            'key',
            'common@shortDescriptionTranslationKeyNotExist',
            payload: [Validator::PPC => PlatformCodeEnum::ENTITY_NOT_FOUND]
        )
    ])]
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