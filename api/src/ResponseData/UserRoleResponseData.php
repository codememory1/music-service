<?php

namespace App\ResponseData;

use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use App\ResponseData\Traits\ToTranslationHandlerTrait;
use Doctrine\Common\Collections\Collection;

/**
 * Class UserRoleResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class UserRoleResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;

    use ToTranslationHandlerTrait;

    /**
     * @var null|int
     */
    public ?int $id = null;

    /**
     * @var null|string
     */
    public ?string $key = null;

    #[ResponseDataConstraints\Callback('handleToTranslation')]
    public ?string $title = null;

    #[ResponseDataConstraints\Callback('handleToTranslation')]
    public ?string $shortDescription = null;

    #[ResponseDataConstraints\Callback('handlePermissions')]
    public array $permissions = [];

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    /**
     * @param Collection $collection
     *
     * @return array
     */
    public function handlePermissions(Collection $collection): array
    {
        $responseData = new UserRolePermissionResponseData($this->container);

        $responseData->setEntities($collection->toArray());

        return $responseData->collect()->getResponse();
    }
}