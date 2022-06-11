<?php

namespace App\Service\Platform\Google;

use App\DTO\GoogleAuthDTO;
use App\Enum\GoogleScopeEnum;
use App\Rest\Http\Exceptions\AuthorizationException;
use App\Service\Platform\Interfaces\ClientInterface;
use App\Service\Platform\Interfaces\UserDataInterface;
use Google\Client as GoogleClient;
use JetBrains\PhpStorm\NoReturn;

/**
 * Class Client.
 *
 * @package App\Service\Platform\Google
 *
 * @author  Codememory
 */
class Client implements ClientInterface
{
    /**
     * @var string
     */
    public readonly string $clientId;

    /**
     * @var string
     */
    public readonly string $secretKey;

    /**
     * @var string
     */
    public readonly string $redirectUrl;

    /**
     * @var array
     */
    public readonly array $scopes;

    /**
     * @var GoogleClient
     */
    public readonly GoogleClient $googleClient;

    /**
     * @var null|string
     */
    private ?string $accessToken = null;

    /**
     * @var array
     */
    private array $authenticateResponse = [];

    /**
     * @param string                 $clientId
     * @param string                 $secretKey
     * @param string                 $redirectUrl
     * @param array<GoogleScopeEnum> $scopes
     */
    #[NoReturn]
    public function __construct(string $clientId, string $secretKey, string $redirectUrl, array $scopes = [])
    {
        $this->clientId = $clientId;
        $this->secretKey = $secretKey;
        $this->redirectUrl = $redirectUrl;
        $this->scopes = array_map(static fn(GoogleScopeEnum $googleScopeEnum) => $googleScopeEnum->value, $scopes);

        $this->googleClient = new GoogleClient();

        $this->googleClient->setClientId($this->clientId);
        $this->googleClient->setClientSecret($this->secretKey);
        $this->googleClient->setRedirectUri($this->redirectUrl);
        $this->googleClient->setScopes($this->scopes);
    }

    /**
     * @inheritDoc
     */
    public function createAuthorizationUrl(): ?string
    {
        return $this->googleClient->createAuthUrl();
    }

    /**
     * @inheritDoc
     */
    public function authenticate(GoogleAuthDTO $googleAuthDTO): self
    {
        $response = $this->googleClient->fetchAccessTokenWithAuthCode(urldecode($googleAuthDTO->code));

        if (array_key_exists('error', $response)) {
            throw AuthorizationException::authorizationError();
        }

        $this->accessToken = $response['access_token'] ?? null;
        $this->authenticateResponse = $response;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @inheritDoc
     */
    public function getAuthenticateResponse(): array
    {
        return $this->authenticateResponse;
    }

    /**
     * @inheritDoc
     */
    public function getUserData(): UserDataInterface
    {
        return new UserData($this);
    }
}