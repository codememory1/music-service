<?php

namespace App\Security\ConfirmationRegistration;

use App\Entity\UserActivationToken;
use App\Enum\EventEnum;
use App\Enum\UserStatusEnum;
use App\Event\UserActivationAccountEvent;
use App\Repository\UserActivationTokenRepository;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Service\JwtTokenGenerator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

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
     * @var null|UserActivationTokenRepository
     */
    private ?UserActivationTokenRepository $userActivationTokenRepository = null;

    /**
     * @var null|JwtTokenGenerator
     */
    private ?JwtTokenGenerator $jwtTokenGenerator = null;

    /**
     * @param JwtTokenGenerator $jwtTokenGenerator
     *
     * @return $this
     */
    #[Required]
    public function setJwtTokenGenerator(JwtTokenGenerator $jwtTokenGenerator): self
    {
        $this->jwtTokenGenerator = $jwtTokenGenerator;

        return $this;
    }

    /**
     * @param UserActivationTokenRepository $userActivationTokenRepository
     *
     * @return $this
     */
    #[Required]
    public function setUserActivationTokenRepository(UserActivationTokenRepository $userActivationTokenRepository): self
    {
        $this->userActivationTokenRepository = $userActivationTokenRepository;

        return $this;
    }

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $token
     *
     * @return Response|UserActivationToken
     */
    public function handle(EventDispatcherInterface $eventDispatcher, string $token): Response|UserActivationToken
    {
        // Checking for the existence of a token
        if (false === $finedUserActivationToken = $this->existToken($token)) {
            return $this->responseCollection
                ->notExist('userActivationAccount@tokenNotExist')
                ->getResponse();
        }

        // Token Validity Check
        if (false === $this->isValid($token)) {
            return $this->responseCollection
                ->notValid('userActivationAccount@tokenIsNotValid')
                ->getResponse();
        }

        // User activation...
        return $this->activate($finedUserActivationToken, $eventDispatcher);
    }

    /**
     * @param UserActivationToken      $userActivationToken
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return UserActivationToken
     */
    public function activate(UserActivationToken $userActivationToken, EventDispatcherInterface $eventDispatcher): UserActivationToken
    {
        $userActivationToken->getUser()->setStatus(UserStatusEnum::ACTIVE);

        $this->em->flush();

        $eventDispatcher->dispatch(
            new UserActivationAccountEvent($userActivationToken),
            EventEnum::USER_ACTIVATION_ACCOUNT->value
        );
        
        return $userActivationToken;
    }

    /**
     * @param string $token
     *
     * @return UserActivationToken|bool
     */
    public function existToken(string $token): UserActivationToken|bool
    {
        return $this->userActivationTokenRepository->findOneBy(['token' => $token]) ?? false;
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