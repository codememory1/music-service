<?php

namespace App\ResponseData\General\User;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class UserAccountActivationResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $email = null;
    private ?string $status = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}