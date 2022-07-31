<?php

namespace App\Security\PasswordReset;

use App\Dto\Transfer\RestorePasswordDto;
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
    public function restore(RestorePasswordDto $restorePasswordDto): JsonResponse
    {
        $this->validate($restorePasswordDto);

        $finedPasswordReset = $this->em->getRepository(PasswordReset::class)->findOneBy([
            'user' => $restorePasswordDto->user,
            'code' => $restorePasswordDto->code,
            'status' => PasswordResetStatusEnum::IN_PROCESS->name
        ]);

        if (null === $finedPasswordReset || false === $finedPasswordReset->isValidTtlByCreatedAt()) {
            throw InvalidException::invalidCode();
        }

        $restorePasswordDto->user->setPassword($restorePasswordDto->password);

        $finedPasswordReset->setCompletedStatus();

        $this->flusherService->save();

        return $this->responseCollection->successUpdate('passwordReset@successRestorePassword');
    }
}