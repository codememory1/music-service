<?php

namespace App\Service\Parser\Http;

class PreparedRoute
{
    private array $routeList = [];

    public function addExampleRoute(string $name, string $url): self
    {
        $this->routeList[$name] = $url;

        return $this;
    }

    public function getRoute(string $name, array $parameters = []): ?string
    {
        if (array_key_exists($name, $this->routeList)) {
            return $this->collectRoute($this->routeList[$name], $parameters);
        }

        return null;
    }

    private function collectRoute(string $url, array $parameters = []): string
    {
        $parameterNames = array_map(static fn(string $name) => sprintf('{%s}', $name), array_keys($parameters));

        return str_replace($parameterNames, $parameters, $url);
    }
}