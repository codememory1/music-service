<?php

namespace App\ResponseData;

use App\Entity\AlbumType;
use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use Doctrine\Common\Collections\Collection;

/**
 * Class AlbumResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class AlbumResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    public ?int $id = null;

    #[ResponseDataConstraints\Callback('handleType')]
    public ?string $type = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $image = null;

    #[ResponseDataConstraints\Callback('handleMultimedia')]
    public array $multimedia = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_ALBUMS)]
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDatetime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDatetime')]
    public ?string $updatedAt = null;

    public function handleType(AlbumType $albumType): array
    {
        $albumTypeResponseData = new AlbumTypeResponseData($this->container);

        $albumTypeResponseData->setEntities($albumType);

        return $albumTypeResponseData->collect()->getResponse(true);
    }

    public function handleMultimedia(Collection $multimedia): array
    {
        $multimediaResponseData = new MultimediaResponseData($this->container);

        $multimediaResponseData->setIgnoreProperty('album');
        $multimediaResponseData->setEntities($multimedia->toArray());

        return $multimediaResponseData->collect()->getResponse();
    }
}