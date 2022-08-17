<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Subscription;
use App\Entity\SubscriptionPermissionKey;
use App\Entity\TranslationKey;
use App\Enum\ResponseTypeEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\EntityManagerInterface;
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
        payload: [ResponseTypeEnum::NOT_EXIST, 409]
    )]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'subscription@descriptionIsRequired')]
    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@shortDescriptionTranslationKeyNotExist',
        payload: [ResponseTypeEnum::NOT_EXIST, 409],
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

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ToEntityCallbackConstraint('callbackPermissionsEntity')]
    public ?array $permissions = null;

    #[Assert\NotBlank(message: 'subscription@statusIsRequired')]
    #[DtoConstraints\ToEnumConstraint(SubscriptionStatusEnum::class)]
    public ?SubscriptionStatusEnum $status = null;

    public function callbackPermissionsEntity(EntityManagerInterface $manager, array $value): array
    {
        $subscriptionPermissionKeyRepository = $manager->getRepository(SubscriptionPermissionKey::class);

        foreach ($value as &$permissionKey) {
            $subscriptionPermissionKey = $subscriptionPermissionKeyRepository->findByKey($permissionKey);

            if (null === $subscriptionPermissionKey) {
                throw EntityNotFoundException::subscriptionPermissionKey();
            }

            $permissionKey = $subscriptionPermissionKey;
        }

        return $value;
    }
}