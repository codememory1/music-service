<?php

namespace App\Rest\Controller;

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
}