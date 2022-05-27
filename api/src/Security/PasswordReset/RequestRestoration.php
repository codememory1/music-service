<?php

namespace App\Security\PasswordReset;

use App\DTO\RequestRestorationPasswordDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RequestRestoration
 *
 * @package App\Security\PasswordReset
 *
 * @author  Codememory
 */
class RequestRestoration extends AbstractService
{
    public function send(RequestRestorationPasswordDTO $requestRestorationPasswordDTO): JsonResponse
    {
        if (false === $this->validate($requestRestorationPasswordDTO)) {
            return $this->validator->getResponse();
        }

        $passwordResetEntity = $requestRestorationPasswordDTO->getEntity();

        $passwordResetEntity->setTtl('10m');

        $this->em->persist($passwordResetEntity);
        $this->em->flush();

        return $this->responseCollection->successSendRequestRestorationPassword();
    }
}