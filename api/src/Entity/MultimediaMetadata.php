<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\MultimediaMetadataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MultimediaMetadata.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MultimediaMetadataRepository::class)]
#[ORM\Table('multimedia_metadata')]
#[ORM\HasLifecycleCallbacks]
class MultimediaMetadata implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

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

    /**
     * @return null|Multimedia
     */
    public function getMultimedia(): ?Multimedia
    {
        return $this->multimedia;
    }

    /**
     * @param null|Multimedia $multimedia
     *
     * @return $this
     */
    public function setMultimedia(?Multimedia $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    /**
     * @return null|float
     */
    public function getDuration(): ?float
    {
        return $this->duration;
    }

    /**
     * @param null|float $duration
     *
     * @return $this
     */
    public function setDuration(?float $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getBitrate(): ?int
    {
        return $this->bitrate;
    }

    /**
     * @param null|int $bitrate
     *
     * @return $this
     */
    public function setBitrate(?int $bitrate): self
    {
        $this->bitrate = $bitrate;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getFramerate(): ?int
    {
        return $this->framerate;
    }

    /**
     * @param null|int $framerate
     *
     * @return $this
     */
    public function setFramerate(?int $framerate): self
    {
        $this->framerate = $framerate;

        return $this;
    }

    /**
     * @return null|bool
     */
    public function isIsLossless(): ?bool
    {
        return $this->isLossless;
    }

    /**
     * @param null|bool $isLossless
     *
     * @return $this
     */
    public function setIsLossless(?bool $isLossless): self
    {
        $this->isLossless = $isLossless ?? false;

        return $this;
    }
}
