<?php

namespace App\Security\SocialAuth;

use App\Interfaces\AuthorizationTokenInterface;
use App\Service\Google\GoogleOAuthClient;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class GoogleAuth.
 *
 * @package App\Security\SocialAuth
 *
 * @author  Codememory
 */
class GoogleAuth extends AbstractSocialAuth
{
    /**
     * @inheritDoc
     */
    protected ?string $typeAuthSocialNetwork = 'google';

    /**
     * @var null|GoogleOAuthClient
     */
    private ?GoogleOAuthClient $client = null;

    /**
     * @param GoogleOAuthClient $client
     *
     * @return $this
     */
    #[Required]
    public function setGoogleOAuthClient(GoogleOAuthClient $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function make(string $code): AuthorizationTokenInterface
    {
        $this->client->fetchAuthToken($code);

        return $this->handler($this->client->getUserData());
    }
}