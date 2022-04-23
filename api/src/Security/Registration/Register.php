<?php

namespace App\Security\Registration;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Event\UserRegistrationEvent;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Service\HashingService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Register.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class Register extends AbstractSecurity
{
    /**
     * @var null|CreatorAccount
     */
    private ?CreatorAccount $creatorUserAccount = null;

    /**
     * @var null|HashingService
     */
    private ?HashingService $hashingService = null;

    /**
     * @param CreatorAccount $creatorAccount
     *
     * @return $this
     */
    #[Required]
    public function setCreatorUserAccount(CreatorAccount $creatorAccount): self
    {
        $this->creatorUserAccount = $creatorAccount;

        return $this;
    }

    /**
     * @param HashingService $hashingService
     *
     * @return $this
     */
    #[Required]
    public function setHashingService(HashingService $hashingService): self
    {
        $this->hashingService = $hashingService;

        return $this;
    }

    /**
     * @param RegistrationDTO          $registrationDTO
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return Response|User
     */
    public function register(RegistrationDTO $registrationDTO, EventDispatcherInterface $eventDispatcher): Response|User
    {
        $userEntity = $registrationDTO->getCollectedEntity();

        // Re-registration if the user already exists but is not activated
        if (false !== $registeredUser = $this->isReRegistration($registrationDTO)) {
            $registeredUser->setPassword($this->hashingService->encode(
                $registrationDTO->password
            ));

            $userEntity = $registeredUser;
        }

        return $this->createUserAccount($userEntity, $eventDispatcher);
    }

    /**
     * @param RegistrationDTO $registrationDTO
     *
     * @return bool|User
     */
    public function isReRegistration(RegistrationDTO $registrationDTO): bool|User
    {
        $userRepository = $this->em->getRepository(User::class);

        return $userRepository->findNotActiveByEmail($registrationDTO->email) ?? false;
    }

    /**
     * @return Response
     */
    public function successRegisterResponse(): Response
    {
        return $this->responseCollection->successRegister()->getResponse();
    }

    /**
     * @param User                     $userEntity
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return Response|User
     */
    private function createUserAccount(User $userEntity, EventDispatcherInterface $eventDispatcher): Response|User
    {
        $createdUserAccount = $this->creatorUserAccount->create($userEntity, $eventDispatcher);

        if ($createdUserAccount instanceof Response) {
            return $createdUserAccount;
        }

        $eventDispatcher->dispatch(
            new UserRegistrationEvent($createdUserAccount),
            EventEnum::USER_REGISTRATION->value
        );

        return $createdUserAccount;
    }
}