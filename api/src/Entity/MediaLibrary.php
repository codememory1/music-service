<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\MediaLibraryStatusEnum;
use App\Repository\MediaLibraryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MediaLibrary.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MediaLibraryRepository::class)]
#[ORM\Table('media_libraries')]
#[ORM\HasLifecycleCallbacks]
class MediaLibrary implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\OneToOne(inversedBy: 'mediaLibrary', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Media library status from MediaLibraryStatusEnum'
    ])]
    private ?string $status = null;

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param null|MediaLibraryStatusEnum $status
     *
     * @return $this
     */
    public function setStatus(?MediaLibraryStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }
}
