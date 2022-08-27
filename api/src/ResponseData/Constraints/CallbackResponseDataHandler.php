<?php

namespace App\ResponseData\Constraints;

use App\Entity\Interfaces\EntityInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Interfaces\ValueHandlerInterface;
use Doctrine\Common\Collections\Collection;
use function is_array;
use RuntimeException;
use Symfony\Component\DependencyInjection\ReverseContainer;

final class CallbackResponseDataHandler implements ValueHandlerInterface
{
    private ReverseContainer $container;

    public function __construct(ReverseContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @param CallbackResponseData $constraint
     */
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): array
    {
        $namespaceResponseData = $constraint->namespaceResponseData;

        if (false === class_exists($namespaceResponseData)) {
            throw new RuntimeException("Class Response data {$namespaceResponseData} not exist");
        }

        /** @var ResponseDataInterface $responseData */
        $responseData = new $namespaceResponseData($this->container);

        foreach ($constraint->ignoreProperties as $ignoreProperty) {
            $responseData->setIgnoreProperty($ignoreProperty);
        }

        if (false === is_array($value) && false === $value instanceof Collection && false === $value instanceof EntityInterface) {
            return [];
        }

        return $responseData->setEntities($value)->getResponse($constraint->asFirst);
    }
}