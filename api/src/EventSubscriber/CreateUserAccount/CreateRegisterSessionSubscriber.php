<?php

namespace App\EventSubscriber\CreateUserAccount;

use App\Entity\UserSession;
use App\Enum\EventEnum;
use App\Enum\UserSessionTypeEnum;
use App\Event\CreateUserAccountEvent;
use App\Rest\Http\Request;
use App\Service\UserSession\CreatorUserSessionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateRegisterSessionSubscriber.
 *
 * @package App\EventSubscriber\CreateUserAccount
 *
 * @author  Codememory
 */
class CreateRegisterSessionSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var CreatorUserSessionService
     */
    private CreatorUserSessionService $creatorUserSession;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @param EntityManagerInterface    $entityManager
     * @param CreatorUserSessionService $creatorUserSessionService
     * @param Request                   $request
     */
    public function __construct(EntityManagerInterface $entityManager, CreatorUserSessionService $creatorUserSessionService, Request $request)
    {
        $this->em = $entityManager;
        $this->creatorUserSession = $creatorUserSessionService;
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EventEnum::USER_CREATE_ACCOUNT->value => 'onUserRegistration'
        ];
    }

    /**
     * @param CreateUserAccountEvent $event
     *
     * @return void
     */
    public function onUserRegistration(CreateUserAccountEvent $event): void
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $finedUserSession = $userSessionRepository->findOneBy([
            'user' => $event->user,
            'type' => UserSessionTypeEnum::REGISTRATION_SESSION->value
        ]);

        if (null === $finedUserSession) {
            $this->creatorUserSession->createRegistrationSession(
                $event->user,
                $this->request->request->getClientIp()
            );
        }
    }
}