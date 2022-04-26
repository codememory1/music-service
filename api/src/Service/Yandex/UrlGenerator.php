<?php

namespace App\Service\Yandex;

use JetBrains\PhpStorm\Pure;

/**
 * Class UrlGenerator.
 *
 * @package App\Service\Yandex
 *
 * @author  Codememory
 */
class UrlGenerator
{
    public const USER_INFO_URL = 'https://login.yandex.ru/info';
    public const USER_AVATAR_URL = 'https://avatars.yandex.net/get-yapic/%s/%s';

    /**
     * @var YandexOAuthClient
     */
    private YandexOAuthClient $yandexOAuthClient;

    /**
     * @param YandexOAuthClient $yandexOAuthClient
     */
    public function __construct(YandexOAuthClient $yandexOAuthClient)
    {
        $this->yandexOAuthClient = $yandexOAuthClient;
    }

    /**
     * @param string|null $type
     * @param string|null $state
     * @param array       $params
     *
     * @return string
     */
    public function generateAuthUrl(?string $type = null, array $params = []): string
    {
        $type ??= $this->yandexOAuthClient::CODE_AUTH_TYPE;

        return $this->yandexOAuthClient->getAuthUrl($type, 'type=yandex', [
            'redirect_uri' => $this->yandexOAuthClient->getRedirectUrl(),
            ...$params
        ]);
    }

    /**
     * @param string $avatarId
     * @param bool   $isEmpty
     *
     * @return string|null
     */
    #[Pure]
    public function generateAvatarUrl(string $avatarId, bool $isEmpty = false): ?string
    {
        $generatedUrl = sprintf(self::USER_AVATAR_URL, $avatarId, $this->yandexOAuthClient->getAvatarSize());

        return $isEmpty ? null : $generatedUrl;
    }
}