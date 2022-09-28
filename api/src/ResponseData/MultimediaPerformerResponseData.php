<?php

namespace App\ResponseData;

use App\Entity\User;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

final class MultimediaPerformerResponseData extends AbstractResponseData
{
    #[RDCV\Callback('handleUser')]
    private array $user = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;

    #[ArrayShape(['id' => 'int|null'])]
    #[Pure]
    public function handleUser(User $user): array
    {
        return ['id' => $user->getId()];
    }
}