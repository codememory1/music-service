<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Exception\Http\AuthorizationException;
use App\Security\AuthorizedUser;

final class AuthorizationHandler implements MethodAnnotationHandlerInterface
{
    public function __construct(
        private readonly AuthorizedUser $authorizedUser
    ) {
    }

    /**
     * @param Authorization|MethodAnnotationInterface $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        $this->authorizedUser->fromBearer();

        if ($annotation->required && null === $this->authorizedUser->getUser()) {
            throw AuthorizationException::authorizedIsRequired();
        }

        if (false === $annotation->required && null !== $this->authorizedUser->getUser()) {
            throw AuthorizationException::authorizedIsNotRequired();
        }
    }
}