<?php

namespace App\EventSubscriber\PasswordRecoveryRequest;

use App\Entity\User;
use App\Enum\EventEnum;
use App\Event\PasswordRecoveryRequestEvent;
use App\Service\JwtTokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateTokenSubscriber.
 *
 * @package App\EventSubscriber\PasswordReset
 *
 * @author  Codememory
 */
class CreateTokenSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

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
            EventEnum::PASSWORD_RECOVERY_REQUEST->value => 'onRecoveryRequest'
        ];
    }

    /**
     * @param PasswordRecoveryRequestEvent $event
     *
     * @return void
     */
    public function onRecoveryRequest(PasswordRecoveryRequestEvent $event): void
    {
        $token = $this->generateToken($event->user);

        $event->passwordReset->setToken($token);

        $this->em->persist($event->passwordReset);
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
        ], 'JWT_PASSWORD_RESET_PRIVATE_KEY', 'JWT_PASSWORD_RESET_TTL');
    }
}