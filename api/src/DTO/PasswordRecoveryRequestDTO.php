<?php

namespace App\DTO;

use App\Entity\PasswordReset;
use App\Entity\User;
use App\Enum\EventNameDTOEnum;
use App\Enum\PasswordResetStatusEnum;
use App\Interfaces\UserIdentificationInterface;
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
    #[Assert\NotBlank(message: 'common@emailIsRequired')]
    #[Assert\Email(message: 'common@invalidEmail')]
    public ?string $email = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->setEntity(PasswordReset::class);

        $this->addExpectedRequestKey('email');

        $this->excludeRequestKeyForBuildEntity('email');

        $this->addEventListener(EventNameDTOEnum::AFTER_BUILD_ENTITY, function(PasswordReset $passwordReset): void {
            $userRepository = $this->em->getRepository(User::class);

            $passwordReset
                ->setUser($userRepository->findByEmail($this->email))
                ->setStatus(PasswordResetStatusEnum::WAITING_RESET);
        });
    }

    /**
     * @inheritDoc
     */
    public function getLogin(): ?string
    {
        return $this->email;
    }
}