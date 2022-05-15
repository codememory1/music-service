<?php

namespace App\Resolver;

use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\ArrayShape;
use LogicException;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use function Symfony\Component\String\u;

/**
 * Class EntityFromRouteParameterResolver.
 *
 * @package App\Resolver
 *
 * @author  Codememory
 */
final class EntityFromRouteParameterResolver implements ArgumentValueResolverInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var array
     */
    private array $routeParameters = [];

    /**
     * @var null|ReflectionClass
     */
    private ?ReflectionClass $reflection = null;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (class_exists($argument->getType())) {
            $this->reflection = new ReflectionClass($argument->getType());

            if ($this->reflection->implementsInterface(EntityInterface::class)) {
                $this->routeParameters = $request->attributes->get('_route_params');

                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $entityRepository = $this->em->getRepository($argument->getType());
        $entityNameInCamel = (string) u($this->reflection->getShortName())->camel();
        $finedRouteParameter = $this->finedRouteParameter($entityNameInCamel);

        $finedEntity = $entityRepository->findOneBy([
            $finedRouteParameter['property_name'] => $finedRouteParameter['value']
        ]);

        if (null === $finedEntity) {
            throw EntityNotFoundException::page();
        }

        yield $finedEntity;
    }

    /**
     * @param string $entityNameInCamel
     *
     * @return null|array
     */
    #[ArrayShape(['property_name' => 'string', 'value' => 'mixed'])]
    private function finedRouteParameter(string $entityNameInCamel): ?array
    {
        foreach ($this->routeParameters as $parameterName => $value) {
            if (false === str_starts_with($parameterName, "${entityNameInCamel}_")) {
                continue;
            }

            return [
                'property_name' => explode('_', $parameterName)[1],
                'value' => $value
            ];
        }

        throw new LogicException("Failed to process ${entityNameInCamel} entity due to missing route parameter");
    }
}