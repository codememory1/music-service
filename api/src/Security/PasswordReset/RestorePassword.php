<?php

namespace App\Security\PasswordReset;

use App\DTO\RestorePasswordDTO;
use App\Entity\PasswordReset;
use App\Enum\PasswordResetStatusEnum;
use App\Rest\Http\Exceptions\InvalidException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RestorePassword.
 *
 * @package App\Security\PasswordReset
 *
 * @author  Codememory
 */
class RestorePassword extends AbstractService
{
    /**
     * @param RestorePasswordDTO $restorePasswordDTO
     *
     * @return JsonResponse
     */
    public function restore(RestorePasswordDTO $restorePasswordDTO): JsonResponse
    {
        if (false === $this->validate($restorePasswordDTO)) {
            return $this->validator->getResponse();
        }

        $finedPasswordReset = $this->em->getRepository(PasswordReset::class)->findOneBy([
            'user' => $restorePasswordDTO->user,
            'code' => $restorePasswordDTO->code,
            'status' => PasswordResetStatusEnum::IN_PROCESS->name
        ]);

        if (null === $finedPasswordReset || false === $finedPasswordReset->isValidTtlByCreatedAt()) {
            throw InvalidException::invalidCode();
        }

        $restorePasswordDTO->user->setPassword($restorePasswordDTO->password);
        $finedPasswordReset->setStatus(PasswordResetStatusEnum::COMPLETED);

        $this->em->flush();

        return $this->responseCollection->successUpdate('passwordReset@successRestorePassword');
    }
}