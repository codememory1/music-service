<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\RunningMultimediaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: RunningMultimediaRepository::class)]
#[ORM\Table('running_multimedia')]
#[ORM\HasLifecycleCallbacks]
final class RunningMultimedia implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\OneToOne(inversedBy: 'runningMultimedia', targetEntity: UserSession::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserSession $userSession = null;

    #[ORM\ManyToOne(targetEntity: Multimedia::class, inversedBy: 'runningMultimedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    #[ORM\Column('`current_time`', Types::FLOAT, options: [
        'comment' => 'Time at which multimedia plays'
    ])]
    private ?float $currentTime = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        'comment' => 'Is media currently running'
    ])]
    private bool $isPlaying = false;

    #[ORM\OneToOne(mappedBy: 'runningMultimedia', targetEntity: StreamRunningMultimedia::class, cascade: ['persist', 'remove'])]
    private ?StreamRunningMultimedia $streamRunningMultimedia = null;

    public function getUserSession(): ?UserSession
    {
        return $this->userSession;
    }

    public function setUserSession(?UserSession $userSession): self
    {
        $this->userSession = $userSession;

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

    public function getCurrentTime(): ?float
    {
        return $this->currentTime;
    }

    public function setCurrentTime(?float $currentTime): self
    {
        $this->currentTime = $currentTime;

        return $this;
    }

    public function isPlaying(): ?bool
    {
        return $this->isPlaying;
    }

    public function setIsPlaying(bool $isPlaying): self
    {
        $this->isPlaying = $isPlaying;

        return $this;
    }

    public function play(): self
    {
        return $this->setIsPlaying(true);
    }

    #[Pure]
    public function isPause(): bool
    {
        return false === $this->isPlaying();
    }

    public function pause(): self
    {
        return $this->setIsPlaying(false);
    }

    public function switchIsPlaying(): self
    {
        $this->isPlaying() ? $this->pause() : $this->play();

        return $this;
    }

    public function getStreamRunningMultimedia(): ?StreamRunningMultimedia
    {
        return $this->streamRunningMultimedia;
    }

    public function setStreamRunningMultimedia(StreamRunningMultimedia $streamRunningMultimedia): self
    {
        // set the owning side of the relation if necessary
        if ($streamRunningMultimedia->getRunningMultimedia() !== $this) {
            $streamRunningMultimedia->setRunningMultimedia($this);
        }

        $this->streamRunningMultimedia = $streamRunningMultimedia;

        return $this;
    }
}
