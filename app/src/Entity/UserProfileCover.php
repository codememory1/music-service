<?php

namespace App\Entity;

use App\Repository\UserProfileCoverRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserProfileCover
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserProfileCoverRepository::class)]
#[ORM\Table('user_profile_covers')]
class UserProfileCover
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
    #[ORM\OneToOne(inversedBy: 'userProfileCover', targetEntity: UserProfile::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'common@userProfileIsRequired', payload: 'user_profile_is_required')]
    private ?UserProfile $userProfile = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text', options: [
        'comment' => 'Path to cover'
    ])]
    #[Assert\NotBlank(message: 'userProfileCover@coverIsRequired', payload: 'cover_is_required')]
    private ?string $cover = null;

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
    public function getCover(): ?string
    {

        return $this->cover;

    }

    /**
     * @param string $cover
     *
     * @return $this
     */
    public function setCover(string $cover): self
    {

        $this->cover = $cover;

        return $this;

    }

}