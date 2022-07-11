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
    public function getUrl(string $ip): ?string;

    public function request(?string $ip): self;

    public function response(): ?IPInformationInterface;
}