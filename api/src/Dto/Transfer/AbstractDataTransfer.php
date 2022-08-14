<?php

namespace App\Dto\Transfer;

use App\Collection\DtoConstraintCollection;
use App\Dto\Interfaces\DataTransferCallSetterConstraintHandlerInterface;
use App\Dto\Interfaces\DataTransferConstraintHandlerInterface;
use App\Dto\Interfaces\DataTransferConstraintInterface;
use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;
use App\Entity\Interfaces\EntityInterface;
use JetBrains\PhpStorm\Pure;
use LogicException;
use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\DependencyInjection\ReverseContainer;
use function Symfony\Component\String\u;

/**
 * @template Entity as mixed
 */
abstract class AbstractDataTransfer implements DataTransferInterface
{
    protected array $propertyNameToData = [];
    protected ReflectionClass $reflectionClass;
    private ReverseContainer $container;
    private ?EntityInterface $entity = null;

    public function __construct(ReverseContainer $container)
    {
        $this->container = $container;
        $this->reflectionClass = new ReflectionClass(static::class);
    }

    public function setEntity(EntityInterface $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return Entity
     */
    public function getEntity(): ?EntityInterface
    {
        return $this->entity;
    }

    public function collect(array $data): static
    {
        foreach ($this->getProperties() as $property) {
            $propertyAttributes = $this->getAttributes($property);
            $propertyNameToData = $this->propertyNameToData[$property->getName()] ?? null;
            $dataValue = $data[$propertyNameToData ?: $this->getPropertyNameToSnakeCase($property)] ?? null;
            $isCallSetterToEntity = true;

            foreach ($propertyAttributes as $attributeCollection) {
                $constraintHandler = $this->getConstraintHandler($attributeCollection);

                $constraintHandler->setDataTransfer($this);
                $constraintHandler->setReflectionProperty($property);

                if ($constraintHandler instanceof DataTransferCallSetterConstraintHandlerInterface) {
                    $isCallSetterToEntity = $constraintHandler->handle($attributeCollection->constraint);
                } else {
                    if ($constraintHandler instanceof DataTransferValueInterceptorConstraintHandlerInterface) {
                        $dataValue = $constraintHandler->handle($attributeCollection->constraint, $dataValue);
                    }
                }
            }

            $this->setValueToDataTransferProperty($property->getName(), $dataValue);

            if (true === $isCallSetterToEntity) {
                $this->setValueToEntity($property->getName(), $dataValue);
            }
        }

        return $this;
    }

    /**
     * @return array<ReflectionProperty>
     */
    #[Pure]
    private function getProperties(): array
    {
        return $this->reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);
    }

    /**
     * @return array<int, DtoConstraintCollection>
     */
    private function getAttributes(ReflectionProperty $reflectionProperty): array
    {
        $attributes = [];
        $reflectionAttributes = $reflectionProperty->getAttributes();

        foreach ($reflectionAttributes as $reflectionAttribute) {
            $attributeInstance = $reflectionAttribute->newInstance();

            if ($attributeInstance instanceof DataTransferConstraintInterface) {
                $attributes[] = new DtoConstraintCollection($attributeInstance, $reflectionAttribute);
            }
        }

        return $attributes;
    }

    private function getConstraintHandler(DtoConstraintCollection $dtoConstraintCollection): ?DataTransferConstraintHandlerInterface
    {
        $namespaceHandler = $dtoConstraintCollection->constraint->getHandler();

        if (false === class_exists($namespaceHandler)) {
            throw new LogicException("Handler for dto constraint not found: {$namespaceHandler}");
        }

        /** @var DataTransferConstraintHandlerInterface|object $service */
        $service = $this->container->getService($namespaceHandler);

        if (false === $service instanceof DataTransferConstraintHandlerInterface) {
            throw new LogicException(sprintf('The %s constraint handler must implement the %s interface', $namespaceHandler, DataTransferConstraintHandlerInterface::class));
        }

        return $service;
    }

    private function getPropertyNameToSnakeCase(ReflectionProperty $reflectionProperty): string
    {
        return u($reflectionProperty->getName())->snake()->toString();
    }

    private function setValueToDataTransferProperty(string $name, mixed $value): void
    {
        $this->$name = $value;
    }

    private function setValueToEntity(string $propertyName, mixed $value): void
    {
        if (null !== $this->entity) {
            $setterName = sprintf('set%s', ucfirst($propertyName));

            $this->entity->$setterName($value);
        }
    }
}