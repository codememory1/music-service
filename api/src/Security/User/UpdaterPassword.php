<?php

namespace App\Security\User;

use App\DTO\UserChangePasswordDTO;
use App\Entity\User;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Service\HashingService;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdaterPassword.
 *
 * @package App\Security\User
 *
 * @author  Codememory
 */
class UpdaterPassword extends AbstractSecurity
{
    /**
     * @var HashingService
     */
    private HashingService $hashingService;

    /**
     * @param HashingService $hashingService
     *
     * @return $this
     */
    #[Required]
    public function setHashingService(HashingService $hashingService): self
    {
        $this->hashingService = $hashingService;

        return $this;
    }

    /**
     * @param UserChangePasswordDTO $userChangePasswordDTO
     * @param User                  $user
     *
     * @return User
     */
    public function update(UserChangePasswordDTO $userChangePasswordDTO, User $user): User
    {
        $user->setPassword($this->hashingService->encode($userChangePasswordDTO->password));

        $this->em->flush();

        return $user;
    }

    /**
     * @return Response
     */
    public function successChangePasswordResponse(): Response
    {
        return $this->responseCollection
            ->successUpdate('user@successChangePassword')
            ->getResponse();
    }
}