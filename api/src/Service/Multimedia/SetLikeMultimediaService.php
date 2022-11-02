<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\MultimediaRatingTypeEnum;
use App\Rest\Response\HttpResponseCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

class SetLikeMultimediaService
{
    public function __construct(
        private readonly HttpResponseCollection $responseCollection,
        private readonly SaveMultimediaRatingService $saveMultimediaRating
    ) {
    }

    public function setOrRemoveLike(Multimedia $multimedia, User $from, ?callable $callbackRemove = null): Multimedia
    {
        $this->saveMultimediaRating->make(
            $multimedia,
            $from,
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