<?php

namespace App\Security\Registration;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Enum\StatusEnum;
use App\Repository\UserRepository;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseCollection;
use App\Security\AbstractSecurity;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Registration.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class Registration extends AbstractSecurity
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param EntityManagerInterface $em
     * @param ResponseCollection     $responseCollection
     */
    public function __construct(EntityManagerInterface $em, ResponseCollection $responseCollection)
    {
        parent::__construct($em, $responseCollection);

        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     *
     * @return bool|User
     */
    public function isReRegistration(RegistrationDTO $registrationDTO): User|bool
    {
        $finedUser = $this->userRepository->findOneBy([
            'email' => $registrationDTO->email,
            'status' => StatusEnum::NOT_ACTIVE->value
        ]);

        return null === $finedUser ? false : $finedUser;
    }

    /**
     * @return Response
     */
    public function successRegisterResponse(): Response
    {
        return $this->responseCollection->successRegister()->getResponse();
    }
}