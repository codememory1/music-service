<?php

namespace App\Service\Google;

use Google\Client;
use JetBrains\PhpStorm\Pure;

/**
 * Class GoogleClient
 *
 * @package App\Service\Google
 *
 * @author  Codememory
 */
class GoogleOAuthClient extends Client
{
    public const USERINFO_EMAIL = 'https://www.googleapis.com/auth/userinfo.email';
    public const USERINFO_PROFILE = 'https://www.googleapis.com/auth/userinfo.profile';
    public const USERINFO_PHONES = 'https://www.googleapis.com/auth/user.phonenumbers.read';
    public const USERINFO_ORGANIZATION = 'https://www.googleapis.com/auth/user.organization.read';
    public const USERINFO_GENDER = 'https://www.googleapis.com/auth/user.gender.read';
    public const USERINFO_BIRTHDAY = 'https://www.googleapis.com/auth/user.birthday.read';
    public const USERINFO_ADDRESS = 'https://www.googleapis.com/auth/user.addresses.read';

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUrl
     * @param array  $scopes
     */
    public function __construct(string $clientId, string $clientSecret, string $redirectUrl, array $scopes = [])
    {
        parent::__construct();
        
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);
        $this->setRedirectUri($redirectUrl);
        $this->setScopes($scopes);
    }

    /**
     * @return UrlGenerator
     */
    #[Pure]
    public function getUrlGenerator(): UrlGenerator
    {
        return new UrlGenerator($this);
    }
}