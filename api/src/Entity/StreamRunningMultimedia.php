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
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: StreamRunningMultimediaRepository::class)]
#[ORM\Table('streams_running_multimedia')]
#[ORM\HasLifecycleCallbacks]
class StreamRunningMultimedia implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: RunningMultimedia::class, inversedBy: 'streamRunningMultimedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RunningMultimedia $runningMultimedia = null;

    #[ORM\ManyToOne(targetEntity: UserSession::class, inversedBy: 'streamRunningMultimediaFromMe')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserSession $fromUserSession = null;

    #[ORM\ManyToOne(targetEntity: UserSession::class, inversedBy: 'streamRunningMultimediaForMe')]
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

    public function pending(): self
    {
        $this->setStatus(StreamMultimediaStatusEnum::PENDING);

        return $this;
    }

    #[Pure]
    public function isPending(): bool
    {
        return $this->getStatus() === StreamMultimediaStatusEnum::PENDING->name;
    }

    public function accepted(): self
    {
        $this->setStatus(StreamMultimediaStatusEnum::ACCEPTED);

        return $this;
    }

    #[Pure]
    public function isAccepted(): bool
    {
        return $this->getStatus() === StreamMultimediaStatusEnum::ACCEPTED->name;
    }
}
