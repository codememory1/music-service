<?php

namespace App\Security\Register;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Enum\ResponseTypeEnum;
use App\Enum\UserStatusEnum;
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
    /**
     * @var null|Registrar
     */
    private ?Registrar $registrar = null;

    /**
     * @var null|EventDispatcherInterface
     */
    private ?EventDispatcherInterface $eventDispatcher = null;

    /**
     * @param Registrar $registrar
     *
     * @return void
     */
    #[Required]
    public function setRegistrar(Registrar $registrar): void
    {
        $this->registrar = $registrar;
    }

    /**
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return void
     */
    #[Required]
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     *
     * @return JsonResponse
     */
    public function handle(RegistrationDTO $registrationDTO): JsonResponse
    {
        if (false === $this->validate($registrationDTO)) {
            return $this->validator->getResponse();
        }

        $userByEmail = $this->em->getRepository(User::class)->findOneBy([
            'email' => $registrationDTO->email
        ]);

        if (null !== $userByEmail && false === $userByEmail->isStatus(UserStatusEnum::NOT_ACTIVE)) {
            throw new ApiResponseException(409, ResponseTypeEnum::EXIST, 'user@existByEmail');
        }

        $this->register($registrationDTO, $userByEmail);

        return $this->responseCollection->successRegistration();
    }

    /**
     * @param RegistrationDTO $registrationDTO
     * @param null|User       $userByEmail
     *
     * @return void
     */
    public function register(RegistrationDTO $registrationDTO, ?User $userByEmail): void
    {
        $registeredUser = $this->registrar->make($registrationDTO, $userByEmail);

        $this->eventDispatcher->dispatch(
            new UserRegistrationEvent($registeredUser),
            EventEnum::REGISTER->value
        );
    }
}