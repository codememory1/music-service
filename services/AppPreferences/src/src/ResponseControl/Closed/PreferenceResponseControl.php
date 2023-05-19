<?php

namespace App\ResponseControl\Closed;

use Codememory\EntityResponseControl\ResponseControl;
use Codememory\EntityResponseControl\Constraints\Value as RCV;

final class PreferenceResponseControl extends ResponseControl
{
    private ?string $key = null;
    private mixed $value = null;

    #[RCV\DateTime(full: true)]
    private array $createdAt = [];

    #[RCV\DateTime(full: true)]
    private array $updatedAt = [];
}