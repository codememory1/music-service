<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\MultimediaExternalServiceEnum;
use App\Enum\MultimediaExternalServiceStatusEnum;
use App\Repository\MultimediaExternalServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MultimediaExternalServiceRepository::class)]
#[ORM\Table('multimedia_external_services')]
#[ORM\HasLifecycleCallbacks]
class MultimediaExternalService implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'multimediaExternalServices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::STRING, length: 25, options: [
        'comment' => 'Service name from MultimediaExternalServiceEnum'
    ])]
    private ?string $serviceName = null;

    #[ORM\Column(type: Types::JSON, options: [
        'comment' => 'Parameters that will be needed to get the clip, for example, some get parameters, etc.'
    ])]
    private array $parameters = [];

    #[ORM\Column(type: Types::STRING, options: [
        'comment' => 'Status from MultimediaExternalServiceStatusEnum'
    ])]
    private ?string $status = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    public function setServiceName(?MultimediaExternalServiceEnum $serviceName): self
    {
        $this->serviceName = $serviceName?->name;

        return $this;
    }

    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?MultimediaExternalServiceStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }
}
