<?php

namespace App\DTO;

use App\Entity\SubscriptionPermissionName;
use App\Entity\TranslationKey;
use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
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

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->setEntity(SubscriptionPermissionName::class);

        $this
            ->addExpectedRequestKey('key')
            ->addExpectedRequestKey('title', 'titleTranslationKey');
    }

    /**
     * @param EntityInterface|SubscriptionPermissionName $entity
     * @param array                                      $excludeKeys
     *
     * @return array
     */
    public function toArray(EntityInterface $entity, array $excludeKeys = []): array
    {
        return $this->toArrayHandler([
            'id' => $entity->getId(),
            'key' => $entity->getKey(),
            'title' => $entity->getTitleTranslationKey(),
            'created_at' => $entity->getCreatedAt()->format('Y-m-d H:i'),
            'updated_at' => $entity->getUpdatedAt()?->format('Y-m-d H:i')
        ], $excludeKeys);
    }
}