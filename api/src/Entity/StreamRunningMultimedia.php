<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\StreamMultimediaStatusEnum;
use App\Repository\StreamRunningMultimediaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StreamRunningMultimediaRepository::class)]
#[ORM\Table('streams_running_multimedia')]
#[ORM\HasLifecycleCallbacks]
final class StreamRunningMultimedia implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\OneToOne(inversedBy: 'streamRunningMultimedia', targetEntity: RunningMultimedia::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?RunningMultimedia $runningMultimedia = null;

    #[ORM\OneToOne(inversedBy: 'streamRunningMultimediaFromMe', targetEntity: UserSession::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserSession $fromUserSession = null;

    #[ORM\OneToOne(inversedBy: 'streamRunningMultimediaForMe', targetEntity: UserSession::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserSession $toUserSession = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Streaming status from StreamMultimediaStatusEnum'
    ])]
    private ?string $status = null;

    public function getRunningMultimedia(): ?RunningMultimedia
    {
        return $this->runningMultimedia;
    }

    public function setRunningMultimedia(RunningMultimedia $runningMultimedia): self
    {
        $this->runningMultimedia = $runningMultimedia;

        return $this;
    }

    public function getFromUserSession(): ?UserSession
    {
        return $this->fromUserSession;
    }

    public function setFromUserSession(UserSession $fromUserSession): self
    {
        $this->fromUserSession = $fromUserSession;

        return $this;
    }

    public function getToUserSession(): ?UserSession
    {
        return $this->toUserSession;
    }

    public function setToUserSession(UserSession $toUserSession): self
    {
        $this->toUserSession = $toUserSession;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?StreamMultimediaStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }
}
