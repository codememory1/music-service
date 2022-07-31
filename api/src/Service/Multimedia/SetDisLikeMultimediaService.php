<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\MultimediaRatingTypeEnum;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SetDisLikeMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class SetDisLikeMultimediaService extends AbstractService
{
    #[Required]
    public ?SaveMultimediaRatingService $saveMultimediaRatingService = null;

    public function setOrRemoveDislike(Multimedia $multimedia, User $fromUser, ?callable $callbackRemove = null): Multimedia
    {
        $this->saveMultimediaRatingService->make(
            $multimedia,
            $fromUser,
            MultimediaRatingTypeEnum::DISLIKE,
            MultimediaRatingTypeEnum::LIKE,
            $callbackRemove
        );

        return $multimedia;
    }

    public function request(Multimedia $multimedia, User $fromUser): JsonResponse
    {
        $responseCollection = $this->responseCollection;
        $successResponse = $responseCollection->successCreate('multimedia@successSetDislike');

        $this->setOrRemoveDislike($multimedia, $fromUser, static function() use ($responseCollection, &$successResponse): void {
            $successResponse = $responseCollection->successDelete('multimedia@successDeleteDislike');
        });

        return $successResponse;
    }
}