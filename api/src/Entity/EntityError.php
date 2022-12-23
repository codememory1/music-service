<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Enum\PlatformCodeEnum;
use App\Enum\TranslationEnum;
use App\Repository\EntityErrorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntityErrorRepository::class)]
#[ORM\Table('entity_errors')]
#[ORM\HasLifecycleCallbacks]
class EntityError implements EntityInterface
{
    use IdentifierTrait;
    use CreatedAtTrait;

    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'Error code from PlatformCodeEnum'
    ])]
    private ?int $platformCode = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Error message, must be in the form of a translation key'
    ])]
    private ?string $message = null;

    #[ORM\Column(type: Types::JSON, options: [
        'comment' => 'Parameters for the message'
    ])]
    private array $messageParameters = [];

    public function getPlatformCode(): ?int
    {
        return $this->platformCode;
    }

    public function setPlatformCode(PlatformCodeEnum $platformCode): self
    {
        $this->platformCode = $platformCode->value;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(TranslationEnum $message): self
    {
        $this->message = $message->value;

        return $this;
    }

    public function getMessageParameters(): ?array
    {
        return $this->messageParameters;
    }

    public function setMessageParameters(array $messageParameters): self
    {
        $this->messageParameters = $messageParameters;

        return $this;
    }
}
