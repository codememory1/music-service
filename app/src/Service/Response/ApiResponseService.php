<?php

namespace App\Service\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiResponseService
 *
 * @package App\Service\Response
 *
 * @author  Codememory
 */
class ApiResponseService
{

    /**
     * @var ApiResponseSchema
     */
    private ApiResponseSchema $apiResponseSchema;

    /**
     * @param ApiResponseSchema $apiResponseSchema
     */
    public function __construct(ApiResponseSchema $apiResponseSchema)
    {

        $this->apiResponseSchema = $apiResponseSchema;

    }

    /**
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function make(array $headers = []): JsonResponse
    {

        $schema = $this->apiResponseSchema->getSchema();

        $response = new JsonResponse($schema, $schema['status_code'], $headers);

        $response->send();

        return $response;

    }

}