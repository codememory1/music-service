<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Interfaces\EntityS3SettingInterface;
use App\Entity\Traits\CloningTrait;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UpdateNumberMultimediaMediaLibraryStatisticTrait;
use App\Entity\Traits\UuidIdentifierTrait;
use App\Enum\EntityS3SettingEnum;
use App\Enum\PlatformCodeEnum;
use App\Infrastructure\Validator\Validator;
use App\Repository\MultimediaMediaLibraryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MultimediaMediaLibraryRepository::class)]
#[ORM\Table('multimedia_media_library')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    ['mediaLibrary', 'multimedia'],
    message: 'multimediaMediaLibrary@multimediaAlreadyAdd',
    payload: [Validator::PPC => PlatformCodeEnum::ENTITY_FOUND]
)]
class MultimediaMediaLibrary implements EntityInterface, EntityS3SettingInterface
{
    use IdentifierTrait;
    use UuidIdentifierTrait;
    use TimestampTrait;
    use UpdateNumberMultimediaMediaLibraryStatisticTrait;
    use CloningTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: MediaLibrary::class, inversedBy: 'multimedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MediaLibrary $mediaLibrary = null;

    #[ORM\ManyToOne(targetEntity: Multimedia::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    #[ORM\Column(type: Types::STRING, length: 50, nullable: true, options: [
        'comment' => 'The name of the media that will be visible only inside the music library'
    ])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: [
        'comment' => 'Media image that will only be visible inside the Music Library'
    ])]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'multimediaMediaLibrary', targetEntity: MultimediaMediaLibraryEvent::class, cascade: ['remove'])]
    private Collection $events;

    public function __construct()
    {
        $this->generateUuid();

        $this->events = new ArrayCollection();
    }

    public function getFolderName(): EntityS3SettingEnum
    {
        return EntityS3SettingEnum::MULTIMEDIA_MEDIA_LIBRARY;
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

    public function getMultimedia(): ?Multimedia
    {
        return $this->multimedia;
    }

    public function setMultimedia(?Multimedia $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, MultimediaMediaLibraryEvent>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(MultimediaMediaLibraryEvent $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setMultimediaMediaLibrary($this);
        }

        return $this;
    }

    public function removeEvent(MultimediaMediaLibraryEvent $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getMultimediaMediaLibrary() === $this) {
                $event->setMultimediaMediaLibrary(null);
            }
        }

        return $this;
    }
}
