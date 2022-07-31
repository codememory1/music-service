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

    public function setOrRemoveLike(Multimedia $multimedia, User $fromUser, ?callable $callbackRemove = null): Multimedia
    {
        $this->saveMultimediaRatingService->make(
            $multimedia,
            $fromUser,
            MultimediaRatingTypeEnum::LIKE,
            MultimediaRatingTypeEnum::DISLIKE,
            $callbackRemove
        );

        return $multimedia;
    }

    public function request(Multimedia $multimedia, User $fromUser): JsonResponse
    {
        $responseCollection = $this->responseCollection;
        $successResponse = $responseCollection->successCreate('multimedia@successSetLike');

        $this->setOrRemoveLike($multimedia, $fromUser, static function() use ($responseCollection, &$successResponse): void {
            $successResponse = $responseCollection->successDelete('multimedia@successDeleteLike');
        });

        return $successResponse;
    }
}