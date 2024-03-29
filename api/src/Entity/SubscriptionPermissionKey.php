<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Infrastructure\Validator\Validator;
use App\Repository\SubscriptionPermissionKeyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SubscriptionPermissionKeyRepository::class)]
#[ORM\Table('subscription_permission_keys')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('key', 'entityExist@subscriptionPermissionKey', payload: [Validator::PPC => PlatformCodeEnum::ENTITY_FOUND])]
class SubscriptionPermissionKey implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'Unique key to identify permissions'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Name in view of the translation key'
    ])]
    private ?string $titleTranslationKey = null;

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?SubscriptionPermissionEnum $subscriptionPermission): self
    {
        $this->key = $subscriptionPermission?->name;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    public function setTitle(?string $titleTranslationKey): self
    {
        $this->titleTranslationKey = $titleTranslationKey;

        return $this;
    }
}
