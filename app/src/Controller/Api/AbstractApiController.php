<?php

namespace App\Controller\Api;

use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseSchema;
use App\Service\Response\ApiResponseService;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
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

    /**
     * @param string             $serviceNamespace
     * @param string             $successTranslationKey
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    protected function executeCreateService(string $serviceNamespace, string $successTranslationKey, Request $request, ValidatorInterface $validator): JsonResponse
    {

        /** @var AbstractApiService $service */
        $service = new $serviceNamespace($request, $this->response, $this->managerRegistry);
        $handler = function (object $entity) use ($service, $successTranslationKey) {
            return $service->push($entity, $successTranslationKey);
        };

        return $service->create($validator, $handler)->make();

    }

    /**
     * @param int                $id
     * @param string             $serviceNamespace
     * @param string             $successTranslationKey
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    protected function executeUpdateService(int $id, string $serviceNamespace, string $successTranslationKey, Request $request, ValidatorInterface $validator): JsonResponse
    {

        /** @var AbstractApiService $service */
        $service = new $serviceNamespace($request, $this->response, $this->managerRegistry);
        $handler = function (object $entity) use ($service, $successTranslationKey) {
            return $service->push($entity, $successTranslationKey, true);
        };

        return $service->update($id, $validator, $handler)->make();

    }

    /**
     * @param int     $id
     * @param string  $serviceNamespace
     * @param string  $successTranslationKey
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    protected function executeDeleteService(int $id, string $serviceNamespace, string $successTranslationKey, Request $request): JsonResponse
    {

        /** @var AbstractApiService $service */
        $service = new $serviceNamespace($request, $this->response, $this->managerRegistry);
        $handler = function (object $entity) use ($service, $successTranslationKey) {
            return $service->remove($entity, $successTranslationKey);
        };

        return $service->delete($id, $handler)->make();

    }

}