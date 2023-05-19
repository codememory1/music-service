<?php

namespace App\UseCase\Auth;

use App\Adapter\JWT\AccessTokenJWT;
use App\Adapter\JWT\RefreshTokenJWT;
use App\DTO\Open\AuthorizationDTO;
use App\Entity\User;
use App\Event\SuccessAuthEvent;
use App\Exceptions\BadException;
use App\ValueObject\TokenPair;
use Codememory\ApiBundle\Exceptions\HttpException;
use Codememory\ApiBundle\Validator\Assert\AssertValidator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Authorization
{
    public function __construct(
        private readonly AssertValidator $validator,
        private readonly Identification $identification,
        private readonly Authentication $authentication,
        private readonly AccessTokenJWT $accessTokenJWT,
        private readonly RefreshTokenJWT $refreshTokenJWT,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @throws HttpException
     * @throws BadException
     */
    public function process(AuthorizationDTO $dto): TokenPair
    {
        $this->validator->validate($dto);

        $identifiedUser = $this->identification->process($dto->email);

        $this->authentication->process($identifiedUser, $dto->password);

        $this->eventDispatcher->dispatch(new SuccessAuthEvent($identifiedUser));

        return new TokenPair(
            $this->accessTokenJWT->encode($this->buildTokenData($identifiedUser)),
            $this->refreshTokenJWT->encode($this->buildTokenData($identifiedUser))
        );
    }

    private function buildTokenData(User $user): array
    {
        return [
            'user' => [
                'id' => $user->getId()
            ]
        ];
    }
}