<?php

namespace App\Controller\Api;

use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseSchema;
use App\Service\Response\ApiResponseService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * @param ManagerRegistry    $managerRegistry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $managerRegistry, ValidatorInterface $validator)
    {

        $this->response = new Response();
        $this->managerRegistry = $managerRegistry;
        $this->validator = $validator;

    }

    /**
     * @param string $entityNamespace
     * @param string $dtoNamespace
     *
     * @return JsonResponse
     */
    protected function showAllFromDatabase(string $entityNamespace, string $dtoNamespace): JsonResponse
    {

        $DTO = new $dtoNamespace(managerRegistry: $this->managerRegistry);
        $entityRepository = $this->managerRegistry->getRepository($entityNamespace);
        $apiResponseSchema = new ApiResponseSchema('success', 200);

        $apiResponseSchema->setData($DTO->transform($entityRepository->findAll()));

        $apiResponseService = new ApiResponseService($apiResponseSchema);

        return $apiResponseService->make();

    }

    /**
     * @param Request $request
     * @param string  $serviceClass
     *
     * @return AbstractApiService
     */
    protected function getCollectedService(Request $request, string $serviceClass): AbstractApiService
    {

        return new $serviceClass($this->response, $this->managerRegistry, $request->getLocale());

    }

}