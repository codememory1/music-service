<?php

namespace App\ResponseControl\Open;

use Codememory\EntityResponseControl\ResponseControl;
use Codememory\EntityResponseControl\Constraints\Value as RCV;

final class RolePermissionResponseControl extends ResponseControl
{
    #[RCV\CallbackResponse(PermissionResponseControl::class)]
    private array $permission = [];
}