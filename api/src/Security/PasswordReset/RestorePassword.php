<?php

namespace App\Security\PasswordReset;

use App\DTO\RestorePasswordDTO;
use App\Entity\PasswordReset;
use App\Enum\PasswordResetStatusEnum;
use App\Rest\Http\Exceptions\InvalidException;
use App\Service\AbstractService;
use DateTimeImmutable;
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

        if (null === $finedPasswordReset || false === $this->isValidTtl($finedPasswordReset)) {
            throw InvalidException::invalidCode();
        }

        $restorePasswordDTO->user->setPassword($restorePasswordDTO->password);
        $finedPasswordReset->setStatus(PasswordResetStatusEnum::COMPLETED);

        $this->em->flush();

        return $this->responseCollection->successUpdate('passwordReset@successRestorePassword');
    }

    /**
     * @param PasswordReset $passwordReset
     *
     * @return bool
     */
    private function isValidTtl(PasswordReset $passwordReset): bool
    {
        $now = (new DateTimeImmutable())->getTimestamp();
        $createdIn = $passwordReset->getCreatedAt()->getTimestamp();

        return !($now > $createdIn + $passwordReset->getTtl());
    }
}