<?php

namespace App\DTO;

use App\DTO\Interceptor\SubscriptionInputPrice;
use App\DTO\Interceptor\ToIntInterceptor;
use App\Entity\Subscription;
use App\Entity\TranslationKey;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Interfaces\EntityInterface;
use App\Rest\DTO\AbstractDTO;
use App\Validator\Constraints as AppAssert;
use ReflectionException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

/**
 * Class SubscriptionDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class SubscriptionDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'subscription@nameIsRequired')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'subscription@nameMaxLength'
    )]
    #[AppAssert\Exist(
        TranslationKey::class,
        'name',
        'common@titleTranslationKeyNotExist',
        payload: ApiResponseTypeEnum::CHECK_EXIST
    )]
    public ?string $nameTranslationKey = null;

    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'common@descriptionIsRequired')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'subscription@descriptionMaxLength'
    )]
    #[AppAssert\Exist(
        TranslationKey::class,
        'name',
        'common@descriptionTranslationKeyNotExist',
        payload: ApiResponseTypeEnum::CHECK_EXIST
    )]
    public ?string $descriptionTranslationKey = null;

    /**
     * @var null|float
     */
    #[Assert\NotBlank(message: 'common@priceIsRequired')]
    public ?float $price = null;

    /**
     * @var null|float
     */
    public ?float $oldPrice = null;

    /**
     * @var null|int
     */
    #[Assert\NotBlank(message: 'common@statusIsRequired')]
    #[Assert\Choice(
        callback: [StatusEnum::class, 'values'],
        message: 'common@statusInvalid'
    )]
    public ?int $status = null;

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     * @throws ClassNotFoundException
     */
    protected function wrapper(): void
    {
        $this->setEntity(Subscription::class);

        $this
            ->addExpectedRequestKey('name', 'nameTranslationKey')
            ->addExpectedRequestKey('description', 'descriptionTranslationKey')
            ->addExpectedRequestKey('price')
            ->addExpectedRequestKey('old_price')
            ->addExpectedRequestKey('status');

        $this
            ->addInterceptor('price', SubscriptionInputPrice::class)
            ->addInterceptor('old_price', SubscriptionInputPrice::class)
            ->addInterceptor('status', ToIntInterceptor::class);
    }

    /**
     * @param EntityInterface|Subscription $entity
     * @param array                        $excludeKeys
     *
     * @return array
     */
    public function toArray(EntityInterface $entity, array $excludeKeys = []): array
    {
        $SubscriptionPermissionDTO = new SubscriptionPermissionDTO();

        return $this->toArrayHandler([
            'id' => $entity->getId(),
            'name' => $entity->getNameTranslationKey(),
            'description' => $entity->getDescriptionTranslationKey(),
            'price' => $entity->getPrice(),
            'old_price' => $entity->getOldPrice(),
            'status' => $entity->getStatus(),
            'permissions' => $SubscriptionPermissionDTO->transform($entity->getPermissions()),
            'created_at' => $entity->getCreatedAt()->format('Y-m-d H:i'),
            'updated_at' => $entity->getUpdatedAt()?->format('Y-m-d H:i')
        ], $excludeKeys);
    }
}