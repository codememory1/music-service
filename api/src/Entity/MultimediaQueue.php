<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\MultimediaQueueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MultimediaQueue.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MultimediaQueueRepository::class)]
#[ORM\Table('multimedia_queue')]
#[ORM\HasLifecycleCallbacks]
class MultimediaQueue implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\OneToOne(inversedBy: 'queue', targetEntity: Multimedia::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    /**
     * @return null|Multimedia
     */
    public function getMultimedia(): ?Multimedia
    {
        return $this->multimedia;
    }

    /**
     * @param Multimedia $multimedia
     *
     * @return $this
     */
    public function setMultimedia(Multimedia $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }
}
