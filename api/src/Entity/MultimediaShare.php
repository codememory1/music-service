<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\MultimediaShareRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MultimediaShare.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MultimediaShareRepository::class)]
#[ORM\Table('multimedia_shares')]
#[ORM\HasLifecycleCallbacks]
class MultimediaShare implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Multimedia::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fromUser = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sharedWithMe')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $toUser = null;

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
     * @return null|User
     */
    public function getFromUser(): ?User
    {
        return $this->fromUser;
    }

    /**
     * @param null|User $fromUser
     *
     * @return $this
     */
    public function setFromUser(?User $fromUser): self
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getToUser(): ?User
    {
        return $this->toUser;
    }

    /**
     * @param null|User $toUser
     *
     * @return $this
     */
    public function setToUser(?User $toUser): self
    {
        $this->toUser = $toUser;

        return $this;
    }
}
