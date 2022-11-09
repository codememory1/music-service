<?php

namespace App\Rest\Jwt;

final class RefreshToken extends AbstractJwtToken
{
    protected ?string $parameterNameWithPublicKeyPath = 'jwt.access_public_key';
}