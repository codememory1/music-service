<?php

namespace App\Rest\Controller;

use App\Security\Auth\AuthorizedUser;
use App\Security\Http\BearerToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class AbstractRestController
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
     * @param AuthorizedUser $authorizedUser
     * @param BearerToken    $bearerToken
     */
    public function __construct(AuthorizedUser $authorizedUser, BearerToken $bearerToken)
    {
        $this->authorizedUser = $authorizedUser;
        $this->bearerToken = $bearerToken;
    }
}