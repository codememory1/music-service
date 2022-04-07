<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\MusicRatingRepository;
use App\Traits\Entity\IdentifierTrait;
use App\Traits\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class MusicRating.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MusicRatingRepository::class)]
#[ORM\Table('music_ratings')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    ['music', 'user'],
    'musicRating@ratingAdded',
    payload: ApiResponseTypeEnum::CHECK_EXIST
)]
class MusicRating implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 50)]
    private ?string $type = null;

    /**
     * @var null|Music
     */
    #[ORM\ManyToOne(targetEntity: Music::class, inversedBy: 'musicRatings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Music $music = null;

    /**
     * @var null|User
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'musicRatings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return null|Music
     */
    public function getMusic(): ?Music
    {
        return $this->music;
    }

    /**
     * @param null|Music $music
     *
     * @return $this
     */
    public function setMusic(?Music $music): self
    {
        $this->music = $music;

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
}
