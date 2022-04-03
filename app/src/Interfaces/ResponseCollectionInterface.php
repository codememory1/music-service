<?php

namespace App\Interfaces;

use App\Rest\Http\Response;

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
}