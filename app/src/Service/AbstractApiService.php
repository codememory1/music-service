<?php

namespace App\Service;

use App\Service\Response\ApiResponseSchema;
use App\Service\Response\ApiResponseService;
use App\Service\Translator\TranslationService;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class AbstractApiService
 *
 * @package App\Service
 *
 * @author  Codememory
 */
abstract class AbstractApiService
{

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var ManagerRegistry
     */
    protected ManagerRegistry $managerRegistry;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $em;

    /**
     * @var TranslationService
     */
    protected TranslationService $translationService;

    /**
     * @var ApiResponseSchema|null
     */
    private ?ApiResponseSchema $preparedApiResponse = null;

    /**
     * @param Request         $request
     * @param Response        $response
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(Request $request, Response $response, ManagerRegistry $managerRegistry)
    {

        $this->request = $request;
        $this->response = $response;
        $this->managerRegistry = $managerRegistry;
        $this->em = $this->managerRegistry->getManager();
        $this->translationService = new TranslationService($request, $managerRegistry);

    }

    /**
     * @param string $status
     * @param int    $code
     *
     * @return ApiResponseSchema
     */
    protected function prepareApiResponse(string $status, int $code): ApiResponseSchema
    {

        $apiResponseSchema = new ApiResponseSchema($status, $code);

        $this->preparedApiResponse = $apiResponseSchema;

        return $apiResponseSchema;

    }

    /**
     * @param string $key
     *
     * @return string|null
     * @throws Exception
     */
    protected function getTranslation(string $key): ?string
    {

        return $this->translationService->getActiveLanguageTranslation($key)?->getTranslation();

    }

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     *
     * @return array
     */
    #[ArrayShape([
        'name'    => "string",
        'message' => "string"
    ])]
    protected function getValidateInfo(ConstraintViolationListInterface $constraintViolationList): array
    {

        /** @var ConstraintViolation $constraint */
        $constraint = $constraintViolationList->get(0);

        return [
            'name'    => $constraint->getConstraint()->payload,
            'message' => $constraint->getMessage()
        ];

    }

    /**
     * @return ApiResponseService
     */
    #[Pure]
    public function getPreparedApiResponse(): ApiResponseService
    {

        return new ApiResponseService($this->preparedApiResponse);

    }

}