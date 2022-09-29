<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\MultimediaRatingTypeEnum;
use App\Repository\MultimediaStatisticRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MultimediaStatisticRepository::class)]
#[ORM\Table('multimedia_statistics')]
#[ORM\HasLifecycleCallbacks]
class MultimediaStatistic implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\OneToOne(inversedBy: 'statistic', targetEntity: Multimedia::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'Number of successful streams'
    ])]
    private int $successfulStreams = 0;

    public function getMultimedia(): ?Multimedia
    {
        return $this->multimedia;
    }

    public function setMultimedia(Multimedia $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    public function getSuccessfulStreams(): int
    {
        return $this->successfulStreams;
    }

    public function setSuccessfulStreams(int $successfulStreams): self
    {
        $this->successfulStreams = $successfulStreams;

        return $this;
    }

    public function addSuccessFulStreams(): self
    {
        ++$this->successfulStreams;

        return $this;
    }

    public function getShared(): Collection
    {
        return $this->multimedia->getShares();
    }

    public function getAddedToMediaLibraries(): Collection
    {
        return $this->multimedia->getMultimediaMediaLibrary();
    }

    public function getFullAuditions(): Collection
    {
        return $this->multimedia->getAuditions()->filter(static fn(MultimediaAudition $multimediaAudition) => $multimediaAudition->isIsFull());
    }

    public function getAuditions(): Collection
    {
        return $this->multimedia->getAuditions();
    }

    public function getLikes(): Collection
    {
        return $this->multimedia->getRatings()->filter(static fn(MultimediaRating $multimediaRating) => $multimediaRating->getType() === MultimediaRatingTypeEnum::LIKE->name);
    }

    public function getDislikes(): Collection
    {
        return $this->multimedia->getRatings()->filter(static fn(MultimediaRating $multimediaRating) => $multimediaRating->getType() === MultimediaRatingTypeEnum::DISLIKE->name);
    }
}
