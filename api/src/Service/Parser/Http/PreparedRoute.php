<?php

namespace App\Service\Parser\Http;

class PreparedRoute
{
    private array $paths = [];
    
    public function __construct(
        public readonly string $exampleLink,
        public readonly array $parameters
    ){}
    
    public function addPathToLink(string $path): self
    {
        $this->paths[] = $path;
        
        return $this;
    }
    
    public function getCollectedRoute(): string
    {
        $link = $this->collectRoute($this->exampleLink, $this->parameters);
        $addedPath = implode('/', $this->paths);
        $endSlash = str_ends_with($link, '/') ? '/' : null;
        
        return [] === $this->paths ? $link : sprintf('%s/%s%s', rtrim($link, '/'), $addedPath, $endSlash);
    }
    
    public function removeLastAddedPath(): self
    {
        if ([] !== $this->paths) {
            unset($this->paths[array_key_last($this->paths)]);
        }
        
        return $this;
    }
    
    private function collectRoute(string $url, array $parameters = []): string
    {
        $parameterNames = array_map(static fn(string $name) => sprintf('{%s}', $name), array_keys($parameters));

        return str_replace($parameterNames, $parameters, $url);
    }
}