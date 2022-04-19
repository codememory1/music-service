<?php

namespace App\Rest;

use App\Entity\User;
use App\Rest\Http\ResponseCollection;
use App\Security\Authenticator\DefineUserForTask;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiController.
 *
 * @package App\Controller\Rest
 *
 * @author  Codememory
 */
class ApiController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * @var ResponseCollection
     */
    protected ResponseCollection $responseCollection;

    /**
     * @var DefineUserForTask
     */
    protected DefineUserForTask $defineUserForTask;

    /**
     * @param EntityManagerInterface $managerRegistry
     * @param ResponseCollection     $responseCollection
     * @param DefineUserForTask      $defineUserForTask
     */
    public function __construct(
        EntityManagerInterface $managerRegistry,
        ResponseCollection $responseCollection,
        DefineUserForTask $defineUserForTask
    ) {
        $this->em = $managerRegistry;
        $this->responseCollection = $responseCollection;
        $this->defineUserForTask = $defineUserForTask;
    }

    /**
     * @param string $entityNamespace
     * @param string $DTONamespace
     * @param array  $excludeKeys
     *
     * @return JsonResponse
     */
    protected function findAllResponse(string $entityNamespace, string $DTONamespace, array $excludeKeys = []): JsonResponse
    {
        $DTO = new $DTONamespace(em: $this->em);
        $entityRepository = $this->em->getRepository($entityNamespace);

        return $this->responseCollection
            ->dataOutput($DTO->transform($entityRepository->findAll(), $excludeKeys))
            ->sendResponse();
    }

    /**
     * @param null|int $userid
     *
     * @return null|User
     */
    protected function definedUser(?int $userid = null): ?User
    {
        return $this->defineUserForTask->setUserid($userid)->getDefinedUser();
    }
}