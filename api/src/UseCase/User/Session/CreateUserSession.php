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

final class CreateUserSession
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
    public function process(UserDto $userDto, User $user, UserSessionTypeEnum $type): UserSession
    {
        $collectedUserSession = $this->collectorSession->collect($userDto, $user, $type);

        $this->flusher->save($collectedUserSession);

        return $collectedUserSession;
    }
}