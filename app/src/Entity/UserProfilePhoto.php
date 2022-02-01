<?php

namespace App\Entity;

use App\Repository\UserProfilePhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserProfilePhoto
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserProfilePhotoRepository::class)]
#[ORM\Table('user_profile_photos')]
class UserProfilePhoto
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var UserProfile|null
     */
    #[ORM\OneToOne(inversedBy: 'userProfilePhoto', targetEntity: UserProfile::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'common@userProfileIsRequired', payload: 'user_profile_is_required')]
    private ?UserProfile $userProfile = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text', options: [
        'comment' => 'Path to photography'
    ])]
    #[Assert\NotBlank(message: 'userProfilePhoto@photoIsRequired', payload: 'photo_is_required')]
    private ?string $photo = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @return UserProfile|null
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
     * @return string|null
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
