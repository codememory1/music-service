<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\UserProfilePhotoRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserProfilePhoto.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserProfilePhotoRepository::class)]
#[ORM\Table('user_profile_photos')]
#[ORM\HasLifecycleCallbacks]
class UserProfilePhoto implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|UserProfile
     */
    #[ORM\OneToOne(inversedBy: 'userProfilePhoto', targetEntity: UserProfile::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserProfile $userProfile = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Path to photography'
    ])]
    private ?string $photo = null;

    /**
     * @return null|UserProfile
     */
    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    /**
     * @param UserProfile $userProfile
     *
     * @return $this
     */
    public function setUserProfile(UserProfile $userProfile): self
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     *
     * @return $this
     */
    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
