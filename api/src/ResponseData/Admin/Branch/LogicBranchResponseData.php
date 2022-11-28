<?php

namespace App\ResponseData\Admin\Branch;

use App\Infrastructure\ResponseData\AbstractResponseData;

final class LogicBranchResponseData extends AbstractResponseData
{
    private ?string $name = null;
    private ?string $status = null;
}