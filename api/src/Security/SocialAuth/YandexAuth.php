<?php

namespace App\Security\SocialAuth;

use App\Interfaces\AuthorizationTokenInterface;
use App\Rest\Http\Response;
use App\Service\Yandex\YandexOAuthClient;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class YandexAuth
 *
 * @package App\Security\SocialAuth
 *
 * @author  Codememory
 */
class YandexAuth extends AbstractSocialAuth
{
    /**
     * @inheritDoc
     */
    protected ?string $typeAuthSocialNetwork = 'yandex';

    /**
     * @var YandexOAuthClient|null
     */
    private ?YandexOAuthClient $client = null;

    /**
     * @param YandexOAuthClient $client
     *
     * @return $this
     */
    #[Required]
    public function setYandexOAuthClient(YandexOAuthClient $client): self
    {
        $this->client = $client;
        
        return $this;
    }

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    public function make(EventDispatcherInterface $eventDispatcher, string $code): Response|AuthorizationTokenInterface
    {
        try {
            $this->client->fetchAuthToken($code);

            return $this->handler($this->client->getUserData(), $eventDispatcher);
        } catch (Exception) {
            return $this->responseCollection->invalid('socialAuth@authenticationRrror')->getResponse();
        }
    }
}