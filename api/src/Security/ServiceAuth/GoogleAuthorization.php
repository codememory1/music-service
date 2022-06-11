<?php

namespace App\Security\ServiceAuth;

use App\DTO\Interfaces\ServiceAuthorizationDTOInterface;
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
    /**
     * @inheritDoc
     */
    protected ?string $serviceType = 'google';

    /**
     * @inheritDoc
     */
    public function make(ClientInterface $client, ServiceAuthorizationDTOInterface $serviceAuthorizationDTO): JsonResponse
    {
        return $this->authorizationHandler($client, $serviceAuthorizationDTO);
    }
}