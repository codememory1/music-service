<?php

namespace App\Rest\Jwt;

class RefreshToken extends AbstractJwtToken
{
    protected ?string $parameterNameWithPublicKeyPath = 'jwt.access_public_key';
}