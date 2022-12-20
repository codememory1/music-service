<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Subscription;
use App\Entity\TranslationKey;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Infrastructure\Validator\Validator;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<Subscription>
 */
final class SubscriptionDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'subscription@keyIsRequired')
    ])]
    public ?string $key = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'subscription@titleIsRequired'),
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
        new Assert\NotBlank(message: 'subscription@descriptionIsRequired'),
        new AppAssert\Exist(
            TranslationKey::class,
            'key',
            'common@shortDescriptionTranslationKeyNotExist',
            payload: [Validator::PPC => PlatformCodeEnum::ENTITY_NOT_FOUND]
        )
    ])]
    public ?string $description = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\Type('float', message: 'common@invalidOldPrice')
    ])]
    public ?float $oldPrice = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'subscription@priceIsRequired'),
        new Assert\Type('float', message: 'common@invalidPrice')
    ])]
    public ?float $price = null;

    #[DtoConstraints\ToTypeConstraint]
    public ?bool $isRecommend = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    #[DtoConstraints\ValidationConstraint([
        new AppAssert\JsonSchema('subscription_permission', message: 'subscription.invalid_permissions_format')
    ])]
    public array $permissions = [];

    #[DtoConstraints\ToEnumConstraint(SubscriptionStatusEnum::class)]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'subscription@statusIsRequired')
    ])]
    public ?SubscriptionStatusEnum $status = null;
}