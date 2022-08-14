<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Interfaces\EntityS3SettingInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UuidIdentifierTrait;
use App\Enum\EntityS3SettingEnum;
use App\Repository\UserProfileDesignRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProfileDesignRepository::class)]
#[ORM\Table('user_profile_designs')]
#[ORM\HasLifecycleCallbacks]
final class UserProfileDesign implements EntityInterface, EntityS3SettingInterface
{
    use IdentifierTrait;
    use UuidIdentifierTrait;
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

    public function __construct()
    {
        $this->generateUuid();
    }

    public function getFolderName(): EntityS3SettingEnum
    {
        return EntityS3SettingEnum::USER_PROFILE_DESIGN;
    }

    public function setUserProfile(?UserProfile $userProfile): self
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

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
