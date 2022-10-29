<?php

namespace App\Entity\Parser;

use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\Parser\ServiceCacheRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceCacheRepository::class)]
#[ORM\Table('service_caches')]
#[ORM\HasLifecycleCallbacks]
class ServiceCache
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $link = null;
    
    #[ORM\Column(type: Types::ARRAY)]
    private array $linkParams = [];

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;
    
    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getLinkParams(): array
    {
        return $this->linkParams;
    }
    
    public function getLinkParam(string $name): null|int|string|float
    {
        return $this->linkParams[$name] ?? null;
    }
    
    public function setLinkParams(array $params): self
    {
        $this->linkParams = $params;
        
        return $this;
    }
    
    public function addLinkParam(string $name, int|string|float $value): self
    {
        $this->linkParams[$name] = $value;
        
        return $this;
    }
    
    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
