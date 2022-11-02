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

class CreateSessionService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly CollectorSessionService $collectorSession
    ) {}

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function make(UserDto $userDto, User $user, UserSessionTypeEnum $type): UserSession
    {
        $collectedUserSession = $this->collectorSession->collect($userDto, $user, $type);

        $this->flusherService->save($collectedUserSession);

        return $collectedUserSession;
    }
}