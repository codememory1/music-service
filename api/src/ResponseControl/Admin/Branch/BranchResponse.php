<?php

namespace App\ResponseControl\Admin\Branch;

use Codememory\EntityResponseControl\ResponseControl;

final class BranchResponse extends ResponseControl
{
    private ?string $key = null;
    private array $value = [];
}