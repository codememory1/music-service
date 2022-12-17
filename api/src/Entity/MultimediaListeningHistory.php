<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\MultimediaListeningHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MultimediaListeningHistoryRepository::class)]
#[ORM\Table('multimedia_listening_history')]
#[ORM\HasLifecycleCallbacks]
class MultimediaListeningHistory implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: Multimedia::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'multimediaListeningHistory')]
    private ?User $user = null;

    #[ORM\Column('`current_time`', Types::FLOAT, options: [
        'comment' => 'The time at which listening stopped'
    ])]
    private ?float $currentTime = null;

    public function getMultimedia(): ?Multimedia
    {
        return $this->multimedia;
    }

    public function setMultimedia(?Multimedia $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
}
