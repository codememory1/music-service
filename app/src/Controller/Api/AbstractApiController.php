<?php

namespace App\Controller\Api;

use App\Service\Response\ApiResponseSchema;
use App\Service\Response\ApiResponseService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * @param string $entityNamespace
     * @param string $dtoNamespace
     *
     * @return JsonResponse
     */
    protected function showAllFromDatabase(string $entityNamespace, string $dtoNamespace): JsonResponse
    {

        $entityRepository = $this->managerRegistry->getRepository($entityNamespace);
        $dto = new $dtoNamespace($entityRepository->findAll());
        $apiResponseSchema = new ApiResponseSchema('success', 200);

        $apiResponseSchema->setData($dto->transform());

        $apiResponseService = new ApiResponseService($apiResponseSchema);

        return $apiResponseService->make();

    }

}