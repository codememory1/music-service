<?php

namespace App\Rest;

use App\Rest\Http\ResponseCollection;
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
     * @param EntityManagerInterface $managerRegistry
     * @param ResponseCollection     $responseCollection
     */
    public function __construct(EntityManagerInterface $managerRegistry, ResponseCollection $responseCollection)
    {

        $this->em = $managerRegistry;
        $this->responseCollection = $responseCollection;
    }

    /**
     * @param string $entityNamespace
     * @param string $DTONamespace
     *
     * @return JsonResponse
     */
    protected function showAllFromDatabase(string $entityNamespace, string $DTONamespace): JsonResponse
    {

        $DTO = new $DTONamespace(em: $this->em);

        $entityRepository = $this->em->getRepository($entityNamespace);
        $data = $DTO->transform($entityRepository->findAll());

        return $this->responseCollection->dataOutput($data)->sendResponse();
    }

}