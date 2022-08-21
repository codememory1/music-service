<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Exception\Http\AuthorizationException;
use App\Security\AuthorizedUser;

final class AuthorizationHandler implements MethodAnnotationHandlerInterface
{
    private AuthorizedUser $authorizedUser;

    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
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