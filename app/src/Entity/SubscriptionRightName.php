<?php

namespace App\Entity;

use App\Repository\SubscriptionRightNameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SubscriptionRightName
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: SubscriptionRightNameRepository::class)]
#[ORM\Table('subscription_right_names')]
#[UniqueEntity('key', message: 'subscriptionRightName@keyExist', payload: 'key_exist')]
class SubscriptionRightName
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
    #[Assert\NotBlank(message: 'subscriptionRightName@keyIsRequired', payload: 'key_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'subscriptionRightName@keyMaxLength', payload: 'key_length')]
    private ?string $key = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, options: [
        'comment' => 'Rule name translation key'
    ])]
    #[Assert\NotBlank(message: 'common@titleIsRequired', payload: 'title_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'common@titleTranslationKeyMaxLength', payload: 'title_length')]
    private ?string $titleTranslationKey = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'subscriptionRightName', targetEntity: SubscriptionRight::class)]
    private Collection $subscriptionRights;

    #[Pure]
    public function __construct()
    {
        $this->subscriptionRights = new ArrayCollection();
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
    public function getSubscriptionRights(): Collection
    {

        return $this->subscriptionRights;

    }

    /**
     * @param SubscriptionRight $subscriptionRight
     *
     * @return $this
     */
    public function addSubscriptionRight(SubscriptionRight $subscriptionRight): self
    {

        if (!$this->subscriptionRights->contains($subscriptionRight)) {
            $this->subscriptionRights[] = $subscriptionRight;
            $subscriptionRight->setSubscriptionRightName($this);
        }

        return $this;

    }

    /**
     * @param SubscriptionRight $subscriptionRight
     *
     * @return $this
     */
    public function removeSubscriptionRight(SubscriptionRight $subscriptionRight): self
    {

        if ($this->subscriptionRights->removeElement($subscriptionRight)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionRight->getSubscriptionRightName() === $this) {
                $subscriptionRight->setSubscriptionRightName(null);
            }
        }

        return $this;

    }

}
