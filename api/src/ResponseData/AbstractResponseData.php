<?php

namespace App\ResponseData;

use App\Entity\Interfaces\EntityInterface;
use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Interfaces\ValueHandlerInterface;
use function is_array;
use JetBrains\PhpStorm\ArrayShape;
use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\DependencyInjection\ReverseContainer;
use function Symfony\Component\String\u;

/**
 * Class AbstractResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
abstract class AbstractResponseData implements ResponseDataInterface
{
    /**
     * @var array
     */
    protected array $ignoredProperties = [];

    /**
     * @var array
     */
    protected array $methodPrefixesForProperties = [];

    /**
     * @var ReverseContainer
     */
    protected ReverseContainer $container;

    /**
     * @var array<EntityInterface>
     */
    private array $entities = [];

    /**
     * @var array
     */
    private array $allowedProperties = [];

    /**
     * @var array
     */
    private array $response = [];

    /**
     * @param ReverseContainer $container
     */
    public function __construct(ReverseContainer $container)
    {
        $this->container = $container;

        $this->ignoredProperties[] = 'ignoredProperties';
        $this->ignoredProperties[] = 'container';
        $this->ignoredProperties[] = 'methodPrefixesForProperties';
    }

    /**
     * @param array<EntityInterface>|EntityInterface $entities
     *
     * @return $this
     */
    public function setEntities(EntityInterface|array $entities): self
    {
        $this->entities = is_array($entities) ? $entities : [$entities];

        return $this;
    }

    /**
     * @return $this
     */
    public function collect(): self
    {
        $reflection = new ReflectionClass(static::class);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            if (in_array($property->getName(), $this->ignoredProperties, true)) {
                continue;
            }

            $propertyHandleResult = $this->handleProperty($property);

            if ($propertyHandleResult['isPassed']) {
                $this->addAllowedProperty($property, $propertyHandleResult['interceptor']);
            }
        }

        $this->collectResponse();

        return $this;
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @param ReflectionProperty $reflectionProperty
     *
     * @return array
     */
    #[ArrayShape(['isPassed' => 'bool', 'interceptor' => 'array'])]
    private function handleProperty(ReflectionProperty $reflectionProperty): array
    {
        $result = [
            'isPassed' => true,
            'interceptor' => []
        ];

        foreach ($reflectionProperty->getAttributes() as $attribute) {
            /** @var ConstraintInterface $constraint */
            $constraint = $attribute->newInstance();
            $constraintHandler = $this->getConstraintHandler($constraint);

            if ($constraintHandler instanceof ConstraintHandlerInterface) {
                if (false === $constraintHandler->handle($constraint)) {
                    $result['isPassed'] = false;

                    break;
                }
            }

            if ($constraintHandler instanceof ValueHandlerInterface) {
                $result['interceptor']['constraint'] = $constraint;
                $result['interceptor']['handler'] = $constraintHandler;
            }
        }

        return $result;
    }

    /**
     * @param ReflectionProperty $reflectionProperty
     * @param array              $interceptor
     *
     * @return void
     */
    private function addAllowedProperty(ReflectionProperty $reflectionProperty, array $interceptor = []): void
    {
        $propertyName = $reflectionProperty->getName();
        $methodPrefix = $this->methodPrefixesForProperties[$propertyName] ?? 'get__';

        $this->allowedProperties[] = [
            'propertyName' => $propertyName,
            'getterToEntity' => u("${methodPrefix}${propertyName}")->camel()->toString(),
            'keyToResponse' => u($propertyName)->snake()->toString(),
            'interceptor' => $interceptor
        ];
    }

    /**
     * @return void
     */
    private function collectResponse(): void
    {
        foreach ($this->entities as $entity) {
            $toArray = [];

            foreach ($this->allowedProperties as $allowedProperty) {
                $value = $entity->{$allowedProperty['getterToEntity']}();

                if ([] !== $interceptor = $allowedProperty['interceptor']) {
                    $value = $interceptor['handler']->handle($interceptor['constraint'], $this, $value);
                }

                $toArray[$allowedProperty['keyToResponse']] = empty($value) ? $this->{$allowedProperty['propertyName']} : $value;
            }

            if (1 === count($this->entities)) {
                $this->response = $toArray;
            } else {
                $this->response[] = $toArray;
            }
        }
    }

    /**
     * @param ConstraintInterface $constraint
     *
     * @return object
     */
    private function getConstraintHandler(ConstraintInterface $constraint): object
    {
        return $this->container->getService($constraint->getHandler());
    }
}