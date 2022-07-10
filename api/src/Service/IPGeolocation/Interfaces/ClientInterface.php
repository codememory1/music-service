<?php

namespace App\Service\IPGeolocation\Interfaces;

/**
 * Interface ClientInterface.
 *
 * @package  App\Service\IPGeolocation\Interfaces
 *
 * @author   Codememory
 */
interface ClientInterface
{
    public function request(?string $ip): self;

    public function response(): ?IPInformationInterface;
}