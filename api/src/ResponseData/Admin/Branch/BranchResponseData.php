<?php

namespace App\ResponseData\Admin\Branch;

use App\Infrastructure\ResponseData\AbstractResponseData;

final class BranchResponseData extends AbstractResponseData
{
    private ?string $key = null;
    private array $value = [];
}