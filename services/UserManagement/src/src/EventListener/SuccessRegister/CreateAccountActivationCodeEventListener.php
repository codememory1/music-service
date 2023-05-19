<?php

namespace App\EventListener\SuccessRegister;

use App\Entity\AccountActivationCode;
use App\Event\SuccessRegisterEvent;
use App\Repository\AccountActivationCodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(SuccessRegisterEvent::class, 'onSuccessRegister')]
final class CreateAccountActivationCodeEventListener
{
    public function __construct(
        private readonly AccountActivationCodeRepository $accountActivationCodeRepository,
        private readonly EntityManagerInterface $em
    ) {
    }

    public function onSuccessRegister(SuccessRegisterEvent $event): void
    {
        $accountActivationCode = new AccountActivationCode();

        $accountActivationCode->setUser($event->user);
        $accountActivationCode->setCode();

        $this->generateUniqueCode($accountActivationCode);

        $this->em->persist($accountActivationCode);
        $this->em->flush();
    }

    private function generateUniqueCode(AccountActivationCode $accountActivationCode): void
    {
        $finedAccountActivationCode = $this->accountActivationCodeRepository->findByUserAndCode(
            $accountActivationCode->getUser(),
            $accountActivationCode->getCode()
        );

        while (null !== $finedAccountActivationCode) {
            $accountActivationCode->setCode();
        }
    }
}