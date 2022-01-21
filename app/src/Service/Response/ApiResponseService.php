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
     * @return void
     */
    public function make(array $headers = []): void
    {

        $schema = $this->apiResponseSchema->getSchema();

        (new JsonResponse($schema, $schema['status_code'], $headers))->send();

    }

}