<?php

namespace App\Service\Platform\Google;

use App\Dto\Transfer\GoogleAuthDto;
use App\Enum\GoogleScopeEnum;
use App\Exception\Http\AuthorizationException;
use App\Service\Platform\Interfaces\ClientInterface;
use App\Service\Platform\Interfaces\UserDataInterface;
use Google\Client as GoogleClient;
use JetBrains\PhpStorm\NoReturn;

final class Client implements ClientInterface
{
    public readonly GoogleClient $googleClient;
    private ?string $accessToken = null;
    private array $authenticateResponse = [];

    #[NoReturn]
    public function __construct(
        private readonly string $clientId,
        private readonly string $secretKey,
        private readonly string $redirectUrl,
        private array $scopes = []
    ) {
        $this->scopes = array_map(static fn(GoogleScopeEnum $googleScopeEnum) => $googleScopeEnum->value, $this->scopes);

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

    public function authenticate(GoogleAuthDto $googleAuthDto): self
    {
        $response = $this->googleClient->fetchAccessTokenWithAuthCode(urldecode($googleAuthDto->code));

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