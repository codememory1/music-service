<?php

namespace App\UseCase\User\Session;

use App\Dto\Transfer\UserDto;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Infrastructure\Doctrine\Flusher;
use App\Service\UserSession\CollectorSession;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class UpdateUserSession
{
    public function __construct(
        private readonly Flusher $flusher,
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
    public function process(
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