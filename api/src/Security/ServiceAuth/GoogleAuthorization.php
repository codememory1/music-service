<?php

namespace App\Security\ServiceAuth;

use App\Dto\Interfaces\ServiceAuthorizationDtoInterface;
use App\Service\Platform\Interfaces\ClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GoogleAuthorization.
 *
 * @package App\Security\ServiceAuth
 *
 * @author  Codememory
 */
class GoogleAuthorization extends AbstractServiceAuthorization
{
    protected ?string $serviceType = 'google';

    public function make(ClientInterface $client, ServiceAuthorizationDtoInterface $serviceAuthorizationDto): JsonResponse
    {
        return $this->authorizationHandler($client, $serviceAuthorizationDto);
    }
}