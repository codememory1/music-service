<?php

namespace App\ResponseControl\Open;

use Codememory\EntityResponseControl\ResponseControl;
use Codememory\EntityResponseControl\Constraints\Value as RCV;
use Codememory\EntityResponseControl\Constraints\System as RCS;

final class RoleResponseControl extends ResponseControl
{
    private ?int $id = null;
    private ?string $name = null;

    #[RCS\AliasInResponse('permissions')]
    #[RCV\CallbackResponse(RolePermissionResponseControl::class)]
    private array $rolePermissions = [];
}