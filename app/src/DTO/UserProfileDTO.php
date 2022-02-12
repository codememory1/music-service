<?php

namespace App\DTO;

use App\Entity\User;
use App\Entity\UserProfile;
use DateTimeInterface;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserProfileDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class UserProfileDTO extends AbstractDTO
{

    /**
     * @var string|null
     */
    protected ?string $entityClass = UserProfile::class;

    /**
     * @var User|null
     */
    #[Assert\NotBlank(message: 'common@userIsRequired', payload: 'user_is_required')]
    private ?User $user = null;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'userProfile@nameIsRequired', payload: 'name_is_required')]
    #[Assert\Length(max: 50, maxMessage: 'userProfile@nameMaxLength', payload: 'name_length')]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[Assert\Length(max: 50, maxMessage: 'user@surnameMaxLength', payload: 'surname_length')]
    private ?string $surname = null;

    /**
     * @var string|null
     */
    #[Assert\Length(max: 50, maxMessage: 'user@patronymicMaxLength', payload: 'patronymic_length')]
    private ?string $patronymic = null;

    /**
     * @var DateTimeInterface|null
     */
    #[Assert\Date(message: 'userPro$userProfilesfile@invalidBirth')]
    private ?DateTimeInterface $birth = null;

    /**
     * @param UserProfile $userProfile
     * @param array       $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'         => "int|null",
        'name'       => "null|string",
        'surname'    => "null|string",
        'patronymic' => "null|string",
        'birth'      => "\DateTimeInterface|null",
        'created_at' => "string",
        'updated_at' => "null|string"
    ])]
    public function toArray(UserProfile $userProfile, array $exclude = []): array
    {

        $userProfile = [
            'id'         => $userProfile->getId(),
            'name'       => $userProfile->getName(),
            'surname'    => $userProfile->getSurname(),
            'patronymic' => $userProfile->getPatronymic(),
            'birth'      => $userProfile->getBirth(),
            'created_at' => $userProfile->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $userProfile->getUpdatedAt()?->format('Y-m-d H:i:s')
        ];

        $this->excludeKeys($userProfile, $exclude);

        return $userProfile;

    }

    /**
     * @param User|null $user
     *
     * @return UserProfileDTO
     */
    public function setUser(?User $user): self
    {

        $this->user = $user;

        return $this;

    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {

        return $this->user;

    }

    /**
     * @param string|null $name
     *
     * @return UserProfileDTO
     */
    public function setName(?string $name): self
    {

        $this->name = $name;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {

        return $this->name;

    }

    /**
     * @param string|null $surname
     *
     * @return UserProfileDTO
     */
    public function setSurname(?string $surname): self
    {

        $this->surname = $surname;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {

        return $this->surname;

    }

    /**
     * @param string|null $patronymic
     *
     * @return UserProfileDTO
     */
    public function setPatronymic(?string $patronymic): self
    {

        $this->patronymic = $patronymic;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getPatronymic(): ?string
    {

        return $this->patronymic;

    }

    /**
     * @param DateTimeInterface|null $birth
     *
     * @return UserProfileDTO
     */
    public function setBirth(?DateTimeInterface $birth): self
    {

        $this->birth = $birth;

        return $this;

    }

    /**
     * @return DateTimeInterface|null
     */
    public function getBirth(): ?DateTimeInterface
    {

        return $this->birth;

    }

}