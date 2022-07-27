<?php

namespace App\Rest\Controller;

use App\Entity\User;
use App\Rest\Http\ResponseCollection;
use App\Security\AuthorizedUser;
use App\Security\Http\BearerToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class AbstractRestController.
 *
 * @package App\Rest\Controller
 *
 * @author  Codememory
 */
abstract class AbstractRestController extends AbstractController
{
    protected readonly AuthorizedUser $authorizedUser;
    protected readonly BearerToken $bearerToken;
    protected readonly ResponseCollection $responseCollection;

    public function __construct(AuthorizedUser $authorizedUser, BearerToken $bearerToken, ResponseCollection $responseCollection)
    {
        $this->authorizedUser = $authorizedUser;
        $this->bearerToken = $bearerToken;
        $this->responseCollection = $responseCollection;
    }

    final protected function getManagerAuthorizedUser(): AuthorizedUser
    {
        return clone $this->authorizedUser;
    }

    final protected function getAuthorizedUser(): ?User
    {
        return $this->authorizedUser->getUser();
    }
}