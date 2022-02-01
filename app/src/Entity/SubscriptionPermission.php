<?php

namespace App\Entity;

use App\Enums\ApiResponseTypeEnum;
use App\Repository\SubscriptionPermissionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class SubscriptionPermission
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: SubscriptionPermissionRepository::class)]
#[ORM\Table('subscription_permissions')]
#[UniqueEntity(['subscriptionPermissionName', 'subscription'], 'subscriptionPermission@exist', payload: [ApiResponseTypeEnum::CHECK_EXIST, 'permission_exist'])]
class SubscriptionPermission
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var SubscriptionPermissionName|null
     */
    #[ORM\ManyToOne(targetEntity: SubscriptionPermissionName::class, inversedBy: 'subscriptionPermissions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'subscriptionPermission@rightNameIsRequired', payload: 'right_name_is_required')]
    private ?SubscriptionPermissionName $subscriptionPermissionName = null;

    /**
     * @var Subscription|null
     */
    #[ORM\ManyToOne(targetEntity: Subscription::class, inversedBy: 'subscriptionPermissions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'common@subscriptionIsRequired', payload: 'subscription_is_required')]
    private ?Subscription $subscription = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @return SubscriptionPermissionName|null
     */
    public function getSubscriptionPermissionName(): ?SubscriptionPermissionName
    {

        return $this->subscriptionPermissionName;

    }

    /**
     * @param SubscriptionPermissionName|null $subscriptionPermissionName
     *
     * @return $this
     */
    public function setSubscriptionPermissionName(?SubscriptionPermissionName $subscriptionPermissionName): self
    {

        $this->subscriptionPermissionName = $subscriptionPermissionName;

        return $this;

    }

    /**
     * @return Subscription|null
     */
    public function getSubscription(): ?Subscription
    {

        return $this->subscription;

    }

    /**
     * @param Subscription|null $subscription
     *
     * @return $this
     */
    public function setSubscription(?Subscription $subscription): self
    {

        $this->subscription = $subscription;

        return $this;

    }

}
