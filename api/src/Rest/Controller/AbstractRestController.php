<?php

namespace App\Rest\Controller;

use App\Entity\User;
use App\Rest\Response\HttpResponseCollection;
use App\Security\AuthorizedUser;
use App\Security\Http\BearerToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractRestController extends AbstractController
{
    protected readonly AuthorizedUser $authorizedUser;
    protected readonly BearerToken $bearerToken;
    protected readonly HttpResponseCollection $responseCollection;

    public function __construct(AuthorizedUser $authorizedUser, BearerToken $bearerToken, HttpResponseCollection $httpResponseCollection)
    {
        $this->authorizedUser = $authorizedUser;
        $this->bearerToken = $bearerToken;
        $this->responseCollection = $httpResponseCollection;
    }

    final protected function getAuthorizedUser(): ?User
    {
        return $this->authorizedUser->getUser();
    }
}