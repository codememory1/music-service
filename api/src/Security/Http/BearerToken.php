<?php

namespace App\Security\Http;

use App\Rest\Http\Request;
use App\Service\JwtTokenGenerator;

/**
 * Class BearerToken.
 *
 * @package App\Security\Http
 *
 * @author  Codememory
 */
class BearerToken
{
    /**
     * @var JwtTokenGenerator
     */
    private JwtTokenGenerator $jwtTokenGenerator;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var null|string
     */
    private ?string $token = null;

    /**
     * @param JwtTokenGenerator $jwtTokenGenerator
     * @param Request           $request
     */
    public function __construct(JwtTokenGenerator $jwtTokenGenerator, Request $request)
    {
        $this->jwtTokenGenerator = $jwtTokenGenerator;
        $this->request = $request;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getToken(): ?string
    {
        if (null === $this->token) {
            $authorization = $this->request->request?->headers->get('Authorization');
            $authorizationData = explode(' ', $authorization, 2);

            if (count($authorizationData) > 1 && 'Bearer' === $authorizationData[0]) {
                return $authorizationData[1];
            }

            return null;
        }

        return $this->token;
    }

    /**
     * @return array|bool
     */
    public function getData(): bool|array
    {
        if (null !== $token = $this->getToken()) {
            $data = $this->jwtTokenGenerator->decode($token, 'jwt.access_public_key');

            return false !== $data ? (array) $data : false;
        }

        return false;
    }
}