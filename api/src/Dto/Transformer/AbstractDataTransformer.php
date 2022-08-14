<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Interfaces\DataTransformerInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use LogicException;

/**
 * @template Dto as mixed
 */
abstract class AbstractDataTransformer implements DataTransformerInterface
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function baseTransformFromRequest(DataTransferInterface $dataTransfer, ?EntityInterface $entity = null): DataTransferInterface
    {
        if (null !== $entity) {
            $dataTransfer->setEntity($entity);
        }

        return $dataTransfer->collect($this->request->all());
    }

    /**
     * @return Dto
     */
    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        throw new LogicException(sprintf('The %s method is not overridden in the %s transformer', __METHOD__, static::class));
    }

    /**
     * @return Dto
     */
    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        throw new LogicException(sprintf('The %s method is not overridden in the %s transformer', __METHOD__, static::class));
    }
}