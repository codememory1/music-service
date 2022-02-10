<?php

namespace App\Resolver;

use App\Service\RequestDataService;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Class RequestDataResolver
 *
 * @package App\Resolver
 *
 * @author  Codememory
 */
class RequestDataResolver implements ArgumentValueResolverInterface
{

    /**
     * @inheritDoc
     */
    #[Pure]
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {

        return RequestDataService::class === $argument->getType();

    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {

        if ($request->isXmlHttpRequest()) {
            $data = $request->toArray();
        } else {
            $data = $request->request->all();
        }

        yield new RequestDataService($data);

    }

}