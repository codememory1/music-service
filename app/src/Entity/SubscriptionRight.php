<?php

namespace App\Entity;

use App\Repository\SubscriptionRightRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SubscriptionRight
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: SubscriptionRightRepository::class)]
#[ORM\Table('subscription_rights')]
class SubscriptionRight
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var SubscriptionRightName|null
     */
    #[ORM\ManyToOne(targetEntity: SubscriptionRightName::class, inversedBy: 'subscriptionRights')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'subscriptionRight@rightNameIsRequired', payload: 'right_name_is_required')]
    private ?SubscriptionRightName $subscriptionRightName = null;

    /**
     * @var Subscription|null
     */
    #[ORM\ManyToOne(targetEntity: Subscription::class, inversedBy: 'subscriptionRights')]
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
     * @return SubscriptionRightName|null
     */
    public function getSubscriptionRightName(): ?SubscriptionRightName
    {

        return $this->subscriptionRightName;

    }

    /**
     * @param SubscriptionRightName|null $subscriptionRightName
     *
     * @return $this
     */
    public function setSubscriptionRightName(?SubscriptionRightName $subscriptionRightName): self
    {

        $this->subscriptionRightName = $subscriptionRightName;

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
