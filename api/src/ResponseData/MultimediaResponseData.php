<?php

namespace App\ResponseData;

use App\Entity\MultimediaRating;
use App\Enum\MultimediaRatingTypeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\ArrayShape;

final class MultimediaResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    protected array $methodPrefixesForProperties = [
        'isObsceneWords' => ''
    ];
    public ?int $id = null;
    public ?string $type = null;
    public ?string $title = null;

    #[ResponseDataConstraints\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    public ?string $multimedia = null;
    public ?string $description = null;
    public ?string $image = null;

    #[ResponseDataConstraints\CallbackResponseData(AlbumResponseData::class, true, ['multimedia'])]
    public array $album = [];

    #[ResponseDataConstraints\CallbackResponseData(MultimediaCategoryResponseData::class, true)]
    public array $category = [];

    #[ResponseDataConstraints\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    public array $text = [];

    #[ResponseDataConstraints\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    public ?string $subtitles = null;
    public ?string $producer = null;

    #[ResponseDataConstraints\CallbackResponseData(MultimediaPerformerResponseData::class)]
    public array $performers = [];
    public bool $isObsceneWords = false;

    #[ResponseDataConstraints\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    #[ResponseDataConstraints\CallbackResponseData(MultimediaMetadataResponseData::class, true)]
    public array $metadata = [];

    #[ResponseDataConstraints\CallbackResponseData(MultimediaQueueResponseData::class, true)]
    public array $queue = [];

    #[ResponseDataConstraints\Callback('handleShares')]
    public int $shares = 0;

    #[ResponseDataConstraints\Callback('handleAuditions')]
    public int $auditions = 0;

    #[ResponseDataConstraints\Callback('handleRatings')]
    public int $ratings = 0;
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    public function handleShares(Collection $shares): int
    {
        return $shares->count();
    }

    public function handleAuditions(Collection $auditions): int
    {
        return $auditions->count();
    }

    #[ArrayShape(['like' => 'int', 'dislike' => 'int'])]
    public function handleRatings(Collection $ratings): array
    {
        return [
            'like' => $ratings->filter(static fn(MultimediaRating $multimediaRating) => $multimediaRating->getType() === MultimediaRatingTypeEnum::LIKE->name)->count(),
            'dislike' => $ratings->filter(static fn(MultimediaRating $multimediaRating) => $multimediaRating->getType() === MultimediaRatingTypeEnum::DISLIKE->name)->count()
        ];
    }
}