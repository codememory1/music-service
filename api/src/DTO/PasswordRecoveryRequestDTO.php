<?php

namespace App\DTO;

use App\Entity\PasswordReset;
use App\Entity\User;
use App\Enum\EventNameDTOEnum;
use App\Enum\PasswordResetStatusEnum;
use App\Repository\UserRepository;
use App\Rest\DTO\AbstractDTO;
use App\Service\JwtTokenGenerator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PasswordRecoveryRequestDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class PasswordRecoveryRequestDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'recoveryRequest@emailIsRequired')]
    #[Assert\Email(message: 'common@invalidEmail')]
    public ?string $email = null;

    /**
     * @return void
     */
    protected function wrapper(): void
    {
        $this->setEntity(PasswordReset::class);

        $this->addExpectedRequestKey('email');

        $this->excludeRequestKeyForBuildEntity('email');

        $this->addEventListener(EventNameDTOEnum::AFTER_BUILD_ENTITY, function(PasswordReset $passwordReset): void {
            /** @var UserRepository $userRepository */
            $userRepository = $this->em->getRepository(User::class);
            $user = $userRepository->findOneBy(['email' => $this->email]);

            $passwordReset
                ->setUser($user)
                ->setToken($this->generateToken($user))
                ->setExecuted(false)
                ->setStatus(PasswordResetStatusEnum::WAITING_RESET);
        });
    }

    /**
     * @param User $user
     *
     * @return string
     */
    private function generateToken(User $user): string
    {
        $jwtTokenGenerator = new JwtTokenGenerator();

        return $jwtTokenGenerator->encode([
            'id' => $user->getId(),
            'email' => $user->getEmail()
        ], 'JWT_PASSWORD_RESET_PRIVATE_KEY', 'JWT_PASSWORD_RESET_TTL');
    }
}