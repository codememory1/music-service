<?php

namespace App\EventSubscriber\UserRegistration;

use App\Entity\User;
use App\Entity\UserActivationToken;
use App\Enums\EventsEnum;
use App\Event\UserRegistrationEvent;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateAccountActivationTokenSubscriber
 *
 * @package App\EventSubscriber\UserRegistration
 *
 * @author  Codememory
 */
class CreateAccountActivationTokenSubscriber implements EventSubscriberInterface
{

    /**
     * @var ObjectManager
     */
    private ObjectManager $em;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {

        $this->em = $managerRegistry->getManager();

    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {

        return [
            EventsEnum::USER_REGISTRATION->value => 'onUserRegistration'
        ];

    }

    /**
     * @param UserRegistrationEvent $event
     *
     * @return void
     */
    public function onUserRegistration(UserRegistrationEvent $event): void
    {

        $userActivationTokenEntity = new UserActivationToken();

        $userActivationTokenEntity
            ->setUser($event->getUser())
            ->setValid($_ENV['ACCOUNT_ACTIVATION_TOKEN_TTL'])
            ->setToken($this->generateActivationToken($event->getUser()));

        $this->em->persist($userActivationTokenEntity);
        $this->em->flush();

    }

    /**
     * @param User $userEntity
     *
     * @return string
     */
    private function generateActivationToken(User $userEntity): string
    {

        $payload = [
            'user_id' => $userEntity->getId(),
            'email'   => $userEntity->getEmail(),
            'random'  => Uuid::uuid4()->toString()
        ];

        return base64_encode(implode('.', $payload));

    }

}