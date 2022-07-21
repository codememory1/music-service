<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\MediaLibraryEventEnum;
use App\Repository\MediaLibraryEventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MediaLibraryEvent.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MediaLibraryEventRepository::class)]
#[ORM\Table('media_library_events')]
#[ORM\HasLifecycleCallbacks]
class MediaLibraryEvent implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Event key from MediaLibraryEventEnum'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::ARRAY, options: [
        'comment' => 'Event Data'
    ])]
    private array $payload = [];

    #[ORM\ManyToOne(targetEntity: MediaLibrary::class, inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MediaLibrary $mediaLibrary = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?MediaLibraryEventEnum $key): self
    {
        $this->key = $key?->name;

        return $this;
    }

    public function getPayload(): ?array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    public function getMediaLibrary(): ?MediaLibrary
    {
        return $this->mediaLibrary;
    }

    public function setMediaLibrary(?MediaLibrary $mediaLibrary): self
    {
        $this->mediaLibrary = $mediaLibrary;

        return $this;
    }
}
