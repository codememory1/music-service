<?php

namespace App\Security\Http;

use App\Rest\Http\Request;
use App\Service\JwtTokenGenerator;

class BearerToken
{
    private JwtTokenGenerator $jwtTokenGenerator;
    private Request $request;
    private ?string $token = null;

    public function __construct(JwtTokenGenerator $jwtTokenGenerator, Request $request)
    {
        $this->jwtTokenGenerator = $jwtTokenGenerator;
        $this->request = $request;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getToken(): ?string
    {
        if (null === $this->token) {
            $authorization = $this->request->getRequest()?->headers->get('Authorization');
            $authorizationData = explode(' ', $authorization, 2);

            if (count($authorizationData) > 1 && 'Bearer' === $authorizationData[0]) {
                return $authorizationData[1];
            }

            return null;
        }

        return $this->token;
    }

    public function getData(): bool|array
    {
        if (null !== $token = $this->getToken()) {
            $data = $this->jwtTokenGenerator->decode($token, 'jwt.access_public_key');

            return false !== $data ? (array) $data : false;
        }

        return false;
    }
}