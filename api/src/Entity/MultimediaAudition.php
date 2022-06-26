<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\MultimediaAuditionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MultimediaAudition.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MultimediaAuditionRepository::class)]
#[ORM\Table('multimedia_auditions')]
#[ORM\HasLifecycleCallbacks]
class MultimediaAudition implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Multimedia::class, inversedBy: 'auditions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'multimediaAuditions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        'comment' => 'Is it full listening - no rewinds'
    ])]
    private bool $isFull = false;

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
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param null|User $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return null|bool
     */
    public function isIsFull(): ?bool
    {
        return $this->isFull;
    }

    /**
     * @param bool $isFull
     *
     * @return $this
     */
    public function setIsFull(bool $isFull): self
    {
        $this->isFull = $isFull;

        return $this;
    }
}