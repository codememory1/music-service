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
    #[Assert\NotBlank(message: 'subscription@keyIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $key = null;

    #[Assert\NotBlank(message: 'subscription@titleIsRequired')]
    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@titleTranslationKeyNotExist',
        payload: [Validator::PPC => PlatformCodeEnum::ENTITY_NOT_FOUND]
    )]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'subscription@descriptionIsRequired')]
    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@shortDescriptionTranslationKeyNotExist',
        payload: [Validator::PPC => PlatformCodeEnum::ENTITY_NOT_FOUND]
    )]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $description = null;

    #[Assert\Type('float', message: 'common@invalidOldPrice')]
    #[DtoConstraints\ToTypeConstraint]
    public ?float $oldPrice = null;

    #[Assert\NotBlank(message: 'subscription@priceIsRequired')]
    #[Assert\Type('float', message: 'common@invalidPrice')]
    #[DtoConstraints\ToTypeConstraint]
    public ?float $price = null;

    #[DtoConstraints\ToTypeConstraint]
    public ?bool $isRecommend = null;

    #[AppAssert\JsonSchema('subscription_permission', message: 'subscription.invalid_permissions_format')]
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public array $permissions = [];

    #[Assert\NotBlank(message: 'subscription@statusIsRequired')]
    #[DtoConstraints\ToEnumConstraint(SubscriptionStatusEnum::class)]
    public ?SubscriptionStatusEnum $status = null;
}