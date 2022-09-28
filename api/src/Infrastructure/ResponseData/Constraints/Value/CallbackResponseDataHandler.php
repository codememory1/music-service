<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintValueHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;
use Doctrine\Common\Collections\Collection;
use function is_array;
use RuntimeException;
use Symfony\Component\DependencyInjection\ReverseContainer;

final class CallbackResponseDataHandler extends AbstractConstraintHandler implements ConstraintValueHandlerInterface
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

        $responseData->setIgnoredProperties($constraint->ignoreProperties);

        if (false === is_array($value) && false === $value instanceof Collection && false === $value instanceof EntityInterface) {
            return [];
        }

        return $responseData->setEntities($value)->getResponse();
    }
}