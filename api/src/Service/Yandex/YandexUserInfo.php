<?php

namespace App\Service\Yandex;

use App\Interfaces\SocialNetworkUserInfoInterface;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class YandexUserInfo
 *
 * @package App\Service\Yandex
 *
 * @author  Codememory
 */
class YandexUserInfo implements SocialNetworkUserInfoInterface
{
    /**
     * @var YandexOAuthClient
     */
    private YandexOAuthClient $client;

    /**
     * @var array
     */
    private array $userInfo;

    /**
     * @param YandexOAuthClient $client
     *
     * @throws GuzzleException
     */
    public function __construct(YandexOAuthClient $client)
    {
        $this->client = $client;
        $this->userInfo = $this->getUserInfo($this->client->getAccessToken());
    }

    /**
     * @inheritDoc
     */
    public function getUniqueId(): ?string
    {
        return empty($this->userInfo['id']) ? null : $this->userInfo['id'];
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return empty($this->userInfo['first_name']) ? null : $this->userInfo['first_name'];
    }

    /**
     * @inheritDoc
     */
    public function getSurname(): ?string
    {
        return empty($this->userInfo['last_name']) ? null : $this->userInfo['last_name'];
    }

    /**
     * @inheritDoc
     */
    public function getEmail(): ?string
    {
        return empty($this->userInfo['emails'][0]) ? null : $this->userInfo['emails'][0];
    }

    /**
     * @inheritDoc
     */
    public function getPhoto(): ?string
    {
        return empty($this->userInfo['default_avatar_id']) ? null : $this->userInfo['default_avatar_id'];
    }

    /**
     * @inheritDoc
     */
    public function getLocale(): ?string
    {
        return empty($this->userInfo['locale']) ? null : $this->userInfo['locale'];
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'id' => "null|string",
        'name' => "null|string",
        'surname' => "null|string",
        'email' => "null|string",
        'photo' => "null|string",
        'locale' => "null|string"
    ])]
    public function __toArray(): array
    {
        return [
            'id' => $this->getUniqueId(),
            'name' => $this->getName(),
            'surname' => $this->getSurname(),
            'email' => $this->getEmail(),
            'photo' => $this->getPhoto(),
            'locale' => $this->getLocale()
        ];
    }

    /**
     * @param string $accessToken
     *
     * @return array
     * @throws GuzzleException
     */
    private function getUserInfo(string $accessToken): array
    {
        $client = $this->client->getHttpClient();

        $response = $client->request(
            'GET',
            UrlGenerator::USER_INFO_URL,
            [
                'query' => [
                    'format' => 'json',
                    'oauth_token' => $accessToken,
                ]
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}