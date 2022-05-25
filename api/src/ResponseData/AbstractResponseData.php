<?php

namespace App\ResponseData;

use App\Entity\Interfaces\EntityInterface;
use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\ResponseData\Interfaces\ResponseDataInterface;
use function is_array;
use ReflectionAttribute;
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
     * @var ReverseContainer
     */
    private ReverseContainer $container;

    /**
     * @var array<EntityInterface>
     */
    private array $entities = [];

    /**
     * @var array
     */
    private array $response = [];

    /**
     * @var array
     */
    private array $allowedProperties = [];

    /**
     * @param ReverseContainer $container
     */
    public function __construct(ReverseContainer $container)
    {
        $this->container = $container;
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
    public function collect(): static
    {
        $this->handleProperties();

        foreach ($this->entities as $entity) {
            $response = [];

            foreach ($this->allowedProperties as $allowedProperty) {
                $nameToEntity = $allowedProperty['to_entity'];
                $getterName = u("get_${nameToEntity}")->camel()->toString();

                $response[$allowedProperty['to_response']] = $entity->$getterName();
            }

            $this->response[] = $response;
        }

        return $this;
    }

    /**
     * @param bool $asFirst
     *
     * @return array
     */
    public function getResponse(bool $asFirst = false): array
    {
        if ($asFirst) {
            return $this->response[array_key_first($this->response)];
        }

        return $this->response;
    }

    /**
     * @return void
     */
    private function handleProperties(): void
    {
        $reflection = new ReflectionClass(static::class);

        foreach ($reflection->getProperties() as $property) {
            if ($this->handleAttributes($property)) {
                $this->addAllowedProperty($property);
            }
        }
    }

    /**
     * @param ReflectionAttribute $attribute
     *
     * @return bool
     */
    private function handleAttributes(ReflectionProperty $property): bool
    {
        foreach ($property->getAttributes() as $attribute) {
            /** @var ConstraintInterface $constraint */
            $constraint = $attribute->newInstance();

            if (false === $this->getHandler($constraint)->handle($constraint)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param ConstraintInterface $constraint
     *
     * @return ConstraintHandlerInterface
     */
    private function getHandler(ConstraintInterface $constraint): ConstraintHandlerInterface
    {
        $namespaceHandler = $constraint->getHandler();

        /** @var ConstraintHandlerInterface $service */
        return $this->container->getService($namespaceHandler);
    }

    /**
     * @param ReflectionProperty $property
     *
     * @return void
     */
    private function addAllowedProperty(ReflectionProperty $property): void
    {
        $this->allowedProperties[] = [
            'to_entity' => $property->getName(),
            'to_response' => u($property->getName())->snake()->toString()
        ];
    }
}