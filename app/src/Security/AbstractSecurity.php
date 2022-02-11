<?php

namespace App\Security;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractSecurity
 *
 * @package App\Security
 *
 * @author  Codememory
 */
abstract class AbstractSecurity
{

    /**
     * @var Request
     */
    protected readonly Request $request;

    /**
     * @var ObjectManager
     */
    protected readonly ObjectManager $em;

    /**
     * @param Request         $request
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(Request $request, ManagerRegistry $managerRegistry)
    {

        $this->request = $request;
        $this->em = $managerRegistry->getManager();

    }

}