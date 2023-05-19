<?php

namespace App\ResponseControl\Admin\Branch;

use Codememory\EntityResponseControl\ResponseControl;

final class LogicBranchResponse extends ResponseControl
{
    private ?string $name = null;
    private ?string $status = null;
}