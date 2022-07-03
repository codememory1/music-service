<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\MultimediaRatingTypeEnum;
use App\Repository\MultimediaRatingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MultimediaRating.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MultimediaRatingRepository::class)]
#[ORM\Table('multimedia_ratings')]
#[ORM\HasLifecycleCallbacks]
class MultimediaRating implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Multimedia::class, inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'multimediaRatings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Assessment type from MultimediaRatingTypeEnum'
    ])]
    private ?string $type = null;

    public function getMultimedia(): ?Multimedia
    {
        return $this->multimedia;
    }

    public function setMultimedia(?Multimedia $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?MultimediaRatingTypeEnum $type): self
    {
        $this->type = $type?->name;

        return $this;
    }
}
