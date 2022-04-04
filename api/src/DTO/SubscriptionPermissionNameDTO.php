<?php

namespace App\DTO;

use App\Entity\SubscriptionPermissionName;
use App\Entity\TranslationKey;
use App\Enum\ApiResponseTypeEnum;
use App\Rest\DTO\AbstractDTO;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SubscriptionPermissionNameDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class SubscriptionPermissionNameDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'subscriptionPermissionName@keyIsRequired')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'subscriptionPermissionName@keyMaxLength'
    )]
    public ?string $key = null;

    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'common@titleIsRequired')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'common@titleTranslationKeyMaxLength'
    )]
    #[AppAssert\Exist(
        TranslationKey::class,
        'name',
        'common@titleTranslationKeyNotExist',
        payload: ApiResponseTypeEnum::CHECK_EXIST
    )]
    public ?string $titleTranslationKey = null;

    protected function wrapper(): void
    {
        $this->setEntity(SubscriptionPermissionName::class);

        $this
            ->addExpectedRequestKey('key')
            ->addExpectedRequestKey('title', 'title_translation_key');
    }
}