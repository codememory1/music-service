<?php

namespace App\ResponseData;

use App\Entity\User;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class MultimediaPerformerResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class MultimediaPerformerResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;

    #[ResponseDataConstraints\Callback('handleUser')]
    public array $user = [];

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    /**
     * @param User $user
     *
     * @return array
     */
    #[ArrayShape(['id' => 'int|null'])]
    #[Pure]
    public function handleUser(User $user): array
    {
        return [
            'id' => $user->getId()
        ];
    }
}