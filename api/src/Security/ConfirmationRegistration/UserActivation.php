<?php

namespace App\Security\ConfirmationRegistration;

use App\Entity\UserActivationToken;
use App\Enum\StatusEnum;
use App\Repository\UserActivationTokenRepository;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseCollection;
use App\Security\AbstractSecurity;
use App\Service\JwtTokenGenerator;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserActivation.
 *
 * @package App\Security\ConfirmationRegistration
 *
 * @author  Codememory
 */
class UserActivation extends AbstractSecurity
{
    /**
     * @var UserActivationTokenRepository
     */
    private UserActivationTokenRepository $userActivationTokenRepository;

    /**
     * @var JwtTokenGenerator
     */
    private JwtTokenGenerator $jwtTokenGenerator;

    /**
     * @param EntityManagerInterface $em
     * @param ResponseCollection     $responseCollection
     * @param JwtTokenGenerator      $jwtTokenGenerator
     */
    public function __construct(
        EntityManagerInterface $em,
        ResponseCollection $responseCollection,
        JwtTokenGenerator $jwtTokenGenerator
    ) {
        parent::__construct($em, $responseCollection);

        /** @var UserActivationTokenRepository $userActivationTokenRepository */
        $userActivationTokenRepository = $this->em->getRepository(UserActivationToken::class);

        $this->userActivationTokenRepository = $userActivationTokenRepository;
        $this->jwtTokenGenerator = $jwtTokenGenerator;
    }

    /**
     * @param string $token
     *
     * @return UserActivationToken
     */
    public function activate(string $token): UserActivationToken
    {
        /** @var UserActivationToken $finedUserActivationToken */
        $finedUserActivationToken = $this->userActivationTokenRepository->findOneBy(['token' => $token]);
        $user = $finedUserActivationToken->getUser();

        $user->setStatus(StatusEnum::ACTIVE->value);

        $this->em->flush();

        return $finedUserActivationToken;
    }

    /**
     * @param string $token
     *
     * @return bool
     */
    public function existToken(string $token): bool
    {
        return null !== $this->userActivationTokenRepository->findOneBy(['token' => $token]);
    }

    /**
     * @param string $token
     *
     * @return bool|Response
     */
    public function isValid(string $token): Response|bool
    {
        $decodedToken = $this->jwtTokenGenerator->decode($token, 'JWT_ACCOUNT_ACTIVATION_PUBLIC_KEY');

        if (!$decodedToken) {
            return $this->responseCollection->notValid('userActivationAccount@tokenIsNotValid')->getResponse();
        }

        return true;
    }

    /**
     * @return Response
     */
    public function successActivationResponse(): Response
    {
        return $this->responseCollection
            ->successActivation('userActivationAccount@successActivation')
            ->getResponse();
    }
}