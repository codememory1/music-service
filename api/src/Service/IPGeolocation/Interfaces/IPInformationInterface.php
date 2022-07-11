<?php

namespace App\Service\IPGeolocation\Interfaces;

/**
 * Interface IPInformationInterface.
 *
 * @package  App\Service\IPGeolocation\Interfaces
 *
 * @author   Codememory
 */
interface IPInformationInterface
{
    public function getContinent(): ?string;

    public function setContinent(?string $continent): self;

    public function getContinentCode(): ?string;

    public function setContinentCode(?string $continentCode): self;

    public function getCountry(): ?string;

    public function setCountry(?string $country): self;

    public function getCountryCode(): ?string;

    public function setCountryCode(?string $countryCode): self;

    public function getRegion(): ?string;

    public function setRegion(?string $region): self;

    public function getRegionName(): ?string;

    public function setRegionName(?string $regionName): self;

    public function getCity(): ?string;

    public function setCity(?string $city): self;

    public function getDistrict(): ?string;

    public function setDistrict(?string $district): self;

    public function getZip(): ?string;

    public function setZip(?string $zip): self;

    public function getLat(): ?string;

    public function setLat(?float $lat): self;

    public function getLon(): ?string;

    public function setLon(?float $lon): self;

    public function getTimezone(): ?string;

    public function setTimezone(?string $timezone): self;

    public function getOffset(): ?string;

    public function setOffset(?int $offset): self;

    public function getCurrency(): ?string;

    public function setCurrency(?string $currency): self;

    public function isProxy(): ?bool;

    public function setProxy(?bool $isProxy): self;
}