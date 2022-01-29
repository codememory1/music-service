<?php

namespace App\Controller\Api;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractApiController
 *
 * @package App\Controller\Api
 *
 * @author  Codememory
 */
abstract class AbstractApiController extends AbstractController
{

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var ManagerRegistry
     */
    protected ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {

        $this->response = new Response();
        $this->managerRegistry = $managerRegistry;

    }

}