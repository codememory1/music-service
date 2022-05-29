<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Entity\TranslationKey;
use App\Enum\ResponseTypeEnum;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserRoleDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<Role>
 *
 * @author  Codememory
 */
class UserRoleDTO extends AbstractDTO
{
    /**
     * @inheritDoc
     */
    protected EntityInterface|string|null $entity = Role::class;

    #[Assert\NotBlank(message: 'role@keyIsRequired')]
    public ?string $key = null;

    #[Assert\NotBlank(message: 'role@titleIsRequired')]
    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@titleTranslationKeyNotExist',
        payload: [ResponseTypeEnum::NOT_EXIST, 409]
    )]
    public ?string $title = null;

    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@shortDescriptionTranslationKeyNotExist',
        payload: [ResponseTypeEnum::NOT_EXIST, 409],
    )]
    public ?string $shortDescription = null;
    public array $permissions = [];

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('key');
        $this->addExpectKey('title');
        $this->addExpectKey('short_description', 'shortDescription');
        $this->addExpectKey('permissions');

        $this->preventSetterCallForKeys(['permissions']);

        $this->addInterceptor('permissions', new AsArrayInterceptor());
    }
}