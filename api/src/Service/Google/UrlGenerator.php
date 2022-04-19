<?php

namespace App\Service\Google;

/**
 * Class UrlGenerator.
 *
 * @package App\Service\Google
 *
 * @author  Codememory
 */
class UrlGenerator
{
    /**
     * @var GoogleOAuthClient
     */
    private GoogleOAuthClient $googleOAuthClient;

    /**
     * @param GoogleOAuthClient $googleOAuthClient
     */
    public function __construct(GoogleOAuthClient $googleOAuthClient)
    {
        $this->googleOAuthClient = $googleOAuthClient;
    }

    /**
     * @param string $accessType
     * @param array  $params
     *
     * @return string
     */
    public function generateAuthUrl(string $accessType = 'offline', array $params = []): string
    {
        return $this->googleOAuthClient->getOAuth2Service()->buildFullAuthorizationUri([
            'client_id' => $this->googleOAuthClient->getClientId(),
            'response_type' => 'code',
            'access_type' => $accessType,
            'redirect_uri' => $this->googleOAuthClient->getRedirectUri(),
            'scope' => implode(' ', $this->googleOAuthClient->getScopes()),
            'state' => 'type=google',
            ...$params
        ]);
    }
}