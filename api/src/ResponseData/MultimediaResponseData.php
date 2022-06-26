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

    /**
     * @inheritDoc
     */
    protected array $methodPrefixesForProperties = [
        'isObsceneWords' => ''
    ];

    /**
     * @var null|int
     */
    public ?int $id = null;

    /**
     * @var null|string
     */
    public ?string $type = null;

    /**
     * @var null|string
     */
    public ?string $title = null;

    #[ResponseDataConstraints\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    public ?string $multimedia = null;

    /**
     * @var null|string
     */
    public ?string $description = null;

    /**
     * @var null|string
     */
    public ?string $image = null;

    #[ResponseDataConstraints\Callback('handleAlbum')]
    public array $album = [];

    #[ResponseDataConstraints\Callback('handleCategory')]
    public array $category = [];

    #[ResponseDataConstraints\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    public array $text = [];

    #[ResponseDataConstraints\SubscriptionPermission(SubscriptionPermissionEnum::LISTENING_TO_MULTIMEDIA)]
    public ?string $subtitles = null;

    /**
     * @var null|string
     */
    public ?string $producer = null;

    #[ResponseDataConstraints\Callback('handlePerformers')]
    public array $performers = [];

    /**
     * @var bool
     */
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

    /**
     * @var null|string
     */
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    /**
     * @param Album $album
     *
     * @return array
     */
    public function handleAlbum(Album $album): array
    {
        $albumResponseData = new AlbumResponseData($this->container);

        $albumResponseData->setIgnoreProperty('multimedia');
        $albumResponseData->setEntities($album);

        return $albumResponseData->collect()->getResponse(true);
    }

    /**
     * @param MultimediaCategory $multimediaCategory
     *
     * @return array
     */
    public function handleCategory(MultimediaCategory $multimediaCategory): array
    {
        $multimediaCategoryResponseData = new MultimediaCategoryResponseData($this->container);

        $multimediaCategoryResponseData->setEntities($multimediaCategory);

        return $multimediaCategoryResponseData->collect()->getResponse(true);
    }

    /**
     * @param Collection $performers
     *
     * @return array
     */
    public function handlePerformers(Collection $performers): array
    {
        $multimediaPerformerResponseData = new MultimediaPerformerResponseData($this->container);

        $multimediaPerformerResponseData->setEntities($performers->toArray());

        return $multimediaPerformerResponseData->collect()->getResponse();
    }

    /**
     * @param null|MultimediaMetadata $multimediaMetadata
     *
     * @return array
     */
    public function handleMetadata(?MultimediaMetadata $multimediaMetadata): array
    {
        $multimediaMetadataResponseData = new MultimediaMetadataResponseData($this->container);

        $multimediaMetadataResponseData->setEntities($multimediaMetadata);

        return $multimediaMetadataResponseData->collect()->getResponse(true);
    }

    /**
     * @param null|MultimediaQueue $multimediaQueue
     *
     * @return array
     */
    public function handleQueue(?MultimediaQueue $multimediaQueue): array
    {
        $multimediaQueueResponseData = new MultimediaQueueResponseData($this->container);

        $multimediaQueueResponseData->setEntities($multimediaQueue ?? []);

        return $multimediaQueueResponseData->collect()->getResponse(true);
    }

    /**
     * @param Collection $shares
     *
     * @return int
     */
    public function handleShares(Collection $shares): int
    {
        return $shares->count();
    }

    /**
     * @param Collection $auditions
     *
     * @return int
     */
    public function handleAuditions(Collection $auditions): int
    {
        return $auditions->count();
    }

    /**
     * @param Collection $ratings
     *
     * @return array
     */
    #[ArrayShape(['like' => 'int', 'dislike' => 'int'])]
    public function handleRatings(Collection $ratings): array
    {
        return [
            'like' => $ratings->filter(static fn(MultimediaRating $multimediaRating) => $multimediaRating->getType() === MultimediaRatingTypeEnum::LIKE->name)->count(),
            'dislike' => $ratings->filter(static fn(MultimediaRating $multimediaRating) => $multimediaRating->getType() === MultimediaRatingTypeEnum::DISLIKE->name)->count()
        ];
    }
}