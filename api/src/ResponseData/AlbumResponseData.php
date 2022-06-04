<?php

namespace App\ResponseData;

use App\Entity\AlbumType;
use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

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

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_ALBUMS)]
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDatetime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDatetime')]
    public ?string $updatedAt = null;

    /**
     * @param AlbumType $albumType
     *
     * @return array
     */
    public function handleType(AlbumType $albumType): array
    {
        $albumTypeResponseData = new AlbumTypeResponseData($this->container);

        $albumTypeResponseData->setEntities($albumType);

        return $albumTypeResponseData->collect()->getResponse();
    }
}