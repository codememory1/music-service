<?php

namespace App\ResponseData;

use App\Entity\Interfaces\EntityInterface;
use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Interfaces\ValueHandlerInterface;
use Doctrine\Common\Collections\Collection;
use function is_array;
use JetBrains\PhpStorm\ArrayShape;
use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\DependencyInjection\ReverseContainer;
use function Symfony\Component\String\u;

abstract class AbstractResponseData implements ResponseDataInterface
{
    protected array $ignoredProperties = [];
    protected array $methodPrefixesForProperties = [];
    protected array $aliases = [];
    protected ReverseContainer $container;
    private array $entities = [];
    private array $allowedProperties = [];
    private array $response = [];

    public function __construct(ReverseContainer $container)
    {
        $this->container = $container;

        $this->ignoredProperties[] = 'ignoredProperties';
        $this->ignoredProperties[] = 'container';
        $this->ignoredProperties[] = 'methodPrefixesForProperties';
        $this->ignoredProperties[] = 'aliases';
    }

    public function setIgnoreProperty(string $name): ResponseDataInterface
    {
        $this->ignoredProperties[] = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setEntities(EntityInterface|array|Collection $entities): self
    {
        if ($entities instanceof Collection) {
            $entities = $entities->toArray();
        }

        $this->entities = is_array($entities) ? $entities : [$entities];

        return $this;
    }

    public function getResponse(bool $first = false): array
    {
        $this->collect();
        
        if (true === $first && [] !== $this->response) {
            $key = array_key_first($this->response);

            return $this->response[$key];
        }

        return $this->response;
    }

    private function collect(): void
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

    }

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

    private function collectResponse(): void
    {
        foreach ($this->entities as $entity) {
            $toArray = [];

            foreach ($this->allowedProperties as $allowedProperty) {
                $value = $entity->{$allowedProperty['getterToEntity']}();
                $keyToResponse = $allowedProperty['keyToResponse'];

                if ([] !== $interceptor = $allowedProperty['interceptor']) {
                    $value = $interceptor['handler']->handle($interceptor['constraint'], $this, $value);
                }

                if (array_key_exists($allowedProperty['keyToResponse'], $this->aliases)) {
                    $keyToResponse = $this->aliases[$allowedProperty['keyToResponse']];
                }

                $toArray[$keyToResponse] = empty($value) ? $this->{$allowedProperty['propertyName']} : $value;
            }

            $this->response[] = $toArray;
        }
    }

    private function getConstraintHandler(ConstraintInterface $constraint): object
    {
        return $this->container->getService($constraint->getHandler());
    }
}