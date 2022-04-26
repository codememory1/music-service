<?php

namespace App\Service\Yandex;

use App\Interfaces\SocialNetworkUserInfoInterface;
use App\Interfaces\SocialOAuthClientInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Yandex\OAuth\OAuthClient;

/**
 * Class YandexOAuthClient
 *
 * @package App\Service\Yandex
 *
 * @author  Codememory
 */
class YandexOAuthClient extends OAuthClient implements SocialOAuthClientInterface
{
    /**
     * @var string
     */
    private string $redirectUrl;

    /**
     * @var string
     */
    private string $avatarSize;

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUrl
     * @param string $avatarSize
     */
    public function __construct(string $clientId, string $clientSecret, string $redirectUrl, string $avatarSize)
    {
        $this->redirectUrl = $redirectUrl;
        $this->avatarSize = $avatarSize;

        parent::__construct($clientId, $clientSecret);
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * @return string
     */
    public function getAvatarSize(): string
    {
        return $this->avatarSize;
    }

    /**
     * @return UrlGenerator
     */
    #[Pure]
    public function getUrlGenerator(): UrlGenerator
    {
        return new UrlGenerator($this);
    }

    /**
     * @param array $headers
     *
     * @return Client|ClientInterface|null
     */
    public function getHttpClient(array $headers = []): Client|ClientInterface|null
    {
        return $this->getClient($headers);
    }

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    public function getUserData(): SocialNetworkUserInfoInterface
    {
        return new YandexUserInfo($this);
    }

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    #[ArrayShape(['access_token' => "string"])]
    public function fetchAuthToken(string $code): array
    {
        try {
            $tokens = $this->requestAccessToken($code);

            return [
                'access_token' => $tokens->getAccessToken()
            ];
        } catch (Exception) {
            return [];
        }
    }

}