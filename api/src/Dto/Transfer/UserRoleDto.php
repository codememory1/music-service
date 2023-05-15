<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\Role;
use App\Entity\RolePermissionKey;
use App\Entity\TranslationKey;
use App\Enum\PlatformCodeEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastructure\Validator\Validator;
use App\Validator\Constraints as AppAssert;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<Role>
 */
final class UserRoleDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'role@keyIsRequired')
    ])]
    public ?string $key = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'role@titleIsRequired'),
        new AppAssert\Exist(
            TranslationKey::class,
            'key',
            'common@titleTranslationKeyNotExist',
            payload: [Validator::PPC => PlatformCodeEnum::ENTITY_NOT_FOUND]
        )
    ])]
    public ?string $title = null;

    #[DC\ToType]
    #[DC\Validation([
        new AppAssert\Exist(
            TranslationKey::class,
            'key',
            'common@shortDescriptionTranslationKeyNotExist',
            payload: [Validator::PPC => PlatformCodeEnum::ENTITY_NOT_FOUND]
        )
    ])]
    public ?string $shortDescription = null;

    #[DC\ToType]
    #[DC\ToEntityList(RolePermissionKey::class, 'key', unique: true, entityNotFoundCallback: 'throwPermissionNotFound')]
    public array $permissions = [];

    public function throwPermissionNotFound(mixed $value): void
    {
        throw EntityNotFoundException::rolePermissionKey();
    }
}