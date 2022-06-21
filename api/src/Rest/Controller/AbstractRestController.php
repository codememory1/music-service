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
    /**
     * @var AuthorizedUser
     */
    protected readonly AuthorizedUser $authorizedUser;

    /**
     * @var BearerToken
     */
    protected readonly BearerToken $bearerToken;

    /**
     * @var ResponseCollection
     */
    protected readonly ResponseCollection $responseCollection;

    /**
     * @param AuthorizedUser     $authorizedUser
     * @param BearerToken        $bearerToken
     * @param ResponseCollection $responseCollection
     */
    public function __construct(AuthorizedUser $authorizedUser, BearerToken $bearerToken, ResponseCollection $responseCollection)
    {
        $this->authorizedUser = $authorizedUser;
        $this->bearerToken = $bearerToken;
        $this->responseCollection = $responseCollection;
    }
}