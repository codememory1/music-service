<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\MultimediaTimeCodeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MultimediaTimeCodeRepository::class)]
#[ORM\Table('multimedia_time_codes')]
#[ORM\HasLifecycleCallbacks]
class MultimediaTimeCode implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Multimedia::class, inversedBy: 'timeCodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: [
        'comment' => 'Path to preview time code'
    ])]
    private ?string $preview = null;

    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'Time code from time'
    ])]
    private ?int $fromTime = null;

    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'Time code to time'
    ])]
    private ?int $toTime = null;

    #[ORM\Column(type: Types::STRING, length: 50, options: [
        'comment' => 'The name of the time code is short about the moment what is happening here'
    ])]
    private ?string $title = null;

    public function getMultimedia(): ?Multimedia
    {
        return $this->multimedia;
    }

    public function setMultimedia(?Multimedia $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    public function getPreview(): ?float
    {
        return $this->preview;
    }

    public function setPreview(?string $preview): self
    {
        $this->preview = $preview;

        return $this;
    }

    public function getFromTime(): ?int
    {
        return $this->fromTime;
    }

    public function setFromTime(?int $fromTime): self
    {
        $this->fromTime = $fromTime;

        return $this;
    }

    public function getToTime(): ?int
    {
        return $this->toTime;
    }

    public function setToTime(?int $toTime): self
    {
        $this->toTime = $toTime;

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
}
