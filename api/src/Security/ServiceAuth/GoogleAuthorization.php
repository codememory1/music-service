<?php

namespace App\Security\ServiceAuth;

use App\Dto\Interfaces\ServiceAuthorizationDtoInterface;
use App\Service\Platform\Interfaces\ClientInterface;

final class GoogleAuthorization extends AbstractServiceAuthorization
{
    protected ?string $serviceType = 'google';

    public function make(ClientInterface $client, ServiceAuthorizationDtoInterface $dto): array
    {
        return $this->auth($this->authorizationHandler($client, $dto));
    }
}