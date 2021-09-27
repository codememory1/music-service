<?php

namespace Kernel\Twig;

use Twig\Environment;
use Twig\TwigFunction;

/**
 * Class TwigExpander
 *
 * @package Kernel\Twig
 *
 * @author  Codememory
 */
final class TwigExpander
{

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {

        $this->functions($environment);

    }

    /**
     * @param Environment $environment
     */
    private function functions(Environment $environment): void
    {

        $environment->addFunction(new TwigFunction('routePath', function (string $name, array $parameters = []): ?string {
            return routePath($name, $parameters);
        }));
        $environment->addFunction(new TwigFunction('dump', function (mixed $data): void {
            dump($data);
        }));
        $environment->addFunction(new TwigFunction('assetAliasPath', function (string $name, bool $withVersion = true): string {
            return assetAliasPath($name, $withVersion);
        }));
        $environment->addFunction(new TwigFunction('assetPath', function (string $path): string {
            return assetPath($path);
        }));

    }

}