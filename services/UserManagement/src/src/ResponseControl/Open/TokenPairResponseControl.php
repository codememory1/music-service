<?php

namespace App\ResponseControl\Open;

use Codememory\EntityResponseControl\ResponseControl;

final class TokenPairResponseControl extends ResponseControl
{
    private ?string $accessToken = null;
    private ?string $refreshToken = null;
}