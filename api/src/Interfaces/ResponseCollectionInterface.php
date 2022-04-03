<?php

namespace App\Interfaces;

use App\Rest\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface ResponseCollectionInterface.
 *
 * @package  App\Interfaces
 *
 * @author   Codememory
 */
interface ResponseCollectionInterface
{
    /**
     * @param null|string $status
     * @param null|int    $code
     *
     * @return Response
     */
    public function getResponse(?string $status = null, ?int $code = null): Response;

    /**
     * @param string|null $status
     * @param int|null    $code
     * @param array       $headers
     *
     * @return JsonResponse
     */
    public function sendResponse(?string $status = null, ?int $code = null, array $headers = []): JsonResponse;
}