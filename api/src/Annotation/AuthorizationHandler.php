<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Rest\Http\Exceptions\AuthorizationException;
use App\Security\Auth\AuthorizedUser;

/**
 * Class AuthorizationHandler.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
class AuthorizationHandler implements MethodAnnotationHandlerInterface
{
    /**
     * @var AuthorizedUser
     */
    private AuthorizedUser $authorizedUser;

    /**
     * @param AuthorizedUser $authorizedUser
     */
    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @inheritDoc
     *
     * @param Authorization|MethodAnnotationInterface $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        if (null === $this->authorizedUser->getUser()) {
            throw AuthorizationException::authorizedIsRequired();
        }
    }
}