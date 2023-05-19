<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Codememory\ApiBundle\Entity\Interfaces\EntityInterface;
use Codememory\ApiBundle\Entity\Traits\IdentifierTrait;
use Codememory\ApiBundle\Entity\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\Table('countries')]
#[ORM\HasLifecycleCallbacks]
class Country implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $officialName = null;

    #[ORM\Column(length: 5, unique: true)]
    private ?string $code = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $capital = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $currency = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Language $language = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Continent $continent = null;

    #[ORM\Column]
    private ?int $area = null;

    #[ORM\Column]
    private ?int $population = null;

    #[ORM\Column]
    private array $coordinates = [];

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PhoneCode $phoneCode = null;

    #[ORM\Column(length: 20)]
    private ?string $startOfWeek = null;

    #[ORM\Column(length: 20)]
    private ?string $timezone = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: City::class, cascade: ['persist', 'remove'])]
    private Collection $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOfficialName(): ?string
    {
        return $this->officialName;
    }

    public function setOfficialName(string $name): self
    {
        $this->officialName = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCapital(): ?City
    {
        return $this->capital;
    }

    public function setCapital(City $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getContinent(): ?Continent
    {
        return $this->continent;
    }

    public function setContinent(Continent $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): self
    {
        $this->population = $population;

        return $this;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function getLatitude(): int
    {
        return $this->getCoordinates()['latitude'];
    }

    public function getLongitude(): int
    {
        return $this->getCoordinates()['longitude'];
    }

    public function setCoordinates(int $latitude, int $longitude): self
    {
        $this->coordinates = [
            'latitude' => $latitude,
            'longitude' => $longitude
        ];

        return $this;
    }

    public function getPhoneCode(): ?PhoneCode
    {
        return $this->phoneCode;
    }

    public function setPhoneCode(PhoneCode $phoneCode): self
    {
        $this->phoneCode = $phoneCode;

        return $this;
    }

    public function getStartOfWeek(): ?string
    {
        return $this->startOfWeek;
    }

    public function setStartOfWeek(string $startOfWeek): self
    {
        $this->startOfWeek = $startOfWeek;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setCountry($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getCountry() === $this) {
                $city->setCountry(null);
            }
        }

        return $this;
    }
}
