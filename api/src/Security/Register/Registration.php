<?php

namespace App\Security\Register;

use App\Dto\Transfer\RegistrationDto;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Enum\ResponseTypeEnum;
use App\Event\UserRegistrationEvent;
use App\Rest\Http\Exceptions\ApiResponseException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Registration.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class Registration extends AbstractService
{
    #[Required]
    public ?Registrar $registrar = null;

    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function handle(RegistrationDto $registrationDto): JsonResponse
    {
        $this->validate($registrationDto);

        $userByEmail = $this->em->getRepository(User::class)->findByEmail($registrationDto->email);

        if (null !== $userByEmail && false === $userByEmail->isNotActive()) {
            throw new ApiResponseException(409, ResponseTypeEnum::EXIST, 'user@existByEmail');
        }

        $this->register($registrationDto, $userByEmail);

        return $this->responseCollection->successRegistration();
    }

    public function register(RegistrationDto $registrationDTO, ?User $userByEmail): void
    {
        $registeredUser = $this->registrar->make($registrationDTO, $userByEmail);

        $this->eventDispatcher->dispatch(
            new UserRegistrationEvent($registeredUser),
            EventEnum::REGISTER->value
        );

        $this->flusherService->save();
    }
}