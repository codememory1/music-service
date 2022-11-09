<?php

namespace App\ResponseData\General\Multimedia;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaRating;
use App\Enum\MultimediaRatingTypeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\Album\AlbumResponseData;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\ArrayShape;

final class MultimediaResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $type = null;
    private ?string $title = null;

    #[RDCA\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    private ?string $multimedia = null;
    private ?string $description = null;
    private ?string $image = null;

    #[RDCV\CallbackResponseData(AlbumResponseData::class, ['multimedia'])]
    private array $album = [];

    #[RDCV\CallbackResponseData(MultimediaCategoryResponseData::class)]
    private array $category = [];

    #[RDCA\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    private array $text = [];

    #[RDCV\CallbackResponseData(MultimediaTimeCodeResponseData::class)]
    private array $timeCodes = [];

    #[RDCA\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    private ?string $subtitles = null;
    private ?string $producer = null;

    #[RDCV\CallbackResponseData(MultimediaPerformerResponseData::class)]
    private array $performers = [];

    #[RDCS\Prefix('is', 'is')]
    private bool $obsceneWords = false;

    #[RDCA\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    #[RDCV\CallbackResponseData(MultimediaMetadataResponseData::class)]
    private array $metadata = [];

    #[RDCV\CallbackResponseData(MultimediaQueueResponseData::class)]
    private array $queue = [];

    #[RDCV\AsCount]
    private int $shares = 0;

    #[RDCV\AsCount]
    private int $auditions = 0;

    #[RDCV\Callback('handleRatings')]
    private int $ratings = 0;
    private ?string $status = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;

    #[ArrayShape(['like' => 'int', 'dislike' => 'int'])]
    public function handleRatings(EntityInterface $entity, Collection $ratings): array
    {
        return [
            'like' => $ratings->filter(static fn(MultimediaRating $multimediaRating) => $multimediaRating->getType() === MultimediaRatingTypeEnum::LIKE->name)->count(),
            'dislike' => $ratings->filter(static fn(MultimediaRating $multimediaRating) => $multimediaRating->getType() === MultimediaRatingTypeEnum::DISLIKE->name)->count()
        ];
    }
}