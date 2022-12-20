<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\MultimediaMediaLibraryEventEnum;
use App\Enum\PlatformCodeEnum;
use App\Infrastructure\Validator\Validator;
use App\Repository\MultimediaMediaLibraryEventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MultimediaMediaLibraryEventRepository::class)]
#[ORM\Table('multimedia_media_library_events')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    ['multimediaMediaLibrary', 'key'],
    'entityExist@multimediaMediaLibraryEvent',
    payload: [Validator::PPC => PlatformCodeEnum::ENTITY_FOUND]
)]
class MultimediaMediaLibraryEvent implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: MultimediaMediaLibrary::class, inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MultimediaMediaLibrary $multimediaMediaLibrary = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Event key from MultimediaMediaLibraryEventEnum'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::ARRAY, options: [
        'comment' => 'Event Data'
    ])]
    private array $payload = [];

    public function getMultimediaMediaLibrary(): ?MultimediaMediaLibrary
    {
        return $this->multimediaMediaLibrary;
    }

    public function setMultimediaMediaLibrary(?MultimediaMediaLibrary $multimediaMediaLibrary): self
    {
        $this->multimediaMediaLibrary = $multimediaMediaLibrary;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?MultimediaMediaLibraryEventEnum $key): self
    {
        $this->key = $key?->name;

        return $this;
    }

    public function getPayload(): ?array
    {
        return $this->payload;
    }

    public function setPayload(?array $payload): self
    {
        $this->payload = $payload ?: [];

        return $this;
    }
}
