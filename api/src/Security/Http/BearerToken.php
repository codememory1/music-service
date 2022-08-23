<?php

namespace App\Security\Http;

use App\Rest\Http\Request;

class BearerToken
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getToken(): ?string
    {
        $request = $this->request->getRequest();
        $authorizationHeader = $request?->headers->get('Authorization');
        $authorizationHeaderData = explode(' ', $authorizationHeader, 2);

        if (count($authorizationHeaderData) > 1 && 'Bearer' === $authorizationHeaderData[0]) {
            return $authorizationHeaderData[1];
        }

        return null;
    }
}