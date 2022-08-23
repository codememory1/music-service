<?php

namespace App\Rest\Jwt;

class AccessToken extends AbstractJwtToken
{
    protected ?string $parameterNameWithPublicKeyPath = 'jwt.access_public_key';
}