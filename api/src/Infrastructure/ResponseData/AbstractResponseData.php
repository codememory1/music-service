<?php

namespace App\Infrastructure\ResponseData;

use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintAvailabilityHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintSystemHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintValueHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;
use App\Infrastructure\ResponseData\Repository\AllowedPropertyRepository;
use App\Infrastructure\ResponseData\Repository\PropertyInterceptorRepository;
use App\Infrastructure\ResponseData\Repository\PropertyMethodRepository;
use App\Service\Reflection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\Pure;
use ReflectionProperty;
use Symfony\Component\DependencyInjection\ReverseContainer;

abstract class AbstractResponseData implements ResponseDataInterface
{
    protected null|array|EntityInterface|Collection $entities = null;
    protected bool $asFirstResponse = false;
    protected Reflection $reflection;
    protected array $ignoredProperties = [];
    protected array $onlyProperties = [];
    protected array $response = [];

    #[Pure] 
    public function __construct(
        protected ReverseContainer $container
    ) {
        $this->reflection = new Reflection(static::class);
    }

    public function setEntities(EntityInterface|Collection|array $entities): self
    {
        if ($entities instanceof EntityInterface) {
            $entities = [$entities];

            $this->asFirstResponse = true;
        }

        if ($entities instanceof Collection) {
            $entities = $entities->toArray();
        }

        $this->entities = $entities;

        return $this;
    }

    public function setIgnoredProperties(array $propertyNames): self
    {
        $this->ignoredProperties = $propertyNames;

        return $this;
    }

    public function addIgnoreProperty(string $propertyName): self
    {
        $this->ignoredProperties[] = $propertyName;

        return $this;
    }

    public function setOnlyProperties(array $propertyNames): self
    {
        $this->onlyProperties = $propertyNames;

        return $this;
    }

    public function addOnlyProperty(string $propertyName): self
    {
        $this->onlyProperties[] = $propertyName;

        return $this;
    }

    public function getResponse(): array
    {
        $this->handle();

        if ($this->asFirstResponse) {
            return $this->response[0] ?? [];
        }

        return $this->response;
    }

    private function handle(): void
    {
        $ignoredProperties = $this->ignoredProperties;
        $onlyProperties = $this->onlyProperties;

        foreach ($this->entities as $entity) {
            $response = [];

            $properties = $this->reflection->getStrictlyClassProperties(static function(ReflectionProperty $property) use ($ignoredProperties, $onlyProperties) {
                if (in_array($property->getName(), $ignoredProperties, true)) {
                    return false;
                }

                return [] === $onlyProperties || in_array($property->getName(), $onlyProperties, true);
            });

            foreach ($properties as $property) {
                $propertyDataDeterminant = $this->propertyHandler($property, $entity);

                if (null !== $propertyDataDeterminant) {
                    $propertyValue = $propertyDataDeterminant->getPropertyValue() ?: $propertyDataDeterminant->getDefaultPropertyValue();

                    $response[$propertyDataDeterminant->getPropertyNameInResponse()] = $propertyValue;
                }
            }

            $this->response[] = $response;
        }
    }

    private function propertyHandler(ReflectionProperty $property, EntityInterface $entity): ?PropertyDataDeterminant
    {
        $propertyIsPassed = true;
        $allowedPropertyRepository = new AllowedPropertyRepository($property);
        $propertyMethodRepository = new PropertyMethodRepository('get', $property->getName());
        $propertyDataDeterminant = new PropertyDataDeterminant();

        $propertyDataDeterminant->setPropertyMethodRepository($propertyMethodRepository);
        $propertyDataDeterminant->setPropertyName($allowedPropertyRepository->getPropertyName());
        $propertyDataDeterminant->setPropertyNameInResponse($allowedPropertyRepository->getPropertyNameInResponse());
        $propertyDataDeterminant->setPropertyValue($this->getPropertyValue($entity, $propertyMethodRepository));
        $propertyDataDeterminant->setDefaultPropertyValue($property->getValue($this));

        foreach ($property->getAttributes() as $attribute) {
            $attributeInstance = $attribute->newInstance();

            if ($attributeInstance instanceof ConstraintInterface) {
                $propertyInterceptorRepository = new PropertyInterceptorRepository($attributeInstance, $attributeInstance->getHandler());
                $constraintHandler = $this->getConstraintHandler($propertyInterceptorRepository);

                $constraintHandler->setEntityIteration($entity);
                $constraintHandler->setResponseData($this);

                if ($constraintHandler instanceof ConstraintSystemHandlerInterface) {
                    $constraintHandler->setPropertyDataDeterminant($propertyDataDeterminant);
                    $constraintHandler->handle($attributeInstance);
                }

                if ($constraintHandler instanceof ConstraintAvailabilityHandlerInterface) {
                    if (false === $constraintHandler->handle($attributeInstance)) {
                        $propertyIsPassed = false;

                        break;
                    }
                }

                if ($constraintHandler instanceof ConstraintValueHandlerInterface) {
                    $propertyDataDeterminant->setPropertyValue(
                        $constraintHandler->handle($attributeInstance, $this, $propertyDataDeterminant->getPropertyValue())
                    );
                }
            }
        }

        return $propertyIsPassed ? $propertyDataDeterminant : null;
    }

    /**
     * @return ConstraintHandlerInterface
     */
    private function getConstraintHandler(PropertyInterceptorRepository $propertyInterceptorRepository): object
    {
        return $this->container->getService($propertyInterceptorRepository->handler);
    }

    private function getPropertyValue(EntityInterface $entity, PropertyMethodRepository $propertyMethodRepository): mixed
    {
        return method_exists($entity, $propertyMethodRepository->getMethodName()) ? $entity->{$propertyMethodRepository->getMethodName()}() : null;
    }
}