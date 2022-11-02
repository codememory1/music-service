<?php

namespace App\Rest\Controller;

use App\Entity\User;
use App\Rest\Response\HttpResponseCollection;
use App\Security\AuthorizedUser;
use App\Security\Http\BearerToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractRestController extends AbstractController
{
    public function __construct(
        protected readonly AuthorizedUser $authorizedUser,
        protected readonly BearerToken $bearerToken,
        protected readonly HttpResponseCollection $httpResponseCollection
    ) {
    }

    final protected function getAuthorizedUser(): ?User
    {
        return $this->authorizedUser->fromBearer()->getUser();
    }
}