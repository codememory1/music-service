<?php

namespace App\Security;

use App\Rest\Http\ResponseCollection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AbstractSecurity.
 *
 * @package App\Security
 *
 * @author  Codememory
 */
class AbstractSecurity
{
    /**
     * @var EntityManagerInterface
     */
    protected readonly EntityManagerInterface $em;

    /**
     * @var ResponseCollection
     */
    protected readonly ResponseCollection $responseCollection;

    /**
     * @param EntityManagerInterface $em
     * @param ResponseCollection     $responseCollection
     */
    public function __construct(EntityManagerInterface $em, ResponseCollection $responseCollection)
    {
        $this->em = $em;
        $this->responseCollection = $responseCollection;
    }
}