<?php

namespace App\Infrastructure\ResponseData;

use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\Repository\PropertyInterceptorRepository;
use App\Infrastructure\ResponseData\Interfaces\ConstraintAvailabilityHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintSystemHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintValueHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;
use App\Service\Reflection;
use Doctrine\Common\Collections\Collection;
use ReflectionProperty;
use Symfony\Component\DependencyInjection\ReverseContainer;

abstract class AbstractResponseData implements ResponseDataInterface
{
    protected ReverseContainer $container;
    protected null|array|EntityInterface|Collection $entities = null;
    protected Reflection $reflection;
    protected array $ignoredProperties = [];

    public function __construct(ReverseContainer $container)
    {
        $this->container = $container;
        $this->reflection = new Reflection(static::class);
    }

    public function setEntities(EntityInterface|Collection|array $entities): self
    {
        $this->entities = $entities;

        return $this;
    }

    public function setIgnoredProperties(array $names): self
    {
        $this->ignoredProperties = $names;

        return $this;
    }

    public function addIgnoreProperty(string $name): self
    {
        $this->ignoredProperties[] = $name;

        return $this;
    }

    public function getResponse(bool $asFirst = false): array
    {
        $this->handle();

        return [];
    }

    private function handle(): void
    {
        foreach ($this->reflection->getStrictlyClassProperties() as $property) {
            $this->propertyHandler($property);
        }
    }

    private function propertyHandler(ReflectionProperty $property): void
    {
        foreach ($property->getAttributes() as $attribute) {
            $attributeInstance = $attribute->newInstance();

            if ($attributeInstance instanceof ConstraintInterface) {
                $propertyInterceptorRepository = new PropertyInterceptorRepository($attributeInstance, $attributeInstance->getHandler());
                $constraintHandler = $this->getConstraintHandler($propertyInterceptorRepository);

                if ($constraintHandler instanceof ConstraintSystemHandlerInterface) {
                    // TODO: System
                }

                if ($constraintHandler instanceof ConstraintAvailabilityHandlerInterface) {
                    // TODO: Availability
                }

                if ($constraintHandler instanceof ConstraintValueHandlerInterface) {
                    // TODO: Value
                }
            }
        }
    }

    private function getConstraintHandler(PropertyInterceptorRepository $propertyInterceptorRepository): ConstraintHandlerInterface
    {
        /** @var ConstraintHandlerInterface $service */
        return $this->container->getService($propertyInterceptorRepository->handler);
    }
}