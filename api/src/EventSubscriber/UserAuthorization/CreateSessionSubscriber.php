<?php

namespace App\EventSubscriber\UserAuthorization;

use App\Enum\EventEnum;
use App\Event\UserAuthorizationEvent;
use App\Rest\Http\Request;
use App\Service\UserSession\CreatorUserSessionService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateSessionSubscriber.
 *
 * @package App\EventSubscriber\UserAuthorization
 *
 * @author  Codememory
 */
class CreateSessionSubscriber implements EventSubscriberInterface
{
    /**
     * @var CreatorUserSessionService
     */
    private CreatorUserSessionService $creatorUserSession;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @param CreatorUserSessionService $creatorUserSessionService
     * @param Request                   $request
     */
    public function __construct(CreatorUserSessionService $creatorUserSessionService, Request $request)
    {
        $this->creatorUserSession = $creatorUserSessionService;
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EventEnum::USER_AUTHORIZATION->value => 'onUserAuthorization'
        ];
    }

    /**
     * @param UserAuthorizationEvent $event
     *
     * @return void
     */
    public function onUserAuthorization(UserAuthorizationEvent $event): void
    {
        $this->creatorUserSession->createTempSession(
            $event->user,
            $event->authorizationToken,
            $this->request->request->getClientIp()
        );
    }
}