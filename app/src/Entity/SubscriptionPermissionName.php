<?php

namespace App\Entity;

use App\Enums\ApiResponseTypeEnum;
use App\Repository\SubscriptionPermissionNameRepository;
use App\ValidatorConstraints as AppAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SubscriptionPermissionName
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: SubscriptionPermissionNameRepository::class)]
#[ORM\Table('subscription_permission_names')]
#[UniqueEntity('key', message: 'subscriptionPermissionName@keyExist', payload: 'key_exist')]
class SubscriptionPermissionName
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column('`key`', 'string', length: 255, unique: true, options: [
        'comment' => 'The unique key of the rule by which access will be checked'
    ])]
    #[Assert\NotBlank(message: 'subscriptionPermissionName@keyIsRequired', payload: 'key_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'subscriptionPermissionName@keyMaxLength', payload: 'key_length')]
    private ?string $key = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, options: [
        'comment' => 'Rule name translation key'
    ])]
    #[Assert\NotBlank(message: 'common@titleIsRequired', payload: 'title_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'common@titleTranslationKeyMaxLength', payload: 'title_length')]
    #[AppAssert\Exist(TranslationKey::class, 'name', 'common@titleTranslationKeyNotExist', [ApiResponseTypeEnum::CHECK_EXIST, 'title_translation_key_not_exist'])]
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
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

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
