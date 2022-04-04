<?php

namespace App\EventSubscriber\UserRegistration;

use App\Entity\User;
use App\Entity\UserActivationToken;
use App\Enum\EventsEnum;
use App\Event\UserRegistrationEvent;
use App\Repository\UserActivationTokenRepository;
use App\Service\JwtTokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateActivationTokenSubscriber.
 *
 * @package App\EventSubscriber\UserRegistration
 *
 * @author  Codememory
 */
class CreateActivationTokenSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
        /** @var UserActivationTokenRepository $userActivationTokenRepository */
        $userActivationTokenRepository = $this->em->getRepository(UserActivationToken::class);
        $finedToken = $userActivationTokenRepository->findOneBy(['user' => $event->getUser()]);

        if (null !== $finedToken) {
            $finedToken->setToken($this->generateToken($event->getUser()));
        } else {
            $userActivationToken = new UserActivationToken();

            $generatedToken = $this->generateToken($event->getUser());

            $userActivationToken
                ->setUser($event->getUser())
                ->setToken($generatedToken);

            $this->em->persist($userActivationToken);
        }

        $this->em->flush();
    }

    /**
     * @param User $user
     *
     * @return string
     */
    private function generateToken(User $user): string
    {
        $jwtTokenGenerator = new JwtTokenGenerator();

        return $jwtTokenGenerator->encode([
            'id' => $user->getId(),
            'email' => $user->getEmail()
        ], 'JWT_ACCOUNT_ACTIVATION_PRIVATE_KEY', 'JWT_ACCOUNT_ACTIVATION_TTL');
    }
}