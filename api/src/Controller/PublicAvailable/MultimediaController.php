<?php

namespace App\Controller\PublicAvailable;

use App\DTO\MultimediaDTO;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class MultimediaController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
class MultimediaController extends AbstractRestController
{
    public function add(MultimediaDTO $multimediaDTO): JsonResponse
    {
    }
}