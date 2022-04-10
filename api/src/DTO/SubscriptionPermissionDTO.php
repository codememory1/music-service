<?php

namespace App\DTO;

use App\DTO\Interceptor\SubscriptionPermissionInputPermissionNameInterceptor;
use App\DTO\Interceptor\SubscriptionPermissionInputSubscriptionInterceptor;
use App\Entity\Subscription;
use App\Entity\SubscriptionPermission;
use App\Entity\SubscriptionPermissionName;
use App\Interfaces\EntityInterface;
use App\Rest\DTO\AbstractDTO;
use ReflectionException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

/**
 * Class SubscriptionPermissionDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class SubscriptionPermissionDTO extends AbstractDTO
{
    /**
     * @var null|SubscriptionPermissionName
     */
    #[Assert\NotBlank(message: 'subscriptionPermission@permissionNameNotExistOrNotEntered')]
    public ?SubscriptionPermissionName $subscriptionPermissionName = null;

    /**
     * @var null|Subscription
     */
    #[Assert\NotBlank(message: 'subscriptionPermission@subscriptionNotExistOrNotEnetred')]
    public ?Subscription $subscription = null;

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     * @throws ClassNotFoundException
     */
    protected function wrapper(): void
    {
        $this->setEntity(SubscriptionPermission::class);

        $this
            ->addExpectedRequestKey('permission_name', 'subscriptionPermissionName')
            ->addExpectedRequestKey('subscription');

        $this
            ->addInterceptor('permission_name', SubscriptionPermissionInputPermissionNameInterceptor::class)
            ->addInterceptor('subscription', SubscriptionPermissionInputSubscriptionInterceptor::class);
    }

    /**
     * @param EntityInterface|SubscriptionPermission $entity
     * @param array                                  $excludeKeys
     *
     * @return array
     */
    public function toArray(EntityInterface $entity, array $excludeKeys = []): array
    {
        $subscriptionPermissionNameDTO = new SubscriptionPermissionNameDTO();

        return $this->toArrayHandler([
            'id' => $entity->getId(),
            'permission' => $subscriptionPermissionNameDTO->toArray($entity->getSubscriptionPermissionName(), [
                'created_at', 'updated_at'
            ]),
            'created_at' => $entity->getCreatedAt()->format('Y-m-d H:i'),
            'updated_at' => $entity->getUpdatedAt()?->format('Y-m-d H:i')
        ], $excludeKeys);
    }
}