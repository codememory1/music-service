<?php

namespace App\Service\IPGeolocation\Interfaces;

interface ClientInterface
{
    public function getUrl(string $ip): ?string;

    public function request(?string $ip): self;

    public function response(): ?IPInformationInterface;
}