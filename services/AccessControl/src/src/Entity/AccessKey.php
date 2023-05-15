<?php

namespace App\Entity;

use App\Repository\AccessKeyRepository;
use Codememory\ApiBundle\Entity\Interfaces\EntityInterface;
use Codememory\ApiBundle\Entity\Traits\IdentifierTrait;
use Codememory\ApiBundle\Entity\Traits\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Enum\TranslationKey;

#[ORM\Entity(repositoryClass: AccessKeyRepository::class)]
#[ORM\Table('access_keys')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(['key', 'microservice'], TranslationKey::ACCESS_KEY_EXIST)]
class AccessKey implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private ?string $key = null;

    #[ORM\Column(length: 50)]
    private ?string $microservice = null;

    public function getKey(): ?string
    {
        return $this->key;
    }

    #[ORM\PrePersist]
    public function setKey(): self
    {
        $this->key = Uuid::uuid4()->toString();

        return $this;
    }

    public function getMicroService(): ?string
    {
        return $this->microservice;
    }

    public function setMicroService(string $microservice): self
    {
        $this->microservice = $microservice;

        return $this;
    }
}
