<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\ResponseTypeEnum;
use App\Repository\MultimediaMediaLibraryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class MultimediaMediaLibrary.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MultimediaMediaLibraryRepository::class)]
#[ORM\Table('multimedia_media_library')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(['mediaLibrary', 'multimedia'], message: 'multimediaMediaLibrary@multimediaAlreadyAdd', payload: [ResponseTypeEnum::EXIST, 409])]
class MultimediaMediaLibrary implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

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

    public function __clone(): void
    {
        $this->id = null;
        $this->createdAt = null;
        $this->updatedAt = null;
    }
}
