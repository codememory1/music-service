<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\MultimediaRatingTypeEnum;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SetLikeMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class SetLikeMultimediaService extends AbstractService
{
    #[Required]
    public ?SaveMultimediaRatingService $saveMultimediaRatingService = null;

    /**
     * @param Multimedia $multimedia
     * @param User       $fromUser
     *
     * @return JsonResponse
     */
    public function make(Multimedia $multimedia, User $fromUser): JsonResponse
    {
        $responseCollection = $this->responseCollection;
        $successResponse = $responseCollection->successCreate('multimedia@successSetLike');

        $this->saveMultimediaRatingService->make(
            $multimedia,
            $fromUser,
            MultimediaRatingTypeEnum::LIKE,
            MultimediaRatingTypeEnum::DISLIKE,
            static function() use (&$successResponse, $responseCollection): void {
                $successResponse = $responseCollection->successDelete('multimedia@successDeleteLike');
            }
        );

        return $successResponse;
    }
}