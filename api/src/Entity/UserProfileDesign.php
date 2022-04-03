<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\UserProfileDesingRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class UserProfileDesign.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserProfileDesingRepository::class)]
#[ORM\Table('user_profile_designs')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    'userProfile',
    'userProfileDesign@designExist',
    payload: ApiResponseTypeEnum::CHECK_EXIST
)]
class UserProfileDesign implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|UserProfile
     */
    #[ORM\OneToOne(inversedBy: 'userProfileDesign', targetEntity: UserProfile::class)]
    #[ORM\JoinColumn(unique: true, nullable: false)]
    private ?UserProfile $userProfile = null;

    /**
     * @var array
     */
    #[ORM\Column(type: Types::JSON)]
    private array $payload = [];

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
     * @return null|array
     */
    public function getPayload(): ?array
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     *
     * @return $this
     */
    public function setPayload(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }
}
