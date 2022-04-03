<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\ArtistSubscriberRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ArtistSubscriber.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: ArtistSubscriberRepository::class)]
#[ORM\Table('artist_subscribers')]
#[ORM\HasLifecycleCallbacks]
class ArtistSubscriber implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|User
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'artistSubscribers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $artist = null;

    /**
     * @var null|User
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'artistSubscribers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $subscriber = null;

    /**
     * @var null|int
     */
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $status = null;

    /**
     * @return null|User
     */
    public function getArtist(): ?User
    {
        return $this->artist;
    }

    /**
     * @param null|User $artist
     *
     * @return $this
     */
    public function setArtist(?User $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getSubscriber(): ?User
    {
        return $this->subscriber;
    }

    /**
     * @param null|User $subscriber
     *
     * @return $this
     */
    public function setSubscriber(?User $subscriber): self
    {
        $this->subscriber = $subscriber;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
