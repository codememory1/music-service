<?php

namespace App\ResponseData;

use App\Entity\TranslationKey;
use App\Enum\RolePermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

/**
 * Class TranslationResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class TranslationResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    public ?int $id = null;

    #[ResponseDataConstraints\Callback('handleTranslationKey')]
    public ?string $translationKey = null;
    public ?string $translation = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    /**
     * @param null|TranslationKey $translationKey
     *
     * @return array
     */
    public function handleTranslationKey(?TranslationKey $translationKey): array
    {
        $translationKeyResponseData = new TranslationKeyResponseData($this->container);

        $translationKeyResponseData->setEntities($translationKey);

        return $translationKeyResponseData->collect()->getResponse();
    }
}