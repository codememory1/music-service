<?php

namespace App\Service\UserSession;

use App\Dto\Transfer\UserDto;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Service\FlusherService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class UpdateSession
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly CollectorSession $collectorSession
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function make(
        UserDto $dto,
        User $user,
        ?UserSession $userSession = null,
        UserSessionTypeEnum $type = UserSessionTypeEnum::TEMP
    ): UserSession {
        $collectedUserSession = $this->collectorSession->collect($dto, $user, $type, $userSession);

        $this->flusher->save($collectedUserSession);

        return $collectedUserSession;
    }
}