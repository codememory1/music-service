<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\Subscription;
use App\Entity\TranslationKey;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Infrastructure\Validator\Validator;
use App\Validator\Constraints as AppAssert;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<Subscription>
 */
final class SubscriptionDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'subscription@titleIsRequired'),
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
        new Assert\NotBlank(message: 'subscription@descriptionIsRequired'),
        new AppAssert\Exist(
            TranslationKey::class,
            'key',
            'common@shortDescriptionTranslationKeyNotExist',
            payload: [Validator::PPC => PlatformCodeEnum::ENTITY_NOT_FOUND]
        )
    ])]
    public ?string $description = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\Type('float', message: 'common@invalidOldPrice')
    ])]
    public ?float $oldPrice = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'subscription@priceIsRequired'),
        new Assert\Type('float', message: 'common@invalidPrice')
    ])]
    public ?float $price = null;

    #[DC\ToType]
    public bool $isRecommend = false;

    #[DC\ToType]
    #[DC\IgnoreSetterCall]
    #[DC\Validation([
        new AppAssert\JsonSchema('subscription_permission', message: 'subscription.invalid_permissions_format')
    ])]
    public array $permissions = [];

    #[DC\ToEnum]
    #[DC\Validation([
        new Assert\NotBlank(message: 'subscription@statusIsRequired')
    ])]
    public ?SubscriptionStatusEnum $status = null;
}