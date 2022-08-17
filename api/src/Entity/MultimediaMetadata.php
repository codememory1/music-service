<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\MultimediaMetadataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MultimediaMetadataRepository::class)]
#[ORM\Table('multimedia_metadata')]
#[ORM\HasLifecycleCallbacks]
class MultimediaMetadata implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\OneToOne(inversedBy: 'metadata', targetEntity: Multimedia::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    #[ORM\Column(type: Types::FLOAT, nullable: false, options: [
        'comment' => 'Media duration'
    ])]
    private ?float $duration = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: [
        'comment' => 'Media bitrate'
    ])]
    private ?int $bitrate = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: [
        'comment' => 'Video frames per second'
    ])]
    private ?int $framerate = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        'comment' => 'Is there lossless compression?'
    ])]
    private ?bool $isLossless = false;

    public function getMultimedia(): ?Multimedia
    {
        return $this->multimedia;
    }

    public function setMultimedia(?Multimedia $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(?float $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getBitrate(): ?int
    {
        return $this->bitrate;
    }

    public function setBitrate(?int $bitrate): self
    {
        $this->bitrate = $bitrate;

        return $this;
    }

    public function getFramerate(): ?int
    {
        return $this->framerate;
    }

    public function setFramerate(?int $framerate): self
    {
        $this->framerate = $framerate;

        return $this;
    }

    public function IsLossless(): ?bool
    {
        return $this->isLossless;
    }

    public function setIsLossless(?bool $isLossless): self
    {
        $this->isLossless = $isLossless ?? false;

        return $this;
    }
}
