<?php

namespace App\DTO;

use App\Entity\Role;
use App\Entity\User;
use App\Enum\EventNameDTOEnum;
use App\Enum\RoleEnum;
use App\Enum\StatusEnum;
use App\Repository\RoleRepository;
use App\Rest\DTO\AbstractDTO;
use App\Service\HashingService;
use App\Traits\DTO\PasswordConfirmTrait;
use App\Traits\DTO\PasswordTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegistrationDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class RegistrationDTO extends AbstractDTO
{
    use PasswordTrait;

    use PasswordConfirmTrait;

    /**
     * @var null|string
     */
    #[Assert\Email(message: 'common@invalidEmail')]
    #[Assert\Length(max: 255, maxMessage: 'common@emailMaxLength')]
    public ?string $email = null;

    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'user@usernameIsRequired')]
    #[Assert\Length(max: 250, maxMessage: 'user@usernameMaxLength')]
    public ?string $username = null;

    /**
     * @return void
     */
    protected function wrapper(): void
    {
        $this->setEntity(User::class);

        $this
            ->addExpectedRequestKey('email')
            ->addExpectedRequestKey('password')
            ->addExpectedRequestKey('password_confirm', 'passwordConfirm');

        $this->excludeRequestKeyForBuildEntity('passwordConfirm');

        $this
            ->addEventListener(EventNameDTOEnum::AFTER_SETTER, function(): void {
                $this->username = explode('@', $this->email)[0] ?? null;
            })
            ->addEventListener(EventNameDTOEnum::AFTER_BUILD_ENTITY, function(User $userEntity): void {
                /** @var RoleRepository $roleRepository */
                $roleRepository = $this->em->getRepository(Role::class);

                $userEntity
                    ->setPassword((new HashingService())->encode($this->password))
                    ->setStatus(StatusEnum::NOT_ACTIVE->value)
                    ->setRole($roleRepository->findOneBy(['key' => RoleEnum::USER->value]));

                if (!empty($this->email)) {
                    $userEntity->setUsername($this->username);
                }
            });
    }
}