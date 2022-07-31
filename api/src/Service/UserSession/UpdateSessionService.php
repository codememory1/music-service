<?php

namespace App\Service\UserSession;

use App\Dto\Transfer\UserDto;
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
 * Class UpdateSessionService.
 *
 * @package App\Service\UserSession
 *
 * @author  Codememory
 */
class UpdateSessionService extends AbstractService
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
    public function make(
        UserDto $userDto,
        User $user,
        ?UserSession $userSession = null,
        UserSessionTypeEnum $type = UserSessionTypeEnum::TEMP
    ): UserSession {
        $collectedUserSession = $this->collectorSessionService->collect($userDto, $user, $type, $userSession);

        $this->flusherService->save($collectedUserSession);

        return $collectedUserSession;
    }
}