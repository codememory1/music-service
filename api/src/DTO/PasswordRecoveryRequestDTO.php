<?php

namespace App\DTO;

use App\Entity\PasswordReset;
use App\Entity\User;
use App\Enum\EventNameDTOEnum;
use App\Enum\PasswordResetStatusEnum;
use App\Interfaces\UserIdentificationInterface;
use App\Repository\UserRepository;
use App\Rest\DTO\AbstractDTO;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PasswordRecoveryRequestDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class PasswordRecoveryRequestDTO extends AbstractDTO implements UserIdentificationInterface
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'common@loginIsRequired')]
    #[Assert\Email(message: 'common@invalidEmail')]
    public ?string $login = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->setEntity(PasswordReset::class);

        $this->addExpectedRequestKey('login');

        $this->excludeRequestKeyForBuildEntity('login');

        $this->addEventListener(EventNameDTOEnum::AFTER_BUILD_ENTITY, function(PasswordReset $passwordReset): void {
            /** @var UserRepository $userRepository */
            $userRepository = $this->em->getRepository(User::class);
            $user = $userRepository->findByLogin($this->login);

            $passwordReset
                ->setUser($user)
                ->setStatus(PasswordResetStatusEnum::WAITING_RESET);
        });
    }

    /**
     * @inheritDoc
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }
}