<?php

namespace App\Resolver;

use App\Service\FileUploaderService;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Class FileUploaderResolver
 *
 * @package App\Resolver
 *
 * @author  Codememory
 */
class FileUploaderResolver implements ArgumentValueResolverInterface
{

    /**
     * @var ContainerBagInterface
     */
    private ContainerBagInterface $parameters;

    /**
     * @param ContainerBagInterface $parameters
     */
    public function __construct(ContainerBagInterface $parameters)
    {

        $this->parameters = $parameters;

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {

        return FileUploaderService::class === $argument->getType();

    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {

        yield new FileUploaderService($request->files, $this->parameters);

    }

}