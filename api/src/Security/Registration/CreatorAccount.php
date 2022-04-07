<?php

namespace App\Security\Registration;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Service\HashingService;

/**
 * Class CreatorAccount.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class CreatorAccount extends AbstractSecurity
{
    /**
     * @var null|HashingService
     */
    private ?HashingService $hashingService = null;

    /**
     * @param HashingService $hashingService
     *
     * @return $this
     */
    public function setHashingService(HashingService $hashingService): self
    {
        $this->hashingService = $hashingService;

        return $this;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     *
     * @return User
     */
    public function create(RegistrationDTO $registrationDTO): User
    {
        /** @var User $userEntity */
        $userEntity = $registrationDTO->getCollectedEntity();

        $this->em->persist($userEntity);
        $this->em->flush();

        return $userEntity;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     * @param User            $user
     *
     * @return User
     */
    public function reCreate(RegistrationDTO $registrationDTO, User $user): User
    {
        $user->setPassword($this->hashingService->encode($registrationDTO->password));

        $this->em->flush();

        return $user;
    }

    /**
     * @return Response
     */
    public function successCreateAccountResponse(): Response
    {
        return $this->responseCollection->successCreate('user@successCreateAccount')->getResponse();
    }
}