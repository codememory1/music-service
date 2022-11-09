<?php

namespace App\Security\AccountActivation;

use App\Dto\Transfer\AccountActivationDto;
use App\Entity\User;
use App\Event\AccountActivationEvent;
use App\Exception\Http\InvalidException;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Repository\AccountActivationCodeRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class AccountActivation
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly AccountActivationCodeRepository $accountActivationCodeRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function activate(AccountActivationDto $dto): User
    {
        $this->validator->validate($dto);

        $finedAccountActivationCode = $this->accountActivationCodeRepository->findByCodeAndUser($dto->user, $dto->code);

        if (null === $finedAccountActivationCode || false === $finedAccountActivationCode->isValidTtlByCreatedAt()) {
            throw InvalidException::invalidCode();
        }

        $dto->user->setActiveStatus();

        $this->flusher->addRemove($finedAccountActivationCode)->save();

        $this->eventDispatcher->dispatch(new AccountActivationEvent($finedAccountActivationCode));

        return $dto->user;
    }
}