<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;

class TestResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $image = null;
    private ?string $status = null;
}