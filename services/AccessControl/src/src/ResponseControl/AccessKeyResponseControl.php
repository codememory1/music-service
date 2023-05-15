<?php

namespace App\ResponseControl;

use Codememory\EntityResponseControl\ResponseControl;
use Codememory\EntityResponseControl\Constraints\Value as RCV;

final class AccessKeyResponseControl extends ResponseControl
{
    private ?int $id = null;
    private ?string $key = null;
    private ?string $microservice = null;

    #[RCV\DateTime(full: true)]
    private array $createdAt = [];

    #[RCV\DateTime(full: true)]
    private array $updatedAt = [];
}