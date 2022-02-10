<?php

namespace App\DTO;

use App\Entity\Role;
use App\Entity\User;
use App\Enum\RoleEnum;
use App\Enum\StatusEnum;
use App\Repository\RoleRepository;
use App\Service\RequestDataService;
use App\Validator\Constraints as AppAssert;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegistrationDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class RegistrationDTO extends AbstractDTO
{

    /**
     * @var array
     */
    protected array $requestKeys = [
        'email', 'password', 'password_confirm'
    ];

    /**
     * @var array|string[]
     */
    protected array $excludeKeyForEntity = [
        'password_confirm'
    ];

    /**
     * @var string|null
     */
    protected ?string $entityClass = User::class;

    /**
     * @var string|null
     */
    #[Assert\Email(message: 'common@invalidEmail', payload: 'invalid_email')]
    #[Assert\Length(max: 255, maxMessage: 'common@emailMaxLength', payload: 'email_length')]
    private ?string $email = null;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'user@usernameIsRequired', payload: 'username_is_required')]
    #[Assert\Length(max: 250, maxMessage: 'user@usernameMaxLength', payload: 'username_length')]
    private ?string $username = null;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'user@passwordIsRequired', payload: 'password_is_required')]
    #[Assert\Length(min: 8, minMessage: 'user@passwordMinLength', payload: 'password_length')]
    #[Assert\Regex('/^[a-z0-9\-_%\.\$\#]+$/i', message: 'user@passwordRegex', payload: 'password_regexp')]
    private ?string $password = null;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'user@passwordConfirmIsRequired', payload: 'password_confirm_is_required')]
    #[AppAssert\Between('getPassword', 'user@invalidPasswordConfirm', payload: 'password_confirm_is_invalid')]
    private ?string $passwordConfirm = null;

    /**
     * @param RequestDataService|null $requestDataService
     * @param ManagerRegistry|null    $managerRegistry
     */
    public function __construct(?RequestDataService $requestDataService = null, ?ManagerRegistry $managerRegistry = null)
    {

        parent::__construct($requestDataService, $managerRegistry);

        $this->afterEntityBuild(function(User $userEntity) {

            /** @var RoleRepository $roleRepository */
            $roleRepository = $this->em->getRepository(Role::class);

            $userEntity
                ->setStatus(StatusEnum::NOT_ACTIVE->value)
                ->setRole($roleRepository->findOneBy(['key' => RoleEnum::USER->value]));
        });

    }

    /**
     * @inheritDoc
     */
    public function transform(array $entities, array $exclude = []): array
    {

        return [];

    }

    /**
     * @param string|null $email
     *
     * @return RegistrationDTO
     */
    public function setEmail(?string $email): self
    {

        $this->email = $email;

        $this->setUsername(explode('@', $email)[0]);

        return $this;

    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {

        return $this->email;

    }

    /**
     * @param string|null $username
     *
     * @return RegistrationDTO
     */
    public function setUsername(?string $username): self
    {

        $this->username = $username;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {

        return $this->username;

    }

    /**
     * @param string|null $password
     *
     * @return RegistrationDTO
     */
    public function setPassword(?string $password): self
    {

        $this->password = $password;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {

        return $this->password;

    }

    /**
     * @param string|null $passwordConfirm
     *
     * @return RegistrationDTO
     */
    public function setPasswordConfirm(?string $passwordConfirm): self
    {

        $this->passwordConfirm = $passwordConfirm;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getPasswordConfirm(): ?string
    {

        return $this->passwordConfirm;

    }

}