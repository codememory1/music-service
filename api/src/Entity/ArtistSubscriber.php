<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\ArtistSubscriberRepository;
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

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'subscribers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $artist = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $subscriber = null;

    /**
     * @return null|User
     */
    public function getArtist(): ?User
    {
        return $this->artist;
    }

    public function setArtist(?User $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getSubscriber(): ?User
    {
        return $this->subscriber;
    }

    public function setSubscriber(?User $subscriber): self
    {
        $this->subscriber = $subscriber;

        return $this;
    }
}
