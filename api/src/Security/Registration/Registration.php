<?php

namespace App\Security\Registration;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Enum\StatusEnum;
use App\Repository\UserRepository;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Registration.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class Registration extends AbstractSecurity
{
    /**
     * @var null|UserRepository
     */
    private ?UserRepository $userRepository = null;

    /**
     * @param UserRepository $userRepository
     *
     * @return $this
     */
    #[Required]
    public function setUserRepository(UserRepository $userRepository): self
    {
        $this->userRepository = $userRepository;

        return $this;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     *
     * @return bool|User
     */
    public function isReRegistration(RegistrationDTO $registrationDTO): User|bool
    {
        $finedUser = $this->userRepository->findOneBy([
            'email' => $registrationDTO->email,
            'status' => StatusEnum::NOT_ACTIVE->value
        ]);

        return null === $finedUser ? false : $finedUser;
    }

    /**
     * @return Response
     */
    public function successRegisterResponse(): Response
    {
        return $this->responseCollection->successRegister()->getResponse();
    }
}