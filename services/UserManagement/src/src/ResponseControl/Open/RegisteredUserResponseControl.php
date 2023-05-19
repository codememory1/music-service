<?php

namespace App\ResponseControl\Open;

use Codememory\EntityResponseControl\Constraints\Value as RCV;
use Codememory\EntityResponseControl\ResponseControl;

final class RegisteredUserResponseControl extends ResponseControl
{
    private ?int $id = null;
    private ?string $email = null;

    #[RCV\FromEnum]
    private array $status = [];

    #[RCV\DateTime(full: true)]
    private array $createdAt = [];

    #[RCV\DateTime(full: true)]
    private array $updatedAt = [];
}