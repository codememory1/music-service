<?php

namespace App\UseCase\Register;

use App\DTO\Open\RegistrationDTO;
use App\Entity\User;
use App\Enum\UserStatus;
use App\Event\SuccessRegisterEvent;
use App\Repository\UserRepository;
use Codememory\ApiBundle\Exceptions\HttpException;
use Codememory\ApiBundle\Validator\Assert\AssertValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Registration
{
    public function __construct(
        private readonly AssertValidator $validator,
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $em,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @throws HttpException
     */
    public function process(RegistrationDTO $dto): User
    {
        $this->validator->validate($dto);

        $user = $this->userRepository->findByEmail($dto->email);

        if (null !== $user && $user->isNotActivated()) {
            $dto->recollectObject($user);
        }

        $dto->getObject()->setStatus(UserStatus::NOT_ACTIVATED);

        $this->em->persist($dto->getObject());
        $this->em->flush();

        $this->eventDispatcher->dispatch(new SuccessRegisterEvent($dto->getObject()));

        return $dto->getObject();
    }
}