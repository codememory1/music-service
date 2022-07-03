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
    public readonly string $clientId;
    public readonly string $secretKey;
    public readonly string $redirectUrl;
    public readonly array $scopes;
    public readonly GoogleClient $googleClient;
    private ?string $accessToken = null;
    private array $authenticateResponse = [];

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

    public function createAuthorizationUrl(): ?string
    {
        return $this->googleClient->createAuthUrl();
    }

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

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function getAuthenticateResponse(): array
    {
        return $this->authenticateResponse;
    }

    public function getUserData(): UserDataInterface
    {
        return new UserData($this);
    }
}