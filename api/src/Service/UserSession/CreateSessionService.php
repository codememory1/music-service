<?php

namespace App\Service\UserSession;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Service\AbstractService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreateSessionService.
 *
 * @package App\Service\UserSession
 *
 * @author  Codememory
 */
class CreateSessionService extends AbstractService
{
    #[Required]
    public ?CollectorSessionService $collectorSessionService = null;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function make(UserDTO $userDTO, User $user, UserSessionTypeEnum $type): UserSession
    {
        $collectedUserSession = $this->collectorSessionService->collect($userDTO, $user, $type);

        $this->flusherService->save($collectedUserSession);

        return $collectedUserSession;
    }
}