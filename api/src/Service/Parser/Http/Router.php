<?php

namespace App\Service\Parser\Http;

use JetBrains\PhpStorm\Pure;

class Router
{
    private array $routeList = [];

    public function addExampleRoute(string $name, string $url): self
    {
        $this->routeList[$name] = $url;

        return $this;
    }

    #[Pure] 
    public function getRoute(string $name, array $parameters = []): ?PreparedRoute
    {
        if (array_key_exists($name, $this->routeList)) {
            return new PreparedRoute($this->routeList[$name], $parameters);
        }

        return null;
    }
}