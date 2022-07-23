<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\UserProfileDesignRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserProfileDesign.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserProfileDesignRepository::class)]
#[ORM\Table('user_profile_designs')]
#[ORM\HasLifecycleCallbacks]
class UserProfileDesign implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\OneToOne(inversedBy: 'design', targetEntity: UserProfile::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserProfile $userProfile = null;

    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Main image'
    ])]
    private ?string $coverImage = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true, options: [
        'comment' => 'Design components according to the user_profile_design.json schema'
    ])]
    private ?array $designComponents = null;

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getDesignComponents(): ?array
    {
        return $this->designComponents ?? [];
    }

    public function setDesignComponents(?array $designComponents): self
    {
        $this->designComponents = $designComponents ?? [];

        return $this;
    }
}
