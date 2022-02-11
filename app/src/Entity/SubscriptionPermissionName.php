<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Enum\RolePermissionNameEnum;
use App\Interface\EntityInterface;
use App\Repository\SubscriptionPermissionNameRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use App\Validator\Constraints as AppAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class SubscriptionPermissionName
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: SubscriptionPermissionNameRepository::class)]
#[ORM\Table('subscription_permission_names')]
#[UniqueEntity(
    'key',
    'subscriptionPermissionName@keyExist',
    payload: [ApiResponseTypeEnum::CHECK_EXIST, 'key_exist']
)]
#[AppAssert\Authorization('common@authRequired', payload: 'not_authorized')]
#[AppAssert\UserPermission(
    RolePermissionNameEnum::CREATE_SUBSCRIPTION,
    'common@accessDenied',
    payload: 'not_enough_permissions'
)]
#[ORM\HasLifecycleCallbacks]
class SubscriptionPermissionName implements EntityInterface
{

    use IdentifierTrait;
    use TimestampTrait;

    /**
     * @var string|null
     */
    #[ORM\Column('`key`', Types::STRING, length: 255, unique: true, options: [
        'comment' => 'The unique key of the rule by which access will be checked'
    ])]
    private ?string $key = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Rule name translation key'
    ])]
    private ?string $titleTranslationKey = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'subscriptionPermissionName', targetEntity: SubscriptionPermission::class)]
    private Collection $subscriptionPermissions;

    #[Pure]
    public function __construct()
    {

        $this->subscriptionPermissions = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {

        return $this->key;

    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key): self
    {

        $this->key = $key;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTitleTranslationKey(): ?string
    {

        return $this->titleTranslationKey;

    }

    /**
     * @param string $titleTranslationKey
     *
     * @return $this
     */
    public function setTitleTranslationKey(string $titleTranslationKey): self
    {

        $this->titleTranslationKey = $titleTranslationKey;

        return $this;

    }

    /**
     * @return Collection
     */
    public function getSubscriptionPermissions(): Collection
    {

        return $this->subscriptionPermissions;

    }

    /**
     * @param SubscriptionPermission $subscriptionPermission
     *
     * @return $this
     */
    public function addSubscriptionRight(SubscriptionPermission $subscriptionPermission): self
    {

        if (!$this->subscriptionPermissions->contains($subscriptionPermission)) {
            $this->subscriptionPermissions[] = $subscriptionPermission;
            $subscriptionPermission->setSubscriptionPermissionName($this);
        }

        return $this;

    }

    /**
     * @param SubscriptionPermission $subscriptionPermission
     *
     * @return $this
     */
    public function removeSubscriptionPermission(SubscriptionPermission $subscriptionPermission): self
    {

        if ($this->subscriptionPermissions->removeElement($subscriptionPermission)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionPermission->getSubscriptionPermissionName() === $this) {
                $subscriptionPermission->setSubscriptionPermissionName(null);
            }
        }

        return $this;

    }

}
