<?php

namespace App\ResponseData;

use App\Entity\Album;
use App\Entity\MultimediaCategory;
use App\Entity\MultimediaMetadata;
use App\Entity\MultimediaQueue;
use App\Entity\MultimediaRating;
use App\Enum\MultimediaRatingTypeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class MultimediaResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class MultimediaResponseData extends AbstractResponseData implements ResponseDataInterface
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

    #[ResponseDataConstraints\Callback('handleAlbum')]
    public array $album = [];

    #[ResponseDataConstraints\Callback('handleCategory')]
    public array $category = [];

    #[ResponseDataConstraints\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    public array $text = [];

    #[ResponseDataConstraints\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    public ?string $subtitles = null;
    public ?string $producer = null;

    #[ResponseDataConstraints\Callback('handlePerformers')]
    public array $performers = [];
    public bool $isObsceneWords = false;

    #[ResponseDataConstraints\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    #[ResponseDataConstraints\Callback('handleMetadata')]
    public array $metadata = [];

    #[ResponseDataConstraints\Callback('handleQueue')]
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

    public function handleAlbum(Album $album): array
    {
        $albumResponseData = new AlbumResponseData($this->container);

        $albumResponseData->setIgnoreProperty('multimedia');
        $albumResponseData->setEntities($album);

        return $albumResponseData->collect()->getResponse(true);
    }

    public function handleCategory(MultimediaCategory $multimediaCategory): array
    {
        $multimediaCategoryResponseData = new MultimediaCategoryResponseData($this->container);

        $multimediaCategoryResponseData->setEntities($multimediaCategory);

        return $multimediaCategoryResponseData->collect()->getResponse(true);
    }

    public function handlePerformers(Collection $performers): array
    {
        $multimediaPerformerResponseData = new MultimediaPerformerResponseData($this->container);

        $multimediaPerformerResponseData->setEntities($performers->toArray());

        return $multimediaPerformerResponseData->collect()->getResponse();
    }

    public function handleMetadata(?MultimediaMetadata $multimediaMetadata): array
    {
        $multimediaMetadataResponseData = new MultimediaMetadataResponseData($this->container);

        $multimediaMetadataResponseData->setEntities($multimediaMetadata ?: []);

        return $multimediaMetadataResponseData->collect()->getResponse(true);
    }

    public function handleQueue(?MultimediaQueue $multimediaQueue): array
    {
        $multimediaQueueResponseData = new MultimediaQueueResponseData($this->container);

        $multimediaQueueResponseData->setEntities($multimediaQueue ?? []);

        return $multimediaQueueResponseData->collect()->getResponse(true);
    }

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