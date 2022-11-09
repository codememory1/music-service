<?php

namespace App\Rest\Jwt;

final class AccessToken extends AbstractJwtToken
{
    protected ?string $parameterNameWithPublicKeyPath = 'jwt.access_public_key';
}