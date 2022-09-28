<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;

class TestResponseData extends AbstractResponseData
{
    private ?int $age = null;
    private ?string $title = null;
}